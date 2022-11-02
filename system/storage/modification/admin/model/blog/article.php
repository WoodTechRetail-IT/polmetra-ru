<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelBlogArticle extends Model {
	public function addArticle($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "article SET status = '" . (int)$data['status'] . "', noindex = '" . (int)$data['noindex'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");

		$article_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "article SET image = '" . $this->db->escape($data['image']) . "' WHERE article_id = '" . (int)$article_id . "'");
		}

		foreach ($data['article_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "article_description SET article_id = '" . (int)$article_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['article_store'])) {
			foreach ($data['article_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_store SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['article_image'])) {
			foreach ($data['article_image'] as $article_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_image SET article_id = '" . (int)$article_id . "', image = '" . $this->db->escape($article_image['image']) . "', sort_order = '" . (int)$article_image['sort_order'] . "'");
			}
		}

		if (isset($data['article_download'])) {
			foreach ($data['article_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_download SET article_id = '" . (int)$article_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		if (isset($data['article_category'])) {
			foreach ($data['article_category'] as $blog_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_blog_category SET article_id = '" . (int)$article_id . "', blog_category_id = '" . (int)$blog_category_id . "'");
			}
		}
		
		if (isset($data['main_blog_category_id']) && $data['main_blog_category_id'] > 0) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_blog_category WHERE article_id = '" . (int)$article_id . "' AND blog_category_id = '" . (int)$data['main_blog_category_id'] . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_blog_category SET article_id = '" . (int)$article_id . "', blog_category_id = '" . (int)$data['main_blog_category_id'] . "', main_blog_category = 1");
		} elseif (isset($data['article_category'][0])) {
			$this->db->query("UPDATE " . DB_PREFIX . "article_to_blog_category SET main_blog_category = 1 WHERE article_id = '" . (int)$article_id . "' AND blog_category_id = '" . (int)$data['article_category'][0] . "'");
		}

		if (isset($data['article_related'])) {
			foreach ($data['article_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$article_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_related SET article_id = '" . (int)$article_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$related_id . "' AND related_id = '" . (int)$article_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_related SET article_id = '" . (int)$related_id . "', related_id = '" . (int)$article_id . "'");
			}
		}
		
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "article_related_product WHERE article_id = '" . (int)$article_id . "' AND product_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_related_product SET article_id = '" . (int)$article_id . "', product_id = '" . (int)$related_id . "'");
			}
		}
		
		// SEO URL
		// SEO URL Generator . begin
		// article_id not exist in controller when add() article
		
		$this->load->model('extension/module/seo_url_generator');

		$sug_log = new StdeLog('seo_url_generator');
		$sug_log->setDebug($this->config->get('module_seo_url_generator_debug'));

		$sug_log->write(4, 'model/blog/article.php :: addArticle() is called');

		$sug_log->write(4, $data['article_seo_url'], 'model/blog/article.php :: addArticle() : $data["article_seo_url"] BEFORE SUG');
		
		#
		# SETTING
		#

		$sug_data['setting'] = array();

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('setting/setting');
		
		$data['store_setting'] = array();
		
		foreach ($data['article_seo_url'] as $store_id => $store) {
			$store_setting = $this->model_setting_setting->getSetting('module_seo_url_generator', $store_id);

			$data['store_setting'][$store_id]['translit_function']     = $store_setting['module_seo_url_generator_translit_function'];			
			$data['store_setting'][$store_id]['formula']               = '';
			$data['store_setting'][$store_id]['delimiter_char']        = $store_setting['module_seo_url_generator_delimiter_char'];			
			$data['store_setting'][$store_id]['change_delimiter_char'] = $store_setting['module_seo_url_generator_change_delimiter_char'];
			$data['store_setting'][$store_id]['rewrite_on_save']       = $store_setting['module_seo_url_generator_rewrite_on_save'];
			$data['store_setting'][$store_id]['custom_replace_from']   = $store_setting['module_seo_url_generator_custom_replace_from'];
			$data['store_setting'][$store_id]['custom_replace_to']     = $store_setting['module_seo_url_generator_custom_replace_to'];
		}

		foreach ($data['article_seo_url'] as $store_id => $store) {
			foreach ($store as $language_id => $url) {
				if (empty($data['article_seo_url'][$store_id][$language_id])) {
					$sug_data = array(
						'name'            =>$data['article_description'][$language_id]['name'],
						'primary_key'     => 'article_id',
						'essence'         => 'article',
						'essence_id'      => $article_id,
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

					$data['article_seo_url'][$store_id][$language_id] = $this->load->controller('extension/module/seo_url_generator/generateSeoUrl', $sug_data);

					$sug_log->write(4, $data['article_seo_url'][$store_id][$language_id], 'model/blog/article.php :: addArticle() : $data["article_seo_url"][$store_id][$language_id]');
				}
			}	
			
		}

		$sug_log->write(4, $data['article_seo_url'], 'model/blog/article.php :: addArticle() : $data["article_seo_url"] AFTER SUG');
		// SEO URL Generator . end

		if (isset($data['article_seo_url'])) {
			foreach ($data['article_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'article_id=" . (int)$article_id . "', keyword = '" . $this->db->escape(trim($keyword)) . "'");
					}
				}
			}
		}

		if (isset($data['article_layout'])) {
			foreach ($data['article_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_layout SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}
		
		if($this->config->get('config_seo_pro')){		
		$this->cache->delete('seopro');
		}

		$this->cache->delete('article');

		return $article_id;
	}

	public function editArticle($article_id, $data) {

		$this->db->query("UPDATE " . DB_PREFIX . "article SET status = '" . (int)$data['status'] . "', noindex = '" . (int)$data['noindex'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "article SET image = '" . $this->db->escape($data['image']) . "' WHERE article_id = '" . (int)$article_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "article_description WHERE article_id = '" . (int)$article_id . "'");

		foreach ($data['article_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "article_description SET article_id = '" . (int)$article_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_store WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_store'])) {
			foreach ($data['article_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_store SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "article_image WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_image'])) {
			foreach ($data['article_image'] as $article_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_image SET article_id = '" . (int)$article_id . "', image = '" . $this->db->escape($article_image['image']) . "', sort_order = '" . (int)$article_image['sort_order'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_download WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_download'])) {
			foreach ($data['article_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_download SET article_id = '" . (int)$article_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_blog_category WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_category'])) {
			foreach ($data['article_category'] as $blog_category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_blog_category SET article_id = '" . (int)$article_id . "', blog_category_id = '" . (int)$blog_category_id . "'");
			}
		}
		
		if (isset($data['main_blog_category_id']) && $data['main_blog_category_id'] > 0) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_blog_category WHERE article_id = '" . (int)$article_id . "' AND blog_category_id = '" . (int)$data['main_blog_category_id'] . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_blog_category SET article_id = '" . (int)$article_id . "', blog_category_id = '" . (int)$data['main_blog_category_id'] . "', main_blog_category = 1");
		} elseif (isset($data['article_category'][0])) {
			$this->db->query("UPDATE " . DB_PREFIX . "article_to_blog_category SET main_blog_category = 1 WHERE article_id = '" . (int)$article_id . "' AND blog_category_id = '" . (int)$data['article_category'][0] . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE related_id = '" . (int)$article_id . "'");

		if (isset($data['article_related'])) {
			foreach ($data['article_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$article_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_related SET article_id = '" . (int)$article_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$related_id . "' AND related_id = '" . (int)$article_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_related SET article_id = '" . (int)$related_id . "', related_id = '" . (int)$article_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_related_product WHERE article_id = '" . (int)$article_id . "'");
		
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "article_related_product WHERE article_id = '" . (int)$article_id . "' AND product_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_related_product SET article_id = '" . (int)$article_id . "', product_id = '" . (int)$related_id . "'");
			}
		}
		
		// SEO URL


		/* SEO URL Generator . begin
		------------------------------------------------------------------------- */	
		// В случае редактирования из админки мы имеем сразу 3 ЧПУ
		// 1 - $keyword_old - тот, который есть в базе на момент до редактирования - именно для него нужен редирект (!)
		// 2 - $data['article_seo_url'][$store_id][$language_id] - тот, который введен в форму - он может совпадать с $keyword_old, быть введенным вручную или вообще отсутствовать
		// 3 - $keyword_new - тот, который генерируется автоматически, в случае, когда это необходимо
		
		$this->load->model('extension/module/seo_url_generator');

		$sug_log = new StdeLog('seo_url_generator');
		$sug_log->setDebug($this->config->get('module_seo_url_generator_debug'));

		$sug_log->write(2, 'model/blog/article.php :: editArticle() is called');

		$sug_log->write(4, $data['article_seo_url'], 'model/blog/article.php :: editArticle() : $data["article_seo_url"] BEFORE SUG');

		if (isset($data['seo_url_generator_redirects'])) {
			$sug_log->write(4, $data['seo_url_generator_redirects'], 'model/blog/article.php :: editArticle() : $data["seo_url_generator_redirects"]');
		}

		if (isset($data['seo_url_generator_front_works'])) {
			$sug_front_ok = true;
			$sug_log->write(4, 'ISSET', 'model/blog/article.php :: editArticle() : $data["seo_url_generator_front_works"]');
		} else {
			$sug_front_ok = false;
			$sug_log->write(4, 'NULL', 'model/blog/article.php :: editArticle() : $data["seo_url_generator_front_works"]');
		}


		#
		# SETTING
		#

		$sug_data['setting'] = array();

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('setting/setting');
		
		$data['store_setting'] = array();
		
		foreach ($data['article_seo_url'] as $store_id => $store) {
			$store_setting = $this->model_setting_setting->getSetting('module_seo_url_generator', $store_id);

			$data['store_setting'][$store_id]['translit_function']     = $store_setting['module_seo_url_generator_translit_function'];			
			$data['store_setting'][$store_id]['formula']               = '';	
			$data['store_setting'][$store_id]['delimiter_char']        = $store_setting['module_seo_url_generator_delimiter_char'];			
			$data['store_setting'][$store_id]['change_delimiter_char'] = $store_setting['module_seo_url_generator_change_delimiter_char'];
			$data['store_setting'][$store_id]['rewrite_on_save']       = $store_setting['module_seo_url_generator_rewrite_on_save'];
			$data['store_setting'][$store_id]['custom_replace_from']   = $store_setting['module_seo_url_generator_custom_replace_from'];
			$data['store_setting'][$store_id]['custom_replace_to']     = $store_setting['module_seo_url_generator_custom_replace_to'];
		}

		$keywords_old = $this->model_extension_module_seo_url_generator->getURLs('article_id', $this->request->get['article_id']);

		$sug_log->write(4, $keywords_old, 'model/blog/article.php :: editArticle() : $keywords_old');

		$redirects_exist = $this->model_extension_module_seo_url_generator->getRedirects('article_id', $this->request->get['article_id']);

		$sug_log->write(4, $redirects_exist, 'model/blog/article.php :: editArticle() : $redirects_exist');


		#
		# ITTERATIONS
		#

		foreach ($data['article_seo_url'] as $store_id => $store) {
			foreach ($store as $language_id => $url) {				

				# SEO URL PROCESSING

				$sug_data = array(
					'name'            => $data['article_description'][$language_id]['name'],
					'primary_key'     => 'article_id',
					'essence'         => 'article',
					'essence_id'      => $this->request->get['article_id'],
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

				$data['article_seo_url'][$store_id][$language_id] = trim($data['article_seo_url'][$store_id][$language_id]);

				$sug_log->write(2, $data['article_seo_url'][$store_id][$language_id], 'model/blog/article.php :: editArticle() : $data["article_seo_url"][$store_id][$language_id]');

				$sug_set_backend_autoredirects = false;

				$keyword_new = false;

				$keyword_old = count($keywords_old) > 0 && isset($keywords_old[$store_id][$language_id]) ? $keywords_old[$store_id][$language_id] : '';

				$sug_log->write(4, $keyword_old, 'model/blog/article.php :: editArticle() : $keyword_old');

				$sug_log->write(4, $sug_data, 'model/blog/article.php :: editArticle() : $sug_data');

				if (!$keyword_old && !$data['article_seo_url'][$store_id][$language_id]) {
					// Все понятно: старого ЧПУ нет, просто генерим новый. Редиректы не нужны.
					$sug_log->write(4, $keyword_old, 'model/blog/article.php :: editArticle() : EMPTY $keyword_old & $data["article_seo_url"][$store_id][$language_id]');

					$data['article_seo_url'][$store_id][$language_id] = $this->load->controller('extension/module/seo_url_generator/generateSeoUrl', $sug_data);
					//$this->cache->delete('seo_pro');
					continue;
				}

				if (!$keyword_old && $data['article_seo_url'][$store_id][$language_id]) {
					// Снова все понятно: старого ЧПУ в базе нет, соглашаемся с ЧПУ из формы
					// Q?
					// А транлитировать этот ЧПУ надо или нет?..

					//$this->cache->delete('seo_pro');
					continue;
				}

				if ($keyword_old && !$data['article_seo_url'][$store_id][$language_id]) {
					// Просто используем существующий ЧПУ из базы
					$data['article_seo_url'][$store_id][$language_id] = $keyword_old;
				}

				if ($keyword_old && $data['article_seo_url'][$store_id][$language_id] && $keyword_old != $data['article_seo_url'][$store_id][$language_id]) {
					// Запускаем механизм редиректов, только если на фронте не работает
					if (!$sug_front_ok) {
						$sug_set_backend_autoredirects = true;
					}

					$keyword_new = $data['article_seo_url'][$store_id][$language_id];

					// Q?
					// А транлитировать этот ЧПУ надо или нет?..
					// Минуем актуализацию, итак понятно, что $keyword_old != $data['article_seo_url'][$store_id][$language_id]
					goto sug_edit_end;
				}
        
        if ($keyword_old && $data['article_seo_url'][$store_id][$language_id] && $keyword_old == $data['article_seo_url'][$store_id][$language_id] && $sug_data['setting']['rewrite_on_save']) {
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
					$sug_log->write(4, 'model/blog/article.php :: editArticle() : Actualization by delimeter BEGIN');

					if ('donot' != $sug_data['setting']['change_delimiter_char']) {
						// Compare without delimiters
						$keyword_old_without_delimiters = preg_replace(array('|_+|', '|-+|'), array('', ''), $keyword_old);
						$keyword_new_without_delimiters = preg_replace(array('|_+|', '|-+|'), array('', ''), $keyword_new);

						$sug_log->write(3, $keyword_old_without_delimiters, 'generateSeoUrl() : $keyword_old_without_delimiters');
						$sug_log->write(3, $keyword_new_without_delimiters, 'generateSeoUrl() : $keyword_new_without_delimiters');

						if ($keyword_old_without_delimiters != $keyword_new_without_delimiters) {
							$sug_set_backend_autoredirects = true;
							$data['article_seo_url'][$store_id][$language_id] = $keyword_new;
						}
					} else {
						// Compare with delimiters
						if ($keyword_old != $keyword_new) {
							$sug_set_backend_autoredirects = true;
							$data['article_seo_url'][$store_id][$language_id] = $keyword_new;
						}
					}
				}

				// Write Redirect
				sug_edit_end:

				$sug_log->write(4, 'model/blog/article.php :: editArticle() : sug_redirects BEGIN');

				$sug_log->write(4, $sug_set_backend_autoredirects, 'model/blog/article.php :: editArticle() : $sug_set_backend_autoredirects');

				$sug_log->write(4, $keyword_new, 'model/blog/article.php :: editArticle() : $keyword_new');

				// Удаляем все существующие редиректы из базы для данной сущности - на фронте предупреждение было выдано, чтобы не убирали из формы
				$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url_generator_redirects WHERE query = 'article_id=" . (int)$article_id . "' AND `store_id` = '" . (int)$store_id . "' AND `language_id` = '" . (int)$language_id . "'");

				// Обрабатываем редиректы из формы - все управление редриректами у пользователя на фронте!
				if (isset($data['seo_url_generator_redirects'][$store_id][$language_id]) && count($data['seo_url_generator_redirects'][$store_id][$language_id]) > 0) {
					$sug_log->write(4, $data['seo_url_generator_redirects'][$store_id][$language_id], 'model/blog/article.php :: editArticle() : $data["seo_url_generator_redirects"][$store_id][$language_id]');

					$data['seo_url_generator_redirects'][$store_id][$language_id] = array_unique($data['seo_url_generator_redirects'][$store_id][$language_id]); // на всякий случай...

					foreach ($data['seo_url_generator_redirects'][$store_id][$language_id] as $redirect) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url_generator_redirects SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', seo_url_old = '" . $this->db->escape($redirect) . "', seo_url_actual = '" . $this->db->escape($data['article_seo_url'][$store_id][$language_id]) . "', query = 'article_id=" . (int)$article_id . "'");
							}
						}

				if ($sug_set_backend_autoredirects) {
					$sug_log->write(3, 'model/blog/article.php :: editArticle() : Autoredirect was created on backend');

					// setRedirect() кроме того, что просто записывет текущий редирект, также обновляет новый ЧПУ для всех старый редиректов
					$this->model_extension_module_seo_url_generator->setRedirect($keyword_new, $keyword_old, $sug_data['primary_key'], $sug_data['essence_id'], $store_id, $language_id);
				}
			}
		}
		/* SEO URL Generator . end
		------------------------------------------------------------------------- */

		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'article_id=" . (int)$article_id . "'");
		
		if (isset($data['article_seo_url'])) {
			foreach ($data['article_seo_url']as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'article_id=" . (int)$article_id . "', keyword = '" . $this->db->escape(trim($keyword)) . "'");
					}
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_layout WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_layout'])) {
			foreach ($data['article_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "article_to_layout SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}
		
		$this->cache->delete('article');

		if($this->config->get('config_seo_pro')){		
		$this->cache->delete('seopro');
		}

	}
	
	public function editArticleStatus($article_id, $status) {
        $this->db->query("UPDATE " . DB_PREFIX . "article SET status = '" . (int)$status . "', date_modified = NOW() WHERE article_id = '" . (int)$article_id . "'");
        
		$this->cache->delete('article');
		
		return $article_id;
    }

	public function copyArticle($article_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "article p LEFT JOIN " . DB_PREFIX . "article_description pd ON (p.article_id = pd.article_id) WHERE p.article_id = '" . (int)$article_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($query->num_rows) {
			$data = $query->row;

			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';
			$data['noindex'] = '0';

			$data['article_description'] = $this->getArticleDescriptions($article_id);
			$data['article_image'] = $this->getArticleImages($article_id);
			$data['article_related'] = $this->getArticleRelated($article_id);
			$data['product_related'] = $this->getProductRelated($article_id);
			$data['article_category'] = $this->getArticleCategories($article_id);
			$data['article_download'] = $this->getArticleDownloads($article_id);
			$data['article_layout'] = $this->getArticleLayouts($article_id);
			$data['article_store'] = $this->getArticleStores($article_id);

			$this->addArticle($data);
		}
	}

	public function deleteArticle($article_id) {

		$this->db->query("DELETE FROM " . DB_PREFIX . "article WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_description WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_image WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_related WHERE related_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_related_product WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_blog_category WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_download WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_layout WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "article_to_store WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "review_article WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'article_id=" . (int)$article_id . "'");

		$this->cache->delete('article');

	}

	public function getArticle($article_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "article p LEFT JOIN " . DB_PREFIX . "article_description pd ON (p.article_id = pd.article_id) WHERE p.article_id = '" . (int)$article_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getArticles($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "article p LEFT JOIN " . DB_PREFIX . "article_description pd ON (p.article_id = pd.article_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		
		if (isset($data['filter_noindex']) && !is_null($data['filter_noindex'])) {
			$sql .= " AND p.noindex = '" . (int)$data['filter_noindex'] . "'";
		}

		$sql .= " GROUP BY p.article_id";

		$sort_data = array(
			'pd.name',
			'p.status',
			'p.noindex',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
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

	public function getArticlesByCategoryId($blog_category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article p LEFT JOIN " . DB_PREFIX . "article_description pd ON (p.article_id = pd.article_id) LEFT JOIN " . DB_PREFIX . "article_to_blog_category p2c ON (p.article_id = p2c.article_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.blog_category_id = '" . (int)$blog_category_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getArticleDescriptions($article_id) {
		$article_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_description WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_h1'	       => $result['meta_h1'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $article_description_data;
	}

	public function getArticleCategories($article_id) {
		$article_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_to_blog_category WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_category_data[] = $result['blog_category_id'];
		}

		return $article_category_data;
	}
	
	public function getArticleMainCategoryId($article_id) {
		$query = $this->db->query("SELECT blog_category_id FROM " . DB_PREFIX . "article_to_blog_category WHERE article_id = '" . (int)$article_id . "' AND main_blog_category = '1' LIMIT 1");
		
		return ($query->num_rows ? (int)$query->row['blog_category_id'] : 0);
	}

	public function getArticleImages($article_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_image WHERE article_id = '" . (int)$article_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getArticleDownloads($article_id) {
		$article_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_to_download WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_download_data[] = $result['download_id'];
		}

		return $article_download_data;
	}

	public function getArticleStores($article_id) {
		$article_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_to_store WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_store_data[] = $result['store_id'];
		}

		return $article_store_data;
	}
	
	public function getArticleSeoUrls($article_id) {
		$article_seo_url_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'article_id=" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $article_seo_url_data;
	}

	public function getArticleLayouts($article_id) {
		$article_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_to_layout WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $article_layout_data;
	}

	public function getArticleRelated($article_id) {
		$article_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_related WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_related_data[] = $result['related_id'];
		}

		return $article_related_data;
	}
	
	public function getProductRelated($article_id) {
		$article_related_product = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "article_related_product WHERE article_id = '" . (int)$article_id . "'");
		
		foreach ($query->rows as $result) {
			$article_related_product[] = $result['product_id'];
		}
		
		return $article_related_product;
	}

	public function getTotalArticles($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.article_id) AS total FROM " . DB_PREFIX . "article p LEFT JOIN " . DB_PREFIX . "article_description pd ON (p.article_id = pd.article_id)";

		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		
		if (isset($data['filter_noindex']) && $data['filter_noindex'] !== null) {
			$sql .= " AND p.noindex = '" . (int)$data['filter_noindex'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalArticlesByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "article_to_download WHERE download_id = '" . (int)$download_id . "'");

		return $query->row['total'];
	}

	public function getTotalArticlesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "article_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}
