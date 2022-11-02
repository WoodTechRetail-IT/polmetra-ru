<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMDBOptimizerHelper.php';

if (!defined('IMDBO_NL')) {
	define('IMDBO_NL', "\n");
}

class IMDBOSettings
{
	private $db;

	private $helper;

	public function __construct(&$db)
	{
		if (!isset($db) || empty($db)) {
			exit('Error: IMDBO Could not load database!');
		}

		$this->db = &$db;

		$this->helper = new IMDBOptimizerHelper($db);
	}

	/////////////////////////////
	// Установка - удаление
	/////////////////////////////
	public function checkCacheSettings()
	{
		$currSet = $this->getSettings('cache');

		if (!isset($currSet['enable'])) {
			$this->updateSettings('cache', array( 'enable' => 0 ));
		}

		if (!isset($currSet['maxdblen'])) {
			$this->updateSettings('cache', array( 'maxdblen' => 20000 ));
		}

		if (!isset($currSet['expire'])) {
			$this->updateSettings('cache', array( 'expire' => 3600 ));
		}

		// 1.4.1
		if (!isset($currSet['mintime_to_cache'])) {
			$this->updateSettings('cache', array( 'mintime_to_cache' => 20 ));
		}

		// 1.4.1
		if (!isset($currSet['filters'])) {
			$defaultFiltersArray = array(
				'#address',
				'#api',
				'#banner',
				'#cart',
				'#country',
				'#coupon',
				'#currency',
				'#customer',
				'#custom_field',
				'#download',
				'#event',
				'#extension',
				'#filter',
				'#geo_zone',
				'#language',
				'#layout',
				'#length_class',
				'#location',
				'#marketing',
				'#modification',
				'#module',
				'#order',
				'#recurring',
				'#return',
				'#seo_url',
				'#setting',
				'#session',
				'#shipping_courier',
				'#statistics',
				'#theme',
				'#translation',
				'#upload',
				'#user',
				'#voucher',
				'#weight_class',
				'#zone',
			);

			$filterString = '';

			foreach($defaultFiltersArray as $item) {
				$filterString .= $item . IMDBO_NL;
			}

			$this->updateSettings('cache', array( 'filters' => $filterString ));
		}

		if (!isset($currSet['urls'])) {
			$defaultUrlsArray = array(
				'r: #/cart',
				'r: #/cart/',
				'i: =checkout/',
				'r: #/checkout',
				'r: #/checkout/',
				'r: #/simplecheckout',
				'r: #/simplecheckout/',
				'i: =common/cart/',
				'i: =account/',
				'i: =extension/total/',
				'i: =extension/payment/',
				'i: =affiliate/',
			);

			$urlsString = '';

			foreach($defaultUrlsArray as $item) {
				$urlsString .= $item . IMDBO_NL;
			}

			$this->updateSettings('cache', array( 'urls' => $urlsString ));
		}
	}
	
	public function checkLogSettings()
	{
		$currSet = $this->getSettings('log');

		if (!isset($currSet['enable_log_slow_query'])) {
			$this->updateSettings('log', array( 'enable_log_slow_query' => 0 ));
		}

		if (!isset($currSet['enable_log_slow_query_admin'])) {
			$this->updateSettings('log', array( 'enable_log_slow_query_admin' => 0 ));
		}

		if (!isset($currSet['log_slow_query_time'])) {
			$this->updateSettings('log', array( 'log_slow_query_time' => 1000 ));
		}

		if (!isset($currSet['log_slow_query_write_url'])) {
			$this->updateSettings('log', array( 'log_slow_query_write_url' => 0 ));
		}

		if (!isset($currSet['file_name_salt']) || empty($currSet['file_name_salt'])) {
			$this->updateSettings('log', array( 'file_name_salt' => $this->helper->getSalt(20) ));
		}
	}

	public function install()
	{
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "imdbo_settings` (
			  `imdbo_settings_id` int(11) NOT NULL AUTO_INCREMENT,
			  `code` varchar(50) NOT NULL,
			  `key` varchar(200) NOT NULL,
			  `value` text NOT NULL,
			  `serialized` int(11) NOT NULL,
			  PRIMARY KEY (`imdbo_settings_id`),
			  INDEX(`code`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
		);

		////////////////////////////////////
		// Кэш
		// Установка параметров по умолчанию
		////////////////////////////////////
		$this->checkCacheSettings();

		////////////////////////////////////
		// Лог
		// Установка параметров по умолчанию
		////////////////////////////////////
		$this->checkLogSettings();
	}

	public function uninstall()
	{
		if ($this->helper->isTableExists('imdbo_settings')) {
			// 1.4.1
			// Выключаем кэш
			$this->updateSettings('cache', array( 'enable' => 0 ));
			// Выключаем лог запросов
			$this->updateSettings('log', array( 'enable_log_slow_query' => 0 ));
		}
	}

	/////////////////////////////
	// Интерфейс
	/////////////////////////////
	public function getSettings($code)
	{
		$data = array();

		$queryString =
			' select * '
			. ' from `' . DB_PREFIX . 'imdbo_settings` '
			. ' where `code` = \'' . $this->db->escape($code) . '\' '
		;

		$query = $this->db->query($queryString);

		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$data[$result['key']] = $result['value'];
			} else {
				$data[$result['key']] = json_decode($result['value'], true);
			}
		}

		return $data;
	}

	public function setSettings($code, $values)
	{
		$this->deleteSettings($code);
		$queryString = '';

		foreach($values as $key => $value)
		{
			$queryString =
				'insert into `' . DB_PREFIX . 'imdbo_settings` '
				. ' (`code`, `key`, `value`, `serialized`) '
				. ' values( '
					. ' \'' . $this->db->escape($code) . '\', '
					. ' \'' . $this->db->escape($key) . '\', '
			;

			if (!is_array($value)) {
				$queryString .=
						' \'' . $this->db->escape($value) . '\', '
						. ' 0 '
					. ' ) '
				;
			} else {
				$queryString .=
						' \'' . $this->db->escape(json_encode($value)) . '\', '
						. ' 1 '
					. ' ) '
				;
			}
			$this->db->query($queryString);
		}
	}

	public function updateSettings($code, $values)
	{
		$currSet = $this->getSettings($code);
		$actSet = array_merge($currSet, $values);
		$this->setSettings($code, $actSet);
	}

	public function deleteSettings($code)
	{
		$queryString =
			' delete '
			. ' from `' . DB_PREFIX . 'imdbo_settings` '
			. ' where `code` = \'' . $this->db->escape($code) . '\' '
		;

		$query = $this->db->query($queryString);
	}

}
