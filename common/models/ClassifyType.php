<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%classify_type}}".
 *
 * @property string $name
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property integer $type
 */
class ClassifyType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%classify_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'type'], 'integer'],
            [['name', 'title', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'type' => 'Type',
        ];
    }


    public function getclassify(){
        return  $this->hasMany(Classify::className(),['cate_id'=>'id','status'=>'status']);
    }
}
