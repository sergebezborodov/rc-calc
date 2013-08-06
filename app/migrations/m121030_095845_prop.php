<?php

class m121030_095845_prop extends CDbMigration
{
	public function up()
	{
        $this->addColumn('propeller', 'max_rpm_const', 'INT NULL DEFAULT NULL');
        Y::dbc()->update('propeller', array('max_rpm_const' => 190000), 'id = 3');
        Y::dbc()->update('propeller', array('max_rpm_const' => 145000), 'id = 2');
        Y::dbc()->update('propeller', array('max_rpm_const' => 65000), 'id = 1');
	}

	public function down()
	{
		$this->dropColumn('propeller', 'max_rpm_const');
	}
}
