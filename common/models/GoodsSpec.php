<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goods_spec}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $goods_type
 * @property integer $sort
 * @property string $spec_value
 * @property integer $is_check
 * @property integer $entry
 */
class GoodsSpec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_spec}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_type', 'sort','stock'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'goods_type' => 'Goods Type',
            'sort' => 'Sort',
            'spec_value' => 'Spec Value',
            'is_check' => 'Is Check',
            'entry' => 'Entry',
        ];
    }
}
