<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* Response class
*/
class Response {
	private $headers = array();
	private $level = 0;
	private $output;

	//JC vars
	private $jetcache_registry = Array();
	//End of JC vars
    

	/**
	 * Constructor
	 *
	 * @param	string	$header
	 *
 	*/

 	public function jetcache_setRegistry($registry) {
		$this->jetcache_registry = $registry;
	}
 	public function jetcache_getHeaders() {
		return $this->headers;
	}
	public function jetcache_getOutput() {
		return $this->output;
	}
    
	public function addHeader($header) {
		$this->headers[] = $header;
	}
	
	/**
	 * 
	 *
	 * @param	string	$url
	 * @param	int		$status
	 *
 	*/
	public function redirect($url, $status = 302) {
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url), true, $status);
		exit();
	}
	
	/**
	 * 
	 *
	 * @param	int		$level
 	*/
	public function setCompression($level) {
		$this->level = $level;
	}
	
	/**
	 * 
	 *
	 * @return	array
 	*/
	public function getOutput() {
		return $this->output;
	}
	
	/**
	 * 
	 *
	 * @param	string	$output
 	*/	
	public function setOutput($output) {
		$this->output = $output;
	}
	
	/**
	 * 
	 *
	 * @param	string	$data
	 * @param	int		$level
	 * 
	 * @return	string
 	*/
	private function compress($data, $level = 0) {
		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)) {
			$encoding = 'gzip';
		}

		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)) {
			$encoding = 'x-gzip';
		}

		if (!isset($encoding) || ($level < -1 || $level > 9)) {
			return $data;
		}

		if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
			return $data;
		}

		if (headers_sent()) {
			return $data;
		}

		if (connection_status()) {
			return $data;
		}

		$this->addHeader('Content-Encoding: ' . $encoding);

		return gzencode($data, (int)$level);
	}
	
	/**
	 * 
 	*/
	public function output() {

		if (is_callable(array($this->jetcache_registry, 'get'))) {
			if ($this->jetcache_registry->get('seocms_cache_status')) {
                $jc_info = NULL;
                $jc_webp_js = '';

				if (isset($this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['cont_ajax_status']) && $this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['cont_ajax_status']) {
                    if (strpos($this->output, 'jc-cont-ajax') !== false && !$this->jetcache_registry->get('page_fromcache')) {
	                    $jc_cont_ajax = $this->jetcache_registry->get('controller_jetcache_jetcache')->cont_ajax_response();
	                    $this->output = str_ireplace('</body>', $jc_cont_ajax . '</body>', $this->output);
                    }
				}

				if (!$this->jetcache_registry->get('page_fromcache')) {
					$this->output = $this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_minify($this->output);
				}

				if (!$this->jetcache_registry->get('page_fromcache') && isset($this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['image_status']) && $this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['image_status'] && isset($this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['image_webp_status']) && $this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['image_webp_status']) {
 					$jc_webp_output = $this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_webp($this->output);
 					$this->output = $jc_webp_output['output'];
 					$jc_webp_js = $jc_webp_output['jc_webp_js'];
				}

				if (isset($this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['query_log_status']) && $this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['query_log_status'] ||
				    isset($this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['cont_log_status']) && $this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['cont_log_status'] ||
				    isset($this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['session_log_status']) && $this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['session_log_status']
				) {
					$this->jetcache_registry->get('controller_jetcache_jetcache')->writeLog();
				}

				if (is_callable(array($this->jetcache_registry, 'get'))) {
		        	if ($this->jetcache_registry->get('seocms_cache_status') && !$this->jetcache_registry->get('page_fromcache')) {
						if ($jc_webp_js != '') {
						    $output_tmp = $this->output;
							$this->output = str_ireplace($jc_webp_js, '', $this->output);
						}
						$this->jetcache_registry->get('controller_jetcache_jetcache')->page_to_cache();
                        if ($jc_webp_js != '') {
                        	$this->output = $output_tmp;
                        	unset($output_tmp);
                        }
					}
				}

				if (isset($this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['minify_js_preload_gps']) && $this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['minify_js_preload_gps'] != '') {
					$this->output = $this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_minify_js_preload_gps($this->output);
				}

				if ((isset($this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['minify_css_after_gps']) && $this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['minify_css_after_gps'] != '') ||
				    (isset($this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['minify_css_fonts_defer_gps']) && $this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['minify_css_fonts_defer_gps'])
				) {
					$this->output = $this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_minify_css_after_gps($this->output);
				}

				if (isset($this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['jetcache_info_status']) && $this->jetcache_registry->get('controller_jetcache_jetcache')->jetcache_settings['jetcache_info_status']) {
					$jc_info = $this->jetcache_registry->get('controller_jetcache_jetcache')->info();
					if ($jc_info != NULL) {
						$this->output = str_ireplace('</body>', $jc_info . '</body>', $this->output);
					}
				}

				if (isset($this->jetcache_registry->get('controller_jetcache_jetcache')->save_user_id) && $this->jetcache_registry->get('controller_jetcache_jetcache')->save_user_id != -1) {
					$this->jetcache_registry->get('session')->data['user_id'] = $_SESSION['user_id'] = $this->jetcache_registry->get('controller_jetcache_jetcache')->save_user_id;
				}

	        	if (isset($this->jetcache_registry->get('request')->post['buildcache'])) {
             		$this->jetcache_registry->get('controller_jetcache_jetcache')->get_buildcache_array();
				}

			}
		}
    
		if ($this->output) {
			$output = $this->level ? $this->compress($this->output, $this->level) : $this->output;
			
			if (!headers_sent()) {
				foreach ($this->headers as $header) {
					header($header, true);
				}
			}
			
			echo $output;
		}
	}
}
