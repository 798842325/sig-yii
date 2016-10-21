<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%leave_msg}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $sex
 * @property string $phone
 * @property string $demand
 * @property integer $created_at
 */
class LeaveMsg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%leave_msg}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'demand'], 'string'],
            [['created_at'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 20],
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
            'sex' => 'Sex',
            'phone' => 'Phone',
            'demand' => 'Demand',
            'created_at' => 'Created At',
        ];
    }
}
