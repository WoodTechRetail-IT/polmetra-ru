<?php

//$GLOBALS['jetcache_opencart_core_start'] = microtime(true);
if (file_exists(DIR_SYSTEM . 'helper/seocmsprofunc.php')) {
	if (!function_exists('loadlibrary')) {
		if (function_exists('modification')) {
			require_once(modification(DIR_SYSTEM . 'helper/seocmsprofunc.php'));
		} else {
			require_once(DIR_SYSTEM . 'helper/seocmsprofunc.php');
		}
	}
}
if (defined('VERSION')) {
	if (!defined('SC_VERSION')) define('SC_VERSION', (int) substr(str_replace('.', '', VERSION), 0, 2));
}

    
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* Model class
*/
abstract class Model {
	protected $registry;

	public function __construct($registry) {
		$this->registry = $registry;

		if (defined('DIR_CATALOG')) {
			$this->registry->set('admin_work', true);
			$this->registry->set('jc_is_admin', true);
		}
    
	}

	public function __get($key) {
		return $this->registry->get($key);
	}

	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
}