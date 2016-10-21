<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_service}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $cover
 * @property string $describe
 * @property string $service_price
 * @property string $content
 */
class GoodsService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_service}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['service_price'], 'number'],
            [['content'], 'string'],
            [['title', 'cover', 'describe'], 'string', 'max' => 255],
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
            'cover' => 'Cover',
            'describe' => 'Describe',
            'service_price' => 'Service Price',
            'content' => 'Content',
        ];
    }
}
