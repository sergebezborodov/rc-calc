<? /** @var CClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Html::asset(Yii::getPathOfAlias('webroot.themes.web.css').DS.'calc.css'));
$cs->registerScriptFile(Html::asset(Yii::getPathOfAlias('webroot.themes.web.js').DS.'object-cache.js'));
$cs->registerScriptFile(Yii::app()->createUrl('/calc/cachejs'));
$cs->registerScriptFile(Html::asset(Yii::getPathOfAlias('webroot.themes.web.js').DS.'copter-interface.js'));
$cs->registerScriptFile(Html::asset(Yii::getPathOfAlias('webroot.themes.web.js').DS.'calc-api.js'));
$cs->registerScriptFile(Html::asset(Yii::getPathOfAlias('webroot.themes.web.js').DS.'copter-calc.js'));
$cs->registerScriptFile(Html::asset(Yii::getPathOfAlias('webroot.themes.web.js').DS.'nano.js'));

/** @var MotorSelectFormModel $motorSelectModel */
/** @var CActiveForm $form */
?>

<script type="text/javascript">
$(function(){
    var template = '<tr data-manufacter="{manufacter_id}" data-model="{model_id}">' +
            '<td>&nbsp;</td>' +
            '<td>{manufacter}</td>' +
            '<td>{model}</td>' +
            '<td>{kv}</td>' +
            '<td>{weight}</td>' +
            '</tr>';
    $('.search-form')
        .submit(function() {
            var html = '';
            $.ajax('/calc/searchMotors', {
                type: 'post',
                data : $(this).serialize(),
                dataType: 'json',
                success: function(resp) {
                    $.each(resp.data.motors, function(index, item) {
                        html += $.nano(template, item);
                    });
                    $('.motor-results .table tbody').empty().html(html);
                }
            });
            return false;
        })
        .on('click', '.sort', function() {
            var $form = $(this).closest('.search-form'),
                field = $(this).data('field'),
                direction = $(this).data('direction');

            if (typeof direction == 'undefined') {
                direction = 'asc';
            } else {
                direction = direction == 'asc' ? 'desc' : 'asc';
            }
            $form.find('.sort-direction').val(direction);
            $form.find('.sort-field').val(field);

            $form.find('a.sort').removeClass('sort-asc sort-desc');

            $(this)
                .data('direction', direction)
                .data('field', field)
                .addClass('sort-'+direction);

            $form.submit();

            return false;
        })
        .on('change', ':input', function() {
            $(this).closest('.search-form').submit();
        })
        .on('click', 'td', function() {
            var manufacterId = $(this).closest('tr').data('manufacter'),
                modelId      = $(this).closest('tr').data('model');

            $('.calc-form .motor-manufacter-select')
                .data('temp-model-id', modelId)
                .val(manufacterId)
                .change();

        })
        .submit();

    $('.calc-form .motor-manufacter-select').on('loadingDidComplete', function() {
        $('.calc-form .motor-model-select')
                .val($(this).data('temp-model-id'))
                .change();
            $(this).data('temp-model-id', null);
            $('#motor-select').modal('hide');
        });

    $('.calc-form .motor-model-select').on('valueDidSelected', function() {
        $('.calc-form .select-motor-link').text(generateMotorTitle());
    });

    function generateMotorTitle()
    {
        var manufacter = $('.calc-form .motor-manufacter-select option:selected').text(),
            model      = $('.calc-form .motor-model-select option:selected').text();

        if (!manufacter && !model) {
            return 'Custom motor';
        } else {
            return [manufacter, model].join(' ');
        }
    }
});
</script>

<div class="modal hide motor-select" id="motor-select">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3><?=_t('copter-interface', 'Motor Select')?></h3>
    </div>
    <div class="modal-body">
        <? $form = $this->beginWidget('CActiveForm', array(
            'htmlOptions' => array('class' => 'search-form form-inline'),
        ))?>
        <?=$form->hiddenField($motorSelectModel, 'sortField', array('class' => 'sort-field'))?>
        <?=$form->hiddenField($motorSelectModel, 'sortDirection', array('class' => 'sort-direction'))?>
        <div class="row">
            <div class="span1"><label><?=_t('copter-interface', 'Manuf')?></label></div>
            <div class="span3">
                <?=$form->dropDownList($motorSelectModel, 'manufacterId', $manufacters,
                    array('class' => ' span3' /* chosen - temporary disabled */))?>
            </div>
            <div class="span1"><label><?=_t('copter-interface', 'Model')?></label></div>
            <div class="span3">
                <?=$form->textField($motorSelectModel, 'model', array('class' => 'span3'))?>
            </div>
        </div>
        <div class="row">
            <div class="span1"><label><?=_t('copter-interface', 'Kv')?></label></div>
            <div class="span3">
                <?=_t('copter-interface', 'from ')?> <?=$form->textField($motorSelectModel, 'kvMin', array('class' => 'span1'))?>
                <?=_t('copter-interface', 'to')?> <?=$form->textField($motorSelectModel, 'kvMax', array('class' => 'span1'))?>
            </div>
            <div class="span1"><label><?=_t('copter-interface', 'Weight')?></label></div>
            <div class="span3">
                <?=_t('copter-interface', 'from')?> <?=$form->textField($motorSelectModel, 'weightMin', array('class' => 'span1'))?>
                <?=_t('copter-interface', 'to')?>   <?=$form->textField($motorSelectModel, 'weightMax', array('class' => 'span1'))?>
            </div>
        </div>


        <div class="motor-results row">
            <table class="table span7 table-striped">
                <thead>
                <tr>
                    <th class="fav-col"></th>
                    <th class="span1">
                        <a href="#" data-field="manufacter" class="sort"><?=_t('copter-interface', 'Manufacter')?></a>
                    </th>
                    <th class="span2">
                        <a href="#" data-field="model" class="sort"><?=_t('copter-interface', 'Model')?></a>
                    </th>
                    <th class="span1">
                        <a href="#" data-field="kv" class="sort"><?=_t('copter-interface', 'Kv')?></a>
                    </th>
                    <th class="span1">
                        <a href="#" data-field="weight" class="sort"><?=_t('copter-interface', 'Weight')?></a>
                    </th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <? $this->endWidget() ?>
    </div>
</div>

<?
/** @var CopterCalcModel $model */

$form = $this->beginWidget('CActiveForm', array('id' => 'calc-form',
                                                'htmlOptions' => array('class' => 'form-inline calc-form'))) ?>
<?=$form->hiddenField($model, 'hash', array('class' => 'calc-hash'))?>
<?=$form->hiddenField($model, 'isNew', array('class' => 'is-new'))?>
<?=$form->hiddenField($model, 'inUserList')?>

<script type="text/javascript">
$(function(){
    $('label').popover({delay: { show: 500, hide: 100 }, trigger : 'hover'});
    $('.regenerate-link').tooltip({delay: { show: 500, hide: 1 }, trigger: 'hover'});
});
</script>



    <div class="row author-row">
        <div class="span7">
            <?=$form->textField($model, 'title', array('class' => 'calc-title-edit span7 hidden'))?>

            <h2 class="calc-title <?if($model->getIsOwner()):?>placeholder<?endif?> <?if(!$model->title):?>no-title<?endif?>">
                <?if($model->title):?>
                    <?=Html::encode($model->title)?>
                <?else:?>
                    <?=_t('copter-interface', 'Enter copter title')?>
                <?endif?>

            </h2>
            <div class="calc-info">
                <?if(!$model->getIsNew()):?>
                <span>
                    <?=Y::nf()->formatDecimal($model->getViewCount())?>
                    <?=_t('copter-interface', 'view|views', $model->getViewCount())?>
                </span>
                <?endif?>
            </div>
        </div>

        <div class="span3">
            <?if(!$model->getIsOwner()):
                $user = $model->getOwnerModel();
            ?>
                <?if($user):?>
                    <?if($user->avatar):?>
                        <?=Html::image(H::getUrlToUserStorage($user).$user->getAvatarFileForSize('small'),
                            'Avatar', array(
                            'class' => 'user-avatar'
                        ))?>
                    <?endif?>
                    <?=Html::link($user->name, array('/user/page', 'username' => $user->username), array('class' => 'user-name'))?>
                <?endif?>
            <?else:?>
                <?if (!$model->getInUserList()):?>
                    <?if(Y::isAuthed()):?>
                        <button class="btn btn-info save-in-my-copters">
                            <?=_t('copter-interface', 'Save to my copters')?>
                        </button>
                    <?endif?>
                <?else:?>
                    <?=_t('copter-interface', 'This model in your copter list')?>
                    <br/>
                    <?=Html::link(_t('copter-interface', 'Remove from list'),
                        array('/calc/delete', 'hash' => $model->getHash()),
                        array('confirm' => _t('copter-interface', 'Really delete?')))?>
                <?endif?>
            <?endif?>
        </div>
    </div>

    <fieldset class="main-row">
        <div class="title"><?=_t('copter-interface', 'Main info')?></div>
        <div class="row">
            <?if(false):?>
            <div class="span3">
                <label>Units</label>
                <br/>
                <label class="radio">
                    <?=$form->radioButton($model, 'units', array('value' => 'metric', 'uncheckValue' => null))?>
                    <?=_t('copter-interface', 'Metric')?>
                </label>
                &nbsp;
                <label class="radio">
                    <?=$form->radioButton($model, 'units', array('value' => 'imperial', 'uncheckValue' => null))?>
                    <?=_t('copter-interface', 'Imperial')?>
                </label>
            </div>
            <?endif?>

            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', 'Copter type')?>"
                        data-content="<?=_t('copter-interface', 'Choose your copter type')?>"
                        ><?=_t('copter-interface', 'Type')?></label>

                <?=$form->dropDownList($model, 'copterTypeId', $model->getCopterTypeList(), array('class' => 'chosen span2'))?>
            </div>

            <div class="span5">
                <label  data-original-title="<?=_t('copter-interface', 'Weight')?>"
                        data-content="<?=_t('copter-interface', 'Select copter weight type - with drives, esc, battery or without them')?>">
                    <?=_t('copter-interface', 'Weight')?></label>
                <br/>
                <?=$form->textField($model, 'totalWeight', array('class' => 'span1'))?>
                <span class="help-inline"><?=_t('copter-interface', 'g')?></span>
                <div class="error-message">
                    <?=$form->error($model, 'totalWeight')?>
                </div>
                &nbsp;
                <label class="radio">
                    <?=$form->radioButton($model, 'isWeightIncludeDrive', array('value' => 1, 'uncheckValue' => null))?>
                    <?=_t('copter-interface', 'incl drive')?>
                </label>
                &nbsp;
                <label class="radio">
                    <?=$form->radioButton($model, 'isWeightIncludeDrive', array('value' => 0, 'uncheckValue' => null))?>
                    <?=_t('copter-interface', 'without drive')?>
                </label>
            </div>
        </div>

    </fieldset>

    <fieldset class="motor-row">
        <div class="title"><?=_t('copter-interface', 'Motor')?></div>

        <div class="row row-first">
            <div class="span4">
                <br/>
                <a href="#motor-select" data-toggle="modal" class="select-motor-link">
                    <?=_t('copter-interface', 'Select motor')?>
                </a>

                <div class="hidden">
                    <label><?=_t('copter-interface', 'Manufacter')?></label>
                    <br/>
                    <?=$form->dropDownList($model, 'motorManufacterId', $manufacters,
                        array('data-ex-id' => $model->motorManufacterId, 'class' => 'span3 motor-manufacter-select'))?>
                </div>
            </div>

            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', 'Motor Kv')?>"
                       data-content="<?=_t('copter-interface', 'The number of revolutions per minute that the motor will'
                           .' turn when 1V is applied with no load attached to the motor.')?>"
                        ><?=_t('copter-interface', 'Kv')?>:</label>
                <br/>
                <?=$form->textField($model, 'motorKv', array('class' => 'span1', 'data-name' => 'kw'))?>
                <span class="help-inline"><?=_t('copter-interface', 'rpm/V')?></span>
                <div class="error-message"><?=$form->error($model, 'motorKv')?></div>
            </div>

            <div class="span2">
                <label  data-original-title="<?=_t('copter-interface', 'Motor Weight')?>"
                        data-content="<?=_t('copter-interface', 'Motor weight without package')?>">
                    <?=_t('copter-interface', 'Weight')?>:</label>
                <br/>
                <?=$form->textField($model, 'motorWeight', array('class' => 'span1', 'data-name' => 'weight'))?>
                <span class="help-inline"><?=_t('copter-interface', 'g')?></span>
                <div class="error-message"><?=$form->error($model, 'motorWeight')?></div>
            </div>
            <div class="span2">
                <label  data-original-title="<?=_t('copter-interface', 'Motor Resistance')?>"
                        data-content="<?=_t('copter-interface', 'Motor internal resistance')?>"
                        ><?=_t('copter-interface', 'Resistance')?>:</label>
                <br/>
                <?=$form->textField($model, 'motorResistance', array('class' => 'span1', 'data-name' => 'resistance'))?>
                <span class="help-inline"><?=_t('copter-interface', 'Ohm')?></span>
                <div class="error-message"><?=$form->error($model, 'motorResistance')?></div>
            </div>

        </div>
        <div class="row">
            <div class="span4">
                <div class="hidden">
                    <label><?=_t('copter-interface', 'Model')?></label>
                    <br/>
                    <?=$form->dropDownList($model, 'motorModelId', $motors,
                        array('data-ex-id' => $model->motorModelId, 'class' => 'span3 motor-model-select', 'id' => 'motorModelId'))?>
                </div>
            </div>

            <div class="span2">
                <label  data-original-title="<?=_t('copter-interface', 'Motor no-load current')?>"
                        data-content="<?=_t('copter-interface', 'Motor current without load')?>"
                        ><?=_t('copter-interface', 'no-load Current')?>:</label>
                <br/>
                <?=$form->textField($model, 'motorCurrentNoLoad', array('class' => 'span1', 'data-name' => 'current_noload'))?>
                <span class="help-inline"><?=_t('copter-interface', 'A')?></span>
                <?=$form->textField($model, 'motorNoLoadVoltage', array('class' => 'input-xsmall', 'data-name' => 'current_noload_voltage'))?>
                <?=_t('copter-interface', 'V')?>
                <div class="error-message">
                    <?=$form->error($model, 'motorCurrentNoLoad')?>
                    <?=$form->error($model, 'motorNoLoadVoltage')?>
                </div>
            </div>
            <div class="span2">
                <label  data-original-title="<?=_t('copter-interface', 'Motor Limit')?>"
                        data-content="<?=_t('copter-interface', 'Motor max values - can be in max current (A) or in max power (W)')?>"
                        ><?=_t('copter-interface', 'Max Current')?>:</label>
                <br/>
                <?=$form->textField($model, 'motorLimitValue', array('class' => 'span1', 'data-name' => 'limit_value'))?>
                <?=$form->radioButtonList($model, 'motorLimitType', MotorModel::model()->getLimitTypeValues(),
                    array('separator' => '&nbsp;&nbsp;', 'data-name' => 'limit_type'))?>
                <div class="error-message"><?=$form->error($model, 'motorLimitValue')?></div>
            </div>
            <div class="span2">
                <label  data-original-title="<?=_t('copter-interface', 'Motor Mag Poles')?>"
                        data-content="<?=_t('copter-interface', 'Count of motor magnets')?>"
                        ><?=_t('copter-interface', '# mag. Poles')?>:</label>
                <br/>
                <?=$form->textField($model, 'motorMagPoles', array('class' => 'span1', 'data-name' => 'mag_poles_count'))?>
                <div class="error-message"><?=$form->error($model, 'motorMagPoles')?></div>
            </div>
        </div>
    </fieldset>

    <fieldset class="prop-row">
        <div class="title"><?=_t('copter-interface', 'Propeller')?></div>

        <?=$form->hiddenField($model, 'propTwist', array('data-name' => 'twist'))?>
        <?=$form->hiddenField($model, 'propConst', array('data-name' => 'const'))?>
        <?=$form->hiddenField($model, 'propGearRatio', array('data-name' => 'gear_ratio'))?>
        <?=$form->hiddenField($model, 'propMaxRpmConst', array('data-name' => 'max_rpm_const'))?>

        <div class="row">
            <div class="span4">
                <label><?=_t('copter-interface', 'Type')?></label>
                <br/>
                <?=$form->dropDownList($model, 'propTypeId', $props, array('class' => 'chosen prop-select'))?>
            </div>
            <div class="span2">
                <label  data-original-title="<?=_t('copter-interface', 'Propeller Diametr')?>"
                        data-content="<?=_t('copter-interface', 'Propeller diametr in Inches')?>"
                        ><?=_t('copter-interface', 'Diameter')?>:</label>
                <br/>
                <?=$form->textField($model, 'propDiametr', array('class' => 'span1', 'data-name' => 'diametr'))?>
                <span class="help-inline"><?=_t('copter-interface', 'Inch')?></span>
                <div class="error-message"><?=$form->error($model, 'propDiametr')?></div>
            </div>
            <div class="span2">
                <label  data-original-title="<?=_t('copter-interface', 'Propeller Pitch')?>"
                        data-content="<?=_t('copter-interface', 'Propeller Pitch in Inches')?>"
                        ><?=_t('copter-interface', 'Pitch')?>:</label>
                <br/>
                <?=$form->textField($model, 'propPitch', array('class' => 'span1', 'data-name' => 'pitch'))?>
                <span class="help-inline"><?=_t('copter-interface', 'Inch')?></span>
                <div class="error-message"><?=$form->error($model, 'propPitch')?></div>
            </div>

            <div class="span2">
                <label  data-original-title="<?=_t('copter-interface', 'Propeller Blades')?>"
                        data-content="<?=_t('copter-interface', 'Count of blades, usually 2 or 3')?>"
                        ><?=_t('copter-interface', 'Blades')?>:</label>
                <br/>
                <?=$form->textField($model, 'propBladesCount', array('class' => 'span1', 'data-name' => 'blades_count'))?>
                <div class="error-message"><?=$form->error($model, 'propBladesCount')?></div>
            </div>
        </div>
    </fieldset>

    <fieldset class="esc-row">
        <div class="title"><?=_t('copter-interface', 'ESC')?></div>

        <div class="row">
            <div class="span2">
                <label><?=_t('copter-interface', 'Type')?>:</label>
                <br/>
                <?=$form->dropDownList($model, 'escId', $esc,
                    array('class' => 'chosen span2 esc-select'))?>
            </div>

            <div class="span2">
                <label  data-original-title="<?=_t('copter-interface', 'ESC Current')?>"
                        data-content="<?=_t('copter-interface', 'Nominal ESC current value')?>"
                        ><?=_t('copter-interface', 'Continuous Current')?>:</label>
                <br/>
                <?=$form->textField($model, 'escCurrentContinuous', array('class' => 'span1', 'data-name' => 'current_normal'))?>
                <span class="help-inline"><?=_t('copter-interface', 'A')?></span>
                <div class="error-message"><?=$form->error($model, 'escCurrentContinuous')?></div>
            </div>

            <div class="span2">
                <label  data-original-title="<?=_t('copter-interface', 'ESC Max Current')?>"
                        data-content="<?=_t('copter-interface', 'Maximum current for ESC, if more it will damage')?>"
                        ><?=_t('copter-interface', 'Max Current')?>:</label>
                <br/>
                <?=$form->textField($model, 'escCurrentMax', array('class' => 'span1', 'data-name' => 'current_max'))?>
                <span class="help-inline"><?=_t('copter-interface', 'A')?></span>
                <div class="error-message"><?=$form->error($model, 'escCurrentMax')?></div>
            </div>
            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', 'ESC Weight')?>"
                       data-content="<?=_t('copter-interface', 'Weight of one ESC')?>">
                    <?=_t('copter-interface', 'Weight')?>:
                </label>
                <br/>
                <?=$form->textField($model, 'escWeight', array('class' => 'span1', 'data-name' => 'weight'))?>
                <span class="help-inline"><?=_t('copter-interface', 'g')?></span>
                <div class="error-message"><?=$form->error($model, 'escWeight')?></div>
            </div>

            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', 'ESC Resistance')?>"
                       data-content="<?=_t('copter-interface', 'Internal ESC Resistance')?>">
                    <?=_t('copter-interface', 'Resistance')?>:</label>
                <br/>
                <?=$form->textField($model, 'escResistance', array('class' => 'span1', 'data-name' => 'resistance'))?>
                <span class="help-inline"><?=_t('copter-interface', 'Ohm')?></span>
                <div class="error-message"><?=$form->error($model, 'escResistance')?></div>
            </div>
        </div>
    </fieldset>


    <fieldset class="battery-row">
        <div class="title"><?=_t('copter-interface', 'Battery')?></div>

        <div class="row">
            <div class="span4">
                <label>&nbsp;</label>
                <br/>
                <?=$form->dropDownList($model, 'batteryId', $batteries, array('class' => 'chosen span3 battery-select'))?>
            </div>

            <?=$form->hiddenField($model, 'batteryNormC', array('data-name' => 'norm_c'))?>
            <?=$form->hiddenField($model, 'batteryBurstC', array('data-name' => 'burst_c'))?>
            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', '')?>"
                       data-content="<?=_t('copter-interface', '')?>">
                    <?=_t('copter-interface', 'Serial')?>:</label>
                <br/>
                <?=$form->textField($model, 'batterySerialCount', array('class' => 'span1', 'data-name' => 'cell_count'))?>
                <span class="help-inline"><?=_t('copter-interface', 'S')?></span>
                <div class="error-message"><?=$form->error($model, 'batterySerialCount')?></div>
            </div>
            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', '')?>"
                       data-content="<?=_t('copter-interface', '')?>">
                    <?=_t('copter-interface', 'Capacity')?>:</label>
                <br/>
                <?=$form->textField($model, 'batteryCapacity', array('class' => 'span1', 'data-name' => 'capacity'))?>
                <span class="help-inline"><?=_t('copter-interface', 'mAh')?></span>
                <div class="error-message"><?=$form->error($model, 'batteryCapacity')?></div>
            </div>
            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', '')?>"
                       data-content="<?=_t('copter-interface', '')?>">
                    <?=_t('copter-interface', '# parallel')?>:</label>
                <br/>
                <?=$form->textField($model, 'batteryParallelCount', array('class' => 'span1', 'data-name' => 'parallel_count'))?>
                <span class="help-inline"><?=_t('copter-interface', 'P')?></span>
                <div class="error-message"><?=$form->error($model, 'batteryParallelCount')?></div>
            </div>
        </div>
        <div class="row">
            <div class="span4">&nbsp;</div>
            <div class="span2">
                <label><?=_t('copter-interface', 'Volt per Cell')?>:</label>
                <br/>
                <?=$form->textField($model, 'batteryVoltPerCell', array('class' => 'span1', 'data-name' => 'volt_per_cell'))?>
                <span class="help-inline"><?=_t('copter-interface', 'V')?></span>
                <div class="error-message"><?=$form->error($model, 'batteryVoltPerCell')?></div>
            </div>
            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', 'Cell weight')?>"
                       data-content="<?=_t('copter-interface', 'Battery cell weight')?>">
                    <?=_t('copter-interface', 'Weight per Cell')?>:</label>
                <br/>
                <?=$form->textField($model, 'batteryWeightPerCell', array('class' => 'span1', 'data-name' => 'weight_per_cell'))?>
                <span class="help-inline"><?=_t('copter-interface', 'g')?></span>
                <div class="error-message"><?=$form->error($model, 'batteryWeightPerCell')?></div>
            </div>
            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', 'Resistance')?>"
                       data-content="<?=_t('copter-interface', 'Battery internal resistance')?>">
                    <?=_t('copter-interface', 'Resistance')?>:</label>
                <br/>
                <?=$form->textField($model, 'batteryResistance', array('class' => 'span1', 'data-name' => 'resistance'))?>
                <span class="help-inline"><?=_t('copter-interface', 'Ohm')?></span>
                <div class="error-message"><?=$form->error($model, 'batteryResistance')?></div>
            </div>
        </div>
    </fieldset>


    <div class="row process-row">
        <div class="span6">
            <ul class="calc-result"></ul>
        </div>
        <div class="span4" style="width: 333px">
            <?=Html::submitButton(_t('copter-interface', 'Calc'), array('class' => 'btn btn-success calc-form-button'))?>
            <button class="btn processing-button disabled"><i class="loader-ic"></i> <?=_t('copter-interface', 'Processing')?></button>

            <div class="input-append calc-link-group hidden">
                <input type="text" class="span2 calc-link" value="http://rc-calc.com/c/qwertyuiop">
                <a href="#" title="<?=_t('copter-interface', 'Regenerate new link')?>"
                        type="button" class="btn btn-warning btn-small regenerate-link">
                    <i class="icon-refresh"></i>
                </a>
            </div>
        </div>
    </div>

    <fieldset class="result-row">
        <div class="title"><?=_t('copter-interface', 'Results')?></div>

        <div class="row">
            <div class="span2">
                <label  data-original-title="<?=_t('copter-interface', 'Flight time')?>"
                        data-content="<?=_t('copter-interface', 'Approximate hover flight time')?>">
                    <?=_t('copter-interface', 'Flight time hover')?>:</label>
                <br/>
                <input type="text" class="span1" value="" data-name="flightTimeHover">
                <span class="help-inline"><?=_t('copter-interface', 'min')?></span>
            </div>
            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', 'Flight time')?>"
                       data-content="<?=_t('copter-interface', 'Mininum flight time with full throttle')?>">
                    <?=_t('copter-interface', 'Flight time min')?>:</label>
                <br/>
                <input type="text" class="span1" value="" data-name="flightTimeMin">
                <span class="help-inline"><?=_t('copter-interface', 'min')?></span>
            </div>
            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', 'Throttle level')?>"
                       data-content="<?=_t('copter-interface', 'Takeoff throttle level')?>">
                    <?=_t('copter-interface', 'Throttle')?>:</label>
                <br/>
                <input type="text" class="span1" value="" data-name="throttle">
                <span class="help-inline">%</span>
            </div>
            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', 'Weight')?>"
                       data-content="<?=_t('copter-interface', 'Full copter weight')?>">
                    <?=_t('copter-interface', 'Total weight')?>:</label>
                <br/>
                <input type="text" class="span1" value="" data-name="totalWeight">
                <span class="help-inline"><?=_t('copter-interface', 'g')?></span>
            </div>
            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', 'Add payload')?>"
                       data-content="<?=_t('copter-interface', 'Addition payload')?>">
                    <?=_t('copter-interface', 'Add payload')?>:</label>
                <br/>
                <input type="text" class="span1" value="" data-name="addPayload">
                <span class="help-inline"><?=_t('copter-interface', 'g')?></span>
            </div>
        </div>
        <div class="row more-result">
            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', 'Max Current')?>"
                       data-content="<?=_t('copter-interface', 'Maximum current for full throttle')?>">
                    <?=_t('copter-interface', 'Max Total Current')?>:</label>
                <br/>
                <input type="text" class="span1" value="" data-name="totalCurrentMax">
                <span class="help-inline"><?=_t('copter-interface', 'A')?></span>
            </div>
            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', 'Hover Current')?>"
                       data-content="<?=_t('copter-interface', 'Total current for hover')?>">
                    <?=_t('copter-interface', 'Hover Total Current')?>:</label>
                <br/>
                <input type="text" class="span1" value="" data-name="totalCurrentHover">
                <span class="help-inline"><?=_t('copter-interface', 'A')?></span>
            </div>
            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', 'Max Load')?>"
                       data-content="<?=_t('copter-interface', 'Max battery load in C')?>">
                    <?=_t('copter-interface', 'Max Load')?>:</label>
                <br/>
                <input type="text" class="span1" value="" data-name="maxBatteryLoad">
                <span class="help-inline"><?=_t('copter-interface', 'C')?></span>
            </div>
            <div class="span2">
                <label data-original-title="<?=_t('copter-interface', 'Drive weight')?>"
                       data-content="<?=_t('copter-interface', 'Total drive weight (motors+ESC+battery)')?>">
                    <?=_t('copter-interface', 'Drive Weight')?>:</label>
                <br/>
                <input type="text" class="span1" value="" data-name="totalDriveWeight">
                <span class="help-inline"><?=_t('copter-interface', 'g')?></span>
            </div>
        </div>
    </fieldset>

<? $this->endWidget() ?>
