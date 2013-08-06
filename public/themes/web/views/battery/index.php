<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dataProvider,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'cssFile' => false,
    'ajaxUpdate' => false,
    'columns' => array(
        array(
            'name' => 'id',
            'headerHtmlOptions' => array('class' => 'span1'),
        ),
        array(
            'name' => 'manufacter_id',
            'headerHtmlOptions' => array('class' => 'span3'),
            'type' => 'raw',
            'value' => function($data) {
                return $data->manufacter->title;
            },
        ),
        array(
            'name' => 'model',
            'type' => 'raw',
            'value' => function($data) {
                return Html::link($data->title, array('update', 'id' => $data->id));
            },
        ),
    )
));
