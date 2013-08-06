<?php

// настройки приложения
return array(
    'admin'       => array(
        'pageSize' => 50,
    ),
    'langs'       => require 'langs.php',
    'defaultLang' => 'ru',
    'hashLength'  => 6,

    'storage' => array(
        'path' => 'root.public.storage',

        'avatar' => array(
            'big' => array(
                'width' => 200,
                'height' => 200,
            ),
            'middle' => array(
                'width' => 100,
                'height' => 100,
            ),
            'small' => array(
                'width' => 50,
                'height' => 50,
            ),
        ),
    ),

    'formula'     => array(
        'copter' => array(
            'airPressure'   => 1013,
            'elevation'     => 500,
            'airTemp'       => 25,
            'wGrad'         => 1,

            'stdAirdensity' => 101325 / 287.05 / 288.15,
            /*
            1 - excellent
            1.75 - good
            2.5 - medium
            3.5 - poor
            5.5 - very poor
            */
            'motorCooling'  => 2.5,
        ),
    ),
);
