<?php
/**
 * Date: 2020-02-26
 * Time: 16:37
 */

use yii\helpers\Html;
use backend\assets\LayuiAsset;

LayuiAsset::register($this);

?><?php $this->beginPage()?><!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>

    <?php if (isset($this->blocks['in_head'])): ?>
        <?= $this->blocks['in_head'] ?>
    <?php endif?>

</head>
<body class="layui-layout-body">
<?php $this->beginBody() ?>
<div class="layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">广告运营平台</div>
        <!--        <ul class="layui-nav layui-layout-left">
                    <li class="layui-nav-item"><a href="">控制台</a></li>
                    <li class="layui-nav-item"><a href="">商品管理</a></li>
                    <li class="layui-nav-item"><a href="">用户</a></li>
                    <li class="layui-nav-item">
                        <a href="javascript:;">其它系统</a>
                        <dl class="layui-nav-child">
                            <dd><a href="">邮件管理</a></dd>
                            <dd><a href="">消息管理</a></dd>
                            <dd><a href="">授权管理</a></dd>
                        </dl>
                    </li>
                </ul>-->
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    管理员                </a>
                <dl class="layui-nav-child">
                    <dd><a href="/site/logout">退出</a></dd>
                </dl>
            </li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree">
                <li class="layui-nav-item">
                    <a class="" href="javascript:;">用户管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="/user/consultation-list" target="content">用户咨询</a></dd>
                        <dd><a href="/user/user-list" target="content">账户审核</a></dd>
                        <dd><a href="/user/user-info" target="content">账户信息</a></dd>
                        <dd><a href="/user/media-member" target="content">媒介列表</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">流量管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="/flow/media" target="content">媒体管理</a></dd>
                        <dd><a href="/flow/advert" target="content">广告位管理</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">投放管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="/devote/manage" target="content">投放列表</a></dd>
                        <dd><a href="/ee-factor/index" target="content">EE-Factor</a></dd>
                        <dd><a href="/ee-factor/order" target="content">EE-Forder</a></dd>
                        <a href="javascript:;">投放设置</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/weight/plat" target="content"> &nbsp;&nbsp;&nbsp; 平台权重</a></dd>
                            <dd><a href="/weight/app" target="content"> &nbsp;&nbsp;&nbsp; 媒体权重</a></dd>
                            <dd><a href="/weight/ad" target="content"> &nbsp;&nbsp;&nbsp; 广告位权重</a></dd>
                        </dl>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">数据管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="/data/show" target="content">数据列表</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">文档管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="/doc/list" target="content">文档上传</a></dd>
                        <dd><a href="/doc/news-list" target="content">消息通知</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a class="" href="javascript:;">账号管理</a>
                    <dl class="layui-nav-child">
                        <dd style="display: ;"><a href="/account/account-list" target="content">添加账号</a></dd>
                        <dd><a href="/account/change-password" target="content">修改密码</a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>

    <div class="layui-body" style="bottom:0px">
        <iframe frameborder="0" width="100%" id="iframe" src="site/welcome"  height="99%" name="content"></iframe>
        <!-- 内容主体区域 -->
    </div>
</div>

<?php $this->endBody() ?>
<script type="text/javascript">
    $(function(){
        $(".layui-nav-child a").click(function(){
            var name= $(this).attr("href");
            location.hash = name;//设置锚点
        })
    })
</script>
<script>
    //JavaScript代码区域
    layui.use('element', function () {
        var element = layui.element;

    });
    document.addEventListener('DOMContentLoaded', function () {//刷新
        var hash = location.hash;
        var url = hash.substring(1,hash.length);
        $("#iframe").attr("src", url);
    }, false)
</script>

<?php if (isset($this->blocks['after_script'])): ?>
    <?= $this->blocks['after_script'] ?>
<?php endif?>

</body>
</html>
<?php $this->endPage() ?>