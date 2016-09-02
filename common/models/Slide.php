<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%slide}}".
 *
 * @property integer $id
 * @property string $slide_id
 * @property string $title
 * @property string $picture
 * @property integer $status
 */
class Slide extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slide}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['slide_id', 'title', 'picture'], 'string', 'max' => 255],
            [['sort','url'],'filter', 'filter' => 'trim', 'skipOnArray' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slide_id' => 'Slide ID',
            'title' => 'Title',
            'picture' => 'Picture',
            'status' => 'Status',
        ];
    }
}
