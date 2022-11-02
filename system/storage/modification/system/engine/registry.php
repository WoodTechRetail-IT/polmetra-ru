<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* Registry class
*/
final class Registry {
	private $data = array();

	/**
     * 
     *
     * @param	string	$key
	 * 
	 * @return	mixed
     */
	public function get($key) {
		if (($key == 'language' || $key == 'document') && __FUNCTION__ == 'get') {
	        if ($this->get('seocms_cache_status')) {
				if (isset($this->data['controller_jetcache_jetcache'])) {
					$this->data['controller_jetcache_jetcache']->hook_Registry_get();
				}
			}
		}
		return (isset($this->data[$key]) ? $this->data[$key] : null);
	}

    /**
     * 
     *
     * @param	string	$key
	 * @param	string	$value
     */	
	public function set($key, $value) {
		$this->data[$key] = $value;
	}
	
    /**
     * 
     *
     * @param	string	$key
	 *
	 * @return	bool
     */
	public function has($key) {
		return isset($this->data[$key]);
	}
}