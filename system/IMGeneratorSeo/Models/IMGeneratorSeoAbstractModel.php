<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once DIR_SYSTEM . 'IMGeneratorSeo/IMGeneratorSeoHelper.php';

abstract class IMGeneratorSeoAbstractModel
{
	protected $db;

	protected $language;

	protected $config;

	protected $imhelper;

	// Конструктор
	function __construct(&$db = null, &$language = null, &$config = null)
	{
		if (isset($db)) {
			$this->db = &$db;
		} else {
			$this->db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
		}

		$this->imhelper = new IMGeneratorSeoHelper($this->db);

		if (isset($language)) {
			$this->language = &$language;
		}

		if (isset($config)) {
			$this->config = &$config;
		}
	}

	// Получение значения из локализации
	public function getLangVal($name = '', $default = '')
	{
		if (isset($name) && trim($name) != '' && isset($this->language)) {
			return $this->language->get($name);
		}
		return $default;
	}

}
