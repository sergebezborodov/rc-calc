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
            'name' => 'title',
            'type' => 'raw',
            'value' => function($data) {
                return Html::link($data->title, array('update', 'id' => $data->id));
            },
        ),
    )
));
