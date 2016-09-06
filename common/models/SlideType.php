<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%slide_type}}".
 *
 * @property string $slide
 * @property string $title
 * @property integer $status
 */
class SlideType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slide_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name', 'title','describe'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'name',
            'title' => 'Title',
            'status' => 'Status',
        ];
    }

    public function getslide(){
        return  $this->hasMany(Slide::className(),['slide_id'=>'id','status'=>'status']);
    }
}
