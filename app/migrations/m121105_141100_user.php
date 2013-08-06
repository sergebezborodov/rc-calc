<?php

class m121105_141100_user extends CDbMigration
{
	public function up()
	{
        $this->createTable('user', array(
            'id'             => 'pk',
            'name'           => 'VARCHAR(50) NOT NULL',
            'avatar'         => 'VARCHAR(40) NULL DEFAULT NULL',
            'email'          => 'VARCHAR(100) NULL DEFAULT NULL',
            'city'           => 'VARCHAR(50) NULL DEFAULT NULL',
            'hash'           => 'CHAR(7) NOT NULL',
            'username'       => 'VARCHAR(30) NOT NULL',

            'date_updated'   => "TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00'",
            'date_created'   => "TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00'",
            'date_lastlogin' => "TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00'"
        ));

        $this->createTable('auth_identity', array(
            'id' => 'pk',
            'title' => 'VARCHAR(50) NOT NULL',
            'alias' => 'VARCHAR(50) NOT NULL',
        ));

        $this->createTable('user_identity', array(
            'id'               => 'pk',
            'user_id'          => 'INT(11) NOT NULL',
            'auth_identity_id' => 'INT(11) NOT NULL',
            'identity_hash'    => 'TEXT',
        ));

        $identities = array(
            array(
                'title' => 'Google',
                'alias' => 'google',
            ),
            array(
                'title' => 'Yandex',
                'alias' => 'yandex',
            ),
            array(
                'title' => 'Twitter',
                'alias' => 'twitter',
            ),
            array(
                'title' => 'Facebook',
                'alias' => 'facebook',
            ),
            array(
                'title' => 'VKontakte',
                'alias' => 'vkontakte',
            ),
        );

        foreach ($identities as $ident) {
            $this->insert('auth_identity', $ident);
        }
	}

	public function down()
	{
		$this->dropTable('user');
        $this->dropTable('auth_identity');
        $this->dropTable('user_identity');
	}
}
