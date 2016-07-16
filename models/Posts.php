<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\components\EavBehavior;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $text
 * @property integer $created_at
 * @property string $ip
 * @property string $agent
 */
class Posts extends \yii\db\ActiveRecord
{
    
    public $verifyCode;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }
    
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],      
            [
                'class' => EavBehavior::className(),
                'model_id' => 'id'
            ],      
        ];
    }
    
    public function additionalAttributes(){
        return ['ip', 'agent'];
    }

    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'text', 'verifyCode'], 'required'],
            [['email'], 'email'],
            [['text'], 'string'],
            [['created_at'], 'integer'],
            [['username'], 'string', 'max' => 255],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Имя',
            'email' => 'E-mail',
            'text' => 'Текст сообщения',
            'created_at' => 'Дата создания',
            'verifyCode' => 'Код с картинки'
        ];
    }
    
    public function beforeSave($insert) {
        if(!parent::beforeSave($insert)){
            return FALSE;
        }
        $this->ip = Yii::$app->request->getUserIp();
        $this->agent = Yii::$app->request->getUserAgent();
        return TRUE;
    }
    
}
