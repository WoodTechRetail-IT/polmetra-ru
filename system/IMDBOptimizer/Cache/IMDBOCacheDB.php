<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

class IMDBOCacheDB
{
	const TABLE_TYPE_MYISAM = 'myisam';
	const TABLE_TYPE_INNODB = 'innodb';

	private $db;
	
	private $expire;

	private $table_type;

	public function __construct(&$db, $expire = 3600, $table_type = IMDBOCacheDB::TABLE_TYPE_MYISAM)
	{
		if (!isset($db) || empty($db)) {
			exit('Error: IMDBO Could not load database!');
		}
		
		$this->db = &$db;
		
		$this->expire = $expire;

		$this->table_type = $table_type;
	}

	/////////////////////////////
	// Установка - удаление
	/////////////////////////////
	public function install()
	{
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "imdbo_cache` (
			  `imdbo_cache_id` int(11) NOT NULL AUTO_INCREMENT, 
			  `key` varchar(255) NOT NULL,
			  `value` text NOT NULL,
			  `in_file` int(11) NOT NULL,
			  `extime` int(11) NOT NULL,
			  PRIMARY KEY (`imdbo_cache_id`),
			  INDEX (`key`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
		);

		// 1.4.0
		$this->db->query(
			'ALTER TABLE `' . DB_PREFIX . 'imdbo_cache` '
			. ' MODIFY COLUMN `imdbo_cache_id` '
			. ' BIGINT AUTO_INCREMENT '
		);

		// 1.4.0
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "imdbo_cache_innodb` (
			  `imdbo_cache_id` int(11) NOT NULL AUTO_INCREMENT,
			  `key` varchar(255) NOT NULL,
			  `value` text NOT NULL,
			  `in_file` int(11) NOT NULL,
			  `extime` int(11) NOT NULL,
			  PRIMARY KEY (`imdbo_cache_id`),
			  INDEX (`key`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
		);

		// 1.4.0
		$this->db->query(
			'ALTER TABLE `' . DB_PREFIX . 'imdbo_cache_innodb` '
			. ' MODIFY COLUMN `imdbo_cache_id` '
			. ' BIGINT AUTO_INCREMENT '
		);
	}

	public function uninstall()
	{
		
	}

	// 1.4.0
	/////////////////////////////
	// Таблица
	/////////////////////////////

	protected function _getTableName()
	{
		switch ($this->table_type) {
			case IMDBOCacheDB::TABLE_TYPE_INNODB:
				return 'imdbo_cache_innodb';
			default:
				return 'imdbo_cache';
		}
	}

	public function getTableType()
	{
		return $this->table_type;
	}

	public function setTableType($value)
	{
		if (isset($value) && !empty($value)) {
			$this->table_type = $value;
		}
	}

	/////////////////////////////
	// Интерфейс
	/////////////////////////////

	public function get($key)
	{
		$this->deleteExpire($key);
		
		$queryString =	
			'select * '
			. ' from `' . DB_PREFIX . $this->_getTableName() . '` '
			. ' where `key` = \'' . $this->db->escape($key) . '\''
		;
		
		$result = $this->db->query($queryString);
		
		if ($result->num_rows) {
			return $result->rows[0];
		}
		return NULL;
	}

	public function set($key, $value, $in_file = 0)
	{
		$this->delete($key);
		
		$queryString = 
			'insert into `' . DB_PREFIX . $this->_getTableName() . '` '
				. ' (`key`, `value`, `extime`, `in_file`) '
			. ' values( '
				. ' \'' . $this->db->escape($key) . '\', '
				. (
					(int)$in_file > 0
					? '\'\''
					: ( '\'' . $this->db->escape(json_encode($value, true)) . '\'' )
				) . ', '
				. ' ' . (int)(time() + $this->expire) . ', '
				. ' ' . (int)$in_file . ' '
			. ' ) '
		;
		
		$this->db->query($queryString);
	}

	public function delete($key)
	{
		$queryString = 'delete from `' . DB_PREFIX . $this->_getTableName() . '` '
			. ' where `key` = \'' . $this->db->escape($key) . '\' '
		;
		
		$this->db->query($queryString);
	}

	public function deleteExpire($key)
	{
		$time = time();
		
		$queryString = 'delete from `' . DB_PREFIX . $this->_getTableName() . '` '
			. ' where `key` = \'' . $this->db->escape($key) . '\' '
				. ' and `extime` < ' . time() . ' '
		;
		
		$this->db->query($queryString);
	}
	
	public function clearAll()
	{
		$queryString = 'truncate table `' . DB_PREFIX . 'imdbo_cache` ';
		$this->db->query($queryString);

		$queryStringInnoDB = 'truncate table `' . DB_PREFIX . 'imdbo_cache_innodb` ';
		$this->db->query($queryStringInnoDB);
	}
}
