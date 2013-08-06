<?
/** @var TbActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
'id'=>'vacancy-form',
'type' => 'horizontal',
'htmlOptions' => array('enctype' => 'multipart/form-data')
)) ?>


<?=$form->textFieldRow($model, 'title', array('class' => 'span4'))?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary',
                                                            'label'=>$model->isNewRecord ? 'Create' : 'Save',
)); ?>
    or <?=Html::link(_t('manufacter', 'return to index'), array('index'))?>
</div>




<? $this->endWidget() ?>
