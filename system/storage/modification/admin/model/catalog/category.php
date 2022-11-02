<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelCatalogCategory extends Model {
	public function addCategory($data) {
	        $data['asc_jetcache_settings'] = $this->config->get('asc_jetcache_settings');
	        if (isset($data['asc_jetcache_settings']['add_category']) && $data['asc_jetcache_settings']['add_category']) {
				if (file_exists(DIR_SYSTEM . 'helper/seocmsprofunc.php')) {
					if (!function_exists('loadlibrary')) {
						if (function_exists('modification')) {
							require_once(modification(DIR_SYSTEM . 'helper/seocmsprofunc.php'));
						} else {
							require_once(DIR_SYSTEM . 'helper/seocmsprofunc.php');
						}
					}
			        agoo_cont_admin('jetcache/jetcache', $this->registry);
	                $this->controller_jetcache_jetcache->hook_Category();
		        }
            }
		$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', 
		`top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `rm_description` = '" . (isset($data['rm_description']) ? (int)$data['rm_description'] : 0) . "', `hd_description` = '" . (isset($data['hd_description']) ? (int)$data['hd_description'] : 0) . "', `ht_description` = '" . (isset($data['ht_description']) ? (int)$data['ht_description'] : 0) . "', `rm_ext_description` = '" . (isset($data['rm_ext_description']) ? (int)$data['rm_ext_description'] : 0) . "', `rmm_ext_description` = '" . (isset($data['rmm_ext_description']) ? (int)$data['rmm_ext_description'] : 0) . "', `hd_ext_description` = '" . (isset($data['hd_ext_description']) ? (int)$data['hd_ext_description'] : 0) . "', `ht_ext_description` = '" . (isset($data['ht_ext_description']) ? (int)$data['ht_ext_description'] : 0) . "',
	   `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', noindex = '" . (int)$data['noindex'] . "', date_modified = NOW(), date_added = NOW()");

		$category_id = $this->db->getLastId();

		// SEO Tags Generator . begin
		$this->load->model('extension/module/seo_tags_generator');

		if (isset($this->request->post['stg_not_use'])) {
			$this->model_extension_module_seo_tags_generator->setStgNotUse($category_id, 'category');
		} else {
			$this->model_extension_module_seo_tags_generator->setStgNotUseOff($category_id, 'category');
		}
		// SEO Tags Generator . end

				if (isset($data['category_mrp'])) {
					foreach ($data['category_mrp'] as $category_mrp) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "category_mrp SET category_id = '" . (int)$category_id . "', status = '" . (int)$category_mrp['status'] . "', sort_order = '" . (int)$category_mrp['sort_order'] . "'");

						$category_mrp_id = $this->db->getLastId();

						foreach ($category_mrp['category_mrp_description'] as $language_id => $category_mrp_description) {				
							$this->db->query("INSERT INTO " . DB_PREFIX . "category_mrp_description SET category_mrp_id = '" . (int)$category_mrp_id . "', language_id = '" . (int)$language_id . "', category_id = '" . (int)$category_id . "', description = '" .  $this->db->escape($category_mrp_description['description']) . "', title = '" .  $this->db->escape($category_mrp_description['title']) . "'");
						}
						
						if (isset($category_mrp['category_mrp_product'])) {
							foreach ($category_mrp['category_mrp_product'] as $category_mrp_product) {
								$this->db->query("INSERT INTO " . DB_PREFIX . "category_mrp_product SET category_mrp_id = '" . (int)$category_mrp_id . "', category_id = '" . (int)$category_id . "', sort_order = '" . (int)$category_mrp_product['sort_order'] . "', product_id = '" . (int)$category_mrp_product['product_id'] . "'");
							}
						}
					}
				}
			


				if (isset($data['banner'])) {
					$this->db->query("UPDATE " . DB_PREFIX . "category SET banner = '" . $this->db->escape($data['banner']) . "' WHERE category_id = '" . (int)$category_id . "'");
				}
			
		if($this->config->get('module_seo_tags_generator_status') && $this->config->get('module_seo_tags_generator_declension')) {
			$this->model_extension_module_seo_tags_generator->addCategoryDeclension($category_id, $data['category_declension']); // SEO Tags Generator: Declension
		}

		// SEO Tags Generator: Formulas . begin
		if ($this->config->get('module_seo_tags_generator_status') && isset($data['stg_specific'])) {
			$this->model_extension_module_seo_tags_generator->addCategoryFormulas($category_id, $data['stg_specific']);
		}
		// SEO Tags Generator: Formulas . end

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', 
		description = '" . $this->db->escape($value['description']) . "', ext_description = '" . $this->db->escape($value['ext_description']) . "',
	   meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['category_filter'])) {
			foreach ($data['category_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_filter SET category_id = '" . (int)$category_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		// SEO URL Generator . begin
		// category_id not exist in controller when add() category
		
		$this->load->model('extension/module/seo_url_generator');

		$sug_log = new StdeLog('seo_url_generator');
		$sug_log->setDebug($this->config->get('module_seo_url_generator_debug'));

		$sug_log->write(4, 'model/category.php :: addCategory() is called');

		$sug_log->write(4, $data['category_seo_url'], 'model/category.php :: addCategory() : $data["category_seo_url"] BEFORE SUG');
		
		#
		# SETTING
		#

		$sug_data['setting'] = array();

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('setting/setting');
		
		$data['store_setting'] = array();
		
		foreach ($data['category_seo_url'] as $store_id => $store) {
			$store_setting = $this->model_setting_setting->getSetting('module_seo_url_generator', $store_id);

			$data['store_setting'][$store_id]['translit_function']     = $store_setting['module_seo_url_generator_translit_function'];			
			$data['store_setting'][$store_id]['formula']               = $store_setting['module_seo_url_generator_category_formula'];	
			$data['store_setting'][$store_id]['delimiter_char']        = $store_setting['module_seo_url_generator_delimiter_char'];			
			$data['store_setting'][$store_id]['change_delimiter_char'] = $store_setting['module_seo_url_generator_change_delimiter_char'];
			$data['store_setting'][$store_id]['rewrite_on_save']       = $store_setting['module_seo_url_generator_rewrite_on_save'];
			$data['store_setting'][$store_id]['custom_replace_from']   = $store_setting['module_seo_url_generator_custom_replace_from'];
			$data['store_setting'][$store_id]['custom_replace_to']     = $store_setting['module_seo_url_generator_custom_replace_to'];
		}

		foreach ($data['category_seo_url'] as $store_id => $store) {
			foreach ($store as $language_id => $url) {
				if (empty($data['category_seo_url'][$store_id][$language_id])) {
					$sug_data = array(
						'name'            =>$data['category_description'][$language_id]['name'],
						'primary_key'     => 'category_id',
						'essence'         => 'category',
						'essence_id'      => $category_id,
					);
					
					$sug_data['setting'] = array(
						'translit_function'     =>$data['store_setting'][$store_id]['translit_function'][$language_id],
						'formula'               =>$data['store_setting'][$store_id]['formula'][$language_id],
						'delimiter_char'        =>$data['store_setting'][$store_id]['delimiter_char'][$language_id],
						'change_delimiter_char' =>$data['store_setting'][$store_id]['change_delimiter_char'][$language_id],
						'rewrite_on_save'       =>$data['store_setting'][$store_id]['rewrite_on_save'][$language_id],
						'custom_replace_from'   =>$data['store_setting'][$store_id]['custom_replace_from'][$language_id],
						'custom_replace_to'     =>$data['store_setting'][$store_id]['custom_replace_to'][$language_id],
					);
        
          $sug_data['store_id'] = $store_id;

					$data['category_seo_url'][$store_id][$language_id] = $this->load->controller('extension/module/seo_url_generator/generateSeoUrl', $sug_data);

					$sug_log->write(4, $data['category_seo_url'][$store_id][$language_id], 'model/category.php :: addCategory() : $data["category_seo_url"][$store_id][$language_id]');
				}
			}	
			
		}

		$sug_log->write(4, $data['category_seo_url'], 'model/category.php :: addCategory() : $data["category_seo_url"] AFTER SUG');
		// SEO URL Generator . end

		if (isset($data['category_seo_url'])) {
			foreach ($data['category_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape(trim($keyword)) . "'");
					}
				}
			}
		}
		
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related_wb SET category_id = '" . (int)$category_id . "', product_id = '" . (int)$related_id . "'");
			}
		}
	
		if (isset($data['article_related'])) {
			foreach ($data['article_related'] as $related_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_related_wb SET category_id = '" . (int)$category_id . "', article_id = '" . (int)$related_id . "'");
			}
		}
		
		// Set which layout to use with this category
		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->cache->delete('category');
		
		if($this->config->get('config_seo_pro')){		
		$this->cache->delete('seopro');
		}

		return $category_id;
	}

	public function editCategory($category_id, $data) {

		// SEO Tags Generator . begin
		$this->load->model('extension/module/seo_tags_generator');

		if (isset($this->request->post['stg_not_use'])) {
			$this->model_extension_module_seo_tags_generator->setStgNotUse($category_id, 'category');
		} else {
			$this->model_extension_module_seo_tags_generator->setStgNotUseOff($category_id, 'category');
		}
		// SEO Tags Generator . end


				$this->db->query("DELETE FROM " . DB_PREFIX . "category_mrp WHERE category_id = '" . (int)$category_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "category_mrp_description WHERE category_id = '" . (int)$category_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "category_mrp_product WHERE category_id = '" . (int)$category_id . "'");
				
				if (isset($data['category_mrp'])) {
					foreach ($data['category_mrp'] as $category_mrp) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "category_mrp SET category_id = '" . (int)$category_id . "', status = '" . (int)$category_mrp['status'] . "', sort_order = '" . (int)$category_mrp['sort_order'] . "'");

						$category_mrp_id = $this->db->getLastId();

						foreach ($category_mrp['category_mrp_description'] as $language_id => $category_mrp_description) {				
							$this->db->query("INSERT INTO " . DB_PREFIX . "category_mrp_description SET category_mrp_id = '" . (int)$category_mrp_id . "', language_id = '" . (int)$language_id . "', category_id = '" . (int)$category_id . "', description = '" .  $this->db->escape($category_mrp_description['description']) . "', title = '" .  $this->db->escape($category_mrp_description['title']) . "'");
						}

						if (isset($category_mrp['category_mrp_product'])) {
							foreach ($category_mrp['category_mrp_product'] as $category_mrp_product) {
								$this->db->query("INSERT INTO " . DB_PREFIX . "category_mrp_product SET category_mrp_id = '" . (int)$category_mrp_id . "', category_id = '" . (int)$category_id . "', sort_order = '" . (int)$category_mrp_product['sort_order'] . "', product_id = '" . (int)$category_mrp_product['product_id'] . "'");
							}
						}
					}
				}
			
	        $data['asc_jetcache_settings'] = $this->config->get('asc_jetcache_settings');
	        if (isset($data['asc_jetcache_settings']['add_category']) && $data['asc_jetcache_settings']['add_category']) {
				if (file_exists(DIR_SYSTEM . 'helper/seocmsprofunc.php')) {
					if (!function_exists('loadlibrary')) {
						if (function_exists('modification')) {
							require_once(modification(DIR_SYSTEM . 'helper/seocmsprofunc.php'));
						} else {
							require_once(DIR_SYSTEM . 'helper/seocmsprofunc.php');
						}
					}
			        agoo_cont_admin('jetcache/jetcache', $this->registry);
	                $this->controller_jetcache_jetcache->hook_Category();
		        }
            }
		$this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$data['parent_id'] . "', 
		`top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `rm_description` = '" . (isset($data['rm_description']) ? (int)$data['rm_description'] : 0) . "', `hd_description` = '" . (isset($data['hd_description']) ? (int)$data['hd_description'] : 0) . "', `ht_description` = '" . (isset($data['ht_description']) ? (int)$data['ht_description'] : 0) . "', `rm_ext_description` = '" . (isset($data['rm_ext_description']) ? (int)$data['rm_ext_description'] : 0) . "', `rmm_ext_description` = '" . (isset($data['rmm_ext_description']) ? (int)$data['rmm_ext_description'] : 0) . "', `hd_ext_description` = '" . (isset($data['hd_ext_description']) ? (int)$data['hd_ext_description'] : 0) . "', `ht_ext_description` = '" . (isset($data['ht_ext_description']) ? (int)$data['ht_ext_description'] : 0) . "',
	   `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', noindex = '" . (int)$data['noindex'] . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");


				if (isset($data['banner'])) {
					$this->db->query("UPDATE " . DB_PREFIX . "category SET banner = '" . $this->db->escape($data['banner']) . "' WHERE category_id = '" . (int)$category_id . "'");
				}
			
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape($data['image']) . "' WHERE category_id = '" . (int)$category_id . "'");
		}


		if($this->config->get('module_seo_tags_generator_status') && $this->config->get('module_seo_tags_generator_declension')) {
			$this->model_extension_module_seo_tags_generator->editCategoryDeclension($category_id, $data['category_declension']); // SEO Tags Generator: Declension
		}


		// SEO Tags Generator: Formulas . begin
		if ($this->config->get('module_seo_tags_generator_status') && isset($data['stg_specific'])) {
			$this->model_extension_module_seo_tags_generator->editCategoryFormulas($category_id, $data['stg_specific']);
		}
		// SEO Tags Generator: Formulas . end

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', 
		description = '" . $this->db->escape($value['description']) . "', ext_description = '" . $this->db->escape($value['ext_description']) . "',
	   meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE path_id = '" . (int)$category_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $category_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' AND level < '" . (int)$category_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_path['category_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_path['category_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_filter'])) {
			foreach ($data['category_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_filter SET category_id = '" . (int)$category_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// SEO URL

		/* SEO URL Generator . begin
		------------------------------------------------------------------------- */	
		// В случае редактирования из админки мы имеем сразу 3 ЧПУ
		// 1 - $keyword_old - тот, который есть в базе на момент до редактирования - именно для него нужен редирект (!)
		// 2 - $data['category_seo_url'][$store_id][$language_id] - тот, который введен в форму - он может совпадать с $keyword_old, быть введенным вручную или вообще отсутствовать
		// 3 - $keyword_new - тот, который генерируется автоматически, в случае, когда это необходимо
		
		$this->load->model('extension/module/seo_url_generator');

		$sug_log = new StdeLog('seo_url_generator');
		$sug_log->setDebug($this->config->get('module_seo_url_generator_debug'));

		$sug_log->write(2, 'model/category.php :: editCategory() is called');

		$sug_log->write(4, $data['category_seo_url'], 'model/category.php :: editCategory() : $data["category_seo_url"] BEFORE SUG');

		if (isset($data['seo_url_generator_redirects'])) {
			$sug_log->write(4, $data['seo_url_generator_redirects'], 'model/category.php :: editCategory() : $data["seo_url_generator_redirects"]');
		}
		
		if (isset($data['seo_url_generator_front_works'])) {
			$sug_front_ok = true;
			$sug_log->write(4, 'ISSET', 'model/category.php :: editCategory() : $data["seo_url_generator_front_works"]');
		} else {
			$sug_front_ok = false;
			$sug_log->write(4, 'NULL', 'model/category.php :: editCategory() : $data["seo_url_generator_front_works"]');
		}


		#
		# SETTING
		#

		$sug_data['setting'] = array();

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('setting/setting');
		
		$data['store_setting'] = array();
		
		foreach ($data['category_seo_url'] as $store_id => $store) {
			$store_setting = $this->model_setting_setting->getSetting('module_seo_url_generator', $store_id);

			$data['store_setting'][$store_id]['translit_function']     = $store_setting['module_seo_url_generator_translit_function'];			
			$data['store_setting'][$store_id]['formula']               = $store_setting['module_seo_url_generator_category_formula'];	
			$data['store_setting'][$store_id]['delimiter_char']        = $store_setting['module_seo_url_generator_delimiter_char'];			
			$data['store_setting'][$store_id]['change_delimiter_char'] = $store_setting['module_seo_url_generator_change_delimiter_char'];
			$data['store_setting'][$store_id]['rewrite_on_save']       = $store_setting['module_seo_url_generator_rewrite_on_save'];
			$data['store_setting'][$store_id]['custom_replace_from']   = $store_setting['module_seo_url_generator_custom_replace_from'];
			$data['store_setting'][$store_id]['custom_replace_to']     = $store_setting['module_seo_url_generator_custom_replace_to'];
		}

		$keywords_old = $this->model_extension_module_seo_url_generator->getURLs('category_id', $this->request->get['category_id']);

		$sug_log->write(4, $keywords_old, 'model/category.php :: editCategory() : $keywords_old');

		$redirects_exist = $this->model_extension_module_seo_url_generator->getRedirects('category_id', $this->request->get['category_id']);

		$sug_log->write(4, $redirects_exist, 'model/category.php :: editCategory() : $redirects_exist');


		#
		# ITTERATIONS
		#

		foreach ($data['category_seo_url'] as $store_id => $store) {
			foreach ($store as $language_id => $url) {				

				# SEO URL PROCESSING

				$sug_data = array(
					'name'            => $data['category_description'][$language_id]['name'],
					'primary_key'     => 'category_id',
					'essence'         => 'category',
					'essence_id'      => $this->request->get['category_id'],
				);

				$sug_data['setting'] = array(
					'translit_function'     =>$data['store_setting'][$store_id]['translit_function'][$language_id],
					'formula'               =>$data['store_setting'][$store_id]['formula'][$language_id],
					'delimiter_char'        =>$data['store_setting'][$store_id]['delimiter_char'][$language_id],
					'change_delimiter_char' =>$data['store_setting'][$store_id]['change_delimiter_char'][$language_id],
					'rewrite_on_save'       =>$data['store_setting'][$store_id]['rewrite_on_save'][$language_id],
					'custom_replace_from'   =>$data['store_setting'][$store_id]['custom_replace_from'][$language_id],
					'custom_replace_to'     =>$data['store_setting'][$store_id]['custom_replace_to'][$language_id],
				);
        
        $sug_data['store_id'] = $store_id;

				$data['category_seo_url'][$store_id][$language_id] = trim($data['category_seo_url'][$store_id][$language_id]);

				$sug_log->write(2, $data['category_seo_url'][$store_id][$language_id], 'model/category.php :: editCategory() : $data["category_seo_url"][$store_id][$language_id]');

				$sug_set_backend_autoredirects = false;

				$keyword_new = false;

				$keyword_old = count($keywords_old) > 0 && isset($keywords_old[$store_id][$language_id]) ? $keywords_old[$store_id][$language_id] : '';

				$sug_log->write(4, $keyword_old, 'model/category.php :: editCategory() : $keyword_old');

				$sug_log->write(4, $sug_data, 'model/category.php :: editCategory() : $sug_data');

				if (!$keyword_old && !$data['category_seo_url'][$store_id][$language_id]) {
					// Все понятно: старого ЧПУ нет, просто генерим новый. Редиректы не нужны.
					$sug_log->write(4, $keyword_old, 'model/category.php :: editCategory() : EMPTY $keyword_old & $data["category_seo_url"][$store_id][$language_id]');

					$data['category_seo_url'][$store_id][$language_id] = $this->load->controller('extension/module/seo_url_generator/generateSeoUrl', $sug_data);
					//$this->cache->delete('seo_pro');
					continue;
				}

				if (!$keyword_old && $data['category_seo_url'][$store_id][$language_id]) {
					// Снова все понятно: старого ЧПУ в базе нет, соглашаемся с ЧПУ из формы
					// Q?
					// А транлитировать этот ЧПУ надо или нет?..

					//$this->cache->delete('seo_pro');
					continue;
				}

				if ($keyword_old && !$data['category_seo_url'][$store_id][$language_id]) {
					// Просто используем существующий ЧПУ из базы
					$data['category_seo_url'][$store_id][$language_id] = $keyword_old;
				}

				if ($keyword_old && $data['category_seo_url'][$store_id][$language_id] && $keyword_old != $data['category_seo_url'][$store_id][$language_id]) {
					// Запускаем механизм редиректов, только если на фронте не работает
					if (!$sug_front_ok) {
						$sug_set_backend_autoredirects = true;
					}

					$keyword_new = $data['category_seo_url'][$store_id][$language_id];

					// Q?
					// А транлитировать этот ЧПУ надо или нет?..
					// Минуем актуализацию, итак понятно, что $keyword_old != $data['category_seo_url'][$store_id][$language_id]
					goto sug_edit_end;
				}
        
        if ($keyword_old && $data['category_seo_url'][$store_id][$language_id] && $keyword_old == $data['category_seo_url'][$store_id][$language_id] && $sug_data['setting']['rewrite_on_save']) {
					// Актуализация по данным сущности - название, другая формула
					// ставить ли редирект, будет понятно лишь после сравнения старого и нового ЧПУ

					$keyword_new = $this->load->controller('extension/module/seo_url_generator/generateSeoUrl', $sug_data);
				}

				// Make unique
				if ($keyword_new && !$this->model_extension_module_seo_url_generator->isUnique($keyword_new, $sug_data['primary_key'], $sug_data['essence_id'], $store_id)) {
					$keyword_new = $this->model_extension_module_seo_url_generator->makeUniqueUrl($keyword_new, $store_id);
				}

				// Актуализация по разделителю
				if ($keyword_new && $sug_data['setting']['rewrite_on_save']) {
					$sug_log->write(4, 'model/category.php :: editCategory() : Actualization by delimeter BEGIN');

					if ('donot' != $sug_data['setting']['change_delimiter_char']) {
						// Compare without delimiters
						$keyword_old_without_delimiters = preg_replace(array('|_+|', '|-+|'), array('', ''), $keyword_old);
						$keyword_new_without_delimiters = preg_replace(array('|_+|', '|-+|'), array('', ''), $keyword_new);

						$sug_log->write(3, $keyword_old_without_delimiters, 'generateSeoUrl() : $keyword_old_without_delimiters');
						$sug_log->write(3, $keyword_new_without_delimiters, 'generateSeoUrl() : $keyword_new_without_delimiters');

						if ($keyword_old_without_delimiters != $keyword_new_without_delimiters) {
							$sug_set_backend_autoredirects = true;
							$data['category_seo_url'][$store_id][$language_id] = $keyword_new;
						}
					} else {
						// Compare with delimiters
						if ($keyword_old != $keyword_new) {
							$sug_set_backend_autoredirects = true;
							$data['category_seo_url'][$store_id][$language_id] = $keyword_new;
						}
					}
				}

				// Write Redirect
				sug_edit_end:

				$sug_log->write(4, 'model/category.php :: editCategory() : sug_redirects BEGIN');
				
				$sug_log->write(4, $sug_set_backend_autoredirects, 'model/category.php :: editCategory() : $sug_set_backend_autoredirects');

				$sug_log->write(4, $keyword_new, 'model/category.php :: editCategory() : $keyword_new');
				
				// Удаляем все существующие редиректы из базы для данной сущности - на фронте предупреждение было выдано, чтобы не убирали из формы
				$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url_generator_redirects WHERE query = 'category_id=" . (int)$category_id . "' AND `store_id` = '" . (int)$store_id . "' AND `language_id` = '" . (int)$language_id . "'");
		
				// Обрабатываем редиректы из формы - все управление редриректами у пользователя на фронте!
				if (isset($data['seo_url_generator_redirects'][$store_id][$language_id]) && count($data['seo_url_generator_redirects'][$store_id][$language_id]) > 0) {
					$sug_log->write(4, $data['seo_url_generator_redirects'][$store_id][$language_id], 'model/category.php :: editCategory() : $data["seo_url_generator_redirects"][$store_id][$language_id]');

					$data['seo_url_generator_redirects'][$store_id][$language_id] = array_unique($data['seo_url_generator_redirects'][$store_id][$language_id]); // на всякий случай...

					foreach ($data['seo_url_generator_redirects'][$store_id][$language_id] as $redirect) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url_generator_redirects SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', seo_url_old = '" . $this->db->escape($redirect) . "', seo_url_actual = '" . $this->db->escape($data['category_seo_url'][$store_id][$language_id]) . "', query = 'category_id=" . (int)$category_id . "'");
					}
				}
				
				if ($sug_set_backend_autoredirects) {
					$sug_log->write(3, 'model/category.php :: editCategory() : Autoredirect was created on backend');

					// setRedirect() кроме того, что просто записывет текущий редирект, также обновляет новый ЧПУ для всех старый редиректов
					$this->model_extension_module_seo_url_generator->setRedirect($keyword_new, $keyword_old, $sug_data['primary_key'], $sug_data['essence_id'], $store_id, $language_id);
				}

			}
		}

		/* SEO URL Generator . end
		------------------------------------------------------------------------- */

		$this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE query = 'category_id=" . (int)$category_id . "'");

		if (isset($data['category_seo_url'])) {
			foreach ($data['category_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape(trim($keyword)) . "'");
					}
				}
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related_wb WHERE category_id = '" . (int)$category_id . "'");
	
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related_wb WHERE category_id = '" . (int)$category_id . "' AND product_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related_wb SET category_id = '" . (int)$category_id . "', product_id = '" . (int)$related_id . "'");
				
	
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_related_wb WHERE category_id = '" . (int)$category_id . "'");
	
		if (isset($data['article_related'])) {
			foreach ($data['article_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "article_related_wb WHERE category_id = '" . (int)$category_id . "' AND article_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_related_wb SET category_id = '" . (int)$category_id . "', article_id = '" . (int)$related_id . "'");
				
	
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->cache->delete('category');
		
		if($this->config->get('config_seo_pro')){		
		$this->cache->delete('seopro');
		}
	}
	
	public function editCategoryStatus($category_id, $status) {
        $this->db->query("UPDATE " . DB_PREFIX . "category SET status = '" . (int)$status . "', date_modified = NOW() WHERE category_id = '" . (int)$category_id . "'");
        
		$this->cache->delete('category');
		
		if($this->config->get('config_seo_pro')){		
		$this->cache->delete('seopro');
		}
		
    }

	public function deleteCategory($category_id) {
	        $data['asc_jetcache_settings'] = $this->config->get('asc_jetcache_settings');
	        if (isset($data['asc_jetcache_settings']['add_category']) && $data['asc_jetcache_settings']['add_category']) {
				if (file_exists(DIR_SYSTEM . 'helper/seocmsprofunc.php')) {
					if (!function_exists('loadlibrary')) {
						if (function_exists('modification')) {
							require_once(modification(DIR_SYSTEM . 'helper/seocmsprofunc.php'));
						} else {
							require_once(DIR_SYSTEM . 'helper/seocmsprofunc.php');
						}
					}
			        agoo_cont_admin('jetcache/jetcache', $this->registry);
	                $this->controller_jetcache_jetcache->hook_Category();
		        }
            }
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_path WHERE category_id = '" . (int)$category_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_path WHERE path_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['category_id']);
		}


				$this->db->query("DELETE FROM " . DB_PREFIX . "category_mrp WHERE category_id = '" . (int)$category_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "category_mrp_description WHERE category_id = '" . (int)$category_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "category_mrp_product WHERE category_id = '" . (int)$category_id . "'");
			
		$this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
		// SEO URL Generator . begin
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url_generator_redirects WHERE query = 'category_id=" . (int)$category_id . "'");
		// SEO URL Generator . end
		$this->db->query("DELETE FROM `".DB_PREFIX."seo_tags_generator_category_declension` WHERE category_id = '" . (int)$category_id . "'"); // SEO Tags Generator: Declension
		// SEO Tags Generator: Formulas . begin
		$this->db->query("DELETE FROM `".DB_PREFIX."seo_tags_generator` WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM `".DB_PREFIX."seo_tags_generator_category_setting` WHERE category_id = '" . (int)$category_id . "'");
		// SEO Tags Generator: Formulas . end
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'category_id=" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related_wb WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_related_wb WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_category WHERE category_id = '" . (int)$category_id . "'");

		$this->cache->delete('category');
		
		if($this->config->get('config_seo_pro')){		
		$this->cache->delete('seopro');
		}
	}

	public function repairCategories($parent_id = 0) {
	        $data['asc_jetcache_settings'] = $this->config->get('asc_jetcache_settings');
	        if (isset($data['asc_jetcache_settings']['add_category']) && $data['asc_jetcache_settings']['add_category']) {
				if (file_exists(DIR_SYSTEM . 'helper/seocmsprofunc.php')) {
					if (!function_exists('loadlibrary')) {
						if (function_exists('modification')) {
							require_once(modification(DIR_SYSTEM . 'helper/seocmsprofunc.php'));
						} else {
							require_once(DIR_SYSTEM . 'helper/seocmsprofunc.php');
						}
					}
			        agoo_cont_admin('jetcache/jetcache', $this->registry);
	                $this->controller_jetcache_jetcache->hook_Category();
		        }
            }
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $category) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category['category_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$category['category_id'] . "', level = '" . (int)$level . "'");

			$this->repairCategories($category['category_id']);
		}
	}

	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id) WHERE cp.category_id = c.category_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.category_id) AS path FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (c.category_id = cd2.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getAllCategories() {
		$result = $this->cache->get('category.all.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'));

		if (!$result || !is_array($result)) {
			$query = $this->db->query("SELECT c.category_id, c.parent_id, name FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY c.parent_id, c.sort_order, cd.name");
		
			$categories = array();
		
			foreach ($query->rows as $row) {
				$categories[$row['parent_id']][$row['category_id']] = $row;
			}
		
			$result = $this->getCategories($categories);
		
			$this->cache->set('category.all.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $result);
		}

		return $result;
	}

	public function getCategories($data = array()) {

		$result_rm_description = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "category LIKE 'rm_description';");
		if ($result_rm_description->num_rows == 0) {
			$this->db->query("ALTER TABLE " . DB_PREFIX . "category ADD COLUMN `rm_description` tinyint(1) NOT NULL AFTER  `top`");
		}

		$result_hd_description = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "category LIKE 'hd_description';");
		if ($result_hd_description->num_rows == 0) {
			$this->db->query("ALTER TABLE " . DB_PREFIX . "category ADD COLUMN `hd_description` tinyint(1) NOT NULL AFTER  `top`");
		}

		$result_ht_description = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "category LIKE 'ht_description';");
		if ($result_ht_description->num_rows == 0) {
			$this->db->query("ALTER TABLE " . DB_PREFIX . "category ADD COLUMN `ht_description` int(5) NOT NULL AFTER  `top`");
		}

		$result_rm_ext_description = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "category LIKE 'rm_ext_description';");
		if ($result_rm_ext_description->num_rows == 0) {
			$this->db->query("ALTER TABLE " . DB_PREFIX . "category ADD COLUMN `rm_ext_description` tinyint(1) NOT NULL AFTER  `top`");
		}

		$result_rmm_ext_description = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "category LIKE 'rmm_ext_description';");
		if ($result_rmm_ext_description->num_rows == 0) {
			$this->db->query("ALTER TABLE " . DB_PREFIX . "category ADD COLUMN `rmm_ext_description` tinyint(1) NOT NULL AFTER  `top`");
		}

		$result_hd_ext_description = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "category LIKE 'hd_ext_description';");
		if ($result_hd_ext_description->num_rows == 0) {
			$this->db->query("ALTER TABLE " . DB_PREFIX . "category ADD COLUMN `hd_ext_description` tinyint(1) NOT NULL AFTER  `top`");
		}

		$result_ht_ext_description = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "category LIKE 'ht_ext_description';");
		if ($result_ht_ext_description->num_rows == 0) {
			$this->db->query("ALTER TABLE " . DB_PREFIX . "category ADD COLUMN `ht_ext_description` int(5) NOT NULL AFTER  `top`");
		}

		$result_ext_description = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "category_description LIKE 'ext_description';");
		if ($result_ext_description->num_rows == 0) {
			$this->db->query("ALTER TABLE " . DB_PREFIX . "category_description ADD COLUMN ext_description TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER  `description` ;");
		}
	  
		$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order, c1.noindex FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.category_id";

		$sort_data = array(
			'name',
			'sort_order',
			'noindex'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getCategoryDescriptions($category_id) {
		$category_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_h1'      	   => $result['meta_h1'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				
		'description'      => $result['description'],
		'ext_description'  => $result['ext_description']
	  
			);
		}

		return $category_description_data;
	}
	
	public function getCategoryPath($category_id) {
		$query = $this->db->query("SELECT category_id, path_id, level FROM " . DB_PREFIX . "category_path WHERE category_id = '" . (int)$category_id . "'");

		return $query->rows;
	}
	
	public function getCategoryFilters($category_id) {
		$category_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_filter_data[] = $result['filter_id'];
		}

		return $category_filter_data;
	}


				public function getCategoryTables($category_id) {
					$this->load->model('catalog/product');

					$category_mrp_data = array();

					$category_mrp_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_mrp WHERE category_id = '" . (int)$category_id . "' ORDER BY sort_order ASC");

					foreach ($category_mrp_query->rows as $category_mrp) {
						$category_mrp_description_data = array();

						$category_mrp_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_mrp_description WHERE category_mrp_id = '" . (int)$category_mrp['category_mrp_id'] . "'");

						foreach ($category_mrp_description_query->rows as $category_mrp_description) {			
							$category_mrp_description_data[$category_mrp_description['language_id']] = array(
								'title' 		=> $category_mrp_description['title'],
								'description' 	=> $category_mrp_description['description'],
							);
						}

						$category_mrp_product_data = array();

						$category_mrp_product_data_q = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_mrp_product WHERE category_mrp_id = '" . (int)$category_mrp['category_mrp_id'] . "' AND category_id = '" . (int)$category_id . "' ORDER BY sort_order, LCASE(category_mrp_product_id)");

						foreach ($category_mrp_product_data_q->rows as $category_mrp_product) {
							$product_info = $this->model_catalog_product->getProduct($category_mrp_product['product_id']);

							$category_mrp_product_data[] = array(
								'category_mrp_product_id' => $category_mrp_product['category_mrp_product_id'],
								'sort_order'                    => $category_mrp_product['sort_order'],
								'product_id'                => $category_mrp_product['product_id'],
								'product_name'              => (!empty($product_info)) ? $product_info['name'] : ''
							);
						}

						$category_mrp_data[] = array(
							'category_mrp_description' => $category_mrp_description_data,
							'status'                     => $category_mrp['status'],
							'sort_order'                 => $category_mrp['sort_order'],
							'category_mrp_id'          => $category_mrp['category_mrp_id'],
							'category_mrp_product'     => $category_mrp_product_data,						
						);
					}

					return $category_mrp_data;
				}

				public function createMrpSQL() {
					$query = $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "category_mrp` (
					`category_mrp_id` int(11) NOT NULL AUTO_INCREMENT, 
					`category_id` int(11) NOT NULL,
					`sort_order` int(3) NOT NULL DEFAULT '0',
					`status` int(1) NOT NULL,
					PRIMARY KEY (`category_mrp_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; 
					");

					$query = $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "category_mrp_description` (
						`category_mrp_id` int(11) NOT NULL,
						`language_id` int(11) NOT NULL,
						`category_id` int(11) NOT NULL,
						`title` varchar(255) CHARACTER SET utf8 NOT NULL,
						`description` text NOT NULL,
						PRIMARY KEY (`category_mrp_id`, `language_id`) 
					) ENGINE=MyISAM DEFAULT CHARSET=utf8; 
					");

					$query = $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "category_mrp_product` (
						`category_mrp_product_id` int(11) NOT NULL AUTO_INCREMENT,
						`category_id` int(11) NOT NULL,
						`category_mrp_id` int(11) NOT NULL,
						`sort_order` int(11) NOT NULL,
						`product_id` int(11) NOT NULL,
						PRIMARY KEY (`category_mrp_product_id`) 
					) ENGINE=MyISAM DEFAULT CHARSET=utf8; 
					");
				}
			
	public function getCategoryStores($category_id) {
		$category_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}

		return $category_store_data;
	}
	
	public function getCategorySeoUrls($category_id) {
		$category_seo_url_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'category_id=" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $category_seo_url_data;
	}
	
	public function getCategoryRelated($category_id) {
		$category_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related_wb WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_related_data[] = $result['related_id'];
		}
		
		return $product_related_data;
	}
	
	public function getCategoryRelated_article($category_id) {
		$category_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_related_wb WHERE article_id = '" . (int)$article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_related_data[] = $result['related_id'];
		}
		
		return $article_related_data;
	}
	
	public function getCategoryLayouts($category_id) {
		$category_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $category_layout_data;
	}

	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category");

		return $query->row['total'];
	}
	
	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}

	public function getCategoriesByParentId($parent_id = 0) {
		$query = $this->db->query("SELECT *, (SELECT COUNT(parent_id) FROM " . DB_PREFIX . "category WHERE parent_id = c.category_id) AS children FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name");
		return $query->rows;
	}
	
	public function getCategoriesChildren($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_path WHERE path_id = '" . (int)$parent_id . "'");
		return $query->rows;
	}
	
	public function getProductRelated($category_id) {
		$product_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related_wb WHERE category_id = '" . (int)$category_id . "'");
		
		foreach ($query->rows as $result) {
			$product_related_data[] = $result['product_id'];
		}
		
		return $product_related_data;
	}
	
	public function getArticleRelated($category_id) {
		$article_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_related_wb WHERE category_id = '" . (int)$category_id . "'");
		
		foreach ($query->rows as $result) {
			$article_related_data[] = $result['article_id'];
		}
		
		return $article_related_data;
	}
}