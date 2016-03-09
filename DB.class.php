<?php

class DB {

	private static $instance; 

	public static function getDBinstance() {

			if (!self::$instance) {
				require_once('db.conf.php');
				self::$instance = new mysqli(CONF_DB_SERVER, CONF_DB_USERNAME,CONF_DB_PASSWORD, CONF_DB_DATABASE);
				self::$instance->query("SET students 'utf8");
				return self::$instance;
			}else {
				return self::$instance;
			}
	}
	private function __construct(){}
	private function __clone(){}

}