<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%article_cate}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $apply_id
 * @property integer $status
 * @property integer $sort
 */
class ArticleCate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_cate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'sort'], 'integer'],
            [['title', 'apply_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'apply_id' => 'Apply ID',
            'status' => 'Status',
            'sort' => 'Sort',
        ];
    }

    public function getarticle(){
        return  $this->hasMany(Article::className(),['cate_id'=>'id']);
    }
}
