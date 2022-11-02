<?php
class ControllerExtensionModuleMRPCategory extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/latest');

		$data['text_tax'] 			= $this->language->get('text_tax');

		$data['button_cart'] 		= $this->language->get('button_cart');
		$data['button_wishlist'] 	= $this->language->get('button_wishlist');
		$data['button_compare'] 	= $this->language->get('button_compare');


		$this->load->model('extension/module/mrp_category');

		$this->load->model('tool/image');
		$this->load->model('catalog/product');

		$data['category_mrps'] = array();
		
		if (isset($this->request->get['path'])) {
            $path = '';

            $parts = explode('_', (string)$this->request->get['path']);

            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = $path_id;
                } else {
                    $path .= '_' . $path_id;
                }
            }

            $category_id = array_pop($parts);
        } else {
            $category_id = null;
        }

		if($setting['desc'] == 1){
			$data['desc_status'] = true;
		} else {
			$data['desc_status'] = false;
		}
		if($setting['subcat'] == 0){
			$category_mrps = $this->model_extension_module_mrp_category->getMrpTable($category_id);
		} else {
			$category_mrps = $this->model_extension_module_mrp_category->getMrpTable($path);
		}
		
				
		if ($category_mrps) {
			foreach ($category_mrps as $category_mrp) {
				$products = array();
				
				foreach ($category_mrp['category_mrp_product']->rows as $prod_info) {
					$result = $this->model_catalog_product->getProduct($prod_info['product_id']);
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$price = false;
					}

					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $result['rating'];
					} else {
						$rating = false;
					}
					 
					$products[] = array(
						'product_id'  => $result['product_id'],
						'thumb'       => $image,
						'name'        => $result['name'],
						'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'rating'      => $rating,
						'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
					);
				}

				$data['category_mrps'][] = array(
					'table_id'          => $category_mrp['category_mrp_id'],
					'table_product'     => $products,
					'description' 		=> html_entity_decode($category_mrp['description']),
					'title' 			=> $category_mrp['title'],
				);
			}
			
			if($setting['tab'] == 0){
				return $this->load->view('extension/module/mrp_category_tab', $data);
			} else {
				return $this->load->view('extension/module/mrp_category', $data);
			}

		}
	}
}
