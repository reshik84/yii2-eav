<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class PostsSearch extends Posts
{
    
    public function search($params){
        $query = Posts::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                  'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
                'attributes' => ['username', 'email', 'created_at']
            ]
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        return $dataProvider;
    }
    
}