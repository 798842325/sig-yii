<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%coupons}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $money
 * @property string $explain
 * @property integer $status
 * @property string $created_at
 * @property string $start_time
 * @property string $end_time
 * @property string $limit_price
 * @property integer $user_id
 */
class Coupons extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%coupons}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['money', 'status', 'user_id'], 'integer'],
            [['start_time', 'end_time','created_at'], 'safe'],
            [['limit_price'], 'number'],
            [['name', 'explain',], 'string', 'max' => 255],
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
            'money' => 'Money',
            'explain' => 'Explain',
            'status' => 'Status',
            'created_at' => 'Created At',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'limit_price' => 'Limit Price',
            'user_id' => 'User ID',
        ];
    }
}
