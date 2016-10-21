<?php

namespace common\models;

use Yii;
use common\models\GoodsEvaluation;

/**
 * This is the model class for table "{{%goods_evaluation}}".
 *
 * @property string $order_code
 * @property integer $goods_id
 * @property string $content
 * @property integer $score
 */
class GoodsEvaluation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_evaluation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id'], 'integer'],
            [['content','label','service_score'], 'string'],
            [['order_code'], 'string', 'max' => 255],
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
            'content' => 'Content',
            'score' => 'Score',
        ];
    }


    /**
     * 根据 商品ID 查询商品评价
     * @param $goods_id
     * @return array
     */
    public function GoodsCommentsAll($goods_id){
        $query=(new \yii\db\Query());
        $d=$query->select('*')
            ->from('{{%goods_evaluation}} as ge')
            ->where(['ge.goods_id'=>$goods_id])
            ->innerJoin('{{%order}} as o','o.order_code = ge.order_code')
            ->innerJoin('{{%user}} as u','ge.user_id = u.id')
            ->all();

        return $d;
    }
}
