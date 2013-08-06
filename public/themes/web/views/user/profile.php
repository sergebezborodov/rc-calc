<?
/** @var TbActiveForm $form  */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action' => array('profile'),
    'htmlOptions' => array('enctype'=>'multipart/form-data')
))?>

<div class="row">
    <div class="span3">
        <?if($model->avatar):?>
            <?=Html::image(H::getUrlToUserStorage($model).$model->getAvatarFileForSize('big'), 'Avatar')?>
        <?else:?>
            <img src="http://placehold.it/200x200" alt="Avatar">
        <?endif?>
        <?=$form->fileField($model, 'avatar', array('class' => 'span4'))?>
    </div>
    <div class="span8">
        <div class="row">
            <div class="span4">
                <?=$form->textFieldRow($model, 'name', array('class' => 'span4'))?>
            </div>
            <div class="span4">
                <?=$form->textFieldRow($model, 'email', array('class' => 'span4'))?>
            </div>
        </div>

        <div class="row">
            <div class="span8"><?=$form->textFieldRow($model, 'city', array('class' => 'span4'))?></div>
        </div>

        <div class="row">
            <div class="span8">
                <div class="control-group">
                    <?=$form->labelEx($model, 'username', array('class' => 'control-label'))?>
                    <div class="controls">
                        http://rc-calc.com/u/
                        <?=$form->textField($model, 'username', array('style' => 'width: 150px;'))?>
                        <?=$form->error($model, 'username')?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="form-actions">
    <?=Html::submitButton(_t('profile', 'Update'), array('class' => 'btn btn-success'))?>
    <?=_t('profile', 'or')?>
    <?=Html::link(_t('profile', 'return to your page'),
        array('/user/page', 'username' => $model->username))?>
</div>

<? $this->endWidget() ?>
