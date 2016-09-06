<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $remark
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $value
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name', 'title', 'remark', 'value'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'remark' => 'Remark',
            'status' => 'Status',
            'value' => 'Value',
        ];
    }
}
