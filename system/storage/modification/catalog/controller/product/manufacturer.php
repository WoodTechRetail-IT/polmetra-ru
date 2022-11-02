<?php
class ControllerProductManufacturer extends Controller {
	public function index() {

			$this->document->addStyle('catalog/view/theme/default/stylesheet/priceview.css');
			$this->document->addScript('catalog/view/javascript/priceview.js');
			
		$this->load->language('product/manufacturer');

		$this->load->model('catalog/manufacturer');

				$this->load->model('tool/image');
			

		$this->load->model('tool/image');

				$this->load->language('stroimarket/stroimarket');
			

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_brand'),
			'href' => $this->url->link('product/manufacturer')
		);

		$data['categories'] = array();

		$results = $this->model_catalog_manufacturer->getManufacturers();

		foreach ($results as $result) {
			if (is_numeric(utf8_substr($result['name'], 0, 1))) {
				$key = '0 - 9';
			} else {
				$key = utf8_substr(utf8_strtoupper($result['name']), 0, 1);
			}

			if (!isset($data['categories'][$key])) {
				$data['categories'][$key]['name'] = $key;
			}

			$data['categories'][$key]['manufacturer'][] = array(

				'image' => $this->model_tool_image->resize($result['image'], 200, 200),
			
				'name' => $result['name'],
				'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'])
			);
		}

		$data['continue'] = $this->url->link('common/home');


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
					if(!isset($microdatapro_main_flag)){
						if(isset($manufacturer_info) && $manufacturer_info){
							$data['microdatapro_data'] = $manufacturer_info;
							$this->document->setTc_og($this->load->controller('extension/module/microdatapro/tc_og', $data));
							$this->document->setTc_og_prefix($this->load->controller('extension/module/microdatapro/tc_og_prefix'));
							$data['microdatapro'] = $this->load->controller('extension/module/microdatapro/manufacturer', $data);
						}
					}
					//microdatapro 7.7 end - 2 - extra
				
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('product/manufacturer_list', $data));
	}

	public function info() {
		$this->load->language('product/manufacturer');

		$this->load->model('catalog/manufacturer');

				$this->load->model('tool/image');
			

		$this->load->model('catalog/product');

    // OCDepartment start
		if (isset($this->request->get['filter_category_id'])) {
			$filter_category_id = $this->request->get['filter_category_id'];
		} else {
			$filter_category_id = 0;
		}
    // OCDepartment end
      

		$this->load->model('tool/image');

				$this->load->language('stroimarket/stroimarket');
			

		if (isset($this->request->get['manufacturer_id'])) {
			$manufacturer_id = (int)$this->request->get['manufacturer_id'];
		} else {
			$manufacturer_id = 0;
		}

        if ($this->config->get('config_noindex_disallow_params')) {
            $params = explode ("\r\n", $this->config->get('config_noindex_disallow_params'));
            if(!empty($params)) {
                $disallow_params = $params;
            }
        }

        if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
            if (!in_array('sort', $disallow_params, true) && $this->config->get('config_noindex_status')) {
                $this->document->setRobots('noindex,follow');
            }
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
            if (!in_array('order', $disallow_params, true) && $this->config->get('config_noindex_status')) {
                $this->document->setRobots('noindex,follow');
            }
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
            if (!in_array('page', $disallow_params, true) && $this->config->get('config_noindex_status')) {
                $this->document->setRobots('noindex,follow');
            }
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
            if (!in_array('limit', $disallow_params, true) && $this->config->get('config_noindex_status')) {
                $this->document->setRobots('noindex,follow');
            }
		} else {
			$limit = (int)$this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_brand'),
			'href' => $this->url->link('product/manufacturer')
		);

		$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);

		if ($manufacturer_info) {
			// Seo Tags Generator.Begin
			$manufacturer_info = $this->load->controller('extension/module/seo_tags_generator/getManufacturerTags', $manufacturer_info);
			// Seo Tags Generator.End
			

			if ($manufacturer_info['meta_title']) {
				$this->document->setTitle($manufacturer_info['meta_title']);
			} else {
				//$this->document->setTitle($manufacturer_info['name']);

			// Seo Tags Generator.Begin
			if (isset($manufacturer_info['meta_title'])) $this->document->setTitle($manufacturer_info['meta_title']);
			if (isset($manufacturer_info['meta_description'])) $this->document->setDescription($manufacturer_info['meta_description']);
			if (isset($manufacturer_info['meta_keyword'])) $this->document->setKeywords($manufacturer_info['meta_keyword']);
			// Seo Tags Generator.End
			}

			if ($manufacturer_info['noindex'] <= 0 && $this->config->get('config_noindex_status')) {
				$this->document->setRobots('noindex,follow');
			}

			if ($manufacturer_info['meta_h1']) {
				$data['heading_title'] = $manufacturer_info['meta_h1'];
			} else {
				$data['heading_title'] = $manufacturer_info['name'];
			}

			$this->document->setDescription($manufacturer_info['meta_description']);
			$this->document->setKeywords($manufacturer_info['meta_keyword']);
			$data['description'] = html_entity_decode($manufacturer_info['description'], ENT_QUOTES, 'UTF-8');


			if ($manufacturer_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($manufacturer_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_manufacturer_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_manufacturer_height'));
			} else {
				$data['thumb'] = '';
			}

			$url = '';

    // OCDepartment start
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
    // OCDepartment end
      

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
				'text' => $manufacturer_info['name'],
				'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url)
			);

			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

			$data['compare'] = $this->url->link('product/compare');

			$data['products'] = array();

				function product($number, $suffix) {
					$keys = array(2, 0, 1, 1, 1, 2);
					$mod = $number % 100;
					$suffix_key = ($mod > 7 && $mod < 20) ? 2: $keys[min($mod % 10, 5)];
					return $suffix[$suffix_key];
				}
				$text_review_array = array('text_reviews_1', 'text_reviews_2', 'text_reviews_3');
			
 
				$data['quantity_btn'] 	= $this->config->get('config_catalog_quantity');
				$data['review_status'] 	= $this->config->get('config_review_status');
				$data['shadow_title'] 	= $this->config->get('config_shadow_title');
			

			$filter_data = array(

        // OCDepartment start
        'filter_category_id' => $filter_category_id,
        // OCDepartment end
      
				'filter_manufacturer_id' => $manufacturer_id,
				'sort'                   => $sort,
				'order'                  => $order,
				'start'                  => ($page - 1) * $limit,
				'limit'                  => $limit
			);

			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
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
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				
                $results_img = $this->model_catalog_product->getProductImages($result['product_id']);
                $additional_img = array();
                foreach ($results_img as $result_img) {
                    if ($result_img['image']) {
                        $additional_image = $this->model_tool_image->resize($result_img['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                    } else {
                        $additional_image = false;
                    }
                    $additional_img[] = $additional_image;
                }
            

				$data['reviews_count'] = $reviews_count = (int)$result['reviews'];				
				$text_review = product($reviews_count, $text_review_array);
				if ($result['quantity'] <= 0) {
					$data['stock'] = $result['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$data['stock'] = $result['quantity'];
				} else {
					$data['stock'] = $this->language->get('text_instock');
				}
			

				$this->load->model('catalog/manufacturer');

				$this->load->model('tool/image');
			
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
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/product', 'manufacturer_id=' . $result['manufacturer_id'] . '&product_id=' . $result['product_id'] . $url)
				);
			}

			$url = '';

    // OCDepartment start
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
    // OCDepartment end
      

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}


      // OCFilter start
      if (isset($url) && $this->registry->get('ocfilter') && $this->ocfilter->startup() && $this->ocfilter->api->isSelected()) {
        $url .= '&' . $this->ocfilter->api->getParamsIndex() . '=' . $this->ocfilter->api->getParamsString();
        
        if (isset($this->request->get['ocfilter_placement'])) {
          $url .= '&ocfilter_placement=' . $this->request->get['ocfilter_placement'];
        }
      }
      // OCFilter end
      
			$data['sorts'] = array();

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=DESC' . $url)
			);

			if ($this->config->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=DESC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=ASC' . $url)
				);
			}

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.model&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.model&order=DESC' . $url)
			);

			$url = '';

    // OCDepartment start
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
    // OCDepartment end
      

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}


      // OCFilter start
      if (isset($url) && $this->registry->get('ocfilter') && $this->ocfilter->startup() && $this->ocfilter->api->isSelected()) {
        $url .= '&' . $this->ocfilter->api->getParamsIndex() . '=' . $this->ocfilter->api->getParamsString();
        
        if (isset($this->request->get['ocfilter_placement'])) {
          $url .= '&ocfilter_placement=' . $this->request->get['ocfilter_placement'];
        }        
      }
      // OCFilter end
      
			$data['limits'] = array();

			$limits = array_unique(array($this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&limit=' . $value)
				);
			}

			$url = '';

    // OCDepartment start
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
    // OCDepartment end
      

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}


      // OCFilter start
      if (isset($url) && $this->registry->get('ocfilter') && $this->ocfilter->startup() && $this->ocfilter->api->isSelected()) {
        $url .= '&' . $this->ocfilter->api->getParamsIndex() . '=' . $this->ocfilter->api->getParamsString();
        
        if (isset($this->request->get['ocfilter_placement'])) {
          $url .= '&ocfilter_placement=' . $this->request->get['ocfilter_placement'];
        }        
      }
      // OCFilter end
      

					//microdatapro 7.7 start - 1 - main
					$data['microdatapro_data'] = $manufacturer_info;
					$this->document->setTc_og($this->load->controller('extension/module/microdatapro/tc_og', $data));
					$this->document->setTc_og_prefix($this->load->controller('extension/module/microdatapro/tc_og_prefix'));
					$data['microdatapro'] = $this->load->controller('extension/module/microdatapro/manufacturer', $data);
					$microdatapro_main_flag = 1;
					//microdatapro 7.7 end - 1 - main
				
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] .  $url . '&page={page}');

			$data['pagination'] = $pagination->render();

    // OCDepartment start
		$ocd_url = '';

		if (isset($this->request->get['filter_category_id'])) {
			$ocd_url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
    // OCDepartment end
      

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

            if (!$this->config->get('config_canonical_method')) {
                // http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
                if ($page == 1) {
                    $this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id']), 'canonical');
                } elseif ($page == 2) {
                    $this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id']), 'prev');
                } else {
                    $this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&page=' . ($page - 1)), 'prev');
                }

                if ($limit && ceil($product_total / $limit) > $page) {
                    $this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&page=' . ($page + 1)), 'next');
                }
            } else {
                if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
                    $server = $this->config->get('config_ssl');
                } else {
                    $server = $this->config->get('config_url');
                };

                $request_url = rtrim($server, '/') . $this->request->server['REQUEST_URI'];
                $canonical_url = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id']);

                if (($request_url != $canonical_url) || $this->config->get('config_canonical_self')) {
                    $this->document->addLink($canonical_url, 'canonical');
                }

                if ($this->config->get('config_add_prevnext')) {

                    if ($page == 2) {
                        $this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id']), 'prev');
                    } elseif ($page > 2)  {
                        $this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&page=' . ($page - 1)), 'prev');
                    }

                    if ($limit && ceil($product_total / $limit) > $page) {
                        $this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&page=' . ($page + 1)), 'next');
                    }
                }
            }

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

    // OCDepartment start
    $this->load->model('catalog/category');

    $category_info = $this->model_catalog_category->getCategory($filter_category_id);

    if ($category_info) {
      $this->document->setTitle($category_info['name'] . ' ' . $this->document->getTitle());

      $data['heading_title'] = $category_info['name'] . ' ' . $data['heading_title'];
    }
    // OCDepartment end
      

      // OCFilter Start
      if ($this->registry->get('ocfilter') && $this->ocfilter->startup()) {
        $this->ocfilter->api->setProductListControllerData($data, (isset($product_total) ? $product_total : null));
      }
      // OCFilter End
      

			$data['continue'] = $this->url->link('common/home');


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
					if(!isset($microdatapro_main_flag)){
						if(isset($manufacturer_info) && $manufacturer_info){
							$data['microdatapro_data'] = $manufacturer_info;
							$this->document->setTc_og($this->load->controller('extension/module/microdatapro/tc_og', $data));
							$this->document->setTc_og_prefix($this->load->controller('extension/module/microdatapro/tc_og_prefix'));
							$data['microdatapro'] = $this->load->controller('extension/module/microdatapro/manufacturer', $data);
						}
					}
					//microdatapro 7.7 end - 2 - extra
				
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');


        $this->load->model('extension/module/fly_pages');
        $fly_pages = $this->model_extension_module_fly_pages->getPagesByManufacturer($manufacturer_info['manufacturer_id']);
        
        if ($fly_pages) {
            $html = '<div class="row fly-page-tags">';
            foreach ($fly_pages as $fly_page) {
                $fly_page_href = $this->url->link('product/category', 'fly_page_id=' . $fly_page['fly_page_id']);
                $html .= '<div class="col-sm-3 col-md-2">';
                if (!empty($fly_page['image'])) {
                    $fly_page_thumb = $this->model_tool_image->resize($fly_page['image'], 200, 200);
                    $html .= '<div class="image"><a href="' . $fly_page_href . '"><img src="' . $fly_page_thumb . '" alt="' . $fly_page['name'] . '" title="' . $fly_page['name'] . '" class="img-responsive" /></a></div>';
                } else {
                    $html .= '<a href="' . $fly_page_href . '">' . $fly_page['name'] . '</a>';
                }
                $html .= '</div>';
            }
            $html .= '</div>';
            $data['content_top'] .= $html;
        }
      
			$this->response->setOutput($this->load->view('product/manufacturer_info', $data));
		} else {
			$url = '';

    // OCDepartment start
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
    // OCDepartment end
      

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
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
				'href' => $this->url->link('product/manufacturer/info', $url)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');

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
					if(!isset($microdatapro_main_flag)){
						if(isset($manufacturer_info) && $manufacturer_info){
							$data['microdatapro_data'] = $manufacturer_info;
							$this->document->setTc_og($this->load->controller('extension/module/microdatapro/tc_og', $data));
							$this->document->setTc_og_prefix($this->load->controller('extension/module/microdatapro/tc_og_prefix'));
							$data['microdatapro'] = $this->load->controller('extension/module/microdatapro/manufacturer', $data);
						}
					}
					//microdatapro 7.7 end - 2 - extra
				
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}
}
