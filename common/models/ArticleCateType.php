<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%article_cate_type}}".
 *
 * @property string $apply
 * @property integer $status
 * @property string $title
 */
class ArticleCateType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_cate_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['apply', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'apply' => 'Apply',
            'status' => 'Status',
            'title' => 'Title',
        ];
    }

    public function getarticle_cate(){
        return  $this->hasMany(ArticleCate::className(),['apply_id'=>'apply']);
    }
}
