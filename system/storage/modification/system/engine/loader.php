<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* Loader class
*/
final class Loader {
	protected $registry;

	/**
	 * Constructor
	 *
	 * @param	object	$registry
 	*/
	public function __construct($registry) {
		$this->registry = $registry;

		if (!$this->registry->get('jetcache_opencart_core_start')) {
			if (isset($GLOBALS['jetcache_opencart_core_start'])) {
				$jc_start_microtime = (float)$GLOBALS['jetcache_opencart_core_start'];
			} else {
				$jc_start_microtime = microtime(true);
			}
			$this->registry->set('jetcache_opencart_core_start', $jc_start_microtime);
		}
    
	}

	/**
	 * 
	 *
	 * @param	string	$route
	 * @param	array	$data
	 *
	 * @return	mixed
 	*/	
	public function controller($route, $data = array()) {
		if ($this->registry->get('seocms_cache_status')) {
			if (SC_VERSION < 21) {
				$data = $args;
			}
	    	$output_cont = $this->registry->get('controller_jetcache_jetcache')->hook_Loader_controller('before', $route, $data);
	    	if ($output_cont != NULL) return $output_cont;
		}
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
		
		// Keep the original trigger
		$trigger = $route;
		
		// Trigger the pre events
		$result = $this->registry->get('event')->trigger('controller/' . $trigger . '/before', array(&$route, &$data));
		
		// Make sure its only the last event that returns an output if required.
		if ($result != null && !$result instanceof Exception) {
			$output = $result;
		} else {
			$action = new Action($route);
			$output = $action->execute($this->registry, array(&$data));
		}
		
		// Trigger the post events
		$result = $this->registry->get('event')->trigger('controller/' . $trigger . '/after', array(&$route, &$data, &$output));
		
		if ($result && !$result instanceof Exception) {
			$output = $result;
		}

		if (!$output instanceof Exception) {

		if ($this->registry->get('seocms_cache_status') && SC_VERSION > 15 && isset($route) && isset($data)) {
	    	$output = $this->registry->get('controller_jetcache_jetcache')->hook_Loader_controller('after', $route, $data, $output);
		}
    
			return $output;
		}
	}

	/**
	 * 
	 *
	 * @param	string	$route
 	*/	
	public function model($route) {
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
		
		if (!$this->registry->has('model_' . str_replace('/', '_', $route))) {
			$file  = DIR_APPLICATION . 'model/' . $route . '.php';
			$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $route);
			
			if (is_file($file)) {
				include_once(modification($file));
	
				$proxy = new Proxy();
				
				// Overriding models is a little harder so we have to use PHP's magic methods
				// In future version we can use runkit
				foreach (get_class_methods($class) as $method) {
					$proxy->{$method} = $this->callback($this->registry, $route . '/' . $method);
				}
				
				$this->registry->set('model_' . str_replace('/', '_', (string)$route), $proxy);
			} else {
				throw new \Exception('Error: Could not load model ' . $route . '!');
			}
		}
	}

	/**
	 * 
	 *
	 * @param	string	$route
	 * @param	array	$data
	 *
	 * @return	string
 	*/

             public function parseLdevBlock($text, $route){

                   //$pattern = '/\[ldev_question_block_id\=\d{1,6}(&|&amp;rel=\d)?\]/m';
                   $pattern = '/\[ldev_question_block_id\=\d{1,6}(&amp;rel=\d)?(&rel=\d)?\]/m';


                   //exclude on some routes
                   $excluded = [
                       //disable for module positions
                       'common/content_top',
                       'common/content_bottom',
                       'common/column_right',
                       'common/column_left',
                       'common/home',
//                       'module/html',

                       //exclude special modules
                       'module/ldev_question/microdata_how_to',
                       'module/ldev_question/microdata_faq',
                       'module/microdatapro/category_manufacturer',
                       'module/microdatapro/product',
                       'module/microdatapro/category_manufacturer',
                       'module/microdatapro/tc_og',
                       'module/microdatapro/information'
                   ];

                   $view_path_parts = explode('/template/', $route);
                   $view_path = str_replace(['extension/module/','.twig','.tpl'],['module/','',''],end($view_path_parts));
                   if(in_array($view_path, $excluded)){

                      return preg_replace($pattern, '', $text);

                   }



        $opencart_version = explode(".", VERSION)[0].explode(".", VERSION)[1];

        $module_path = 'extension/module/ldev_question';
        if($opencart_version < 23){
            $module_path = 'module/ldev_question';
        }


        //search
        $short_codes = array();
        $replace_table = [
            'patterns' => [],
            'blocks' => []
        ];

        preg_match_all($pattern, $text, $short_codes);

            foreach ($short_codes[0] as $k=>$short_code){

            $code = $short_code;
            $replace_table['patterns'][] = str_replace([ '[', ']' ], [ '/\[', '\]/' ], $code);


            $code = str_replace(['[',']'], '', $code);

            $params = [];
            $code = str_replace('&amp;', '&', $code);
            $param_strings = explode('&', $code);
            foreach ($param_strings as $param_string){
                $key = explode('=',$param_string)[0];
                $value = isset(explode('=',$param_string)[1]) ? explode('=',$param_string)[1] : '';
                $params[$key] = $value;
            }

            $replace_table['blocks'][] = $this->controller($module_path, $params);
            }

              if($short_codes){
                $assets = $this->controller($module_path.'/getAssetsGlobal');
                foreach ($assets['styles'] as $style){
                    $this->registry->get('document')->addStyle($style);
                }
                foreach ($assets['scripts'] as $script){
                    $this->registry->get('document')->addScript($script);
                }
            }

        //replace
        return preg_replace($replace_table['patterns'], $replace_table['blocks'], $text);


        }
            
	public function view($route, $data = array()) {
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
		
		// Keep the original trigger
		$trigger = $route;
		
		// Template contents. Not the output!
		$code = '';
		
		// Trigger the pre events
		$result = $this->registry->get('event')->trigger('view/' . $trigger . '/before', array(&$route, &$data, &$code));
		
		// Make sure its only the last event that returns an output if required.
		if ($result && !$result instanceof Exception) {
			$output = $result;
		} else {
			$template = new Template($this->registry->get('config')->get('template_engine'));
				
			foreach ($data as $key => $value) {
				$template->set($key, $value);
			}

			$output = $template->render($this->registry->get('config')->get('template_directory') . $route, $code);

               if(!defined('DIR_CATALOG')) {
                    $output = $this->parseLdevBlock($output, $route);
                }
            
		}
		
		// Trigger the post events
		$result = $this->registry->get('event')->trigger('view/' . $trigger . '/after', array(&$route, &$data, &$output));
		
		if ($result && !$result instanceof Exception) {
			$output = $result;
		}
		
		return $output;
	}

	/**
	 * 
	 *
	 * @param	string	$route
 	*/
	public function library($route) {
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
			
		$file = DIR_SYSTEM . 'library/' . $route . '.php';
		$class = str_replace('/', '\\', $route);

		if (is_file($file)) {
			include_once(modification($file));

			$this->registry->set(basename($route), new $class($this->registry));
		} else {
			throw new \Exception('Error: Could not load library ' . $route . '!');
		}
	}

	/**
	 * 
	 *
	 * @param	string	$route
 	*/	
	public function helper($route) {
		$file = DIR_SYSTEM . 'helper/' . preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route) . '.php';

		if (is_file($file)) {
			include_once(modification($file));
		} else {
			throw new \Exception('Error: Could not load helper ' . $route . '!');
		}
	}

	/**
	 * 
	 *
	 * @param	string	$route
 	*/	
	public function config($route) {
		$this->registry->get('event')->trigger('config/' . $route . '/before', array(&$route));
		
		$this->registry->get('config')->load($route);
		
		$this->registry->get('event')->trigger('config/' . $route . '/after', array(&$route));
	}

	/**
	 * 
	 *
	 * @param	string	$route
	 * @param	string	$key
	 *
	 * @return	array
 	*/
	public function language($route, $key = '') {
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
		
		// Keep the original trigger
		$trigger = $route;
				
		$result = $this->registry->get('event')->trigger('language/' . $trigger . '/before', array(&$route, &$key));
		
		if ($result && !$result instanceof Exception) {
			$output = $result;
		} else {
			$output = $this->registry->get('language')->load($route, $key);
		}
		
		$result = $this->registry->get('event')->trigger('language/' . $trigger . '/after', array(&$route, &$key, &$output));
		
		if ($result && !$result instanceof Exception) {
			$output = $result;
		}
				
		return $output;
	}
	
	protected function callback($registry, $route) {
		return function($args) use($registry, $route) {
			static $model;
			
			$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);

			// Keep the original trigger
			$trigger = $route;
					
			// Trigger the pre events
			$result = $registry->get('event')->trigger('model/' . $trigger . '/before', array(&$route, &$args));
			
			if ($result && !$result instanceof Exception) {
				$output = $result;
			} else {
				$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', substr($route, 0, strrpos($route, '/')));
				
				// Store the model object
				$key = substr($route, 0, strrpos($route, '/'));
				
				if (!isset($model[$key])) {
					$model[$key] = new $class($registry);
				}
				
				$method = substr($route, strrpos($route, '/') + 1);
				
				$callable = array($model[$key], $method);
	
				if (is_callable($callable)) {
					
				$jetcache_output = false;
				$jc_args = $args;
				if ($this->registry->get('seocms_cache_status')) {
		       	    $jetcache_output = $this->registry->get('controller_jetcache_jetcache')->model_from_cache($route, $method, $jc_args);
				}
                if ($jetcache_output === false) {
                	$output = call_user_func_array($callable, $args);
                	$jetcache_from_cache = false;
                } else {
                	$output = $jetcache_output;
                	$jetcache_from_cache = true;
                }
    

				if (!$jetcache_from_cache && $this->registry->get('seocms_cache_status')) {
		       	    $this->registry->get('controller_jetcache_jetcache')->model_to_cache($output, $route, $method, $jc_args);
				}
    
				} else {
					throw new \Exception('Error: Could not call model/' . $route . '!');
				}					
			}
			
			// Trigger the post events
			$result = $registry->get('event')->trigger('model/' . $trigger . '/after', array(&$route, &$args, &$output));
			
			if ($result && !$result instanceof Exception) {
				$output = $result;
			}
						
			return $output;
		};
	}	
}