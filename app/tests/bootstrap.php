<?php

// change the following paths if necessary
require dirname(__FILE__).'/../../lib/platform/platformt.php';
$shared = require dirname(__FILE__).'/../../etc/shared.php';
$local = require dirname(__FILE__).'/../../etc/local/local.php';
$test = require dirname(__FILE__).'/../../etc/test.php';

$config = CMap::mergeArray($shared, $test);
$config = CMap::mergeArray($config, $local);


require_once(dirname(__FILE__) . '/WebTestCase.php');

Yii::createWebApplication($config);
