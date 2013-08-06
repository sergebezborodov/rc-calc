<?php

$basePath = dirname(__FILE__) . '/../app';

require_once $basePath . '/components/helpers/functions.php';
require 'others/CacheConf.php';

return array(
    'basePath'    => dirname(__FILE__) . '/../app',
    'name'        => 'Rc Calc',
    'runtimePath' => ROOT . '/tmp',
    'language' => 'ru',

    // preloading 'log' component
    'preload'     => array('log'),

    // autoloading model and component classes
    'import'      => array(
        'application.components.*',
        'application.components.auth.*',
        'application.components.base.*',
        'application.components.exceptions.*',
        'application.components.helpers.*',

        'application.models.*',
        'application.models.calc.*',

        'ext.logger.*',

        'ext.eoauth.*',
        'ext.eoauth.lib.*',
        'ext.lightopenid.*',
        'ext.eauth.*',
        'ext.eauth.services.*',

        'application.widgets.frontend.*'
    ),

    // application components
    'components'  => array(
        'db'     => require_once 'local/database.php',
        'mongo'  => array(
            'class' => 'application.components.mongo.MongoDBConnection',
            'db'    => 'rc-calc',
        ),
        'cache'  => array(
            'class' => 'CDummyCache',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
            ),
        ),
    ),

    'params'      => require_once 'others/params.php',
);
