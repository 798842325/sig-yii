<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order_when}}".
 *
 * @property string $content
 * @property string $created_at
 * @property string $order_code
 */
class OrderWhen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_when}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'int'],
            [['content', 'order_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'content' => 'Content',
            'created_at' => 'Created At',
            'order_code' => 'Order Code',
        ];
    }
}
