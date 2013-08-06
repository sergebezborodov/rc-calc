<?php

return array(
    'sourcePath'  => dirname(__FILE__) . DIRECTORY_SEPARATOR . '../..',
    'messagePath' => dirname(__FILE__),
    'languages'   => array('ru'),
    'fileTypes'   => array('php'),
    'translator'  => '_t',
    'overwrite'   => true,
    'removeOld'   => false,
    'exclude'     => array(
        '/_devel',
        '/bin',
        '/platform',
        '/app/extensions/',
        '/app/runtime/',
        '/app/tests/',
        '/app/services/',
        '/app/vendors/',
        '/app/views/',
        '/app/widgets/views/',
    ),
);
