<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerProductProduct extends Controller {

        public function getOptions() {
            $product_id = $this->request->post['product_id'];
            $this->load->model('catalog/product');
            $product_info = $this->model_catalog_product->getProduct($product_id);
            $data['product_name'] = $product_info['name'];
            $data['product_id'] = $product_id;
            $data['text_select'] = $this->language->get('text_select');
            $data['summa'] = $this->request->post['summa'];
            $data['gift_id'] = $this->request->post['gift_id'];
            $data['gift_type'] = $this->request->post['gift_type'];
            $data['options']=array();

            foreach ($this->model_catalog_product->getProductOptions($product_id) as $option) {
                $product_option_value_data = array();

                foreach ($option['product_option_value'] as $option_value) {
                    if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                        if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
                            $price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
                        } else {
                            $price = false;
                        }

                        $product_option_value_data[] = array(

          'price_value'                   => $option_value['price'],
          'points_value'                  => intval($option_value['points_prefix'].$option_value['points']),
      
                                'product_option_value_id' => $option_value['product_option_value_id'],
                                'option_value_id'         => $option_value['option_value_id'],
                                'name'                    => $option_value['name'],
                                'image'                   => $option_value['image'] ? $this->model_tool_image->resize($option_value['image'], 50, 50) : '',
                                'price'                   => $price,
                                'price_prefix'            => $option_value['price_prefix']
                        );
                    }
                }

                $data['options'][] = array(
                        'product_option_id'    => $option['product_option_id'],
                        'product_option_value' => $product_option_value_data,
                        'option_id'            => $option['option_id'],
                        'name'                 => $option['name'],
                        'type'                 => $option['type'],
                        'value'                => $option['value'],
                        'required'             => $option['required']
                );
            }
            if(empty($data['options'])){
                echo 0;
            }else{
                $this->response->setOutput($this->load->view('extension/gift_price/options_in_product', $data));
            }
        }
        
	private $error = array();

	public function index() {
		$this->load->language('product/product');

				$this->load->language('stroimarket/stroimarket');
			

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$this->load->model('catalog/category');

		if (isset($this->request->get['path'])) {
			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path)
					);
				}
			}

			// Set the last category breadcrumb
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$data['breadcrumbs'][] = array(
					'text' => $category_info['name'],
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url)
				);
			}
		}

		$this->load->model('catalog/manufacturer');

		if (isset($this->request->get['manufacturer_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_brand'),
				'href' => $this->url->link('product/manufacturer')
			);

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);

			if ($manufacturer_info) {
				$data['breadcrumbs'][] = array(
					'text' => $manufacturer_info['name'],
					'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url)
				);
			}
		}

		if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_search'),
				'href' => $this->url->link('product/search', $url)
			);
		}

		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
 			$data['prodvar_module'] = $this->load->controller('extension/module/prodvar');

                $showInstallmentsBlock = $this->config->get('yoomoney_kassa_enabled')
                    && $this->config->get('yoomoney_kassa_add_installments_block');

                $data['yoomoney_showInstallmentsBlock'] = $showInstallmentsBlock;
                $data['yoomoney_shop_id'] = $this->config->get('yoomoney_kassa_shop_id');
                $data['yoomoney_language_code'] = $this->language->get('code');
            

						//microdatapro 7.7 start
						$data['microdatapro_data'] = $product_info;
						//microdatapro 7.7 end
					
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $product_info['name'],
				'href' => $this->url->link('product/product', $url . '&product_id=' . $this->request->get['product_id'])
			);

			// Seo Tags Generator.Begin
			$stg_data = array(
				'attribute_groups' => isset($data['attribute_groups']) ? $data['attribute_groups'] : array(),
				'product_info' => $product_info
			);

			$product_info = $this->load->controller('extension/module/seo_tags_generator/getProductTags', $stg_data);
			// Seo Tags Generator.End
			
			if ($product_info['meta_title']) {
				$this->document->setTitle($product_info['meta_title']);
			} else {
				$this->document->setTitle($product_info['name']);
			}
			
			if ($product_info['noindex'] <= 0 && $this->config->get('config_noindex_status')) {
				$this->document->setRobots('noindex,follow');
			}
			
			if ($product_info['meta_h1']) {
				$data['heading_title'] = $product_info['meta_h1'];
			} else {
				$data['heading_title'] = $product_info['name'];
			}
			$data['pmtemplate'] = $product_info['pmtemplate'];
			$this->document->setDescription($product_info['meta_description']);
			$this->document->setKeywords($product_info['meta_keyword']);
			$this->document->addLink($this->url->link('product/product', 'product_id=' . $this->request->get['product_id']), 'canonical');
			$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
			$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment/moment.min.js');
			$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment/moment-with-locales.min.js');
			$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

			$data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
			$data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));

			$this->load->model('catalog/review');

			$data['tab_review'] = sprintf($this->language->get('tab_review'), $product_info['reviews']);

			$data['product_id'] = (int)$this->request->get['product_id'];
			$data['manufacturer'] = $product_info['manufacturer'];
			$data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
			$data['model'] = $product_info['model'];

				$data['sku'] 	= $this->config->get('config_product_sku') ? $product_info['sku'] : '';
				$data['weight'] = $this->config->get('config_product_weight') ? number_format($product_info['weight'], 1).''.$this->weight->getUnit($product_info['weight_class_id']) : '';
			
			$data['reward'] = $product_info['reward'];
			$data['points'] = $product_info['points'];

				$data['quantity'] = $product_info['quantity'];
			
			$data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');

			if ($product_info['quantity'] <= 0) {
				$data['stock'] = $product_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$data['stock'] = $product_info['quantity'];
			} else {
				$data['stock'] = $this->language->get('text_instock');
			}

			$this->load->model('tool/image');
			$this->load->model('tool/imagequadr');

			if ($product_info['image']) {
				$data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height'));
			} else {
				$data['popup'] = '';
			}

			
			
			
                if ($product_info['pmtemplate'] == 'productpol') {
            			if ($product_info['image']) {
            				$data['thumb'] = $this->model_tool_imagequadr->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height'));
            			} else {
            				$data['thumb'] = '';
            			}
                    
    			     } elseif ($product_info['pmtemplate'] == 'productdver') {
            			if ($product_info['image']) {
            				$data['thumb'] = $this->model_tool_image->resize($product_info['image'], 280, 570);
            			} else {
            				$data['thumb'] = '';
            			}
    			     } else {
            			if ($product_info['image']) {
            				$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height'));
            			} else {
            				$data['thumb'] = '';
            			}
                }
			
			

			$data['images'] = array();

			$results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);

            if ($product_info['pmtemplate'] == 'productpol') {
    			foreach ($results as $result) {
    				$data['images'][] = array(
    					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height')),
    					'thumb' => $this->model_tool_imagequadr->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_height'))
    				);
    			}
            } else {
    			foreach ($results as $result) {
    				$data['images'][] = array(
    					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height')),
    					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_height'))
    				);
    			}
    		}

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

                $cost = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
                if ($this->currency->has('RUB')) {
                    $data['cost'] = sprintf('%.2f', $this->currency->format($cost, 'RUB', '', false));
                } else {
                    $this->load->model('extension/payment/yoomoney');
                    $data['cost'] = $this->model_extension_payment_yoomoney->convertFromCbrf(array('total' => $cost), 'RUB');
                }
                $data['yoomoney_showInstallmentsBlock'] = $data['yoomoney_showInstallmentsBlock'] && ($data['cost'] >= 3000);
            
			} else {
				$data['price'] = false;
 
				$data['attention']	=	sprintf($this->language->get('text_price_login'), $this->url->link('account/login'), $this->url->link('account/register'));	
			
			}

			if (!is_null($product_info['special']) && (float)$product_info['special'] >= 0) {

				$data['economy'] = $this->config->get('config_product_economy') ? $this->currency->format($this->tax->calculate($product_info['price'] - $product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']) : '';
				$data['percent'] = $this->config->get('config_product_discount') ? round(100-($product_info['special']/($product_info['price']/100))) : '';
			
				$data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				$tax_price = (float)$product_info['special'];
			} else {
				$data['special'] = false;

				$data['economy'] = false;
				$data['percent'] = false;
			
				$tax_price = (float)$product_info['price'];
			}

			if ($this->config->get('config_tax')) {
				$data['tax'] = $this->currency->format($tax_price, $this->session->data['currency']);
			} else {
				$data['tax'] = false;
			}

			$discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);

			$data['discounts'] = array();

			foreach ($discounts as $discount) {
				$data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'])
				);
			}


          if ($data['price']) {
              $data['price'] = '<span class=\'autocalc-product-price\'>' . $data['price'] . '</span>';
          }
          if ($data['special']) {
              $data['special'] = '<span class=\'autocalc-product-special\'>' . $data['special'] . '</span>';
          }
          if ($data['points']) {
              $data['points'] = '<span class=\'autocalc-product-points\'>' . $data['points'] . '</span>';
          }
          
          $data['price_value'] = $product_info['price'];
          $data['special_value'] = $product_info['special'];
          $data['tax_value'] = (float)$product_info['special'] ? $product_info['special'] : $product_info['price'];
          $data['points_value'] = $product_info['points'];
          
          $var_currency_autocalc = array();
          $currency_code_autocalc = $this->session->data['currency'];
          $var_currency_autocalc['value'] = $this->currency->getValue($currency_code_autocalc);
          $var_currency_autocalc['symbol_left'] = $this->currency->getSymbolLeft($currency_code_autocalc);
          $var_currency_autocalc['symbol_right'] = $this->currency->getSymbolRight($currency_code_autocalc);
          $var_currency_autocalc['decimals'] = $this->currency->getDecimalPlace($currency_code_autocalc);
          $var_currency_autocalc['decimal_point'] = $this->language->get('decimal_point');
          $var_currency_autocalc['thousand_point'] = $this->language->get('thousand_point');
          $data['currency_autocalc'] = $var_currency_autocalc;
          
          $data['dicounts_unf_autocalc'] = $discounts;

          $data['tax_class_id'] = $product_info['tax_class_id'];
          $data['tax_rates'] = $this->tax->getRates(0, $product_info['tax_class_id']);

      
			$data['options'] = array();

			foreach ($this->model_catalog_product->getProductOptions($this->request->get['product_id']) as $option) {
				$product_option_value_data = array();

				foreach ($option['product_option_value'] as $option_value) {
					if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
						if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
							$price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
						} else {
							$price = false;
						}

						$product_option_value_data[] = array(

          'price_value'                   => $option_value['price'],
          'points_value'                  => intval($option_value['points_prefix'].$option_value['points']),
      
							'product_option_value_id' => $option_value['product_option_value_id'],
							'option_value_id'         => $option_value['option_value_id'],
							'name'                    => $option_value['name'],
							'image'                   => $this->model_tool_imagequadr->resize($option_value['image'], 82, 54),
							'price'                   => $price,
							'price_prefix'            => $option_value['price_prefix']
						);
					}
				}

				$data['options'][] = array(
					'product_option_id'    => $option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $option['option_id'],
					'name'                 => $option['name'],
					'type'                 => $option['type'],
					'value'                => $option['value'],
					'required'             => $option['required']
				);
			}

			if ($product_info['minimum']) {
				$data['minimum'] = $product_info['minimum'];
			} else {
				$data['minimum'] = 1;
			}

			$data['review_status'] = $this->config->get('config_review_status');

			if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
				$data['review_guest'] = true;
			} else {
				$data['review_guest'] = false;
			}

			if ($this->customer->isLogged()) {
				$data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
			} else {
				$data['customer_name'] = '';
			}

			
				$data['reviews_count'] = $reviews_count = (int)$product_info['reviews'];
				function getcartword($count, $suffix) {
					$keys = array(2, 0, 1, 1, 1, 2);
					$mod = $count % 100;
					$suffix_key = ($mod > 7 && $mod < 20) ? 2: $keys[min($mod % 10, 5)];
					return $suffix[$suffix_key];
				}
				$text_array = array('text_reviews_1', 'text_reviews_2', 'text_reviews_3');
				$text = getcartword($reviews_count, $text_array);
				$data['reviews'] = sprintf($this->language->get($text), (int)$product_info['reviews']);
			
			$data['rating'] = (int)$product_info['rating'];

			// Expanded rating
			$this->load->model('catalog/review');
			$review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);
			$estimations = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id']);

			$one 		= 0;
			$two 		= 0;
			$three 		= 0;
			$four 		= 0;
			$five 		= 0;
			$rating_sum = 0;

			foreach ($estimations as $estimation){
				($estimation['rating'] == '1') && $one++;
				($estimation['rating'] == '2') && $two++;
				($estimation['rating'] == '3') && $three++;
				($estimation['rating'] == '4') && $four++;
				($estimation['rating'] == '5') && $five++;

				$rating_sum += $estimation['rating'];
			}

			if ($review_total > 0) {
				$data['expanded_rating'][] = array(
					'one' 		=> number_format((100/$review_total) * $one),
					'two' 		=> number_format((100/$review_total) * $two),
					'three' 	=> number_format((100/$review_total) * $three),
					'four' 		=> number_format((100/$review_total) * $four),
					'five' 		=> number_format((100/$review_total) * $five),
					'rating' 	=> number_format($rating_sum / $review_total, 1),
					'total' 	=> $review_total
				);
			} else {
        		$data['expanded_rating'][] = array(
					'one' 		=> $one,
					'two' 		=> $two,
					'three' 	=> $three,
					'four' 		=> $four,
					'five' 		=> $five,
					'rating' 	=> number_format($rating_sum, 1),
					'total' 	=> $review_total
				);
        	}
			

			// Captcha
			if ($this->config->get('captcha_' . $this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
				$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
			} else {
				$data['captcha'] = '';
			}

			$data['share'] = $this->url->link('product/product', 'product_id=' . (int)$this->request->get['product_id']);

			$data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);

				$data['attributes'] = $this->config->get('config_product_attributes') ? $this->model_catalog_product->getProductOnlyAttributes($this->request->get['product_id']) : '';
			

			$data['products'] = array();

				$data['shadow_title'] 	= $this->config->get('config_shadow_title');
				$data['quantity_btn'] 	= $this->config->get('config_product_quantity');
				$data['back_history'] 	= $this->config->get('config_product_back_history');
				$data['stock_display'] 	= $this->config->get('config_stock_display');
			

			$results = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_height'));
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if (!is_null($result['special']) && (float)$result['special'] >= 0) {

				$percent = $this->config->get('config_product_discount') ? round(100-($result['special']/($result['price']/100))) : '';
			
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$tax_price = (float)$result['special'];
				} else {
					$special = false;

				$percent = false;
			
					$tax_price = (float)$result['price'];
				}
	
				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format($tax_price, $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				$data['products'][] = array(

				'percent'     	=> $percent,
                'quantity' 	  	=> $result['quantity'],
			
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(trim(strip_tags(html_entity_decode(
          preg_replace('/\[\s*gallery_rb\s*id\s*=\s*\s*\d{1,}\s*\]/', '', $result['description'])
        , ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}

			$data['tags'] = array();

			if ($product_info['tag']) {
				$tags = explode(',', $product_info['tag']);

				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('product/search', 'tag=' . trim($tag))
					);
				}
			}

			$data['recurrings'] = $this->model_catalog_product->getProfiles($this->request->get['product_id']);


        $data['downloads'] = array();

        $results = $this->model_catalog_product->getDownloads($this->request->get['product_id']);

        foreach ($results as $result) {  
		  $size = false;
          $file_exists = file_exists(DIR_DOWNLOAD . $result['filename']);
          $http = preg_match('/^http/',$result['filename']);
          if ($file_exists OR $http) {
            if ($file_exists) {
              $size = filesize(DIR_DOWNLOAD . $result['filename']);
              $i = 0;
              $suffix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' );
              while (($size / 1024) > 1) {
              $size = $size / 1024;
              $i++;
              }
            }

            $data['downloads'][] = array(
            'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
            'name' => $result['name'],
            'size' => ($size)?round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]:false,
            'href' => ($http)?$result['filename']:$this->url->link('product/product/download', 'product_id='. $this->request->get['product_id']. '&download_id=' . $result['download_id']),
            'icon' => ($http)?'fa fa-external-link-square text-primary':'fa fa-download text-success'
            );
          }
        }
		

						//microdatapro 7.7 start - 1 - main
						if(!isset($data['microdatapro_data'])){
							$data['microdatapro_data'] = $product_info;
						}
						$this->document->setTc_og($this->load->controller('extension/module/microdatapro/tc_og', $data));
						$this->document->setTc_og_prefix($this->load->controller('extension/module/microdatapro/tc_og_prefix'));
						$data['microdatapro'] = $this->load->controller('extension/module/microdatapro/product', $data);
						$microdatapro_main_flag = 1;
						//microdatapro 7.7 end - 1 - main
					
			$this->model_catalog_product->updateViewed($this->request->get['product_id']);

				// << Related Options  
				$this->load->model('extension/liveopencart/related_options');
				$data = $this->model_extension_liveopencart_related_options->getProductControllerData( (!empty($data) ? $data : array()) );
				if ( $data['ro_installed'] && !empty($data['ro_scripts']) ) {
					foreach ( $data['ro_scripts'] as $ro_script ) {
						$this->document->addScript($ro_script);
					}
				}
				// >> Related Options
			
			

      // OCFilter Start
      if ($this->registry->get('ocfilter') && $this->ocfilter->startup()) {
        $this->ocfilter->api->setProductItemControllerData($data);
      }
      // OCFilter End
      

          // Intagration of Gallery RB Start 
          if(isset($data['description'])){
            $find_gallery_rb = preg_match_all('/\[\s*gallery_rb\s*id\s*=\s*\s*\d{1,}\s*\]/', $data['description'], $gallery_rb_matches); // Find [gallery_rb id=""]
            if($find_gallery_rb){
              $this->load->model('setting/module');
              
              foreach($gallery_rb_matches[0] as $gallery_rb){
                $find_gallery_rb_id = preg_match('/\d{1,}/', $gallery_rb, $gallery_rb_id_matches); //Find module ID
                $custom_module_info = $this->model_setting_module->getModule($gallery_rb_id_matches[0]);
                
                if($custom_module_info && $custom_module_info['status']){
                  $gallery_rb_html = $this->load->controller('extension/module/galleryrb', $custom_module_info);
                  $data['description'] = str_replace($gallery_rb, $gallery_rb_html, $data['description']);
                }
              } 
            }
          }
          // Intagration of Gallery RB END
        

						//microdatapro 7.7 start - 2 - extra
						if(!isset($microdatapro_main_flag) or isset($this->request->get['filter_ocfilter'])){
							if(isset($product_info) && $product_info){
								if(!isset($data['microdatapro_data'])){
									$data['microdatapro_data'] = $product_info;
								}
								$this->document->setTc_og($this->load->controller('extension/module/microdatapro/tc_og', $data));
								$this->document->setTc_og_prefix($this->load->controller('extension/module/microdatapro/tc_og_prefix'));
								$data['microdatapro'] = $this->load->controller('extension/module/microdatapro/product', $data);
								$microdatapro_main_flag = 1;
							}
						}
						//microdatapro 7.7 end - 2 - extra
					
			//product variant
            $data['variantproducts'] = $this->model_catalog_product->getProductVariantproducts($this->request->get['product_id']);

            foreach ($data['variantproducts'] as $k => $variantproduct) {
                if ($variantproduct['products']) {
                    foreach ($variantproduct['products'] as $j => $product) {
						
    				if ($product['pmtemplate'] == 'productpol') {
                        if ($product['image']) {
                            $image = $this->model_tool_imagequadr->resize($product['image'], 90, 90);
                        } else {
                            $image = false;
                        }
                     } elseif ($product['pmtemplate'] == 'productdver') {
                        if ($product['image']) {
                            $image = $this->model_tool_image->resize($product['image'], 60, 120);
                        } else {
                            $image = false;
                        }
                     } else {
                        if ($product['image']) {
                            $image = $this->model_tool_image->resize($product['image'], 90, 90);
                        } else {
                            $image = false;
                        }
                       }


                        $product['image'] = $image;
                     
						$product['href'] = $this->url->link('product/product', 'product_id=' . $product['product_id']);						
                        $data['variantproducts'][$k]['products'][$j] = $product;
                    }
                }
            }
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/variants.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/variants.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/variants.css');
		}		
    //product variant
          $data['column_left'] = $this->load->controller('common/column_left');	
		
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

				// BuyOneClick
					$this->load->model('setting/setting');
					$current_language_id = $this->config->get('config_language_id');

					$buyoneclick = $this->config->get('buyoneclick');
					$data['buyoneclick_name'] = isset($buyoneclick["name"][$current_language_id]) ? $buyoneclick["name"][$current_language_id] : '';
					$data['buyoneclick_status_product'] = $buyoneclick["status_product"];
					$data['buyoneclick_status_module'] = $buyoneclick["status_module"];

					$data['buyoneclick_ya_status'] 					= $buyoneclick['ya_status'];
					$data['buyoneclick_ya_counter'] 				= $buyoneclick['ya_counter'];
					$data['buyoneclick_ya_identificator'] 			= $buyoneclick['ya_identificator'];
					$data['buyoneclick_ya_identificator_send'] 		= $buyoneclick['ya_identificator_send'];
					$data['buyoneclick_ya_identificator_success'] 	= $buyoneclick['ya_identificator_success'];

					$data['buyoneclick_google_status'] 				= $buyoneclick['google_status'];
					$data['buyoneclick_google_category_btn'] 		= $buyoneclick['google_category_btn'];
					$data['buyoneclick_google_action_btn'] 			= $buyoneclick['google_action_btn'];
					$data['buyoneclick_google_category_send'] 		= $buyoneclick['google_category_send'];
					$data['buyoneclick_google_action_send'] 		= $buyoneclick['google_action_send'];
					$data['buyoneclick_google_category_success'] 	= $buyoneclick['google_category_success'];
					$data['buyoneclick_google_action_success'] 		= $buyoneclick['google_action_success'];

					$this->load->language('extension/module/buyoneclick');
					if (!isset($data['buyoneclick_name']) or $data['buyoneclick_name'] == '') {
						$data['buyoneclick_name'] = $this->language->get('buyoneclick_button');
					}
					$data['buyoneclick_text_loading'] = $this->language->get('buyoneclick_text_loading');
				// BuyOneClickEnd
				


			$this->load->language('extension/module/print_version');
			
			$this->response->setOutput($this->load->view('product/product', $data));
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');


      // OCFilter Start
      if ($this->registry->get('ocfilter') && $this->ocfilter->startup()) {
        $this->ocfilter->api->setProductItemControllerData($data);
      }
      // OCFilter End
      

          // Intagration of Gallery RB Start 
          if(isset($data['description'])){
            $find_gallery_rb = preg_match_all('/\[\s*gallery_rb\s*id\s*=\s*\s*\d{1,}\s*\]/', $data['description'], $gallery_rb_matches); // Find [gallery_rb id=""]
            if($find_gallery_rb){
              $this->load->model('setting/module');
              
              foreach($gallery_rb_matches[0] as $gallery_rb){
                $find_gallery_rb_id = preg_match('/\d{1,}/', $gallery_rb, $gallery_rb_id_matches); //Find module ID
                $custom_module_info = $this->model_setting_module->getModule($gallery_rb_id_matches[0]);
                
                if($custom_module_info && $custom_module_info['status']){
                  $gallery_rb_html = $this->load->controller('extension/module/galleryrb', $custom_module_info);
                  $data['description'] = str_replace($gallery_rb, $gallery_rb_html, $data['description']);
                }
              } 
            }
          }
          // Intagration of Gallery RB END
        

						//microdatapro 7.7 start - 2 - extra
						if(!isset($microdatapro_main_flag) or isset($this->request->get['filter_ocfilter'])){
							if(isset($product_info) && $product_info){
								if(!isset($data['microdatapro_data'])){
									$data['microdatapro_data'] = $product_info;
								}
								$this->document->setTc_og($this->load->controller('extension/module/microdatapro/tc_og', $data));
								$this->document->setTc_og_prefix($this->load->controller('extension/module/microdatapro/tc_og_prefix'));
								$data['microdatapro'] = $this->load->controller('extension/module/microdatapro/product', $data);
								$microdatapro_main_flag = 1;
							}
						}
						//microdatapro 7.7 end - 2 - extra
					
			//product variant
            $data['variantproducts'] = $this->model_catalog_product->getProductVariantproducts($this->request->get['product_id']);

            foreach ($data['variantproducts'] as $k => $variantproduct) {
                if ($variantproduct['products']) {
                    foreach ($variantproduct['products'] as $j => $product) {
						
    				if ($product['pmtemplate'] == 'productpol') {
                        if ($product['image']) {
                            $image = $this->model_tool_imagequadr->resize($product['image'], 90, 90);
                        } else {
                            $image = false;
                        }
                     } elseif ($product['pmtemplate'] == 'productdver') {
                        if ($product['image']) {
                            $image = $this->model_tool_image->resize($product['image'], 60, 120);
                        } else {
                            $image = false;
                        }
                     } else {
                        if ($product['image']) {
                            $image = $this->model_tool_image->resize($product['image'], 90, 90);
                        } else {
                            $image = false;
                        }
                       }


                        $product['image'] = $image;
                     
						$product['href'] = $this->url->link('product/product', 'product_id=' . $product['product_id']);						
                        $data['variantproducts'][$k]['products'][$j] = $product;
                    }
                }
            }
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/variants.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/variants.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/variants.css');
		}		
    //product variant
          $data['column_left'] = $this->load->controller('common/column_left');	
		
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

				// BuyOneClick
					$this->load->model('setting/setting');
					$current_language_id = $this->config->get('config_language_id');

					$buyoneclick = $this->config->get('buyoneclick');
					$data['buyoneclick_name'] = isset($buyoneclick["name"][$current_language_id]) ? $buyoneclick["name"][$current_language_id] : '';
					$data['buyoneclick_status_product'] = $buyoneclick["status_product"];
					$data['buyoneclick_status_module'] = $buyoneclick["status_module"];

					$data['buyoneclick_ya_status'] 					= $buyoneclick['ya_status'];
					$data['buyoneclick_ya_counter'] 				= $buyoneclick['ya_counter'];
					$data['buyoneclick_ya_identificator'] 			= $buyoneclick['ya_identificator'];
					$data['buyoneclick_ya_identificator_send'] 		= $buyoneclick['ya_identificator_send'];
					$data['buyoneclick_ya_identificator_success'] 	= $buyoneclick['ya_identificator_success'];

					$data['buyoneclick_google_status'] 				= $buyoneclick['google_status'];
					$data['buyoneclick_google_category_btn'] 		= $buyoneclick['google_category_btn'];
					$data['buyoneclick_google_action_btn'] 			= $buyoneclick['google_action_btn'];
					$data['buyoneclick_google_category_send'] 		= $buyoneclick['google_category_send'];
					$data['buyoneclick_google_action_send'] 		= $buyoneclick['google_action_send'];
					$data['buyoneclick_google_category_success'] 	= $buyoneclick['google_category_success'];
					$data['buyoneclick_google_action_success'] 		= $buyoneclick['google_action_success'];

					$this->load->language('extension/module/buyoneclick');
					if (!isset($data['buyoneclick_name']) or $data['buyoneclick_name'] == '') {
						$data['buyoneclick_name'] = $this->language->get('buyoneclick_button');
					}
					$data['buyoneclick_text_loading'] = $this->language->get('buyoneclick_text_loading');
				// BuyOneClickEnd
				

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}


			public function download() {

			$this->load->model('catalog/product');

			if (isset($this->request->get['download_id'])) {
			$download_id = $this->request->get['download_id'];
			} else {
			$download_id = 0;
			}

			if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
			} else {
			$product_id = 0;
			}

			$download_info = $this->model_catalog_product->getDownload($product_id, $download_id);

			if ($download_info) {
			$file = DIR_DOWNLOAD . $download_info['filename'];
			$mask = basename($download_info['mask']);

			if (!headers_sent()) {
			if (file_exists($file)) { 
      $finfo = new finfo(FILEINFO_MIME);
      $mime_type = $finfo->file($file);
			header('Content-Description: File Transfer');
			header('Content-Type: '.$mime_type); //application/octet-stream
			header('Content-Disposition: inline; filename="' . ($mask ? $mask : basename($file)) . '"');   //attachment
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));

			readfile($file, 'rb');

			//$this->model_account_download->updateRemaining($this->request->get['download_id']);

			exit;
			} else {
			exit('Error: Could not find file ' . $file . '!');
			}
			} else {
			exit('Error: Headers already sent out!');
			}
			} else {
			$this->redirect(HTTP_SERVER . 'index.php?route=account/download');
			}
			}
		
	public function review() {
		$this->load->language('product/product');

				$this->load->language('stroimarket/stroimarket');
			

		$this->load->model('catalog/review');

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['reviews'] = array();

		$review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);

		$results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);

		foreach ($results as $result) {
			$data['reviews'][] = array(

				'answer'       => $result['answer'],
			
				'author'     => $result['author'],
				'text'       => nl2br($result['text']),
				'rating'     => (int)$result['rating'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$pagination = new Pagination();
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = 5;
		$pagination->url = $this->url->link('product/product/review', 'product_id=' . $this->request->get['product_id'] . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($review_total - 5)) ? $review_total : ((($page - 1) * 5) + 5), $review_total, ceil($review_total / 5));

		$this->response->setOutput($this->load->view('product/review', $data));
	}

	public function write() {
		$this->load->language('product/product');

				$this->load->language('stroimarket/stroimarket');
			

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}

			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}

			if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
				$json['error'] = $this->language->get('error_rating');
			}

			// Captcha
			if ($this->config->get('captcha_' . $this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
				$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

				if ($captcha) {
					$json['error'] = $captcha;
				}
			}

			if (!isset($json['error'])) {
				$this->load->model('catalog/review');

				$this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function getRecurringDescription() {
		$this->load->language('product/product');

				$this->load->language('stroimarket/stroimarket');
			
		$this->load->model('catalog/product');

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		if (isset($this->request->post['recurring_id'])) {
			$recurring_id = $this->request->post['recurring_id'];
		} else {
			$recurring_id = 0;
		}

		if (isset($this->request->post['quantity'])) {
			$quantity = $this->request->post['quantity'];
		} else {
			$quantity = 1;
		}

		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		$recurring_info = $this->model_catalog_product->getProfile($product_id, $recurring_id);

		$json = array();

		if ($product_info && $recurring_info) {
			if (!$json) {
				$frequencies = array(
					'day'        => $this->language->get('text_day'),
					'week'       => $this->language->get('text_week'),
					'semi_month' => $this->language->get('text_semi_month'),
					'month'      => $this->language->get('text_month'),
					'year'       => $this->language->get('text_year'),
				);

				if ($recurring_info['trial_status'] == 1) {
					$price = $this->currency->format($this->tax->calculate($recurring_info['trial_price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$trial_text = sprintf($this->language->get('text_trial_description'), $price, $recurring_info['trial_cycle'], $frequencies[$recurring_info['trial_frequency']], $recurring_info['trial_duration']) . ' ';
				} else {
					$trial_text = '';
				}

				$price = $this->currency->format($this->tax->calculate($recurring_info['price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

				if ($recurring_info['duration']) {
					$text = $trial_text . sprintf($this->language->get('text_payment_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
				} else {
					$text = $trial_text . sprintf($this->language->get('text_payment_cancel'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
				}

				$json['success'] = $text;
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
