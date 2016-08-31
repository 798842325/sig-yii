<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sig_classify}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 */
class Classify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%classify}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name_id', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_id' => 'Name',
            'title' => 'Title',
        ];
    }


    public function getservice(){
        return  $this->hasMany(Service::className(),['cate_id'=>'id']);
    }
}
