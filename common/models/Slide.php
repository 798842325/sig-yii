<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%slide}}".
 *
 * @property integer $id
 * @property string $slide_id
 * @property string $title
 * @property string $picture
 * @property integer $status
 */
class Slide extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slide}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status','slide_id'], 'integer'],
            [[ 'title', 'picture'], 'string', 'max' => 255],
            [['sort','url'],'filter', 'filter' => 'trim', 'skipOnArray' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slide_id' => 'Slide ID',
            'title' => 'Title',
            'picture' => 'Picture',
            'status' => 'Status',
        ];
    }

    public function getslidetype(){
        return  $this->hasMany(SlideType::className(),['slide'=>'slide_id','status'=>'status']);
    }

    /**
     * 获取 轮播
     * @param array $SlideType
     * @return mixed
     */
    public function getSlide($SlideType=[]){
        $slide= $this ->find()->where(['in','slide',$SlideType])->joinWith(['slidetype'=>function($query){
            $query ->where(['{{%slide_type}}.status'=>1]);
        }],false)->asArray()->all();
        foreach ($slide as $v){
            $arr[$v['slide_id']][] = $v;
        }

     return $arr;

    }
}
