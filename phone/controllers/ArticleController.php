<?php
namespace phone\controllers;


use common\models\Article;
use common\models\ArticleCate;
use common\models\ArticleCateType;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;



/**
 *  文章
 * Article Controller
 */
class ArticleController extends Controller
{

    /**
     * 文章首页
     * @param string $cate_id
     * @return string
     */
    public function actionIndex($cate_id='')
    {
        //获取文章分类
        $classify= Yii::$app->cache->get('CLASSIFY');
        $data['CateArticleV1'] = isset($classify['PHONE_CATE_ARTICLE'])?$classify['PHONE_CATE_ARTICLE']:[];


        //获取文章
        if(empty($cate_id)){
            foreach ($data['CateArticleV1'] as $v){
                $cate_id[]= $v['id'];
            }
        }

        // where 条件
        $cond = ['and','status=1',['in','cate_id',$cate_id]];

        $Article = new Article();
        $data['article']= $Article ->find()->where($cond)->orderBy(['sort'=>SORT_DESC,'updated_at'=>SORT_DESC])->asArray()->all();


        return $this->render('index',$data);
    }

    /**
     *  文章详情
     * @param $id
     * @return string
     */
    public function actionInfo($id)
    {

        //获取文章信息
        $Article= new Article();
        $data['ArticleInfo']= $Article ->find()->where(['id'=>$id])->asArray()->one();

        return $this->render('info',$data);
    }


}
