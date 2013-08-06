<?php

return array(
	'name' => 'Platform',

    'components' => array(
        'gearmanClient' => array(
            'servers' => array(
                array('host' => '127.0.0.1', 'port' => 4730,)
            ),
        ),
    ),
);
