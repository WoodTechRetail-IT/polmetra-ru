<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once DIR_SYSTEM . 'IMDBOptimizer/IMDBOSettings.php';
require_once DIR_SYSTEM . 'IMDBOptimizer/Cache/IMDBOCacheDB.php';
require_once DIR_SYSTEM . 'IMDBOptimizer/Cache/IMDBOCacheFile.php';

class IMDBOClientAPI
{
	protected $db;

	protected $language;

	protected $config;

	protected $settingsProvider;

	////////////////////////////
	// Конструктор
	////////////////////////////
	function __construct(&$db = null, &$language = null, &$config = null)
	{
		if (isset($db)) {
			$this->db = &$db;
		} else {
			$this->db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
		}

		if (isset($language)) {
			$this->language = &$language;
		}

		if (isset($config)) {
			$this->config = &$config;
		}

		$this->settingsProvider = new IMDBOSettings($this->db);
	}

	////////////////////////////
	// Интерфейс
	////////////////////////////
	public function enableSQLCache()
	{
		$this->settingsProvider->updateSettings(
			'cache', array( 'enable' => 1 )
		);

		$result = array(
			'action' => 'EnableSQLCache',
			'success' => 1,
			'message' => 'SQL Cache Enabled',
		);

		return $result;
	}

	public function disableSQLCache()
	{
		$this->settingsProvider->updateSettings(
			'cache', array( 'enable' => 0 )
		);

		$result = array(
			'action' => 'DisableSQLCache',
			'success' => 1,
			'message' => 'SQL Cache Disabled',
		);

		return $result;
	}

	public function clearSQLCache()
	{
		$cacheDB = new IMDBOCacheDB($this->db);
		$cacheDB->clearAll();

		$cacheFile = new IMDBOCacheFile();
		$cacheFile->clearAll();

		$result = array(
			'action' => 'ClearSQLCache',
			'success' => 1,
			'message' => 'SQL Cache Cleared',
		);

		return $result;
	}

	public function enableSQLLog()
	{
		$this->settingsProvider->updateSettings(
			'log', array( 'enable_log_slow_query' => 1 )
		);

		$result = array(
			'action' => 'EnableSQLLog',
			'success' => 1,
			'message' => 'SQL Log Enabled',
		);

		return $result;
	}

	public function disableSQLLog()
	{
		$this->settingsProvider->updateSettings(
			'log', array( 'enable_log_slow_query' => 0 )
		);

		$result = array(
			'action' => 'DisableSQLLog',
			'success' => 1,
			'message' => 'SQL Log Disabled',
		);

		return $result;
	}

	public function clearSQLLog()
	{
		$this->settingsProvider->checkLogSettings();
		$logSettings = $this->settingsProvider->getSettings('log');

		$dirToLog = DIR_SYSTEM . 'IMDBOptimizer/Log/';
		$filename = 'imdbo_slow_' . $logSettings['file_name_salt'] . '.log';
		if (file_exists($dirToLog . $filename)) {
			@unlink($dirToLog . $filename);
		}

		$result = array(
			'action' => 'ClearSQLLog',
			'success' => 1,
			'message' => 'SQL Log Cleared',
		);

		return $result;

	}

	////////////////////////////
	// Единый вызов
	////////////////////////////
	public function execActions($actions = '')
	{
		$result = array();
		$actionList = array();
		$temp = '';

		if ( !isset($actions) || empty ($actions) ) {
			return $result;
		}

		////////////////////////////
		// Распаковываем экшены
		////////////////////////////
		if ( is_array($actions) ) {
			foreach ($actions as $item) {
				if ( trim($item) == '' ) continue;
				$actionList[] = strtolower(trim($item));
			}
		} else {
			$temp = explode(',', $actions);
			foreach ($temp as $item) {
				if ( trim($item) == '' ) continue;
				$actionList[] = strtolower(trim($item));
			}
		}

		////////////////////////////
		// Вызываем интерфейс
		////////////////////////////
		for($cnt = 0; $cnt < count($actionList); $cnt++) {
			if ( $actionList[$cnt] == strtolower('enableSQLCache') ) {
				$result[] = $this->enableSQLCache();
			} else if ( $actionList[$cnt] == strtolower('disableSQLCache') ) {
				$result[] = $this->disableSQLCache();
			} else if ( $actionList[$cnt] == strtolower('clearSQLCache') ) {
				$result[] = $this->clearSQLCache();
			} else if ( $actionList[$cnt] == strtolower('enableSQLLog') ) {
				$result[] = $this->enableSQLLog();
			} else if ( $actionList[$cnt] == strtolower('disableSQLLog') ) {
				$result[] = $this->disableSQLLog();
			} else if ( $actionList[$cnt] == strtolower('clearSQLLog') ) {
				$result[] = $this->clearSQLLog();
			} else {
				$result[] = array(
					'action' => $actionList[$cnt],
					'success' => 0,
					'error' =>	'Action "' . $actionList[$cnt] . '" not support'
				);
			}
		}

		return $result;
	}

}
