<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%service}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $describe
 * @property string $cover
 * @property string $price
 * @property string $price_unit
 * @property string $recommend
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%service}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['title', 'describe', 'cover', 'price_unit', 'recommend'], 'string', 'max' => 255],
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
            'describe' => 'Describe',
            'cover' => 'Cover',
            'price' => 'Price',
            'price_unit' => 'Price Unit',
            'recommend' => 'Recommend',
        ];
    }
}
