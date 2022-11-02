<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once DIR_SYSTEM . 'IMDBOptimizer/IMDBOLicSA100.php';
require_once 'IMDBOCacheDB.php';
require_once 'IMDBOCacheFile.php';
require_once DIR_SYSTEM . 'IMDBOptimizer/IMDBOSettings.php';
require_once DIR_SYSTEM . 'IMDBOptimizer/IMDBOLog.php';
require_once DIR_SYSTEM . 'IMDBOptimizer/IMDBOptimizerHelper.php';

if (!defined('IMDBO_NL')) {
	define('IMDBO_NL', "\n");
}

if (!defined('IMDBO_R')) {
	define('IMDBO_R', "\r");
}

class IMDBOCacheProcessor
{
	//////////////////////
	// Cache
	//////////////////////

	const DEFAULT_MAX_SIZE_IN_DB = 20000;
	const DEFAULT_MAX_SIZE_TEXT_FIELD = 65000;
	const DEFAULT_EXPIRE_TIME_SEC = 3600;

	private $maxLengthToDBCache = 0;

	private $db;

	private $enable = 0;

	private $isAdmin = false;

	private $isValid;

	private $expire;

	private $mintimeToCache;

	private $filters;

	private $urls;

	private $currUrl;

	private $countAffected = -1;

	private $lastId = -1;

	private $cacheDBProvider;

	private $cacheDBProviderTableType;

	private $cacheFileProvider;

	private $settingsProvider;

	private $moduleSettings;

	private $request;

	private $helper;

	private $currentState;

	//////////////////////
	// Log
	//////////////////////

	private $logSettings;

	private $logEnable;

	private $logger;

	private $logTimeCurr;

	private $logTimeMin;

	private $logAdmin;

	private $logUrl;

	private $logUrlEnable;

	/////////////////////////////////////////
	// Constructor
	/////////////////////////////////////////

	public function __construct(&$db)
	{
		if (!isset($db) || empty($db)) {
			exit('Error: IMDBO Could not load database!');
		}
		$this->db = &$db;

		$this->request = new Request();

		$this->helper = new IMDBOptimizerHelper($this->db);

		$this->settingsProvider = new IMDBOSettings($this->db);

		$this->init();

		$this->cachedCheckValid();

		$this->isAdmin = $this->checkAdmin();

		$this->logger = new IMDBOLog(
			DIR_SYSTEM . 'IMDBOptimizer/Log/'
			. 'imdbo_slow_' . $this->logSettings['file_name_salt'] . '.log'
		);

		$this->cacheDBProvider = new IMDBOCacheDB(
			$this->db, $this->expire, $this->cacheDBProviderTableType
		);

		$this->cacheFileProvider = new IMDBOCacheFile($this->expire);

		$this->currentState = array(
			'is_url_check' => false,
			'is_url_check_result' => false,
		);
	}

	protected function checkAdmin()
	{
		if (defined('HTTP_CATALOG') || defined('HTTPS_CATALOG') || defined('DIR_CATALOG')) {
			return true;
		}
		return false;
	}

	/////////////////////////////////////////
	// Инициализация
	/////////////////////////////////////////

	protected function init()
	{
		/////////////////////////////
		// Кэш
		/////////////////////////////

		$this->settingsProvider->checkCacheSettings();

		$this->moduleSettings = $this->settingsProvider->getSettings('cache');

		$this->filters = array();

		if (isset($this->moduleSettings['filters'])) {
			$filtersString = $this->moduleSettings['filters'];

			$filtersString = str_replace('#', DB_PREFIX, $filtersString);
			$filtersArray = explode(IMDBO_NL, $filtersString);

			foreach($filtersArray as $filter) {
				if (trim($filter) == '') {
					continue;
				}
				$this->filters[] = str_replace( array( IMDBO_NL, IMDBO_R ), '', $filter);
			}
		}

		$this->urls = array();

		if (isset($this->moduleSettings['urls'])) {
			$urlsString = $this->moduleSettings['urls'];

			$urlsString = str_replace('#', $this->getDomainLowerCase(), $urlsString);
			$urlsArray = explode(IMDBO_NL, $urlsString);

			foreach($urlsArray as $filter) {
				if (trim($filter) == '') {
					continue;
				}
				$filter = str_replace( array( IMDBO_NL, IMDBO_R ), '', $filter);
				$this->urls[] = str_replace(array('http://', 'https://'), '', $filter);
			}
		}

		if (isset($this->moduleSettings['maxdblen'])) {
			$this->maxLengthToDBCache = (int)$this->moduleSettings['maxdblen'];
		}

		if (isset($this->moduleSettings['expire'])) {
			$expire = (int)$this->moduleSettings['expire'];
			$this->expire = ($expire > 0 ? $expire : IMDBOCacheProcessor::DEFAULT_EXPIRE_TIME_SEC);
		}

		// 1.4.1
		if (isset($this->moduleSettings['mintime_to_cache'])) {
			$mintimeToCache = (int)$this->moduleSettings['mintime_to_cache'];
			$this->mintimeToCache = round(
				((float)$mintimeToCache) / 1000.0, 4
			);
		}

		if (isset($this->moduleSettings['enable'])) {
			$this->enable = (int)$this->moduleSettings['enable'];
		}

		if (isset($this->moduleSettings['cache_table_type'])) {
			$this->cacheDBProviderTableType = $this->moduleSettings['cache_table_type'];
		}

		/////////////////////////////
		// Лог
		/////////////////////////////

		$this->settingsProvider->checkLogSettings();

		$this->logSettings = $this->settingsProvider->getSettings('log');

		if (isset($this->logSettings['enable_log_slow_query'])) {
			$this->logEnable = (int)$this->logSettings['enable_log_slow_query'];
		}

		if (isset($this->logSettings['log_slow_query_time'])) {
			$this->logTimeMin = round(
				((float)$this->logSettings['log_slow_query_time']) / 1000.0, 4
			);
		}

		if (isset($this->logSettings['enable_log_slow_query_admin'])) {
			$this->logAdmin = (int)$this->logSettings['enable_log_slow_query_admin'];
		}

		if (isset($this->logSettings['log_slow_query_write_url'])) {
			$this->logUrlEnable = (int)$this->logSettings['log_slow_query_write_url'];
		}

		$this->logUrl = $this->_getUrlForLog();
	}

	// 1.4.0
	/////////////////////////////
	// Лог
	/////////////////////////////
	protected function _getUrlForLog()
	{
		$result = '';
		if (!isset($this->request->server['HTTP_HOST'])
			|| empty($this->request->server['HTTP_HOST'])
		) {
			$result .= $this->request->server['SERVER_NAME'];
		}
		$result .= $this->request->server['HTTP_HOST'];

		$result .= mb_eregi_replace(
			'&amp;', '&', $this->request->server['REQUEST_URI']
		);

		return $result;
	}

	protected function _startLog()
	{
		if ($this->logEnable > 0 && $this->isValid) {
			if ($this->isAdmin && $this->logAdmin == 0) {
				return;
			}

			$this->logTimeCurr = microtime(true);
		}
	}

	protected function _endLog($query = '')
	{
		if ($this->logEnable > 0 && $this->isValid) {
			if ($this->isAdmin && $this->logAdmin == 0) {
				return;
			}

			// В секундах (включая мс)
			$time = round(microtime(true) - $this->logTimeCurr, 4);

			if ($time >= $this->logTimeMin) {
				$this->logger->setPrefix(
					'Exec time (s): ' . $time . ', '
					. 'IsAdmin = ' . ($this->isAdmin ? '1' : '0')
					. ($this->logUrlEnable ? ', URL = ' . $this->logUrl : '' )
				);

				$this->logger->add($query);
			}
		}
	}

	/////////////////////////////////////////
	// Валидация
	/////////////////////////////////////////

	protected $imlic;

	// Проверка, что у пользователя есть необходимые права
	private function validate($only_edit = false) {
		$data = array();

		$module_name = 'IMDBOptimizer(OC3)';

		$queryString =
			' select distinct `key`, `value` '
			. ' from `' . DB_PREFIX . 'setting` '
			. ' where `key` in ( '
					. ' \'IMDBOptimizerData_key\' ' . ', '
					. ' \'IMDBOptimizerData_enc_mess\' ' . ', '
					. ' \'' . $this->db->escape($module_name) . 'DataDemo_date' . '\' '
				. ')'
		;

		$query = $this->db->query($queryString);

		foreach($query->rows as $row) {
			$data[$row['key']] = $row['value'];
		}

		if (!isset($this->imlic) || empty($this->imlic)) {
			$this->imlic = new IMDBOLicSA100(
				$module_name,
				(isset($data['IMDBOptimizerData_key']) ? $data['IMDBOptimizerData_key'] : ''),
				(isset($data['IMDBOptimizerData_enc_mess']) ? $data['IMDBOptimizerData_enc_mess'] : ''),
				(isset($data[$module_name.'DataDemo_date']) ? $data[$module_name.'DataDemo_date'] : '')
			);
		}

		if (!$this->imlic->isValid()) {
			return false;
		}
		return true;
	}

	protected function cachedCheckValid()
	{
		/*
		if ($this->enable == 0) {
			$this->isValid = false;
			return;
		}
		*/

		$text = 'IMDBOptimizer(OC3)' . date('d.m.y');
		$key = md5($text).dechex(crc32($text)).strlen($text);

		$cacheFileProvider = new IMDBOCacheFile();

		$itemCache = $cacheFileProvider->get($key);

		if (isset($itemCache) && !empty($itemCache)) {
			$this->isValid = (bool)$itemCache['result'];
		} else {
			$this->validate();
			$this->isValid = $this->imlic->isValid();
			if ($this->isValid) {
				$cacheFileProvider->set($key, array( 'result' => true ));
			}
		}
	}

	/////////////////////////////////////////
	// Функции
	/////////////////////////////////////////

	protected function getMaxLengthToDBCache()
	{
		if ( $this->maxLengthToDBCache < 0
			|| $this->maxLengthToDBCache > IMDBOCacheProcessor::DEFAULT_MAX_SIZE_TEXT_FIELD )
		{
			return IMDBOCacheProcessor::DEFAULT_MAX_SIZE_IN_DB;
		}
		return (int)$this->maxLengthToDBCache;
	}

	protected function getDomainLowerCase()
	{
		if (!isset($this->request->server['HTTP_HOST'])
			|| empty($this->request->server['HTTP_HOST'])
		) {
			return strtolower($this->request->server['SERVER_NAME']);
		}
		return strtolower($this->request->server['HTTP_HOST']);
	}

	protected function getRequestUriLowerCase($clearQueryString = false)
	{
		$uri = strtolower($this->request->server['REQUEST_URI']);

		if ($clearQueryString) {
			$uriArray = explode('?', $uri);
			return $uriArray[0];
		}
		return $uri;
	}

	protected function isNotCacheable($sql)
	{
		$result = false;
		$testL = '';

		$sqlL = strtolower(trim($sql));

		////////////////////////////////
		// Только select
		////////////////////////////////
		if (!$this->helper->startsWith($sqlL, 'select')) {
			$result = true;
			return $result;
		}

		////////////////////////////////
		// Проверка по словам
		////////////////////////////////
		foreach($this->filters as $test) {
			$testL = strtolower($test);

			if (strpos($sqlL, $testL) !== false) {
				$result = true;
				return $result;
			}
		}

		if (
			isset($this->currentState['is_url_check'])
			&& $this->currentState['is_url_check']
			&& isset($this->currentState['is_url_check_result'])
		) {
			return $this->currentState['is_url_check_result'];
		}

		////////////////////////////////
		// Проверка по URl
		////////////////////////////////
		foreach($this->urls as $test) {
			$testL = strtolower($test);
			$currUrlWithQS = $this->getDomainLowerCase() . $this->getRequestUriLowerCase(false);
			$currUrlWithoutQS = $this->getDomainLowerCase() . $this->getRequestUriLowerCase(true);

			// Поиск внутри
			if ($this->helper->startsWith($testL, 'i:')) {
				// Учет QS
				$testL = trim(substr($testL, 2));
				// Подстрока внутри
				if ($this->helper->isSubstr($currUrlWithQS, $testL)) {
					$result = true;
					$this->currentState['is_url_check'] = true;
					$this->currentState['is_url_check_result'] = true;
					return $result;
				}
			}
			// Поиск справа
			else if ($this->helper->startsWith($testL, 'r:')) {
				// Без QS
				$testL = trim(substr($testL, 2));
				// Подстрока справа
				if ($this->helper->endsWith($currUrlWithoutQS, $testL)) {
					$result = true;
					$this->currentState['is_url_check'] = true;
					$this->currentState['is_url_check_result'] = true;
					return $result;
				}
			}
			// В остальных случаях поиск слева
			else {
				// Учет QS
				// Если начинается c l:
				if ($this->helper->startsWith($testL, 'l:')) {
					$testL = trim(substr($testL, 2));
				} else {
					// Чистый URL
					$testL = trim($testL);
				}
				// Подстрока слева
				if ($this->helper->startsWith($currUrlWithQS, $testL)) {
					$result = true;
					$this->currentState['is_url_check'] = true;
					$this->currentState['is_url_check_result'] = true;
					return $result;
				}
			}

		}
		$this->currentState['is_url_check'] = true;
		$this->currentState['is_url_check_result'] = false;

		return $result;
	}

	//
	protected function isIMDBOTablesInSQL($sql)
	{
		$result = false;
		$testL = '';

		$sqlL = strtolower(trim($sql));

		$filters = array(
			DB_PREFIX . 'imdbo_cache',
			DB_PREFIX . 'imdbo_cache_innodb',
			DB_PREFIX . 'imdbo_settings',
		);

		////////////////////////////////
		// Проверка по словам
		////////////////////////////////
		foreach($filters as $test) {
			$testL = strtolower($test);

			if (strpos($sqlL, $testL) !== false) {
				$result = true;
				return $result;
			}
		}
		return $result;
	}

	// Кэшированный запрос
	protected function queryCacheable($sql)
	{
		$in_file = 0;
		$keySQL = md5($sql).dechex(crc32($sql)).strlen($sql);

		$cacheDB = $this->cacheDBProvider->get($keySQL);
		$cacheFile = 0;
		$itemCache = '';

		/////////////////////////////////
		// Есть кэш
		/////////////////////////////////
		if (isset($cacheDB)) {
			$in_file = (int)$cacheDB['in_file'];

			if ($in_file == 0) {
				$itemCache = json_decode($cacheDB['value'], true);

				$this->countAffected = (int)$itemCache['countA'];
				$this->lastId = (int)$itemCache['lastId'];

				if (is_object($itemCache['result']) || is_array($itemCache['result'])) {
					return (object)$itemCache['result'];
				}
				return $itemCache['result'];
			} else {
				$itemCache = $this->cacheFileProvider->get($keySQL);

				$this->countAffected = (int)$itemCache['countA'];
				$this->lastId = (int)$itemCache['lastId'];

				if (is_object($itemCache['result']) || is_array($itemCache['result'])) {
					return (object)$itemCache['result'];
				}
				return $itemCache['result'];
			}
		}

		/////////////////////////////////
		// Кэша нет
		/////////////////////////////////
		$this->_startLog();
		$timeFrom = microtime( true );
		$result = $this->db->query($sql);
		$timeT0 = microtime( true );
		$this->_endLog($sql);

		$this->countAffected = $this->db->countAffected();
		$this->lastId = $this->db->getLastId();

		// 1.4.1
		if ( $timeT0 - $timeFrom <= $this->mintimeToCache ) {
			return $result;
		}

		$tocache = array(
			'result' => $result,
			'lastId' => $this->lastId,
			'countA' => $this->countAffected,
		);

		$tocacheJson = json_encode($tocache, true);

		if (strlen($tocacheJson) < $this->getMaxLengthToDBCache())
		{
			$this->cacheDBProvider->set($keySQL, $tocache, 0);
		} else {
			$this->cacheDBProvider->set($keySQL, '', 1);
			$this->cacheFileProvider->set($keySQL, $tocache);
		}
		return $result;
	}

	////////////////////////////////
	// Интерфейс
	////////////////////////////////

	public function query($sql)
	{
		// Если кэш не нужен
		if ($this->enable == 0
			|| $this->isAdmin
			|| !$this->isValid
			|| $this->isNotCacheable($sql)
			|| $this->isIMDBOTablesInSQL($sql)
		) {
			$this->_startLog();
			$result = $this->db->query($sql);
			$this->_endLog($sql);
			$this->countAffected = $this->db->countAffected();
			$this->lastId = $this->db->getLastId();
			return $result;
		}
		return $this->queryCacheable($sql);
	}

	public function escape($value)
	{
		return $this->db->escape($value);
	}

	public function countAffected()
	{
		return $this->countAffected;
	}

	public function getLastId()
	{
		return $this->lastId;
	}

	public function connected()
	{
		if (version_compare('2.2.0.0', VERSION) <= 0) {
			return $this->db->connected();
		}
		return false;
	}

	// 1.3.0
	////////////////////////////////
	// Динамические вызовы
	////////////////////////////////
	public function __call($name, array $params)
	{
		return call_user_func_array( array( $this->db, $name ), $params );
	}

	public function __get($name)
	{
		return $this->db->$name;
	}

	public function __set($name, $value)
	{
		$this->db->$name = $value;
	}
}
