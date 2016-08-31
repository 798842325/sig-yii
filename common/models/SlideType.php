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
            [['slide'], 'required'],
            [['status'], 'integer'],
            [['slide', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'slide' => 'Slide',
            'title' => 'Title',
            'status' => 'Status',
        ];
    }

    public function getslide(){
        return  $this->hasMany(Slide::className(),['slide_id'=>'slide']);
    }
}
