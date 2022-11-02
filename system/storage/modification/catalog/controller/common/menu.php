<?php
class ControllerCommonMenu extends Controller {
	public function index() {
		$this->load->language('common/menu');

				$this->load->language('stroimarket/stroimarket');
			

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

				$this->load->model('tool/image');
			

		$data['categories'] = array();

				$data['special'] = $this->url->link('product/special');
			

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {

				$gchildren_data = array();
				$gchildren = $this->model_catalog_category->getCategories($child['category_id']);
				foreach ($gchildren as $gchild) {
				    $gchildren_filter_data = array(
				        'filter_category_id'  => $gchild['category_id'],
				        'filter_sub_category' => true
				    );			        
				    $gchildren_data[] = array(
				        'name'  => $gchild['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($gchildren_filter_data) . ')' : ''),
				        'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] . '_' . $gchild['category_id'])
				    );    
				}
			

				if ($child['image']) {
					$child['image'] = $this->model_tool_image->resize($child['image'], 24, 24);
				} else {
					$child['image'] = $this->model_tool_image->resize('placeholder.png', 24, 24);
				}
			
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(

				'image' => $this->config->get('config_menu_image2') ? $child['image'] : '',
			
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),

				'gchildren' => $this->config->get('config_menu_gchildren') ? $gchildren_data : '',
				'column'   => $child['column'] ? $child['column'] : 1,
			
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
					
				}

				// Level 1

				if ($category['image']) {
					$category['image'] = $this->model_tool_image->resize($category['image'], 24, 24);
				} else {
					$category['image'] = $this->model_tool_image->resize('placeholder.png', 24, 24);
				}
			
				$data['categories'][] = array(

				'image' 		=> $this->config->get('config_menu_image') ? $category['image'] : '',
				'category_id' 	=> $category['category_id'],
			
					'name'     => $category['name'],
					'menudopblock'     => $category['menudopblock'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		return $this->load->view('common/menu', $data);
	}
}
