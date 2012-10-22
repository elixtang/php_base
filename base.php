<?php
//initialisation for mysql lib
require("lib/ez_sql_core.php");
require("lib/ez_sql_mysql.php");

/**
 * Model class
 *
 * @package Model
 * @author Chengguang Tang <tangchengguang@126.com>
 * @copyright (c)2012 Chengguang Tang
 * @License MIT
 */
class Base { 
        /**     
         * file to array
         *              
         * @param none
         * @return array (array)
         */  
	public static function file_to_array() {
		require('config/config.php');
		$arr = array();
		foreach ($files as $k => $v) {
			$arr[$k] = file($v);
		}
		return $arr;
	}

        /**     
         * initialize mysql
         *              
         * @param none
         * @return resource (object)
         */  
        public static function mysql_init() {
                require("config/config.php");
                $db = new ezSQL_mysql($db['dbuser'], $db['dbpasswd'], $db['dbname'], $db['dbhost'] . ':' . $db['dbport']);
                return $db;
        }

        /**     
         * handle insert, update and delete operation
         *              
         * @param resource (object)
         * @param string
         * @return string
         */  
	public static function mysql_write($db, $sql) {
		return $db->query($sql);
	}

        /**     
         * handle select operation
         *              
         * @param resource (object)
         * @param string
         * @return array (an array of objects)
         */  
	public static function mysql_read($db, $sql) {
		$results = $db->get_results($sql);
		return $results;
	}
}
?>
