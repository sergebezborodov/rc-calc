<?
/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;

//$cs->registerCssFile(Html::asset(Yii::getPathOfAlias('webroot.themes.web.css').DS.'bootstrap.css'));
//$cs->registerCssFile(Html::asset(Yii::getPathOfAlias('webroot.themes.web.css').DS.'popover.css'));
$cs->registerCssFile(Html::asset(Yii::getPathOfAlias('webroot.themes.web.css').DS.'main.css'));
$cs->registerCssFile(Html::asset(Yii::getPathOfAlias('webroot.themes.web.css').DS.'icons.css'));
$cs->registerCoreScript('jquery');
$cs->registerScriptFile(Html::asset(Yii::getPathOfAlias('webroot.themes.web.js').DS.'nano.js'));
$cs->registerScriptFile(Html::asset(Yii::getPathOfAlias('webroot.themes.web.js').DS.'utils.js'));

$cs->registerScriptFile('/themes/web/js/chosen/chosen.jquery.js');
$cs->registerCssFile('/themes/web/js/chosen/chosen.css');

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=Html::encode($this->pageTitle)?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <script type="text/javascript">
        $(function(){
            $('.chosen').chosen({disable_search_threshold: 5});
        });
    </script>
</head>

<body>

<div id="wrap">
    <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
    <div class="container">

        <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <?=Html::link('Rc Calc', array('/site/index'), array('class' => 'brand'))?>

        <div class="nav-collapse collapse navbar-responsive-collapse">
            <?$this->widget('bootstrap.widgets.TbMenu', array('items' => $this->menu))?>

            <ul class="pull-right nav">
                <li>
                    <?if(Y::isGuest()):?>
                        <?=Html::link(_t('frontend', 'Login'), array('/user/login'))?>
                    <?else:
                    $user = Y::user()->getModel();
                    ?>
                        <div class="user-avatar">
                            <?if($user->avatar):?>
                                <?=Html::image(H::getUrlToUserStorage($user).$user->getAvatarFileForSize('small'),'Avatar')?>
                            <?endif?>
                            <?=Html::link($user->name, array('user/page', 'username' => $user->username))?>
                        </div>
                    <?endif?>
                </li>
            </ul>
        </div>

    </div>
    </div>
    </div>

    <div class="container content">
        <? $this->renderPartial('//layouts/_flash')?>
        <?=$content?>
    </div>
    <div id="push"></div>
</div>

<div id="footer">
    <div class="container">
        <p class="muted credit">
            &copy;<?=date('Y')?> <a href="http://sergebezborodov.com">Serge Bezborodov</a>
            <span style="float: right">
                <?foreach ($this->langs as $title => $url):?>
                    <?=Html::link($title, $url)?>
                <?endforeach?>
            </span>
        </p>
    </div>
</div>


<? $this->renderPartial('//counters/yandex') ?>
</body>
</html>
