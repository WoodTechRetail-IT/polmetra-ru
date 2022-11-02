<?php
class ControllerExtensionModuleFeatured extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/featured');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

				$this->load->language('stroimarket/stroimarket');
			

		$data['products'] = array();

				function featured($number, $suffix) {
					$keys = array(2, 0, 1, 1, 1, 2);
					$mod = $number % 100;
					$suffix_key = ($mod > 7 && $mod < 20) ? 2: $keys[min($mod % 10, 5)];
					return $suffix[$suffix_key];
				}
				$text_review_array = array('text_reviews_1', 'text_reviews_2', 'text_reviews_3');
			
 
				$data['quantity_btn'] 	= $this->config->get('config_catalog_quantity');
				$data['review_status'] 	= $this->config->get('config_review_status');
				$data['shadow_title'] 	= $this->config->get('config_shadow_title');
			

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

		if (!empty($setting['product'])) {
			$products = array_slice($setting['product'], 0, (int)$setting['limit']);

			foreach ($products as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$price = false;
					}

					if (!is_null($product_info['special']) && (float)$product_info['special'] >= 0) {

				$economy = $this->currency->format($this->tax->calculate($product_info['price'] - $product_info['special'], $this->config->get('config_tax')), $this->session->data['currency']);
			    $percent = round(100-($product_info['special']/($product_info['price']/100)));
			
						$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						$tax_price = (float)$product_info['special'];
					} else {
						$special = false;

				$economy = false;
				$percent = false;
			
						$tax_price = (float)$product_info['price'];
					}
		
					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format($tax_price, $this->session->data['currency']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $product_info['rating'];
					} else {
						$rating = false;
					}

					
                $results_img = $this->model_catalog_product->getProductImages($product_info['product_id']);
                $additional_img = array();
                foreach ($results_img as $result_img) {
                    if ($result_img['image']) {
                        $additional_image = $this->model_tool_image->resize($result_img['image'], $setting['width'], $setting['height']);
                    } else {
                        $additional_image = false;
                    }
                    $additional_img[] = $additional_image;
                }
            

				$data['reviews_count'] = $reviews_count = (int)$product_info['reviews'];				
				$text_review = featured($reviews_count, $text_review_array);
	
				if ($product_info['quantity'] <= 0) {
					$data['stock'] = $product_info['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$data['stock'] = $product_info['quantity'];
				} else {
					$data['stock'] = $this->language->get('text_instock');
				}

				$this->load->model('catalog/manufacturer');

				if ($product_info['manufacturer_id']) {
					$manufacturer_image = $this->model_catalog_manufacturer->getManufacturer($product_info['manufacturer_id']);
				} else {
					$manufacturer_image = false;
				}
			
					$data['products'][] = array(

				'manufacturer'   		=> $product_info['manufacturer'],
			    'quantity'    			=> $product_info['quantity'],
				'minimum'	  			=> $product_info['minimum'],
				'reviews' 	  			=> sprintf($this->language->get($text_review), (int)$product_info['reviews']),
				'sku'               	=> $this->config->get('config_catalog_sku') ? $product_info['sku'] : '',
			

				'manufacturer_image' 	=> $this->config->get('config_catalog_manufacturer') ? $this->model_tool_image->resize($manufacturer_image['image'], 60, 40) : '',
				'stock'       			=> $data['stock'],
				'economy'		    	=> $this->config->get('config_catalog_economy') ? $economy : '',
				'percent' 	        	=> $this->config->get('config_catalog_discount') ? $percent : '',
				'attention'   			=> sprintf($this->language->get('text_price_login'), $this->url->link('account/login'), $this->url->link('account/register')),
			

                'additional_img' => $additional_img,
            
						'product_id'  => $product_info['product_id'],
						'thumb'       => $image,
						'name'        => $product_info['name'],
						'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'rating'      => $rating,
						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
					);
				}
			}
		}

		if ($data['products']) {
			return $this->load->view('extension/module/featured', $data);
		}
	}
}