<?php
//  Quantity per Option / Количество для опций
//  Support: support@liveopencart.com / Поддержка: help@liveopencart.ru

namespace liveopencart\ext;

class qpo extends \liveopencart\lib\v0005\extension {
	
	protected $extension_code 	= 'qpo3';
	protected $version = '3.0.1';
	protected $resource_route_catalog = 'view/theme/extension_liveopencart/quantity_per_option/';
	protected $event_prefix = 'liveopencart.qpo.';
	protected $setting_items = array(
		array(
			'name'=>'reset_on_add_to_cart',
			'fields'=>array(),
			'values'=>array(0,1,2),
		),
		array(
			'name'=>'pov_default_quantity',
			'fields'=>array('default_quantity'),
			'values'=>array(),
		),
	);
	protected $additional_db_fields = array(
		array(
			'name'=>'default_quantity',
			'type'=>'int(3) NOT NULL',
			'tables'=>array('product_option_value'),
		),
		array(
			'name'=>'quantity_per_option',
			'type'=>'tinyint(1) NOT NULL',
			'tables'=>array('option'),
		),
	);
	protected $events = array(
		array(
			'code' 			=> 'eventOptionFormViewBefore',
			'trigger' 	=> 'admin/view/catalog/option_form/before',
			'action' 		=> 'extension/module/quantity_per_option/eventOptionFormViewBefore',
			'priority'	=> -1, // to apply before the standard language to template event
		),
		array(
			'code' 			=> 'eventOptionModelAddOptionAfter',
			'trigger' 	=> 'admin/model/catalog/option/addOption/after',
			'action' 		=> 'extension/module/quantity_per_option/eventOptionModelAddOptionAfter',
		),
		array(
			'code' 			=> 'eventOptionModelEditOptionAfter',
			'trigger' 	=> 'admin/model/catalog/option/editOption/after',
			'action' 		=> 'extension/module/quantity_per_option/eventOptionModelEditOptionAfter',
		),
		array(
			'code' 			=> 'eventProductFormViewBefore',
			'trigger' 	=> 'admin/view/catalog/product_form/before',
			'action' 		=> 'extension/module/quantity_per_option/eventProductFormViewBefore',
			'priority'	=> -1, // to apply before the standard language to template event
		),
		array(
			'code' 			=> 'eventProductPageControllerIndexBefore',
			'trigger' 	=> 'catalog/controller/product/product/before',
			'action' 		=> 'extension/liveopencart/quantity_per_option/eventProductPageControllerIndexBefore',
		),
		array(
			'code' 			=> 'eventProductPageViewBefore',
			'trigger' 	=> 'catalog/view/product/product/before',
			'action' 		=> 'extension/liveopencart/quantity_per_option/eventProductPageViewBefore',
			'priority'	=> -1, // to apply before the standard language to template event
		),
	);
	
	public function __construct() {
		call_user_func_array( array('parent', '__construct') , func_get_args());
		
		if ( $this->installed() ) {
			$this->checkTables();
		}
	}
	
	public function installed() {
    return $this->getExtensionInstalledStatus('quantity_per_option', 'qpo_installed');
		//if ( !$this->hasCacheSimple('installed') ) {
		//	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = 'module' AND `code` = 'quantity_per_option'");
		//	$this->setCacheSimple('installed', $query->num_rows);
		//}
		//return $this->getCacheSimple('installed');
	}
	
	public function getSettings() {
		if ( !$this->hasCacheSimple('settings') ) {
			$settings = $this->config->get('module_quantity_per_option_settings');
			if ( !is_array($settings) ) {
				$settings = array();
			}
			foreach ( $this->getSettingItems() as $setting_item ) {
				if ( !isset($settings[$setting_item['name']]) ) {
					$settings[$setting_item['name']] = false;
				}
			}
			$this->setCacheSimple('settings', $settings);
		}
		return $this->getCacheSimple('settings');
	}
	
  public function getThemeName() {
    
    if ( !$this->theme_details ) {
      $params = 
       array(
        'themes_shorten' => $this->getAdaptedThemes(),
        'sibling_dir' => $sibling_file_name = $this->getBasicDirOfExtension().'theme_sibling/',
      );
      ///$this->theme_details = new \liveopencart\lib\v0005\theme_details($params);
      
      $this->theme_details = $this->getOuterLibraryInstanceByName('theme_details', $params);
      
    } 
    return $this->theme_details->getThemeName();
  }
  
//	public function getThemeName() {
//		
//		if ( !$this->hasCacheSimple('theme_name') ) {
//			$theme_name = '';
//			
//			$settings = $this->getSettings();
//			if ( !empty($settings['custom_theme_id']) ) {
//				$theme_name = $settings['custom_theme_id'];
//			} else {
//			
//				if ($this->config->get('config_theme') == 'theme_default' || $this->config->get('config_theme') == 'default') {
//					$theme_name = $this->config->get('theme_default_directory');
//				} else {
//					$theme_name = substr($this->config->get('config_theme'), 0, 6) == 'theme_' ? substr($this->config->get('config_theme'), 6) : $this->config->get('config_theme') ;
//				}
//				
//				// shorten theme name
//				$themes_shorten = $this->getAdaptedThemes();
//				foreach ( $themes_shorten as $theme_shorten ) {
//					$theme_shorten_length = strlen($theme_shorten);
//					if ( substr($theme_name, 0, $theme_shorten_length) == $theme_shorten ) {
//						$theme_name = substr($theme_name, 0, $theme_shorten_length);
//						break;
//					}
//				}
//				
//				$theme_name = $this->replaceThemeNameIfSibling($theme_name);
//				
//			}
//			$this->setCacheSimple('theme_name', $theme_name);
//		}
//		return $this->getCacheSimple('theme_name');
//  }
//	
//	protected function replaceThemeNameIfSibling($theme_name) {
//		$sibling_file_name = $this->getBasicDirOfExtension().'theme_sibling/'.$theme_name.'.php';
//		if ( file_exists($sibling_file_name) ) {
//			require($sibling_file_name); // $sibling_main_theme should be defined there
//			if ( !empty($sibling_main_theme) ) {
//				return $sibling_main_theme;
//			}
//		}
//		return $theme_name;
//	}

  protected function getAdaptedThemes() {
		
		$dir_of_themes = $this->getBasicDirOfThemes();
		
		$themes = glob($dir_of_themes . '*' , GLOB_ONLYDIR);
		$themes = $themes ? array_map( 'basename', $themes ) : array();
		
		if ( ($default_key = array_search('default', $themes)) !== false ) {
			unset($themes[$default_key]);
		}
		
		usort($themes, function($a, $b) {
			return strlen($b) - strlen($a);
		});
		
		return $themes;
	}
	
	//protected function getAdaptedThemes() {
	//	
	//	$dir_of_themes = $this->getBasicDirOfTemplates();
	//	
	//	$themes = glob($dir_of_themes . '*' , GLOB_ONLYDIR);
	//	if ( $themes ) {
	//		$themes = array_map( 'basename', $themes );
	//		
	//		if ( ($default_key = array_search('default', $themes)) !== false ) {
	//			unset($themes[$default_key]);
	//		}
	//		
	//		usort($themes, function($a, $b) {
	//			return strlen($b) - strlen($a);
	//		});
	//		return $themes;
	//	} else {
	//		return array();
	//	}
	//}
	
	public function getBasicDirOfExtension() {
		return DIR_APPLICATION.$this->resource_route_catalog;
	}
	public function getBasicDirOfThemes() {
		return $this->getBasicDirOfExtension().'theme/';
	}
	
	public function getResourceRouteCatalog($resource) {
		return $this->resource_route_catalog.$resource;
	}
	public function getResourcePathWithVersionCatalog($resource) {
		return $this->getResourceLinkWithVersion( $this->getResourceRouteCatalog($resource) );
	}
	
	public function getSetting($setting_key) {
		$mod_settings = $this->getSettings();
		if ( isset($mod_settings[$setting_key]) ) {
			return $mod_settings[$setting_key];
		} else {
			return false;
		}
	}
	
	public function checkTables() {
		
		if ( !$this->hasCacheSimple('tables_checked') ) {
			
			foreach ( $this->getAdditionalDBFields() as $field ) {
				
				foreach ( $field['tables'] as $table_name ) {
					$query = $this->db->query("SHOW COLUMNS FROM `".DB_PREFIX.$table_name."`	WHERE field='".$this->db->escape($field['name'])."'	");
					if (!$query->num_rows) {
						$this->db->query("ALTER TABLE `".DB_PREFIX.$table_name."`	ADD COLUMN `".$field['name']."` ".$field['type']." " );
					}
				}
			}
			$this->setCacheSimple('tables_checked', true);
		}
  }
	
	public function getAdditionalDBFields() {
		return $this->additional_db_fields;
	}
	
	public function getSettingItems() {
		return $this->setting_items;
	}
	
	public function addEvents() {
		$this->load->model('setting/event');
		foreach ( $this->events as $event ) {
			$priority = isset($event['priority']) ? $event['priority'] : 0;
			$this->model_setting_event->addEvent($this->event_prefix.$event['code'], $event['trigger'], $event['action'], 1, $priority);
		}
	}
	
	public function removeEvents() {
		$this->load->model('setting/event');
		foreach ( $this->events as $event ) {
			$this->model_setting_event->deleteEventByCode($this->event_prefix.$event['code']);
		}
	}
	
	//public function getOptionFormResourcesAndData($data) {
	//	
	//	if ( $this->installed() ) {
	//		$this->loadLanguageLazyByRoute('extension/module/quantity_per_option');
	//		
	//		if (isset($this->request->post['quantity_per_option'])) {
	//			$data['quantity_per_option'] = $this->request->post['quantity_per_option'];
	//		} elseif (!empty($option_info['quantity_per_option'])) {
	//			$data['quantity_per_option'] = $option_info['quantity_per_option'];
	//		} else {
	//			$data['quantity_per_option'] = 0;
	//		}
	//		$data['qpo_installed'] = $this->installed();
	//	}
	//	return $data;
	//}
	
	public function setOptionQPO($option_id, $data) {
		if ( $this->installed() ) {
			$this->checkTables();
			$quantity_per_option = isset($data['quantity_per_option']) ? (int)$data['quantity_per_option'] : 0;
			$this->db->query("UPDATE `".DB_PREFIX."option` SET `quantity_per_option` = ".(int)$quantity_per_option." WHERE `option_id` = ".(int)$option_id." ");
		}
	}
	
	public function setPOVDefaultQuantity($pov_id, $pov) {
		if ( $this->installed() ) {
			$this->checkTables();
			if ( isset($pov['default_quantity']) ) {
				$this->db->query("UPDATE ".DB_PREFIX."product_option_value SET default_quantity = ".(int)$pov['default_quantity']." WHERE product_option_value_id = ".(int)$pov_id." ");
			}
		}
	}
	
	public function getOptionIdsHavingEnabledQPO() {
		$option_ids = array();
		if ( $this->installed() ) {
			$mod_settings = $this->getSettings();
			if ( !empty($mod_settings['pov_default_quantity']) ) {
				$this->checkTables();
				$query = $this->db->query("SELECT `option_id` FROM `".DB_PREFIX."option` WHERE `quantity_per_option` = 1 ");
				foreach ( $query->rows as $row ) {
					$option_ids[] = $row['option_id'];
				}
			}
		}
		return $option_ids;
	}
	
	public function normalizeArrayOfQPO($p_quantity_per_option) {
		$quantity_per_options = array();
		foreach ( $p_quantity_per_option as $product_option_id => $quantity_per_option ) { 
			foreach ( $quantity_per_option as $product_option_value_id => $product_option_value_quantity ) {
				$product_option_value_quantity = (int)$product_option_value_quantity;
				if ( $product_option_value_quantity ) {
					if ( !isset($quantity_per_options[$product_option_id]) ) {
						$quantity_per_options[$product_option_id] = array();
					}
					$quantity_per_options[$product_option_id][$product_option_value_id] = $product_option_value_quantity;
				}	
			}
		}
		return $quantity_per_options;
	}
	
	public function getQPOFromPOST() {
		$quantity_per_options = array();
		if ( !empty($this->request->post['quantity_per_option']) && is_array($this->request->post['quantity_per_option']) ) {
			$quantity_per_options = $this->normalizeArrayOfQPO($this->request->post['quantity_per_option']);
		}
		return $quantity_per_options;
	}
	
	// to be called from checkout/cart
	public function addToCartCheckMinQuantity($product_info, $json) {
		
		if ( $this->installed() && !empty($product_info['minimum']) && (int)$product_info['minimum'] > 0 ) {
			
			$quantity_per_options = $this->getQPOFromPOST();
			if ( !empty($quantity_per_options) ) {
				
				foreach ( $quantity_per_options as $product_option_id => $quantity_per_option ) {
					$qpo_total_quantity = 0;
					foreach ($quantity_per_option as $qpo_quantity) {
						$qpo_total_quantity+= $qpo_quantity;
					}
					if ( $qpo_total_quantity < (int)$product_info['minimum'] ) {
						$json['error']['option'][ $product_option_id ] = sprintf($this->language->get('error_minimum'), $product_info['name'], $product_info['minimum']);;
					}
				}
			}
		}
		return $json;
	}
	
	public function getCombinationsOfOptions($quantity_per_options, $options) {
		
		$qpo_all_combinations = array( array('options'=>$options, 'quantity'=>0) ); // theoretically, there may be more than one option with QPO
		foreach ( $quantity_per_options as $product_option_id => $quantity_per_option ) {
			$qpo_current_combinations = array();
			foreach ( $quantity_per_option as $product_option_value_id => $product_option_value_quantity ) {
				foreach ( $qpo_all_combinations as $qpo_combination_of_options ) {
					$qpo_combination_of_options['options'][$product_option_id] = $product_option_value_id;
					$qpo_combination_of_options['quantity'] = max($product_option_value_quantity, $qpo_combination_of_options['quantity']);
					$qpo_current_combinations[] = $qpo_combination_of_options;
				}
			}
			$qpo_all_combinations = $qpo_current_combinations;
		}
		return $qpo_all_combinations;
	}
	
	public function addCombinationsOfOptionsToCart($json, $quantity_per_options, $option, $recurring_id) {
		$qpo_all_combinations = $this->getCombinationsOfOptions($quantity_per_options, $option);
		if ( $qpo_all_combinations ) {
			$json['qpo_reset_on_add_to_cart'] = $this->getSetting('reset_on_add_to_cart');
			foreach ( $qpo_all_combinations as $qpo_of_options ) { // add all combinations of options to the shopping cart
				$this->cart->add($this->request->post['product_id'], $qpo_of_options['quantity'], $qpo_of_options['options'], $recurring_id);
			} 
		}
		return $json;
	}
	
	public function getDefaultQuantityFromPOVArrayIfEnabled($pov) {
		if ( $this->getSetting('pov_default_quantity') && isset($pov['default_quantity']) ) {
			return $pov['default_quantity'];
		} else {
			return 0;
		}
	}
	
	public function getProductPageQPOData($product_id) {
		
		$qpo = array();
		
		if ( $this->installed() ) {
			$query = $this->db->query("
				SELECT POV.product_option_id, POV.product_option_value_id, POV.default_quantity
				FROM `".DB_PREFIX."product_option_value` POV
						,`".DB_PREFIX."option` O
				WHERE POV.product_id = ".(int)$product_id."
					AND O.option_id = POV.option_id
					AND O.quantity_per_option = 1
					AND O.type IN ('radio', 'select', 'image')
			");
			foreach ( $query->rows as $row ) {
				$product_option_id 				= $row['product_option_id'];
				$product_option_value_id 	= $row['product_option_value_id'];
				if ( empty($qpo[$product_option_id]) ) {
					$qpo[$product_option_id] = array('product_option_id'=>$product_option_id, 'default_quantities'=>array());
				}
				if ( $this->getSetting('pov_default_quantity') && !empty($row['default_quantity']) ) {
					$qpo[$product_option_id]['default_quantities'][$product_option_value_id] = $row['default_quantity'];
				}
			}
		}
		return $qpo;
	}
	
	public function getProductPageOptionTemplatePath() {
		
		$theme_template = 'theme/'.$this->getThemeName().'/product.twig';
		if ( $this->resourceExists( $this->getResourcePathCatalog($theme_template) ) ) {
			$template_path = $this->getResourceFullPathCatalog($theme_template);
		} else {
			$template_path = $this->getResourceFullPathCatalog('default.product.twig');
		}
		return $this->getResourceThemeDirRelatedPathByFullPath( $template_path );
	}
	
	public function addProductPageStyles() {
		$styles = array();
		$theme_style = $this->getResourcePathCatalog('theme/'.$this->getThemeName().'/product.css');
		if ( $this->resourceExists($theme_style) ) {
			$styles[] = $this->getResourceLinkWithVersionCatalog($theme_style);
		}
		if ( count($styles) == 0 ) {
			$styles[] = $this->getResourceLinkWithVersionCatalog( $this->getResourcePathCatalog('default.product.css') );
		}
		$this->addStyles($styles);
	}
	
	public function addProductPageScripts() {
		$scripts = array();
		$scripts[] = $this->getResourceLinkWithVersionCatalog( $this->getResourcePathCatalog('liveopencart.quantity_per_option.js') );
		$theme_script = $this->getResourcePathCatalog('theme/'.$this->getThemeName().'/product.js');
		if ( $this->resourceExists($theme_script) ) {
			$scripts[] = $this->getResourceLinkWithVersionCatalog($theme_script);
		}
		$this->addScripts($scripts);
	}
	
	
}