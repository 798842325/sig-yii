<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $order_code
 * @property integer $goods_id
 * @property string $total
 * @property string $amount
 * @property integer $cretad_at
 * @property string $norms
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_code'], 'required'],
            [['goods_id', 'cretad_at','status','user_id','pay_status'], 'integer'],
            [['total', 'amount','receiving_phone','rebate_amount'], 'number'],
            [['norms','receiver','admin_remark'], 'string'],
            [['order_code'], 'string', 'max' => 18],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_code' => 'Order Code',
            'goods_id' => 'Goods ID',
            'total' => 'Total',
            'amount' => 'Amount',
            'cretad_at' => 'Cretad At',
            'norms' => 'Norms',
        ];
    }
}
