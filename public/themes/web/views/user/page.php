<?
/** @var UserModel $user */
?>

<div class="row">
    <div class="span3">
        <?if($user->avatar):?>
            <?=Html::image(H::getUrlToUserStorage($user).$user->getAvatarFileForSize('big'), 'Avatar')?>
        <?else:?>
            <img src="http://placehold.it/200x200" alt="Avatar">
        <?endif?>
    </div>
    <div class="span6">
        <div class="row">
            <div class="span3">
                <h3><?=$user->name?></h3>
            </div>
        </div>
        <div class="row">
            <div class="span3">
                <?=_t('user', 'City')?>: <?=$user->city?>
            </div>
        </div>
        <div class="row">
            <div class="span6">
                <?if(Y::isAuthed() && Y::userId() == $user->id):?>
                <?=Html::link(_t('frontend', 'Edit your profile'), array('/user/profile'),
                    array('class' => 'has-icon16 pencil'))?>
                <?endif?>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="span8">
        <h3><?=_t('frontend', 'Copters')?></h3>
    </div>
    <div class="span12">
        <?if($calcs):?>
            <ul class="thumbnails">
                <?foreach($calcs as $calc):?>
                    <li class="span3">
                        <? $this->widget('CopterInfoWidget', array('calcModel' => $calc)) ?>
                    </li>
                <?endforeach?>
            </ul>
        <?else:?>
            <?if($user->id == Y::userId()):?>
                <?=_t('frontend', 'You have no copter calcs, please')?> <?=Html::link(_t('frontend', 'add one'), array('/calc/copter'))?>
            <?else:?>
                <?=_t('frontend', '{user} doesn\'t have any copters', array('{user}' => $user->name))?>
            <?endif?>
        <?endif?>
    </div>
</div>
