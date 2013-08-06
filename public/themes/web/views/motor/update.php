<?
/** @var TbActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array('id' => 'form', 'type' => 'horizontal', 'inlineErrors' => false)) ?>


<?=$form->dropDownListRow($model, 'manufacter_id', $manufacters, array('class' => 'span3 chosen'))?>

<?=$form->textFieldRow($model, 'model', array('class' => 'span3'))?>

<div class="row">
    <div class="span4">
        <?=$form->textFieldRow($model, 'kw', array('class' => 'span1'))?>
    </div>
    <div class="span3">
        <?=$form->textFieldRow($model, 'resistance', array('class' => 'span1'))?>
    </div>
</div>

<div class="row">
    <div class="span4">
        <?=$form->textFieldRow($model, 'current_noload', array('class' => 'span1'))?>
    </div>
    <div class="span4">
        <?=$form->textFieldRow($model, 'current_noload_voltage', array('class' => 'span1'))?>
    </div>
</div>

<div class="row">
    <div class="span4">
        <?=$form->dropDownListRow($model, 'limit_type', $model->getLimitTypeValues(), array('class' => 'span1'))?>
    </div>
    <div class="span4">
        <?=$form->textFieldRow($model, 'limit_value', array('class' => 'span1'))?>
    </div>
</div>


<div class="row">
    <div class="span4">
        <?=$form->textFieldRow($model, 'weight', array('class' => 'span1'))?>
    </div>
    <div class="span4">
        <?=$form->textFieldRow($model, 'length', array('class' => 'span1'))?>
    </div>
</div>
<?=$form->textFieldRow($model, 'mag_poles_count', array('class' => 'span1'))?>


<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary',
                                                            'label'=>$model->isNewRecord ? 'Create' : 'Save',
)); ?>
    or <?=Html::link(_t('manufacter', 'return to index'), array('index'))?>
</div>




<? $this->endWidget() ?>
