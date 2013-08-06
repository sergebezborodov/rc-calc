
<div class="row">
    <div class="span3">
        <img src="/themes/web/img/icons/keys-128.png" alt="">
    </div>
    <div class="span6">
        <? $this->widget('EAuthWidget', array('action' => '/user/login'));?>

        <?=_t('user', 'Please, click on icon where you are. You will be automaticaly login in system without any registration')?>
    </div>
</div>


