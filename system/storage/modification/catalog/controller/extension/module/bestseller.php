<?php
class ControllerExtensionModuleBestSeller extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/bestseller');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

				$this->load->language('stroimarket/stroimarket');
			

		$data['products'] = array();

				function bestseller($number, $suffix) {
					$keys = array(2, 0, 1, 1, 1, 2);
					$mod = $number % 100;
					$suffix_key = ($mod > 7 && $mod < 20) ? 2: $keys[min($mod % 10, 5)];
					return $suffix[$suffix_key];
				}
				$text_review_array = array('text_reviews_1', 'text_reviews_2', 'text_reviews_3');
			
 
				$data['quantity_btn'] 	= $this->config->get('config_catalog_quantity');
				$data['review_status'] 	= $this->config->get('config_review_status');
				$data['shadow_title'] 	= $this->config->get('config_shadow_title');
			

		$results = $this->model_catalog_product->getBestSellerProducts($setting['limit']);

		if ($results) {
			foreach ($results as $result) {
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

				if (!is_null($result['special']) && (float)$result['special'] >= 0) {

				$economy = $this->currency->format($this->tax->calculate($result['price'] - $result['special'], $this->config->get('config_tax')), $this->session->data['currency']);
			    $percent = round(100-($result['special']/($result['price']/100)));
			
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$tax_price = (float)$result['special'];
				} else {
					$special = false;

				$economy = false;
				$percent = false;
			
					$tax_price = (float)$result['price'];
				}
	
				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format($tax_price, $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}

				
                $results_img = $this->model_catalog_product->getProductImages($result['product_id']);
                $additional_img = array();
                foreach ($results_img as $result_img) {
                    if ($result_img['image']) {
                        $additional_image = $this->model_tool_image->resize($result_img['image'], $setting['width'], $setting['height']);
                    } else {
                        $additional_image = false;
                    }
                    $additional_img[] = $additional_image;
                }
            
				
				$data['reviews_count'] = $reviews_count = (int)$result['reviews'];
				$text_review = bestseller($reviews_count, $text_review_array);
				if ($result['quantity'] <= 0) {
					$data['stock'] = $result['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$data['stock'] = $result['quantity'];
				} else {
					$data['stock'] = $this->language->get('text_instock');
				}
			

				$this->load->model('catalog/manufacturer');
				if ($result['manufacturer_id']) {
					$manufacturer_image = $this->model_catalog_manufacturer->getManufacturer($result['manufacturer_id']);
				} else {
					$manufacturer_image = false;
				}
			
				$data['products'][] = array(

				'manufacturer'   		=> $result['manufacturer'],
				'quantity'      		=> $result['quantity'],
				'minimum'	    		=> $result['minimum'],
				'reviews' 	    		=> sprintf($this->language->get($text_review), (int)$result['reviews']),
                'sku'           		=> $this->config->get('config_catalog_sku') ? $result['sku'] : '',
			

				'manufacturer_image' 	=> $this->config->get('config_catalog_manufacturer') ? $this->model_tool_image->resize($manufacturer_image['image'], 60, 40) : '',
				'stock'       			=> $data['stock'],
				'economy'		    	=> $this->config->get('config_catalog_economy') ? $economy : '',
				'percent' 	        	=> $this->config->get('config_catalog_discount') ? $percent : '',
				'attention'   			=> sprintf($this->language->get('text_price_login'), $this->url->link('account/login'), $this->url->link('account/register')),
			

                'additional_img' => $additional_img,
            
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(trim(strip_tags(html_entity_decode(
          preg_replace('/\[\s*gallery_rb\s*id\s*=\s*\s*\d{1,}\s*\]/', '', $result['description'])
        , ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}

			return $this->load->view('extension/module/bestseller', $data);
		}
	}
}
