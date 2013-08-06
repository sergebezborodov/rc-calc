<?php

class m121101_105646_calcs extends CDbMigration
{
    public function up()
    {
        $this->createTable('calc', array(
            'id'            => 'pk',
            'hash'          => 'CHAR(5) NOT NULL',
            'data'          => 'TEXT NOT NULL',
            'ps_user_id'    => 'BIGINT(20) NOT NULL',
            'view_count'    => 'INT(11) NOT NULL DEFAULT 1',
            'date_updated'  => "TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00'",
            'date_created'  => "TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00'",
            'date_lastview' => "TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00'",
        ));
        $this->createIndex('calc', 'calc', 'hash', true);
    }

    public function down()
    {
        $this->dropTable('calc');
    }
}
