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
 * Service Controller
 */
class ServiceController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

        ];
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        //获取文章分类
        $ArticleCateType = new ArticleCateType();
        $ArticleCateData=$ArticleCateType ->find() ->where(['apply'=>'PHONE_ARTICLE_CATE'])->joinWith(['article_cate'=>function ($query) {
            $query->where('{{%article_cate}}.status =1')->orderBy(['sort'=>SORT_DESC]);
        }])->asArray()->all();
        $data['articleCate'] = $ArticleCateData[0]['article_cate'];


        //获取文章
        $ArticleCate =  new ArticleCate();
        $ArticleData= $ArticleCate ->find()->select(['id']) ->where(['apply_id' =>$ArticleCateData[0]['apply']]);
        $Article = new Article();
        $ArticleData=$Article ->find()->where(['in','cate_id',$ArticleData])->asArray()->all();
        $data['article'] = $ArticleData;



        return $this->render('index',$data);
    }

    /**
     * 用户登录
     *
     * @return mixed
     */
    public function actionInfo($id)
    {

        //获取文章信息
        $Article= new Article();
        $ArticleInfo= $Article ->find()->where(['id'=>$id])->asArray()->one();
        $data['ArticleInfo'] = $ArticleInfo;

        return $this->render('info',$data);
    }




}
