<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%spec}}".
 *
 * @property integer $spec_id
 * @property string $spec_name
 * @property integer $goods_type_id
 * @property string $spec_value
 * @property integer $sort
 * @property integer $entry_way
 */
class Spec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%spec}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_type_id', 'sort', 'entry_way'], 'integer'],
            [['spec_value'], 'string'],
            [['spec_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'spec_id' => 'Spec ID',
            'spec_name' => 'Spec Name',
            'goods_type_id' => 'Goods Type ID',
            'spec_value' => 'Spec Value',
            'sort' => 'Sort',
            'entry_way' => 'Entry Way',
        ];
    }
}
