<?php
class ControllerExtensionModuleOCDepartment extends Controller {
  private $setting = array();

  private $parent_id = 0;
  private $category_id = 0;
  private $location = '';
  private $url_params = '';

  private $path = '';
  private $manufacturer_id = 0;
  private $manufacturer_info;
  private $search = '';
  private $description = false;

  private $ocfilter;

  protected function init($setting) {
    $this->load->model('extension/module/ocdepartment');

    $this->setting = $setting;

    $this->url_params = $this->getURLParams();

    if (isset($this->request->get['manufacturer_id'])) {
      $this->manufacturer_id = $this->request->get['manufacturer_id'];
    }

    if (isset($this->request->get['search'])) {
      $this->search = urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
    }

    if (isset($this->request->get['description'])) {
      $this->description = $this->request->get['description'];
    }

    if (isset($this->request->get['path'])) {
      $parts = explode('_', (string)$this->request->get['path']);
    } else {
      $parts = array();
    }

    $parts = array_filter($parts, 'strlen');

    if ($parts) {
      $this->category_id = array_pop($parts);
    } else if (isset($this->request->get['category_id'])) {
      // When search with category
      $this->category_id = $this->request->get['category_id'];
    } else if (isset($this->request->get['filter_category_id'])) {
      // In product/special
      $this->category_id = $this->request->get['filter_category_id'];
    } else {
      $this->category_id = 0;
    }

    if ($parts) {
      $this->path = implode('_', $parts);
    }

    if ($parts) {
      $this->parent_id = array_pop($parts);
    } else {
      $this->parent_id = 0;
    }

    // Manufacturer info as heading
    if ($this->manufacturer_id) {
      $this->load->model('catalog/manufacturer');

      $this->manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->manufacturer_id);
    } else {
      $this->manufacturer_info = false;
    }

    // Get current location page
    $this->location = '';

    if (!isset($this->request->get['path'])) {
      if ($this->manufacturer_info) {
        $this->location = 'manufacturer';
      } else if (trim($this->search) && utf8_strlen($this->search) > 2) {
        $this->location = 'search';
      } else if (isset($this->request->get['route']) && $this->request->get['route'] == 'product/special') {
        $this->location = 'special';
      }
    } else {
      $this->location = 'category';
    }

    if ($this->location == 'manufacturer' && $this->isOCFInstalled() && !$this->registry->has('ocfilter')) {
      $this->ocfilter = new OCFilter();
    }
  }

  public function index($setting = array()) {
    $this->init($setting);

    $data = $this->load->language('extension/module/ocdepartment');

    // Parent category as heading
    $data['parent'] = array();

    if ($this->parent_id) {
      $parent_info = $this->model_catalog_category->getCategory($this->parent_id);

      if ($parent_info) {
        $data['parent'] = array(
          'name' => $parent_info['name'],
          'href' => $this->url->link('product/category', 'path=' . str_replace('_' . $this->category_id, '', $this->path))
        );
      }
    }

    if ($this->manufacturer_info) {
      $data['manufacturer'] = $this->manufacturer_info['name'];
    } else {
      $data['manufacturer'] = '';
    }

    // Category results
    if ($this->location == 'manufacturer') {
      $categories = $this->model_extension_module_ocdepartment->getManufacturerCategories($this->manufacturer_id);
    } else if ($this->location == 'search') {
      $categories = $this->model_extension_module_ocdepartment->getProductSearchCategories($this->search, $this->description);
    } else if ($this->location == 'special') {
      $categories = $this->model_extension_module_ocdepartment->getSpecialCategories();
    } else if ($this->location == 'category') {
      $categories = $this->model_extension_module_ocdepartment->getCategories($this->category_id);

      if (!$categories) {
        $categories = $this->model_extension_module_ocdepartment->getCategories($this->parent_id);
      }
    } else {
      $categories = array();
    }

    if ($categories) {
      // Temporary category list with parent_id > 0 key
      $_categories = array();

      foreach ($categories as $key => $category) {
        if ($category['parent_id'] > 0) {
          if (isset($category['level']) && isset($category['max_level']) && $category['level'] == $category['max_level']) {
            if (!isset($_categories[$category['parent_id']])) {
              $_categories[$category['parent_id']] = array();
            }

            $_categories[$category['parent_id']][] = $category;

            unset($categories[$key]);
          }
        }
      }

      // Set children and remove from temp
      foreach ($categories as $key => $category) {
        if (isset($_categories[$category['category_id']])) {
          $children = $_categories[$category['category_id']];

          unset($_categories[$category['category_id']]);
        } else {
          $children = array();
        }

        $categories[$key]['children'] = $children;
      }

      // Move unused child categories to primary array
      if ($_categories) {
        foreach ($_categories as $parent_id => $children) {
        	$categories = array_merge($categories, $children);
        }
      }

      $path = $this->path;

      if ($path) {
        $path .= '_';
      }

      $data['categories'] = array();

      foreach ($categories as $category) {
        $children_data = array();

        if (isset($category['children'])) {
          foreach ($category['children'] as $child) {
            if ($setting['show_total'] && isset($child['total']) && $child['total'] > 0) {
            	$total = $child['total'];
            } else {
              $total = '';
            }

            $children_data[] = array(
              'category_id' => $child['category_id'],
              'name' => $child['name'],
              'total' => $total,
              'active' => ($child['category_id'] == $this->category_id),
              'href' => $this->getCategoryLink($child, $path . $category['category_id'] . '_' . $child['category_id'])
            );
          }
        }

        if ($setting['show_total'] && isset($category['total']) && $category['total'] > 0 && !$children_data) {
        	$total = $category['total'];
        } else {
          $total = '';
        }

        $data['categories'][] = array(
          'category_id' => $category['category_id'],
          'name'        => $category['name'],
          'total'       => $total,
          'children'    => $children_data,
          'active'      => ($category['category_id'] == $this->category_id),
          'href'        => $this->getCategoryLink($category, $path)
        );
      }

      $data['location'] = $this->location;

      $data['collapse_parent'] = $this->setting['collapse_parent'];
      $data['collapse_parent_limit'] = $this->setting['collapse_parent_limit'];
      $data['collapse_child'] = $this->setting['collapse_child'];
      $data['collapse_child_limit'] = $this->setting['collapse_child_limit'];

  		if (file_exists(DIR_TEMPLATE . $this->config->get($this->config->get('config_theme') . '_directory') . '/stylesheet/ocdepartment.css')) {
  			$this->document->addStyle('catalog/view/theme/' . $this->config->get($this->config->get('config_theme') . '_directory') . '/stylesheet/ocdepartment.css');
  		} else {
  			$this->document->addStyle('catalog/view/theme/default/stylesheet/ocdepartment.css');
      }

      return $this->load->view('extension/module/ocdepartment/module', $data);
    }
  }

  protected function getURLParams() {
    $url = '';

    if (isset($this->request->get['manufacturer_id'])) {
      if ($this->config->get('ocfilter_status') || $this->config->get('module_ocfilter_status')) {
        $url .= '&filter_ocfilter=m:' . $this->request->get['manufacturer_id'];
      } else {
        $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
      }
    }

    if (isset($this->request->get['search'])) {
      $url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
    }

    if (isset($this->request->get['description'])) {
      $url .= '&description=' . $this->request->get['description'];
    }

    return $url;
  }

  protected function getCategoryLink($category_info, $path) {
    if ($this->location == 'special') {
      return $this->url->link('product/special', 'filter_category_id=' . $category_info['category_id'] . $this->url_params);
    } else if ($this->location == 'search') {
      return $this->url->link('product/search', 'category_id=' . $category_info['category_id'] . '&sub_category=true' .  $this->url_params);
    } else if ($this->location == 'category' || $this->setting['link_to'] == 'category') {
      if (isset($category_info['path'])) {
        $_path = $category_info['path'];
      } else {
        if ($this->location == 'category') {
        	$_path = $path . $category_info['category_id'];
        } else {
        	$_path = $category_info['category_id'];
        }
      }

      return $this->OCFRewrite($this->url->link('product/category', 'path=' . $_path . $this->url_params));
    } else if ($this->location == 'manufacturer') {
      return $this->url->link('product/manufacturer/info', 'filter_category_id=' . $category_info['category_id'] . $this->url_params);
    }
  }

  protected function isOCFInstalled() {
    return ($this->config->get('ocfilter_status') || $this->config->get('module_ocfilter_status'));
  }

  protected function OCFRewrite($link) {
    if ($this->location == 'manufacturer' && $this->isOCFInstalled() && !$this->registry->has('ocfilter')) {
      $link = $this->ocfilter->rewrite($link);
    }

    return $link;
  }
}