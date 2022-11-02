<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* DB class
*/
class DB {

	//Jet Cache vars
	private $jc_construct = false;
	private $jc_registry = Array();
    private $jc_dir_root;
	private $sc_jetcache_setting = false;
	private $seocms_jetcache_settings = Array();
	private $jc_registry_is_callable = false;
	private $sc_jetcache_query_count = 0;
	private $sc_jetcache_query_count_cache = 0;
	private $sc_jetcache_query_time_cache = 0;
	private $sc_jetcache_query_time_start_cache = 0;
	private $sc_jetcache_db_log = false;
	private	$jc_min_time = 1.1;
	//End of Jet Cache vars

	private $adaptor;

	/**
	 * Constructor
	 *
	 * @param	string	$adaptor
	 * @param	string	$hostname
	 * @param	string	$username
     * @param	string	$password
	 * @param	string	$database
	 * @param	int		$port
	 *
 	*/
	public function __construct($adaptor, $hostname, $username, $password, $database, $port = NULL) {
		$class = 'DB\\' . $adaptor;

		if (class_exists($class)) {
			$this->adaptor = new $class($hostname, $username, $password, $database, $port);
		} else {
			throw new \Exception('Error: Could not load database adaptor ' . $adaptor . '!');
		}
	}

	/**
     * 
     *
     * @param	string	$sql
	 * 
	 * @return	array
     */
public function get_sc_jetcache_query_count() {
		return $this->sc_jetcache_query_count;
	}
	public function get_sc_jetcache_query_count_cache() {
		return $this->sc_jetcache_query_count_cache;
	}
	public function get_sc_jetcache_query_time_cache() {
		return $this->sc_jetcache_query_time_cache;
	}
public function jc_setRegistry($registry) {
		$this->jc_registry = $registry;
		$this->jc_registry_is_callable = true;

		$this->sc_jetcache_setting = true;
		$this->jc_construct = true;

		$this->seocms_jetcache_settings = $this->jc_registry->get('config')->get('asc_jetcache_settings');

		if (isset($this->seocms_jetcache_settings['query_log_maxtime']) && $this->seocms_jetcache_settings['query_log_maxtime'] != '') {
			$this->jc_min_time = $this->seocms_jetcache_settings['query_log_maxtime'];
		}
	}

	private function jetcache_construct() {
		if (!$this->jc_construct) {

            $this->jc_construct = true;

            $this->jc_dir_root = str_ireplace('/system/', '', DIR_SYSTEM);
            $this->jc_dir_root = str_ireplace('\\', '/', $this->jc_dir_root);

			$query = $this->query("SELECT value FROM " . DB_PREFIX . "setting WHERE store_id = '0' AND `key`='asc_jetcache_settings'");

			if ($query->row) {
				if (!defined('VERSION')) return;
				if (!defined('SC_VERSION')) define('SC_VERSION', (int) substr(str_replace('.', '', VERSION), 0, 2));

				$this->sc_jetcache_setting = true;

				if (SC_VERSION > 20) {
					$this->seocms_jetcache_settings = (array)json_decode($query->row['value']);
				} else {
					$this->seocms_jetcache_settings = (array)unserialize($query->row['value']);
				}
				if (isset($this->seocms_jetcache_settings['query_log_maxtime']) && $this->seocms_jetcache_settings['query_log_maxtime'] != '') {
					$this->jc_min_time = $this->seocms_jetcache_settings['query_log_maxtime'];
				}
			}
		}
	}

	public function get_sc_jetcache_db_log() {
    	return $this->sc_jetcache_db_log;
	}

 	public function jetcache_put_to_log($jc_data_log) {

       	if (isset($this->seocms_jetcache_settings['query_log_file']) && $this->seocms_jetcache_settings['query_log_file'] != '' && isset($this->seocms_jetcache_settings['query_log_status']) && $this->seocms_jetcache_settings['query_log_status']) {

            $debug_output = '';
            if (isset($jc_data_log['file'])) {
	            $debug_back = $jc_data_log['file'];
	            foreach ($debug_back as $num => $debug_option) {
	                if (isset($debug_option['function'])) {
		             	$debug_level = $debug_option['function'];
		                if ($debug_level == 'call_user_func_array') {
		                    break;
		                }
	                }
	                if (isset($debug_option['class'])) {
	                    $debug_level = $debug_option['class'] . '::' . $debug_level;
	                }
	                if (isset($debug_option['line'])) {
	                	if (empty($debug_option['line'])) {
	                		$debug_option['file'] = '';
	                	}
	                    $debug_level .= ' [' . str_ireplace($this->jc_dir_root, '', str_ireplace('\\', '/', $debug_option['file'])) . '::' . $debug_option['line'] . ']';
	                }
	                if ($debug_output) {
	                    $debug_output = $debug_level . ' -> ' . $debug_output;
	                } else {
	                    $debug_output = $debug_level;
	                }
	            }
            }

	        $jc_log_file = $this->seocms_jetcache_settings['query_log_file'];

			$jc_data_log['name'] = (!isset($jc_data_log['file'][0]['file'])) ? '-' : $jc_data_log['file'][0]['file'];

			$jc_data_log['model'] = (!isset($jc_data_log['file'][1]['class'])) ? '-' : $jc_data_log['file'][1]['class'];
			$jc_data_log['function'] = (!isset($jc_data_log['file'][1]['function'])) ? '-' : $jc_data_log['file'][1]['function'];


			if (!isset($jc_data_log['file'][2]['class'])) {
				$mother_count = 3;
			} else {
				$mother_count = 2;
			}

			$jc_data_log['model_mother'] = (!isset($jc_data_log['file'][$mother_count]['class'])) ? '-' : $jc_data_log['file'][$mother_count]['class'];
			$jc_data_log['function_mother'] = (!isset($jc_data_log['file'][$mother_count]['function'])) ? '-' : $jc_data_log['file'][$mother_count]['function'];

			if (isset($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				$jc_data_log['ajax'] = 'AJAX ';
			} else {
				$jc_data_log['ajax'] = '';
			}

			$entry_jetcache_page = '{Page}';
			$entry_jetcache_page_source = '{Source}';
			$entry_jetcache_page_time = '{Query time}';
			$entry_jetcache_query_time = '{Page time}';
			$entry_jetcache_query_number = '{Query number}';

			$this_log = PHP_EOL .
			$jc_data_log['ajax'] . $entry_jetcache_page . ': ' . $this->escape($_SERVER['REQUEST_URI']) . PHP_EOL .
			$entry_jetcache_page_source . ': ' . str_ireplace($this->jc_dir_root, '', str_ireplace('\\', '/', $jc_data_log['name'])) . PHP_EOL.PHP_EOL .
			$entry_jetcache_query_time . ': ' . ($jc_data_log['sc_jetcache_query_time_cache'] + $jc_data_log['sql_time']) . ' c ' . PHP_EOL . PHP_EOL .
			$entry_jetcache_page_time . ': ' . $jc_data_log['sql_time'] . ' c ' . PHP_EOL.PHP_EOL .
			$entry_jetcache_query_number . ': ' . ($jc_data_log['sc_jetcache_query_count']-1) . ' ' . PHP_EOL.PHP_EOL .
			$jc_data_log['sql'] . PHP_EOL.PHP_EOL . $debug_output . PHP_EOL.PHP_EOL .
			$jc_data_log['model_mother'] . ' -> ' . $jc_data_log['function_mother'] . PHP_EOL .
			$jc_data_log['model'] . ' -> ' . $jc_data_log['function'] . PHP_EOL.PHP_EOL .
			'----------------------' . PHP_EOL;

            if ($this->sc_jetcache_db_log === false) {
            	$this->sc_jetcache_db_log = '*************************************** '. $this->escape($_SERVER['REQUEST_URI']) .' ***************************************' . PHP_EOL . $this_log;
            } else {
            	$this->sc_jetcache_db_log .= $this_log;
            }

		}
	}

	public function query($sql) {
			$this->sc_jetcache_query_count++;
			if ($this->sc_jetcache_query_time_start_cache <= 0) {
				$this->sc_jetcache_query_time_start_cache = microtime(true);
			} else {
				$this->sc_jetcache_query_time_cache = round((microtime(true) - (float)$this->sc_jetcache_query_time_start_cache), 8);
			}
		
			$jetcache_cacheble = false;

			if ($this->jc_registry_is_callable) {
				if (!$this->jc_registry->get('admin_work')) {
					if (!$this->jc_construct) {
						$this->jetcache_construct();
					}
				}
			}
			if ($this->jc_registry_is_callable && isset($this->seocms_jetcache_settings['jetcache_query_status']) && $this->jc_registry->get('seocms_cache_status') && $this->seocms_jetcache_settings['jetcache_query_status'] ) {
				if (!$this->jc_registry->get('admin_work')) {
					if ($this->jc_registry->get('controller_jetcache_jetcache')->query_model_access(debug_backtrace())) {
		                if (stripos($sql, 'SELECT ') !== false) {
		                	if (stripos($sql, 'FOUND_ROWS') === false) {
								if ($this->jc_registry->get('seocms_cache_status') && $this->jc_registry->get('controller_jetcache_jetcache')->cache_access_output(true)) {
					                $query_hash = md5($sql);
					                $jetcache_cacheble = true;
					                // From cache
				                    $cache_from = $this->jc_registry->get('controller_jetcache_jetcache')->query_from_cache('query', $query_hash);
				                    if (!empty($cache_from)) {
			                           	$this->sc_jetcache_query_count_cache++;
			                           	$this->sc_jetcache_query_count--;
				                    	return (object)$cache_from;
				                    }
								}
							}
		                }
	                }
				}
			}

			if ($this->sc_jetcache_setting && isset($this->seocms_jetcache_settings['jetcache_query_status']) && $this->seocms_jetcache_settings['jetcache_query_status'] ) {

		     	$jc_start = microtime(true);

		        $query_data = $this->adaptor->query($sql);

 		        $jc_end = microtime(true);

                $jc_sql_time = round(($jc_end - $jc_start), 8);

		        if ($jc_sql_time >= $this->jc_min_time && isset($this->seocms_jetcache_settings['query_log_file']) && $this->seocms_jetcache_settings['query_log_file'] != '' && isset($this->seocms_jetcache_settings['query_log_status']) && $this->seocms_jetcache_settings['query_log_status']) {
			        if ($this->sc_jetcache_setting) {
				        $jc_data_log['file'] = debug_backtrace();
						$jc_data_log['sql'] = $sql;
						$jc_data_log['sql_time'] = $jc_sql_time;
						$jc_data_log['sc_jetcache_query_time_cache'] = $this->sc_jetcache_query_time_cache;
						$jc_data_log['sc_jetcache_query_count'] = $this->sc_jetcache_query_count;

						$this->jetcache_put_to_log($jc_data_log);
					}
		        }

				if ($jetcache_cacheble) {
	                $this->jc_registry->get('controller_jetcache_jetcache')->query_to_cache((array)$query_data, 'query', $query_hash);
				}

				return $query_data;
            }

		return $this->adaptor->query($sql);
	}

	/**
     * 
     *
     * @param	string	$value
	 * 
	 * @return	string
     */
	public function escape($value) {
		return $this->adaptor->escape($value);
	}

	/**
     * 
	 * 
	 * @return	int
     */
	public function countAffected() {
		return $this->adaptor->countAffected();
	}

	/**
     * 
	 * 
	 * @return	int
     */
	public function getLastId() {
		return $this->adaptor->getLastId();
	}
	
	/**
     * 
	 * 
	 * @return	bool
     */	
	public function connected() {
		return $this->adaptor->connected();
	}
}