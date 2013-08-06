<div class="row">
<br/><br/>
    <div class="span6 sub-logo">
        <span class="mega-big-title">Rc Calc</span>
        <br/>
        <span class="slogan"><?=_t('frontend', 'Easy way to calculate you rc model')?></span>
    </div>
    <div class="span5">
        <?=_t('frontend', 'Rc Calc is the simpliest way to calculate your RC Copter.We can help you with bulding any type of copters.
        We can help you with bulding any type of copters.You can share you calc and save in you profile.')?>
    </div>
</div>
<br/><br/>
<div class="row">
    <div class="span6">
        <h4>
            <?=_t('frontend', 'We calculate now')?> <?=Y::nf()->formatDecimal($copterCalcs)?> <?=_t('frontend', 'model|models', $copterCalcs)?>
        </h4>
    </div>
    <?if(Y::isGuest()):?>
        <div class="span6">
            <h3><?=_t('frontend', 'Login in Rc Calc without any registration')?></h3>
            <? $this->widget('EAuthWidget', array('action' => '/user/login'));?>
        </div>
    <?endif?>
</div>

