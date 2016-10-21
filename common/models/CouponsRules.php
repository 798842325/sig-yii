<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%coupons_rules}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $status
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $create_time
 * @property integer $effective_days
 * @property string $price
 * @property integer $send_total
 * @property integer $receive_num
 * @property string $limit_price
 * @property integer $type
 * @property string $full_pirce
 * @property string $rules
 */
class CouponsRules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%coupons_rules}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'start_time', 'end_time', 'create_time', 'effective_days', 'send_total', 'receive_num', 'type'], 'integer'],
            [['price', 'limit_price'], 'number'],
            [['title', 'full_pirce', 'rules'], 'string', 'max' => 255],
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
            'status' => 'Status',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'create_time' => 'Create Time',
            'effective_days' => 'Effective Days',
            'price' => 'Price',
            'send_total' => 'Send Total',
            'receive_num' => 'Receive Num',
            'limit_price' => 'Limit Price',
            'type' => 'Type',
            'full_pirce' => 'Full Pirce',
            'rules' => 'Rules',
        ];
    }
}
