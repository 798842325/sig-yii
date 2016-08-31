<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sig_classify_type}}".
 *
 * @property string $name
 * @property string $title
 * @property string $description
 * @property integer $status
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
            [['status'], 'integer'],
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
        ];
    }

    public function getclassify(){
        return  $this->hasMany(Classify::className(),['name_id'=>'name']);
    }


}
