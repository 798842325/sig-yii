<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $abstract
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $shelf_time
 * @property integer $soldout_time
 * @property string $content
 * @property integer $cate_id
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'goods_type','created_at', 'updated_at', 'shelf_time', 'soldout_time', 'cate_id','pattern_type'], 'integer'],
            [['content','picture','goods_spec','goods_price','goods_units','goods_service','royalty_rate'], 'string'],
            [['title', 'abstract','main_map'], 'string', 'max' => 255],
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
            'abstract' => 'Abstract',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'shelf_time' => 'Shelf Time',
            'soldout_time' => 'Soldout Time',
            'content' => 'Content',
            'cate_id' => 'Cate ID',
        ];
    }
}
