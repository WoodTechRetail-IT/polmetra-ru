<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCatalogCategory extends Controller {
	private $error = array();
	private $category_id = 0;
	private $path = array();

	public function index() {

		$this->load->language('catalog/extra_description_category');
	  
		$this->load->language('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

				$this->model_catalog_category->createMrpSQL();
			

		$this->getList();
	}

	public function add() {

		$this->load->language('catalog/extra_description_category');
	  
		$this->load->language('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

				$this->model_catalog_category->createMrpSQL();
			

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_category->addCategory($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';


		if ($this->config->get('module_admin_quick_edit_status') && $this->config->get('module_admin_quick_edit_catalog_categories_status')) {
			foreach ($this->config->get('module_admin_quick_edit_catalog_categories') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
		}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {

		$this->load->language('catalog/extra_description_category');
	  
		$this->load->language('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

				$this->model_catalog_category->createMrpSQL();
			

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_category->editCategory($this->request->get['category_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';


		if ($this->config->get('module_admin_quick_edit_status') && $this->config->get('module_admin_quick_edit_catalog_categories_status')) {
			foreach ($this->config->get('module_admin_quick_edit_catalog_categories') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
		}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {

		$this->load->language('catalog/extra_description_category');
	  
		$this->load->language('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

				$this->model_catalog_category->createMrpSQL();
			

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $category_id) {
				$this->model_catalog_category->deleteCategory($category_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';


		if ($this->config->get('module_admin_quick_edit_status') && $this->config->get('module_admin_quick_edit_catalog_categories_status')) {
			foreach ($this->config->get('module_admin_quick_edit_catalog_categories') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
		}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	public function repair() {

		$this->load->language('catalog/extra_description_category');
	  
		$this->load->language('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

				$this->model_catalog_category->createMrpSQL();
			

		if ($this->validateRepair()) {
			$this->model_catalog_category->repairCategories();

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';


		if ($this->config->get('module_admin_quick_edit_status') && $this->config->get('module_admin_quick_edit_catalog_categories_status')) {
			foreach ($this->config->get('module_admin_quick_edit_catalog_categories') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
		}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';


		if ($this->config->get('module_admin_quick_edit_status') && $this->config->get('module_admin_quick_edit_catalog_categories_status')) {
			foreach ($this->config->get('module_admin_quick_edit_catalog_categories') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
		}
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);
		$data['add'] = $this->url->link('catalog/category/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/category/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['repair'] = $this->url->link('catalog/category/repair', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['enabled'] = $this->url->link('catalog/category/enable', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['disabled'] = $this->url->link('catalog/category/disable', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['path'])) {
			if ($this->request->get['path'] != '') {
					$this->path = explode('_', $this->request->get['path']);
					$this->category_id = end($this->path);
					$this->session->data['path'] = $this->request->get['path'];
			} else {
				unset($this->session->data['path']);
			}
		} elseif (isset($this->session->data['path'])) {
				$this->path = explode('_', $this->session->data['path']);
				$this->category_id = end($this->path);
 		}

		$data['categories'] = $this->getCategories(0);

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		$category_total = $this->model_catalog_category->getTotalCategories();

		$data['results'] = $this->language->get('text_category_total') . ($category_total);
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');


			$data['hb_image_rename'] = htmlspecialchars_decode($this->url->link('extension/hbseo/hb_seoimage/renamecategoryimages', 'user_token=' . $this->session->data['user_token'], true));
			if ($this->config->get('hb_seoimage_status') && $this->config->get('hb_seoimage_auto')) {
			    $data['hb_seoimage_auto'] = true;
			}else{
			    $data['hb_seoimage_auto'] = false;
			}
			if (isset($this->request->get['page'])) {
				$data['pagination_detected'] = true;
			}else{
				$data['pagination_detected'] = false;
			}
			
		$this->response->setOutput($this->load->view('catalog/category_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['category_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		// SEO Tags Generator : Declension . begin
		if (isset($this->error['category_name_plural_nominative'])) {
			$data['error_category_name_plural_nominative'] = $this->error['category_name_plural_nominative'];
		} else {
			$data['error_category_name_plural_nominative'] = array();
		}

		if (isset($this->error['category_name_plural_genitive'])) {
			$data['error_category_name_plural_genitive'] = $this->error['category_name_plural_genitive'];
		} else {
			$data['error_category_name_plural_genitive'] = array();
		}

		if (isset($this->error['category_name_singular_nominative'])) {
			$data['error_category_name_singular_nominative'] = $this->error['category_name_singular_nominative'];
		} else {
			$data['error_category_name_singular_nominative'] = array();
		}
		// SEO Tags Generator : Declension . end

		// SEO Tags Generator : Attributes . begin
		if (isset($this->error['stg_error_attributes'])) {
			$GLOBALS['stg_error_attributes'] = $this->error['stg_error_attributes'];
		} else {
			$GLOBALS['stg_error_attributes'] = false;
		}
		// SEO Tags Generator : Attributes . end

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}

		if (isset($this->error['meta_h1'])) {
			$data['error_meta_h1'] = $this->error['meta_h1'];
		} else {
			$data['error_meta_h1'] = array();
		}

    // SEO URL Generator PRO . begin
		if (isset($this->error['seo_url_generator_redirects'])) {
			$data['error_seo_url_generator_redirects'] = $this->error['seo_url_generator_redirects'];
		} else {
			$data['error_seo_url_generator_redirects'] = array();
		}
		// SEO URL Generator PRO . end

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		if (isset($this->error['parent'])) {
			$data['error_parent'] = $this->error['parent'];
		} else {
			$data['error_parent'] = '';
		}

		$url = '';


		if ($this->config->get('module_admin_quick_edit_status') && $this->config->get('module_admin_quick_edit_catalog_categories_status')) {
			foreach ($this->config->get('module_admin_quick_edit_catalog_categories') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
		}
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$this->load->language('extension/module/seo_tags_generator'); // SEO Tags Generator - heading_title problem!

		if (!isset($this->request->get['category_id'])) {
			$data['action'] = $this->url->link('catalog/category/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/category/edit', 'user_token=' . $this->session->data['user_token'] . '&category_id=' . $this->request->get['category_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$category_info = $this->model_catalog_category->getCategory($this->request->get['category_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['category_description'])) {
			$data['category_description'] = $this->request->post['category_description'];
		} elseif (isset($this->request->get['category_id'])) {
			$data['category_description'] = $this->model_catalog_category->getCategoryDescriptions($this->request->get['category_id']);
		} else {
			$data['category_description'] = array();
		}

		$language_id = $this->config->get('config_language_id');
		if (isset($data['category_description'][$language_id]['name'])) {

			$this->load->model('extension/module/seo_tags_generator'); // SEO Tags Generator

			$this->document->addStyle('view/stylesheet/seo-tags-generator.css'); // SEO Tags Generator

			
			$data['heading_title'] = $data['category_description'][$language_id]['name'];
		}

		if (isset($this->request->post['path'])) {
			$data['path'] = $this->request->post['path'];
		} elseif (!empty($category_info)) {
			$data['path'] = $category_info['path'];
		} else {
			$data['path'] = '';
		}

		if (isset($this->request->post['parent_id'])) {
			$data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($category_info)) {
			$data['parent_id'] = $category_info['parent_id'];
		} else {
			$data['parent_id'] = 0;
		}

		// SEO Tags Generator . begin
		$data['stg_status'] = $this->config->get('module_seo_tags_generator_status');

		$data['stg_preview'] = array(); // preview auto generation

		$data['stg_not_use_auto'] = false; // checkbox follow static meta tags

		if (!$data['stg_status'] || !isset($this->request->get['category_id'])) {
			goto stg_tags_preview_end;
		} // else continue ->

		$data['text_stg_preview'] = $this->language->get('text_stg_preview');

		if ($this->model_extension_module_seo_tags_generator->notUseAutoCategory($this->request->get['category_id'])) {
			$data['stg_not_use_auto'] = true;

			goto stg_tags_preview_end;
		} // else continue ->

		foreach ($data['languages'] as $language) {
			$stg_category_info0 = array(
				'category_id'			 => $this->request->get['category_id'],
				'name'						 => isset($data['category_description'][$language['language_id']]['name']) ? $data['category_description'][$language['language_id']]['name'] : '',
				'meta_title'			 => isset($data['category_description'][$language['language_id']]['meta_title']) ? $data['category_description'][$language['language_id']]['meta_title'] : '',
				'meta_description' => isset($data['category_description'][$language['language_id']]['meta_description']) ? $data['category_description'][$language['language_id']]['meta_description'] : '',
				'meta_keyword'		 => isset($data['category_description'][$language['language_id']]['meta_keyword']) ? $data['category_description'][$language['language_id']]['meta_keyword'] : '',
				'description'			 => isset($data['category_description'][$language['language_id']]['description']) ? $data['category_description'][$language['language_id']]['description'] : '',
			);

			if (array_key_exists('meta_h1', $data['category_description'][$language['language_id']])) {
				$stg_category_info0['meta_h1'] = $data['category_description'][$language['language_id']]['meta_h1']; // ocStore
			}

			if (array_key_exists('h1', $data['category_description'][$language['language_id']])) {
				$stg_category_info0['h1'] = $data['category_description'][$language['language_id']]['h1']; // seo-tag-h1.ocmod.zip
			}

			$stg_category_info1 = $this->load->controller('extension/module/seo_tags_generator/getCategoryTags', array(
				'category_info' => $stg_category_info0,
				'language_id' => $language['language_id'],
			));

			$data['stg_preview'][$language['language_id']]['meta_title']				 = $stg_category_info1['meta_title'];
			$data['stg_preview'][$language['language_id']]['meta_description']	 = $stg_category_info1['meta_description'];
			$data['stg_preview'][$language['language_id']]['meta_keyword']			 = $stg_category_info1['meta_keyword'];

			if (isset($stg_category_info1['meta_h1'])) {
				$data['stg_preview'][$language['language_id']]['meta_h1'] = $stg_category_info1['meta_h1'];	// ocStore
			}

			if (isset($stg_category_info1['h1'])) {
				$data['stg_preview'][$language['language_id']]['h1'] = $stg_category_info1['h1']; // seo-tag-h1.ocmod.zip
			}
		}

		stg_tags_preview_end:
		// SEO Tags Generator . end

		// SEO Tags Generator: Declension . begin
		$data['stg_declension'] = $this->config->get('module_seo_tags_generator_declension');

		if ($data['stg_status'] && $data['stg_declension']) {
			$this->load->language('extension/module/seo_tags_generator');

			$data['fieldset_seo_tags_generator'] = $this->language->get('fieldset_seo_tags_generator');

			if (isset($this->request->post['category_declension'])) {
				$data['category_declension'] = $this->request->post['category_declension'];
			} elseif (isset($this->request->get['category_id'])) {
				$data['category_declension'] = $this->model_extension_module_seo_tags_generator->getCategoryDeclensionForEdit($this->request->get['category_id']);
			} else {
				$data['category_declension'] = array();
			}
		}
		// SEO Tags Generator: Declension . end

		// SEO Tags Generator: Formulas . begin
		if ($data['stg_status']) {
			$data['tab_seo_tags_generator'] = $this->language->get('tab_seo_tags_generator');

			$data['stg_category_tab'] = $this->load->controller('extension/module/seo_tags_generator/getCategoryTab');
		}
		// SEO Tags Generator: Formulas . end


		if (isset($this->request->post['rm_description'])) {
		  $data['rm_description'] = $this->request->post['rm_description'];
		} elseif (!empty($category_info)) {
		  $data['rm_description'] = $category_info['rm_description'];
		} else {
		  $data['rm_description'] = 0;
		}

		if (isset($this->request->post['ht_description'])) {
		  $data['ht_description'] = $this->request->post['ht_description'];
		} elseif (!empty($category_info)) {
		  $data['ht_description'] = $category_info['ht_description'];
		} else {
		  $data['ht_description'] = 0;
		}

		if (isset($this->request->post['hd_description'])) {
		  $data['hd_description'] = $this->request->post['hd_description'];
		} elseif (!empty($category_info)) {
		  $data['hd_description'] = $category_info['hd_description'];
		} else {
		  $data['hd_description'] = 0;
		}

		if (isset($this->request->post['ext_description'])) {
		  $data['ext_description'] = $this->request->post['ext_description'];
		} elseif (isset($this->request->get['category_id'])) {
		  $data['ext_description'] = $this->model_catalog_category->getCategoryDescriptions($this->request->get['category_id']);
		} else {
		  $data['ext_description'] = array();
		}

		if (isset($this->request->post['rm_ext_description'])) {
		  $data['rm_ext_description'] = $this->request->post['rm_ext_description'];
		} elseif (!empty($category_info)) {
		  $data['rm_ext_description'] = $category_info['rm_ext_description'];
		} else {
		  $data['rm_ext_description'] = 0;
		}

		if (isset($this->request->post['rmm_ext_description'])) {
		  $data['rmm_ext_description'] = $this->request->post['rmm_ext_description'];
		} elseif (!empty($category_info)) {
		  $data['rmm_ext_description'] = $category_info['rmm_ext_description'];
		} else {
		  $data['rmm_ext_description'] = 0;
		}

		if (isset($this->request->post['ht_ext_description'])) {
		  $data['ht_ext_description'] = $this->request->post['ht_ext_description'];
		} elseif (!empty($category_info)) {
		  $data['ht_ext_description'] = $category_info['ht_ext_description'];
		} else {
		  $data['ht_ext_description'] = 0;
		}

		if (isset($this->request->post['hd_ext_description'])) {
		  $data['hd_ext_description'] = $this->request->post['hd_ext_description'];
		} elseif (!empty($category_info)) {
		  $data['hd_ext_description'] = $category_info['hd_ext_description'];
		} else {
		  $data['hd_ext_description'] = 0;
		}
	  
		$this->load->model('catalog/filter');

		if (isset($this->request->post['category_filter'])) {
			$filters = $this->request->post['category_filter'];
		} elseif (isset($this->request->get['category_id'])) {
			$filters = $this->model_catalog_category->getCategoryFilters($this->request->get['category_id']);
		} else {
			$filters = array();
		}

		$data['category_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['category_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}

		$this->load->model('setting/store');

		$data['stores'] = array();

		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);

		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}

		if (isset($this->request->post['category_store'])) {
			$data['category_store'] = $this->request->post['category_store'];
		} elseif (isset($this->request->get['category_id'])) {
			$data['category_store'] = $this->model_catalog_category->getCategoryStores($this->request->get['category_id']);
		} else {
			$data['category_store'] = array(0);
		}


				if (isset($this->request->post['banner'])) {
					$data['banner'] = $this->request->post['banner'];
				} elseif (!empty($category_info)) {
					$data['banner'] = $category_info['banner'];
				} else {
					$data['banner'] = '';
				}
			
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($category_info)) {
			$data['image'] = $category_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');


				if (isset($this->request->post['banner']) && is_file(DIR_IMAGE . $this->request->post['banner'])) {
					$data['banner'] = $this->model_tool_image->resize($this->request->post['banner'], 100, 100);
				} elseif (!empty($category_info) && is_file(DIR_IMAGE . $category_info['banner'])) {
					$data['banner'] = $this->model_tool_image->resize($category_info['banner'], 100, 100);
				} else {
					$data['banner'] = $this->model_tool_image->resize('no_image.png', 100, 100);
				}
			
		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($category_info) && is_file(DIR_IMAGE . $category_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($category_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['top'])) {
			$data['top'] = $this->request->post['top'];
		} elseif (!empty($category_info)) {
			$data['top'] = $category_info['top'];
		} else {
			$data['top'] = 0;
		}

		if (isset($this->request->post['column'])) {
			$data['column'] = $this->request->post['column'];
		} elseif (!empty($category_info)) {
			$data['column'] = $category_info['column'];
		} else {
			$data['column'] = 1;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($category_info)) {
			$data['sort_order'] = $category_info['sort_order'];
		} else {
			$data['sort_order'] = 0;
		}

		if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} elseif (isset($category_info)) {
			$products = $this->model_catalog_category->getProductRelated($this->request->get['category_id']);
		} else {
			$products = array();
		}

		$data['product_related'] = array();

		$this->load->model('catalog/product');

		foreach ($products as $product_id) {
			$related_info = $this->model_catalog_product->getProduct($product_id);

			if ($related_info) {
				$data['product_related'][] = array(
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name']
				);
			}
		}

		if (isset($this->request->post['article_related'])) {
			$articles = $this->request->post['article_related'];
		} elseif (isset($category_info)) {
			$articles = $this->model_catalog_category->getArticleRelated($this->request->get['category_id']);
		} else {
			$articles = array();
		}

		$data['article_related'] = array();

		$this->load->model('blog/article');

		foreach ($articles as $article_id) {
			$related_info = $this->model_blog_article->getArticle($article_id);

			if ($related_info) {
				$data['article_related'][] = array(
					'article_id' => $related_info['article_id'],
					'name'       => $related_info['name']
				);
			}
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($category_info)) {
			$data['status'] = $category_info['status'];
		} else {
			$data['status'] = true;
		}

		// SEO URL Generator PRO . begin
		$data['module_seo_url_generator_status'] = $this->config->get('module_seo_url_generator_status');

		$data['category_id'] = isset($this->request->get['category_id']) ? $this->request->get['category_id'] : false;
		
		$this->load->language('extension/module/seo_url_generator');
		
		$this->load->model('extension/module/seo_url_generator');
		
		$data['sug_button_generate'] = $this->language->get('sug_button_generate');
		$data['sug_text_redirects'] = $this->language->get('sug_text_redirects');
		$data['sug_help_redirects'] = $this->language->get('sug_help_redirects');
		$data['sug_button_add_redirect'] = $this->language->get('sug_button_add_redirect');
		$data['sug_button_delete_redirect'] = $this->language->get('sug_button_delete_redirect');		
		$data['sug_confirm_title'] = $this->language->get('sug_confirm_title');
		$data['sug_confirm_body'] = $this->language->get('sug_confirm_body');
		$data['sug_confirm_btn_yes'] = $this->language->get('sug_confirm_btn_yes');
		$data['sug_confirm_btn_no'] = $this->language->get('sug_confirm_btn_no');
		$data['sug_redirects_error_title'] = $this->language->get('sug_redirects_error_title');
		$data['sug_redirects_error_empty'] = $this->language->get('sug_redirects_error_empty');
		$data['sug_redirects_error_slash'] = $this->language->get('sug_redirects_error_slash');
		$data['sug_redirects_error_protocol'] = $this->language->get('sug_redirects_error_protocol');
		$data['sug_redirects_error_html'] = $this->language->get('sug_redirects_error_html');
		$data['sug_redirects_error_common'] = $this->language->get('sug_redirects_error_common');
		

		$this->load->language('catalog/extra_description_category');
	  
		$this->load->language('catalog/category'); // for heading_title no conflict
		
		if (isset($this->request->get['category_id'])) {
			if (isset($this->request->post['seo_url_generator_redirects'])) {
				$data['redirects'] = $this->request->post['seo_url_generator_redirects'];
			} else {
				$data['redirects'] = $this->model_extension_module_seo_url_generator->getRedirects('category_id', $this->request->get['category_id']);
			}
		} else {
			$data['redirects'] = array();
		}
		
		// For TWIG
		$data['url_redirects_rows'] = array();

		foreach ($data['stores'] as $store) {
			foreach ($data['languages'] as $language) {
				$data['url_redirects_rows'][$store['store_id']][$language['language_id']] = false;
			}
		}
		// SEO URL Generator PRO . end

		if (isset($this->request->post['category_seo_url'])) {
			$data['category_seo_url'] = $this->request->post['category_seo_url'];
		} elseif (isset($this->request->get['category_id'])) {
			$data['category_seo_url'] = $this->model_catalog_category->getCategorySeoUrls($this->request->get['category_id']);
		} else {
			$data['category_seo_url'] = array();
		}

		if (isset($this->request->post['noindex'])) {
			$data['noindex'] = $this->request->post['noindex'];
		} elseif (!empty($category_info)) {
			$data['noindex'] = $category_info['noindex'];
		} else {
			$data['noindex'] = 1;
		}


				if (isset($this->request->post['category_mrp'])) {
					$category_mrps = $this->request->post['category_mrp'];
				} elseif (isset($this->request->get['category_id'])) {
					$category_mrps = $this->model_catalog_category->getCategoryTables($this->request->get['category_id']);
				} else {
					$category_mrps = array();
				}

				$data['category_mrps'] = array();

				foreach ($category_mrps as $category_mrp) {
					$data['category_mrps'][] = array(
						'category_mrp_id'          		=> (isset($category_mrp['category_mrp_id'])) ? $category_mrp['category_mrp_id'] : 0,
						'category_mrp_product'     		=> (isset($category_mrp['category_mrp_product'])) ? $category_mrp['category_mrp_product'] : array(),
						'category_mrp_description' 		=> $category_mrp['category_mrp_description'],
						'sort_order'                 	=> $category_mrp['sort_order'],
						'status'                     	=> $category_mrp['status'],
					);
				}
			
		if (isset($this->request->post['category_layout'])) {
			$data['category_layout'] = $this->request->post['category_layout'];
		} elseif (isset($this->request->get['category_id'])) {
			$data['category_layout'] = $this->model_catalog_category->getCategoryLayouts($this->request->get['category_id']);
		} else {
			$data['category_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/category_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// SEO Tags Generator : Declension . begin
		if ($this->config->get('module_seo_tags_generator_status') && $this->config->get('module_seo_tags_generator_declension')) {
			foreach ($this->request->post['category_declension'] as $language_id => $item) {
				if ((utf8_strlen($item['category_name_singular_nominative']) < 2) || (utf8_strlen($item['category_name_singular_nominative']) > 255)) {
					$this->error['category_name_singular_nominative'][$language_id] = $this->language->get('error_category_name_singular_nominative');
				}
			}
		}
		// SEO Tags Generator : Declension . end

		// SEO Tags Generator : Attributes . begin
		if (isset($this->request->post['stg_specific']['setting']['attributes'])) {
			foreach ($this->request->post['stg_specific']['setting']['attributes'] as $attribute) {
				if (!$attribute) {
					$this->error['stg_error_attributes'] = $this->language->get('error_attributes_empty');
				}
			}
		}
		// SEO Tags Generator : Attributes . end

		foreach ($this->request->post['category_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 0) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}

			if ((utf8_strlen($value['meta_h1']) < 0) || (utf8_strlen($value['meta_h1']) > 255)) {
				$this->error['meta_h1'][$language_id] = $this->language->get('error_meta_h1');
			}
		}

		if (isset($this->request->get['category_id']) && $this->request->post['parent_id']) {
			$results = $this->model_catalog_category->getCategoryPath($this->request->post['parent_id']);

			foreach ($results as $result) {
				if ($result['path_id'] == $this->request->get['category_id']) {
					$this->error['parent'] = $this->language->get('error_parent');

					break;
				}
			}
		}

    // SEO URL Generator PRO . begin
		if (isset($this->request->post['seo_url_generator_redirects'])) {
			foreach ($this->request->post['seo_url_generator_redirects'] as $store_id => $store) {
				foreach ($store as $language_id => $redirects) {
					foreach ($redirects as $index => $redirect) {
						if (false !== strpos($redirect, '/') || false !== strpos($redirect, 'http') || false !== strpos($redirect, '.html') || empty(trim($redirect))) {
					$this->error['seo_url_generator_redirects'][$store_id][$language_id][$index] = $this->language->get('sug_redirects_error_validate');
						}
					}
				}
			}
		}    
		// SEO URL Generator PRO . end

		if ($this->request->post['category_seo_url']) {
			$this->load->model('design/seo_url');

			foreach ($this->request->post['category_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						if (count(array_keys($language, $keyword)) > 1) {
							$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
						}

						$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);

						foreach ($seo_urls as $seo_url) {
							if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['category_id']) || ($seo_url['query'] != 'category_id=' . $this->request->get['category_id']))) {
								$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_keyword');

								break;
							}
						}
					}
				}
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	public function enable() {

		$this->load->language('catalog/extra_description_category');
	  
        $this->load->language('catalog/category');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/category');

				$this->model_catalog_category->createMrpSQL();
			
        if (isset($this->request->post['selected']) && $this->validateEnable()) {
            foreach ($this->request->post['selected'] as $category_id) {
                $this->model_catalog_category->editCategoryStatus($category_id, 1);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $url = '';
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

		if ($this->config->get('module_admin_quick_edit_status') && $this->config->get('module_admin_quick_edit_catalog_categories_status')) {
			foreach ($this->config->get('module_admin_quick_edit_catalog_categories') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
		}
			
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
			$this->response->redirect($this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }
        $this->getList();
    }

    public function disable() {

		$this->load->language('catalog/extra_description_category');
	  
        $this->load->language('catalog/category');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/category');

				$this->model_catalog_category->createMrpSQL();
			
        if (isset($this->request->post['selected']) && $this->validateDisable()) {
            foreach ($this->request->post['selected'] as $category_id) {
                $this->model_catalog_category->editCategoryStatus($category_id, 0);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $url = '';
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

		if ($this->config->get('module_admin_quick_edit_status') && $this->config->get('module_admin_quick_edit_catalog_categories_status')) {
			foreach ($this->config->get('module_admin_quick_edit_catalog_categories') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
		}
			
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            $this->response->redirect($this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }
        $this->getList();
    }

	protected function validateEnable() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateDisable() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateRepair() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/category');

				$this->model_catalog_category->createMrpSQL();
			

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'sort'        => 'name',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => $this->config->get('config_limit_autocomplete')
			);


      // OCFilter start
      if (isset($filter_data['filter_name']) && isset($filter_data['limit']) && $filter_data['limit'] == 5) {
        $filter_data['limit'] = 15;
      }
      // OCFilter end
      
			$results = $this->model_catalog_category->getCategories($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'category_id' => $result['category_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function getCategories($parent_id, $parent_path = '', $indent = '') {
		$category_id = array_shift($this->path);
		$output = array();
		static $href_category = null;
		static $href_action = null;
		if ($href_category === null) {
			$href_category = $this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token'] . '&path=', true);
			$href_action = $this->url->link('catalog/category/update', 'user_token=' . $this->session->data['user_token'] . '&category_id=', true);
		}
		$results = $this->model_catalog_category->getCategoriesByParentId($parent_id);
		foreach ($results as $result) {
			$path = $parent_path . $result['category_id'];
			$href = ($result['children']) ? $href_category . $path : '';
			$name = $result['name'];
			if ($category_id == $result['category_id']) {
				$name = '<b>' . $name . '</b>';
				$data['breadcrumbs'][] = array(
					'text'      => $result['name'],
					'href'      => $href,
					'separator' => ' :: '
			);
				$href = '';
			}
			$selected = isset($this->request->post['selected']) && in_array($result['category_id'], $this->request->post['selected']);
			$action = array();
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $href_action . $result['category_id']
			);
			$output[$result['category_id']] = array(
				'category_id' => $result['category_id'],
				'name'        => $name,
				'sort_order'  => $result['sort_order'],
				'noindex'  	  => $result['noindex'],
				'edit'        => $this->url->link('catalog/category/edit', 'user_token=' . $this->session->data['user_token'] . '&category_id=' . $result['category_id'], true),
				'selected'    => $selected,
				'action'      => $action,
				'href'        => $href,
				'href_shop'   => HTTP_CATALOG . 'index.php?route=product/category&path=' . ($result['category_id']),
				'indent'      => $indent
			);
			if ($category_id == $result['category_id']) {
				$output += $this->getCategories($result['category_id'], $path . '_', $indent . str_repeat('&nbsp;', 8));
			}
		}
		return $output;
	}
	private function getAllCategories($categories, $parent_id = 0, $parent_name = '') {
		$output = array();
		if (array_key_exists($parent_id, $categories)) {
			if ($parent_name != '') {
				$parent_name .= $this->language->get('text_separator');
			}
			foreach ($categories[$parent_id] as $category) {
				$output[$category['category_id']] = array(
					'category_id' => $category['category_id'],
					'name'        => $parent_name . $category['name']
				);
				$output += $this->getAllCategories($categories, $category['category_id'], $parent_name . $category['name']);
			}
		}
		return $output;
		}
}