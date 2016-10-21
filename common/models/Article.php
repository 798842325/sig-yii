<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $cate_id
 * @property string $content
 * @property integer $status
 * @property integer $sort
 * @property string $cover
 * @property integer $created_at
 * @property integer $updated_at
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cate_id', 'status', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['title', 'cover','author'], 'string', 'max' => 255],
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
            'cate_id' => 'Cate ID',
            'content' => 'Content',
            'status' => 'Status',
            'sort' => 'Sort',
            'cover' => 'Cover',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
