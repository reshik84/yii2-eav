<?php

namespace app\components;

use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use app\models\EavEntity;
use app\models\EavAttributes;
use app\models\EavValues;

class EavBehavior extends AttributeBehavior
{
    
    protected $_values;

    public $model_id = 'id';

    public function events() {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'eavAfterFind',
            ActiveRecord::EVENT_INIT => 'eavInit',
            ActiveRecord::EVENT_AFTER_INSERT => 'eavAfterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'eavAfterInsert'
        ];
    }
    
    public function eavInit() {
        foreach ($this->owner->additionalAttributes() as $attribute){
            $this->_values[$attribute] = FALSE;
        }
    }
    
    public function canGetProperty($name, $checkVars = true) {
        $attributes = $this->owner->additionalAttributes();

        return in_array($name, $attributes);
    }
    
    public function canSetProperty($name, $checkVars = true) {
        $attributes = $this->owner->additionalAttributes();

        return in_array($name, $attributes);
    }

    public function eavAfterFind(){
        $classname = $this->owner->className();
        $entity = EavEntity::find()->where(['class' => $classname])->one();
        $attributes = $entity->getEavAttributes()->all();
        foreach($attributes as $attribute){
            $value = EavValues::find()->where(['attribute_id' => $attribute->id, 'model_id' => $this->owner->{$this->model_id}])->one();
            $this->_values[$attribute->attribute] = $value->value;
        }
    }
    
    public function __get($name) {
        if(isset($this->_values[$name])){
            return $this->_values[$name]    ;
        }
    }
    
    public function __set($name, $value) {
        if(isset($this->_values[$name])){
            $this->_values[$name] = $value;
        }
    }
    
    public function eavAfterInsert(){
        $classname = $this->owner->className();
        $entity = EavEntity::find()->where(['class' => $classname])->one();
        if(!$entity){
            $entity = new EavEntity();
            $entity->class = $classname;
            $entity->save();
        }
        
        $attributes = $this->owner->additionalAttributes();
        foreach ($attributes as $attribute){
            $attr_model = EavAttributes::find()->where(['class_id' => $entity->id, 'attribute' => $attribute])->one();
            if(!$attr_model){
                $attr_model = new EavAttributes();
                $attr_model->class_id = $entity->id;
                $attr_model->attribute = $attribute;
                $attr_model->save();
            }
            
            $val_model = EavValues::find()->where(['attribute_id' => $attr_model->id, 'model_id' => $this->owner->{$this->model_id}])->one();
            if(!$val_model){
                $val_model = new EavValues();
                $val_model->model_id = $this->owner->{$this->model_id};
                $val_model->attribute_id = $attr_model->id;
            }
            $val_model->value = $this->owner->$attribute;
            $val_model->save();
        }
        
    }
    
}