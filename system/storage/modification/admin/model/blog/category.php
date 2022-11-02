<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt
class ModelBlogCategory extends Model {
	public function addCategory($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', noindex = '" . (int)$data['noindex'] . "', date_modified = NOW(), date_added = NOW()");
		$blog_category_id = $this->db->getLastId();
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_category SET image = '" . $this->db->escape($data['image']) . "' WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		}
		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_description SET blog_category_id = '" . (int)$blog_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}
		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");
		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "blog_category_path` SET `blog_category_id` = '" . (int)$blog_category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");
			$level++;
		}
		$this->db->query("INSERT INTO `" . DB_PREFIX . "blog_category_path` SET `blog_category_id` = '" . (int)$blog_category_id . "', `path_id` = '" . (int)$blog_category_id . "', `level` = '" . (int)$level . "'");
		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_to_store SET blog_category_id = '" . (int)$blog_category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		// SEO URL Generator . begin
		// blog_category_id not exist in controller when add() category
		
		$this->load->model('extension/module/seo_url_generator');

		$sug_log = new StdeLog('seo_url_generator');
		$sug_log->setDebug($this->config->get('module_seo_url_generator_debug'));

		$sug_log->write(4, 'model/blog/category.php :: addCategory() is called');

		$sug_log->write(4, $data['category_seo_url'], 'model/blog/category.php :: addCategory() : $data["category_seo_url"] BEFORE SUG');
		
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
			$data['store_setting'][$store_id]['formula']               = '';
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
						'primary_key'     => 'blog_category_id',
						'essence'         => 'blog_category',
						'essence_id'      => $blog_category_id,
					);
					
					$sug_data['setting'] = array(
						'translit_function'     =>$data['store_setting'][$store_id]['translit_function'][$language_id],
						'formula'               =>'',
						'delimiter_char'        =>$data['store_setting'][$store_id]['delimiter_char'][$language_id],
						'change_delimiter_char' =>$data['store_setting'][$store_id]['change_delimiter_char'][$language_id],
						'rewrite_on_save'       =>$data['store_setting'][$store_id]['rewrite_on_save'][$language_id],
						'custom_replace_from'   =>$data['store_setting'][$store_id]['custom_replace_from'][$language_id],
						'custom_replace_to'     =>$data['store_setting'][$store_id]['custom_replace_to'][$language_id],
					);
        
        	$sug_data['store_id'] = $store_id;

					$data['category_seo_url'][$store_id][$language_id] = $this->load->controller('extension/module/seo_url_generator/generateSeoUrl', $sug_data);

					$sug_log->write(4, $data['category_seo_url'][$store_id][$language_id], 'model/blog/category.php :: addCategory() : $data["category_seo_url"][$store_id][$language_id]');
				}
			}	
			
		}

		$sug_log->write(4, $data['category_seo_url'], 'model/blog/category.php :: addCategory() : $data["category_seo_url"] AFTER SUG');
		// SEO URL Generator . end

		if (isset($data['category_seo_url'])) {
			foreach ($data['category_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'blog_category_id=" . (int)$blog_category_id . "', keyword = '" . $this->db->escape(trim($keyword)) . "'");
					}
				}
			}
		}
		// Set which layout to use with this category
		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_to_layout SET blog_category_id = '" . (int)$blog_category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}
		$this->cache->delete('blog_category');
		
		if($this->config->get('config_seo_pro')){		
		$this->cache->delete('seopro');
		}
		return $blog_category_id;
	}
	public function editCategory($blog_category_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog_category SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', noindex = '" . (int)$data['noindex'] . "', date_modified = NOW() WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog_category SET image = '" . $this->db->escape($data['image']) . "' WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_description WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_description SET blog_category_id = '" . (int)$blog_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}
		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category_path` WHERE path_id = '" . (int)$blog_category_id . "' ORDER BY level ASC");
		if ($query->rows) {
			foreach ($query->rows as $category_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$category_path['blog_category_id'] . "' AND level < '" . (int)$category_path['level'] . "'");
				$path = array();
				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");
				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}
				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$category_path['blog_category_id'] . "' ORDER BY level ASC");
				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}
				// Combine the paths with a new level
				$level = 0;
				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "blog_category_path` SET blog_category_id = '" . (int)$category_path['blog_category_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");
					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$blog_category_id . "'");
			// Fix for records with no paths
			$level = 0;
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");
			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "blog_category_path` SET blog_category_id = '" . (int)$blog_category_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");
				$level++;
			}
			$this->db->query("REPLACE INTO `" . DB_PREFIX . "blog_category_path` SET blog_category_id = '" . (int)$blog_category_id . "', `path_id` = '" . (int)$blog_category_id . "', level = '" . (int)$level . "'");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_to_store WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_to_store SET blog_category_id = '" . (int)$blog_category_id . "', store_id = '" . (int)$store_id . "'");
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

		$sug_log->write(2, 'model/blog/category.php :: editCategory() is called');

		$sug_log->write(4, $data['category_seo_url'], 'model/blog/category.php :: editCategory() : $data["category_seo_url"] BEFORE SUG');

		if (isset($data['seo_url_generator_redirects'])) {
			$sug_log->write(4, $data['seo_url_generator_redirects'], 'model/blog/category.php :: editCategory() : $data["seo_url_generator_redirects"]');
		}
		
		if (isset($data['seo_url_generator_front_works'])) {
			$sug_front_ok = true;
			$sug_log->write(4, 'ISSET', 'model/blog/category.php :: editCategory() : $data["seo_url_generator_front_works"]');
		} else {
			$sug_front_ok = false;
			$sug_log->write(4, 'NULL', 'model/blog/category.php :: editCategory() : $data["seo_url_generator_front_works"]');
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
			$data['store_setting'][$store_id]['formula']               = '';
			$data['store_setting'][$store_id]['delimiter_char']        = $store_setting['module_seo_url_generator_delimiter_char'];			
			$data['store_setting'][$store_id]['change_delimiter_char'] = $store_setting['module_seo_url_generator_change_delimiter_char'];
			$data['store_setting'][$store_id]['rewrite_on_save']       = $store_setting['module_seo_url_generator_rewrite_on_save'];
			$data['store_setting'][$store_id]['custom_replace_from']   = $store_setting['module_seo_url_generator_custom_replace_from'];
			$data['store_setting'][$store_id]['custom_replace_to']     = $store_setting['module_seo_url_generator_custom_replace_to'];
		}

		$keywords_old = $this->model_extension_module_seo_url_generator->getURLs('blog_category_id', $this->request->get['blog_category_id']);

		$sug_log->write(4, $keywords_old, 'model/blog/category.php :: editCategory() : $keywords_old');

		$redirects_exist = $this->model_extension_module_seo_url_generator->getRedirects('blog_category_id', $this->request->get['blog_category_id']);

		$sug_log->write(4, $redirects_exist, 'model/blog/category.php :: editCategory() : $redirects_exist');


		#
		# ITTERATIONS
		#

		foreach ($data['category_seo_url'] as $store_id => $store) {
			foreach ($store as $language_id => $url) {				

				# SEO URL PROCESSING

				$sug_data = array(
					'name'            => $data['category_description'][$language_id]['name'],
					'primary_key'     => 'blog_category_id',
					'essence'         => 'blog_category',
					'essence_id'      => $this->request->get['blog_category_id'],
				);

				$sug_data['setting'] = array(
					'translit_function'     =>$data['store_setting'][$store_id]['translit_function'][$language_id],
					'formula'               =>'',
					'delimiter_char'        =>$data['store_setting'][$store_id]['delimiter_char'][$language_id],
					'change_delimiter_char' =>$data['store_setting'][$store_id]['change_delimiter_char'][$language_id],
					'rewrite_on_save'       =>$data['store_setting'][$store_id]['rewrite_on_save'][$language_id],
					'custom_replace_from'   =>$data['store_setting'][$store_id]['custom_replace_from'][$language_id],
					'custom_replace_to'     =>$data['store_setting'][$store_id]['custom_replace_to'][$language_id],
				);

        $sug_data['store_id'] = $store_id;
        
				$data['category_seo_url'][$store_id][$language_id] = trim($data['category_seo_url'][$store_id][$language_id]);

				$sug_log->write(2, $data['category_seo_url'][$store_id][$language_id], 'model/blog/category.php :: editCategory() : $data["category_seo_url"][$store_id][$language_id]');

				$sug_set_backend_autoredirects = false;

				$keyword_new = false;

				$keyword_old = count($keywords_old) > 0 && isset($keywords_old[$store_id][$language_id]) ? $keywords_old[$store_id][$language_id] : '';

				$sug_log->write(4, $keyword_old, 'model/blog/category.php :: editCategory() : $keyword_old');

				$sug_log->write(4, $sug_data, 'model/blog/category.php :: editCategory() : $sug_data');

				if (!$keyword_old && !$data['category_seo_url'][$store_id][$language_id]) {
					// Все понятно: старого ЧПУ нет, просто генерим новый. Редиректы не нужны.
					$sug_log->write(4, $keyword_old, 'model/blog/category.php :: editCategory() : EMPTY $keyword_old & $data["category_seo_url"][$store_id][$language_id]');

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
					$sug_log->write(4, 'model/blog/category.php :: editCategory() : Actualization by delimeter BEGIN');

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

				$sug_log->write(4, 'model/blog/category.php :: editCategory() : sug_redirects BEGIN');
				
				$sug_log->write(4, $sug_set_backend_autoredirects, 'model/blog/category.php :: editCategory() : $sug_set_backend_autoredirects');

				$sug_log->write(4, $keyword_new, 'model/blog/category.php :: editCategory() : $keyword_new');
				
				// Удаляем все существующие редиректы из базы для данной сущности - на фронте предупреждение было выдано, чтобы не убирали из формы
				$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url_generator_redirects WHERE query = 'blog_category_id=" . (int)$blog_category_id . "' AND `store_id` = '" . (int)$store_id . "' AND `language_id` = '" . (int)$language_id . "'");
		
				// Обрабатываем редиректы из формы - все управление редриректами у пользователя на фронте!
				if (isset($data['seo_url_generator_redirects'][$store_id][$language_id]) && count($data['seo_url_generator_redirects'][$store_id][$language_id]) > 0) {
					$sug_log->write(4, $data['seo_url_generator_redirects'][$store_id][$language_id], 'model/blog/category.php :: editCategory() : $data["seo_url_generator_redirects"][$store_id][$language_id]');

					$data['seo_url_generator_redirects'][$store_id][$language_id] = array_unique($data['seo_url_generator_redirects'][$store_id][$language_id]); // на всякий случай...

					foreach ($data['seo_url_generator_redirects'][$store_id][$language_id] as $redirect) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url_generator_redirects SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', seo_url_old = '" . $this->db->escape($redirect) . "', seo_url_actual = '" . $this->db->escape($data['category_seo_url'][$store_id][$language_id]) . "', query = 'blog_category_id=" . (int)$blog_category_id . "'");
					}
				}
				
				if ($sug_set_backend_autoredirects) {
					$sug_log->write(3, 'model/blog/category.php :: editCategory() : Autoredirect was created on backend');

					// setRedirect() кроме того, что просто записывет текущий редирект, также обновляет новый ЧПУ для всех старый редиректов
					$this->model_extension_module_seo_url_generator->setRedirect($keyword_new, $keyword_old, $sug_data['primary_key'], $sug_data['essence_id'], $store_id, $language_id);
				}

			}
		}

		/* SEO URL Generator . end
		------------------------------------------------------------------------- */

		$this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE query = 'blog_category_id=" . (int)$blog_category_id . "'");
		if (isset($data['category_seo_url'])) {
			foreach ($data['category_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'blog_category_id=" . (int)$blog_category_id . "', keyword = '" . $this->db->escape(trim($keyword)) . "'");
					}
				}
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_to_layout WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_category_to_layout SET blog_category_id = '" . (int)$blog_category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}
		$this->cache->delete('category');
		
		if($this->config->get('config_seo_pro')){		
		$this->cache->delete('seopro');
		}
	}
	
	public function editCategoryStatus($blog_category_id, $status) {
        $this->db->query("UPDATE " . DB_PREFIX . "blog_category SET status = '" . (int)$status . "', date_modified = NOW() WHERE blog_category_id = '" . (int)$blog_category_id . "'");
        
		$this->cache->delete('category');
    }
	public function deleteCategory($blog_category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_path WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category_path WHERE path_id = '" . (int)$blog_category_id . "'");
		foreach ($query->rows as $result) {
			$this->deleteCategory($result['blog_category_id']);
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_description WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_to_store WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_category_to_layout WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_blog_category WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'blog_category_id=" . (int)$blog_category_id . "'");
		$this->cache->delete('blog_category');
		
		if($this->config->get('config_seo_pro')){		
		$this->cache->delete('seopro');
		}
	}
	public function repairCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category WHERE parent_id = '" . (int)$parent_id . "'");
		foreach ($query->rows as $category) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$category['blog_category_id'] . "'");
			// Fix for records with no paths
			$level = 0;
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blog_category_path` WHERE blog_category_id = '" . (int)$parent_id . "' ORDER BY level ASC");
			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "blog_category_path` SET blog_category_id = '" . (int)$category['blog_category_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");
				$level++;
			}
			$this->db->query("REPLACE INTO `" . DB_PREFIX . "blog_category_path` SET blog_category_id = '" . (int)$category['blog_category_id'] . "', `path_id` = '" . (int)$category['blog_category_id'] . "', level = '" . (int)$level . "'");
			$this->repairCategories($category['blog_category_id']);
		}
	}
	public function getCategory($blog_category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "blog_category_path cp LEFT JOIN " . DB_PREFIX . "blog_category_description cd1 ON (cp.path_id = cd1.blog_category_id AND cp.blog_category_id != cp.path_id) WHERE cp.blog_category_id = c.blog_category_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.blog_category_id) AS path FROM " . DB_PREFIX . "blog_category c LEFT JOIN " . DB_PREFIX . "blog_category_description cd2 ON (c.blog_category_id = cd2.blog_category_id) WHERE c.blog_category_id = '" . (int)$blog_category_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		return $query->row;
	}
	public function getCategories($data = array()) {
		$sql = "SELECT cp.blog_category_id AS blog_category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order, c1.noindex FROM " . DB_PREFIX . "blog_category_path cp LEFT JOIN " . DB_PREFIX . "blog_category c1 ON (cp.blog_category_id = c1.blog_category_id) LEFT JOIN " . DB_PREFIX . "blog_category c2 ON (cp.path_id = c2.blog_category_id) LEFT JOIN " . DB_PREFIX . "blog_category_description cd1 ON (cp.path_id = cd1.blog_category_id) LEFT JOIN " . DB_PREFIX . "blog_category_description cd2 ON (cp.blog_category_id = cd2.blog_category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		$sql .= " GROUP BY cp.blog_category_id";
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
	public function getCategoryDescriptions($blog_category_id) {
		$category_description_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category_description WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_h1'      	   => $result['meta_h1'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}
		return $category_description_data;
	}
	public function getCategoryStores($blog_category_id) {
		$category_store_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category_to_store WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}
		return $category_store_data;
	}
	
	public function getCategorySeoUrls($blog_category_id) {
		$category_seo_url_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'blog_category_id=" . (int)$blog_category_id . "'");
		foreach ($query->rows as $result) {
			$category_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}
		return $category_seo_url_data;
	}
	public function getCategoryLayouts($blog_category_id) {
		$category_layout_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category_to_layout WHERE blog_category_id = '" . (int)$blog_category_id . "'");
		foreach ($query->rows as $result) {
			$category_layout_data[$result['store_id']] = $result['layout_id'];
		}
		return $category_layout_data;
	}
	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_category");
		return $query->row['total'];
	}
	
	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");
		return $query->row['total'];
	}
	
	public function getCategoriesByParentId($parent_id = 0) {
		$query = $this->db->query("SELECT *, (SELECT COUNT(parent_id) FROM " . DB_PREFIX . "blog_category WHERE parent_id = c.blog_category_id) AS children FROM " . DB_PREFIX . "blog_category c LEFT JOIN " . DB_PREFIX . "blog_category_description cd ON (c.blog_category_id = cd.blog_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name");
		return $query->rows;
	}
	
	public function getAllCategories() {
		$category_data = $this->cache->get('category.all.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'));
		if (!$category_data || !is_array($category_data)) {
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_category c LEFT JOIN " . DB_PREFIX . "blog_category_description cd ON (c.blog_category_id = cd.blog_category_id) LEFT JOIN " . DB_PREFIX . "blog_category_to_store c2s ON (c.blog_category_id = c2s.blog_category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY c.parent_id, c.sort_order, cd.name");
		$category_data = array();
		
		foreach ($query->rows as $row) {
			$category_data[$row['parent_id']][$row['blog_category_id']] = $row;
		}
		$this->cache->set('category.all.' . $this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $category_data);
		}
		
		return $category_data;
	}
}