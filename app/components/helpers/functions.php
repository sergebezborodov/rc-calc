<?php

function sqldate($timestamp = null) {
    $format = "Y-m-d H:i:s";
    return (empty($timestamp)) ? date($format) : date($format, $timestamp);
}

function _t($cat, $message, $params=array())
{
    return Yii::t($cat, $message, $params);
}
