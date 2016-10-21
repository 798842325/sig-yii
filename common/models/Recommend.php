<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%recommend}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sex
 * @property integer $age
 * @property string $phone
 * @property string $describe
 * @property integer $status
 * @property string $remark
 */
class Recommend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recommend}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'age', 'status'], 'integer'],
            [['describe'], 'string'],
            [['name', 'phone', 'remark'], 'string', 'max' => 255],
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
            'age' => 'Age',
            'phone' => 'Phone',
            'describe' => 'Describe',
            'status' => 'Status',
            'remark' => 'Remark',
        ];
    }
}
