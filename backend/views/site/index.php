<?php

use yii\helpers\Url;
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = Yii::$app->cache->get('WEB_SITE_TITLE');
?>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i></div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <span><img alt="image" class="img-circle" src="<?= Yii::$app->user->identity->avatar ?>" width="80" height="80" /></span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs"><strong class="font-bold"><?= Yii::$app->user->identity->username ?></strong></span>
                                    <span class="text-muted text-xs block">超级管理员<b class="caret"></b></span>
                                </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class="J_menuItem" href="form_avatar.html">修改头像</a></li>
                            <li><a class="J_menuItem" href="profile.html">个人资料</a></li>
                            <li><a class="J_menuItem" href="contacts.html">联系我们</a></li>
                            <li><a class="J_menuItem" href="mailbox.html">信箱</a></li>
                            <li class="divider"></li>
                            <li>
                                <?= Html::beginForm(['/site/logout'], 'post') ?>
                                <?= Html::submitButton('安全退出', ['class' => 'btn btn-link']) ?>
                                <?= Html::endForm() ?>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element">H+</div>
                </li>

                <?php foreach (Yii::$app->params['menu'] as $vm): ?>
                <li>
                    <a href="<?= Url::to($vm['route']) ?>">
                        <i class="fa  <?=$vm['icon']?>"></i>
                        <span class="nav-label"><?=$vm['name']?></span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                    <?php if (!empty($vm['_child'])): ?>
                        <?php foreach ($vm['_child'] as $ks =>$vs): ?>
                            <li><a class="J_menuItem" href="<?= Url::to($vs['route']) ?>" data-index="<?=$ks?>"><?=$vs['name']?></a></li>
                        <?php endforeach;?>
                     <?php endif; ?>
                    </ul>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="{{ url('admin/index/index')  }}">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

                </button>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a>定位当前选项卡</a></li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a>关闭全部选项卡</a></li>
                    <li class="J_tabCloseOther"><a>关闭其他选项卡</a></li>
                </ul>
            </div>

            <a href="###;" class="roll-nav roll-right J_tabExit">
                <?= Html::beginForm(['/site/logout'], 'post') ?>
                <?= Html::submitButton('<i class="fa fa fa-sign-out"></i> 退出', ['class' => 'btn btn-link']) ?>
                <?= Html::endForm() ?>
                </a>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="" frameborder="0" data-id="" seamless></iframe>
        </div>
        <div class="footer">
            <div class="pull-right">&copy; 2014-2015 <a href="http://www.zi-han.net/" target="_blank">zihan'sblog</a>
            </div>
        </div>
    </div>
    <!--右侧部分结束-->

</div>

</body>




