<?
/** @var TbActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array('id' => 'form', 'type' => 'horizontal', 'inlineErrors' => false)) ?>


<?=$form->dropDownListRow($model, 'manufacter_id', $manufacters, array('class' => 'span3 chosen'))?>

<div class="row">
    <div class="span3">
        <?=$form->textFieldRow($model, 'capacity', array('class' => 'span1'))?>
    </div>
    <div class="span3">
        <?=$form->textFieldRow($model, 'weight_per_cell', array('class' => 'span1'))?>
    </div>
</div>

<div class="row">
    <div class="span3">
        <?=$form->textFieldRow($model, 'norm_c', array('class' => 'span1'))?>
    </div>
    <div class="span3">
        <?=$form->textFieldRow($model, 'burst_c', array('class' => 'span1'))?>
    </div>
</div>

<div class="row">
    <div class="span3">
        <?=$form->textFieldRow($model, 'cell_count', array('class' => 'span1'))?>
    </div>
    <div class="span3">
        <?=$form->textFieldRow($model, 'parallel_count', array('class' => 'span1'))?>
    </div>
</div>


<div class="row">
    <div class="span3">
        <?=$form->textFieldRow($model, 'volt_per_cell', array('class' => 'span1'))?>
    </div>
    <div class="span3">
        <?=$form->textFieldRow($model, 'resistance', array('class' => 'span1'))?>
    </div>
</div>


<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary',
                                                            'label'=>$model->isNewRecord ? 'Create' : 'Save')) ?>
    or <?=Html::link(_t('battery', 'return to index'), array('index'))?>
</div>

<? $this->endWidget() ?>
