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
			$tmp = file($v);
			array_walk($tmp, function(&$v){
				$v = trim($v);
			});
			$arr[$k] = $tmp;
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
		$db->query("set names utf8");
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

        /**     
         * handle truncate table operation
         *              
         * @param string
         * @return boolean
         */  
	public static function truncate($table) {
		$conn = self::mysql_init();
		$sql = "show tables like '{$table}'";
		$res = self::mysql_read($conn, $sql);
		if (!$res) {
			echo "\033[31;49;5m [Table `" . $table. "` doesn't exists ] \033[39;49;0m\n";
			return FALSE;
		}
		self::mysql_write($conn, "truncate table {$table}");
		return TRUE;
	}
}

class Helper {

	/**
	 * init
	 *
	 * check plugin curl exists or not
	 * @param none
	 * @return none
	 */
	public function __construct() {
		if (!function_exists('curl_init')) {
			throw new Exception('Helper requires the php-curl extension to be installed.');
		}
	}

	/**
	 * send HTTP GET request using curl
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public static function curl_download($Url, $refer = null, $user_agent = null) {
		if (!$refer) $refer = 'http://www.37du.com/';
		if (!$user_agent) $user_agent = 'Mozilla/4.0 (Windows NT 6.1) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.83';
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $Url);
		curl_setopt($ch, CURLOPT_REFERER, $refer);
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}

	/**
	 * create a GET query for URLs
	 *
	 * @param array
	 * @return string
	 */
	public static function encode_array($args) {
		if (!is_array($args)) return 'null';
		$c = 0;
		$out = '';
		foreach ($args as $name => $value) {
			if ($c++ != 0) $out .= '&';
			$out .= urlencode("$name").'=';
			if (is_array($value)) {
				$out .= urlencode(serialize($value));
			} else {
				$out .= urlencode("$value");
			}
		}
		return $out . "\n";
	}

	/**
	 * get provnice and city map
	 *
	 * @param none
	 * @return array
	 */
	public static function prov_city_map() {
		return require('./lib/pc_map.php');
	}
}

?>
