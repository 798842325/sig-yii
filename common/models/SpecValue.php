<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%spec_value}}".
 *
 * @property integer $spec_id
 * @property string $item
 * @property integer $id
 */
class SpecValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%spec_value}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['spec_id'], 'integer'],
            [['item'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'spec_id' => 'Spec ID',
            'item' => 'Item',
            'id' => 'ID',
        ];
    }
}
