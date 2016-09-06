<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%classify}}".
 *
 * @property integer $id
 * @property string $name_id
 * @property string $title
 * @property integer $status
 * @property integer $sort
 * @property string $cover
 * @property integer $pid
 */
class Classify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%classify}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'sort', 'pid','cate_id'], 'integer'],
            [[ 'title', 'cover'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cate_id' => 'Cate ID',
            'title' => 'Title',
            'status' => 'Status',
            'sort' => 'Sort',
            'cover' => 'Cover',
            'pid' => 'Pid',
        ];
    }


}
