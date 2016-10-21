<?php

namespace backend\controllers;


use backend\models\Menu;
use common\libs\Helpers;
use common\models\AuthGroup;
use common\models\AuthGroupAccess;
use common\models\AuthRule;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * ItemController implements the CRUD actions for AuthItem model.
 */
class BaseController extends Controller
{


    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if(parent::beforeAction($action)){
            //判断是否登录
            if(!Yii::$app->user->isGuest){
                Yii::$app->params['menu']=$this ->getMenu();
            }
            return true;
        }else{
            return false;
        }
    }


    /**
     * 获取当前用户的菜单
     * @return array
*/
    public function getMenu(){
        //获取用户ID
        $UID=Yii::$app->user->identity->getId();
        //获取菜单
        $Menu=new Menu();
        $d_menu=$Menu ->getMenu($UID);

        return Helpers::list_to_tree($d_menu);
    }
}
