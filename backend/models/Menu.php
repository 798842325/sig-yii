<?php

namespace backend\models;

use common\models\AuthGroup;
use common\models\AuthRule;
use Yii;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $parent
 * @property string $sort
 * @property string $data
 * @property string $route
 */
class Menu extends \yii\db\ActiveRecord
{

    //定义场景
    const SCENARIOS_CREATE = 'create';
    const SCENARIOS_DELETE = 'delete';
    const SCENARIOS_UPDATE = 'update';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data','icon'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['route'], 'string', 'max' => 255],
            [['pid','sort'],'number'],
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
            'sort' => 'Sort',
            'data' => 'Data',
            'route' => 'Route',
        ];
    }


    /**
     * 根据用户id获取 用户拥有规则
     * @param $uid
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getMenu($uid){
        $AuthGroup=new AuthGroup();
        $rule_id= $AuthGroup->getGroups($uid);
        $arr_rule =[];
        foreach ($rule_id as $v){
            $arr_rule =array_unique(array_merge($arr_rule,explode(',',$v['rules'])));
        }

        $sqlAuthRule=AuthRule::find()->select(['name'])->where(['in','id',$arr_rule]);

        return $dd= $this->find()->where(['or','pid=0',['in','route',$sqlAuthRule]])->asArray()->all();
    }


}
