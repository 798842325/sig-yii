<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%withdrawal_record}}".
 *
 * @property integer $id
 * @property string $amount
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $status
 */
class WithdrawalRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%withdrawal_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['user_id', 'created_at', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}
