<?
/** @var CopterCalcModel $model */
/** @var CopterCalcResult $calc */
?>

<div class="thumbnail">
    <div class="caption">
        <h4>
            <?=Html::link($model->title, array('/calc/copter', 'hash' => $model->getHash()))?>
        </h4>

        <ul>
            <li>
                <?=_t('widget-copter-info', 'Weight')?>:
                    <?=Y::nf()->formatDecimal($calc->totalWeight)?>
                    <?=_t('widget-copter-info', 'gr')?>
            </li>
            <li>
                <?=_t('widget-copter-info', 'Flight time')?>: <?=$calc->flightTimeHover?> <?=_t('widget-copter-info', 'min')?>
            </li>
            <?if($this->showDelete && $model->getIsOwner()):?>
                <span class="label label-info"><?=Html::link(_t('widget-copter-info', 'Remove'), array('/calc/delete', 'hash' => $model->getHash()),
                    array('style' => 'color:#fff; font-weight: normal;', 'confirm' => _t('copter-interface', 'Really delete?')))?></span>
            <?endif?>
        </ul>
    </div>
</div>
