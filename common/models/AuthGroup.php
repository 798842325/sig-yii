<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%auth_group}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $status
 * @property string $rules
 * @property string $description
 */
class AuthGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['rules'], 'required'],
            [['rules'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
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
            'rules' => 'Rules',
            'description' => 'Description',
        ];
    }
}
