<?php

$langsUrlParam = '<language:('.implode('|', array_keys(require 'others/langs.php')).')>';



return array(
    'theme' => 'web',

    'preload' => array('bootstrap', 'input'),

    // application components
    'components' => array(
        'user' => array(
            'class' => 'WebUser',
            'loginDuration' => 3600 * 24 * 100,
            'allowAutoLogin' => true,
        ),
        'input' => array(
            'class'         => 'CmsInput',
            'cleanPost'     => true,
            'cleanGet'      => true,
        ),
        'urlManager' => array(
            'class' => 'UrlManager',
            'urlFormat'       => 'path',
            'showScriptName'  => false,
            'rules' => array(
                $langsUrlParam.'/' => array('/site/index'),

                $langsUrlParam.'/copter/<hash:[\w+\d+]+>' => array('/calc/copter'),
                $langsUrlParam.'/copter' => array('/calc/copter'),
                '/c/<hash:\w+>' => array('/calc/redirect'),
                '/copter' => array('/calc/copter'),

                $langsUrlParam.'/login' => 'user/login',
                '/u/<username:[\w+\d+-_]+>' => 'user/page',

                $langsUrlParam.'/<controller:\w+>/<id:\d+>'=>'<controller>/view',
                $langsUrlParam.'/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                $langsUrlParam.'/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
            'notLangRoutes' => array(
                'user/page'
            ),
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'bootstrap'=>array(
            'class' => 'ext.yii-bootstrap.components.Bootstrap',
        ),
        'loid' => array(
            'class' => 'ext.lightopenid.loid',
        ),
		'eauth' => array(
            'class' => 'ext.eauth.EAuth',
            'popup' => true, // Использовать всплывающее окно вместо перенаправления на сайт провайдера
            'cache' => false, // Названия компнента для кеширования. False для отключения кеша. По умолчанию 'cache'.
            'cacheExpire' => 0, // Время жизни кеша. По умолчанию 0 - означает перманентное кеширование.
			'services' => array( // Вы можете настроить список провайдеров и переопределить их классы
                'google' => array(
                    'class' => 'GoogleOpenIDService',
                ),
                'yandex' => array(
                    'class' => 'YandexOpenIDService',
                ),
//                'yandex_oauth' => array(
//                    // регистрация приложения: https://oauth.yandex.ru/client/my
//                    'class' => 'YandexOAuthService',
//                    'client_id' => '540327e984044b9b856dc9d9402aa0de',
//                    'client_secret' => '1387ae4d4dcd42c98874af19ce7ac63d',
//                    'title' => 'Yandex (OAuth)',
//                ),
                'facebook' => array(
                    // регистрация приложения: https://developers.facebook.com/apps/
                    'class' => 'FacebookOAuthServiceEx',
                    'client_id' => '432455600135362',
                    'client_secret' => '3ef409eeaeee1131d5417fd77f5643a4',
                ),
                'vkontakte' => array(
                    // регистрация приложения: http://vk.com/editapp?act=create&site=1
                    'class' => 'VKontakteOAuthServiceEx',
                    'client_id' => '3218802',
                    'client_secret' => 'CtqwArrL9oyNFkrn7Nl8',
                ),
			),
		),
    ),
);
