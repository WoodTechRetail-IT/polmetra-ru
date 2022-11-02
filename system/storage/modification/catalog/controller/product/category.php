<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerProductCategory extends Controller {
	public function index() {

			$this->document->addStyle('catalog/view/theme/default/stylesheet/priceview.css');
			$this->document->addScript('catalog/view/javascript/priceview.js');
			
		$this->load->language('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

				$this->load->language('stroimarket/stroimarket');
			
		$this->load->model('tool/imagequadr');


		$data['text_empty'] = $this->language->get('text_empty');

        if ($this->config->get('config_noindex_disallow_params')) {
            $params = explode ("\r\n", $this->config->get('config_noindex_disallow_params'));
            if(!empty($params)) {
                $disallow_params = $params;
            }
        }

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
			if (!in_array('filter', $disallow_params, true) && $this->config->get('config_noindex_status')){
                $this->document->setRobots('noindex,follow');
            }
		} else {
			$filter = '';
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
			$limit = $this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['path'])) {
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			
        if (!empty($this->request->get['fly_page_id'])) {
            $category_id = -1;
        } else {
            $category_id = (int)array_pop($parts);
        }
      

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path . $url)
					);
				}
			}
		} else {
			$category_id = 0;
		}

		
        if (!empty($this->request->get['fly_page_id'])) {
            $this->load->model('extension/module/fly_pages');
            $category_info = $this->model_extension_module_fly_pages->getPage($this->request->get['fly_page_id']);
            $category_info['category_id'] = -1;
            $category_info['noindex'] = 1;
            $category_id = -1;
            $this->request->get['path'] = '';
            $data['is_fly_page'] = 1;
            $category_info['description_bottom'] = '';

            /*
            if ($category_info['parent_category_id'] == 0 && $category_info['parent_manufacturer_id'] != 0) {
                $this->load->model('catalog/manufacturer');
                $this->load->language('product/manufacturer');
                $data['breadcrumbs'][] = array(
                    'text' => $this->language->get('text_brand'),
                    'href' => $this->url->link('product/manufacturer')
                );
                $parent_manufacturer = $this->model_catalog_manufacturer->getManufacturer($category_info['parent_manufacturer_id']);      
                if ($parent_manufacturer) {
                    $data['breadcrumbs'][] = array(
                        'text' => $parent_manufacturer['name'],
                        'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $parent_manufacturer['manufacturer_id'])
                    );
                }
            }
            */
        } else {
            $category_info = $this->model_catalog_category->getCategory($category_id);
            $data['is_fly_page'] = 0;
        }
      

		if ($category_info) {

			// Seo Tags Generator.Begin
			$category_info = $this->load->controller('extension/module/seo_tags_generator/getCategoryTags', $category_info);
			// Seo Tags Generator.End
			
			if ($category_info['meta_title']) {
				$this->document->setTitle($category_info['meta_title']);
			} else {
				$this->document->setTitle($category_info['name']);
			}

			if ($category_info['noindex'] <= 0 && $this->config->get('config_noindex_status')) {
				$this->document->setRobots('noindex,follow');
			}

			if ($category_info['meta_h1']) {
				$data['heading_title'] = $category_info['meta_h1'];
			} else {
				$data['heading_title'] = $category_info['name'];
			}

			if ($category_info['noviewchild']) {
				$data['noviewchild'] = $category_info['noviewchild'];
			}

			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);

			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

			// Set the last category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $category_info['name'],
				'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'])
			);

 
				if ($category_info['banner']) {
					$data['banner'] = $this->model_tool_image->resize($category_info['banner'], $this->config->get('theme_' . $this->config->get('config_theme') . '_banner_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_banner_category_height'));
				} else {
					$data['banner'] = '';
				} 
			

        if (!empty($this->request->get['fly_page_id'])) {
            array_pop($data['breadcrumbs']);
            $data['breadcrumbs'][] = array(
                'text' => $category_info['name'],
                'href' => $this->url->link('product/category', 'fly_page_id=' . $this->request->get['fly_page_id'])
            );
        }
      

		if ($category_info['hd_description']) {
		if (!isset($this->request->get['page']) || $this->request->get['page'] == 1) {
	  
			if ($category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height'));
			} else {
				$data['thumb'] = '';
			}


		  }else{
			$data['thumb'] = '';
		  }
		}else{
		  if ($category_info['image']) {
			$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height'));
		  } else {
			$data['thumb'] = '';
		  }
		}
	  
			
		$data['rm_description'] = $category_info['rm_description'];
		$data['ht_description'] = $category_info['ht_description'];
		$data['ht_ext_description'] = $category_info['ht_ext_description'];
		$data['rm_ext_description'] = $category_info['rm_ext_description'];
		$data['rmm_ext_description'] = $category_info['rmm_ext_description'];

		if ($category_info['hd_description']) {
		  if (!isset($this->request->get['page']) || $this->request->get['page'] == 1) {
			$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
		  }else{
			$data['description'] = '';
		  }
		}else{
		  $data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
		}

		if ($category_info['hd_ext_description']) {
		  if (!isset($this->request->get['page']) || $this->request->get['page'] == 1) {
			$data['ext_description'] = html_entity_decode($category_info['ext_description'], ENT_QUOTES, 'UTF-8');
		  }else{
			$data['ext_description'] = '';
		  }
		}else{
		  $data['ext_description'] = html_entity_decode($category_info['ext_description'], ENT_QUOTES, 'UTF-8');
		}
	  
			$data['compare'] = $this->url->link('product/compare');

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['categories'] = array();

			$results = $this->model_catalog_category->getCategories($category_id);

			foreach ($results as $result) {
				$filter_data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true
				);

 
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 150, 150);
				} else {
					$image = false;
				} 
			
				$data['categories'][] = array(
 
				'thumb' => $image, 
			
					 
				'name'  		=> $result['name'],				
				'count' 	 	=> $this->model_catalog_product->getTotalProducts($filter_data),
				'config_count'  => $this->config->get('config_product_count'),
			
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
				);
			}

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
				'filter_category_id' => $category_id,
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);

        if (!empty($this->request->get['fly_page_id']) && isset($category_info['setting']['type'])) {
            unset($filter_data['filter_category_id']);
            $language_id = $this->config->get('config_language_id');
        
            if ($category_info['setting']['type'] == 'search') {
                $filter_data['filter_name'] = isset($category_info['setting']['search'][$language_id]) ? $category_info['setting']['search'][$language_id] : '';
                $filter_data['filter_tag'] = $filter_data['filter_name'];
            } else if ($category_info['setting']['type'] == 'tag') {
                $filter_data['filter_tag'] = isset($category_info['setting']['tag'][$language_id]) ? $category_info['setting']['tag'][$language_id] : '';
            } else if ($category_info['setting']['type'] == 'list') {
                $filter_data['filter_product_id'] = isset($category_info['setting']['products']) ? $category_info['setting']['products'] : array();
            }
            
            if (!empty($category_info['setting']['category'])) {
                $filter_data['filter_category_id'] = $category_info['setting']['category'];
            }
            if (!empty($category_info['setting']['manufacturer'])) {
                $filter_data['filter_manufacturer_id'] = $category_info['setting']['manufacturer'];
            }

            if (!empty($category_info['setting']['attribute'])) {
                $filter_data['attributes'] = array();
                foreach ($category_info['setting']['attribute'] as $attribute) {
                    if (!empty($attribute['value'])) {
                        $filter_data['attributes'][$attribute['attribute_id']][] = $attribute['value'];
                    }
                }
            }
        }
      


      // OCFilter start
      if ($this->registry->get('ocfilter') && $this->ocfilter->startup() && $this->ocfilter->api->useSubCategory() && $this->ocfilter->api->isSelected() && empty($filter_data['filter_sub_category'])) {
        $filter_data['filter_sub_category'] = true;
      }
      // OCFilter end
      
			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
    				if ($result['pmtemplate'] == 'productpol') {
                    if ($result['image']) {
                        $image = $this->model_tool_imagequadr->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                    } else {
                        $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                    }
                    } elseif ($result['pmtemplate'] == 'productdver') {
                        if ($result['image']) {
                            $image = $this->model_tool_image->resize($result['image'], 140, 285);
                        } else {
                            $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                        }
                        
                    } else {
                    if ($result['image']) {
                        $image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                    } else {
                        $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                    }
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
					'pmtemplate'        => $result['pmtemplate'],
					'description' => utf8_substr(trim(strip_tags(html_entity_decode(
          preg_replace('/\[\s*gallery_rb\s*id\s*=\s*\s*\d{1,}\s*\]/', '', $result['description'])
        , ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url)
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
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
      
			$data['sorts'] = array();

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
			);

			if ($this->config->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
				);
			}

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
			);

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

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
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

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
					$data['microdatapro_data'] = $category_info;
					$data_mpd = $data;
					$data_mpd['results'] = $results;
					$this->document->setTc_og($this->load->controller('extension/module/microdatapro/tc_og', $data_mpd));
					$this->document->setTc_og_prefix($this->load->controller('extension/module/microdatapro/tc_og_prefix'));
					$data['microdatapro'] = $this->load->controller('extension/module/microdatapro/category', $data_mpd);
					$microdatapro_main_flag = 1;
					//microdatapro 7.7 end - 1 - main
				
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			
        if (!empty($this->request->get['fly_page_id'])) {
            $pagination->url = $this->url->link('product/category', 'fly_page_id=' . $this->request->get['fly_page_id'] . $url . '&page={page}');
        } else {
            $pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');
        }
      

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

            if (!$this->config->get('config_canonical_method')) {
                // http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
                if ($page == 1) {
                    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id']), 'canonical');
                } elseif ($page == 2) {
                    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id']), 'prev');
                } else {
                    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page=' . ($page - 1)), 'prev');
                }

                if ($limit && ceil($product_total / $limit) > $page) {
                    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page=' . ($page + 1)), 'next');
                }
            } else {

                if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
                    $server = $this->config->get('config_ssl');
                } else {
                    $server = $this->config->get('config_url');
                };

                $request_url = rtrim($server, '/') . $this->request->server['REQUEST_URI'];
                $canonical_url = $this->url->link('product/category', 'path=' . $category_info['category_id']);

                if (($request_url != $canonical_url) || $this->config->get('config_canonical_self')) {
                    $this->document->addLink($canonical_url, 'canonical');
                }

                if ($this->config->get('config_add_prevnext')) {

                    if ($page == 2) {
                        $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id']), 'prev');
                    } elseif ($page > 2)  {
                        $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page=' . ($page - 1)), 'prev');
                    }

                    if ($limit && ceil($product_total / $limit) > $page) {
                        $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page=' . ($page + 1)), 'next');
                    }
                }
            }

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

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
						if(isset($category_info) && $category_info){
							$data['microdatapro_data'] = $category_info;
							$data_mpd = $data;
							$data_mpd['results'] = $results;
							$this->document->setTc_og($this->load->controller('extension/module/microdatapro/tc_og', $data_mpd));
							$this->document->setTc_og_prefix($this->load->controller('extension/module/microdatapro/tc_og_prefix'));
							$data['microdatapro'] = $this->load->controller('extension/module/microdatapro/category', $data_mpd);
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
        $fly_pages = $this->model_extension_module_fly_pages->getPagesByCategory($category_info['category_id']);
        
        if ($fly_pages) {
            $page_as_tag = array();
            $page_as_category = array();
            
            $config_image_category_width = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width');
            $config_image_category_height = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height');
        
            foreach ($fly_pages as $fly_page) {
                if (!isset($fly_page['setting']['category_link']) || $fly_page['setting']['category_link'] == 'tag') {
                    $page_as_tag[] = array(
                        'name'      => $fly_page['name'],
                        'href'      => $this->url->link('product/category', 'fly_page_id=' . $fly_page['fly_page_id'])
                    );
                } else {
                    if ($fly_page['setting']['category_link'] == 'replace_subcategory') $data['categories'] = array();
                    
                    if ($fly_page['image'] && file_exists(DIR_IMAGE . $fly_page['image'])) {
                        $image = $this->model_tool_image->resize($fly_page['image'], $config_image_category_width, $config_image_category_height);
                    } else {
                        $image = $this->model_tool_image->resize('placeholder.png', $config_image_category_width, $config_image_category_height);
                    }

                    if (defined('JOURNAL3_ACTIVE')) {
                        $page_as_category[] = array(
                            'name'  => $fly_page['name'],
                            'image' => $this->model_journal3_image->resize($fly_page['image'], $this->journal3->settings->get('image_dimensions_subcategory.width'), $this->journal3->settings->get('image_dimensions_subcategory.height'), $this->journal3->settings->get('image_dimensions_subcategory.resize')),
                            'image2x' => $this->model_journal3_image->resize($fly_page['image'], $this->journal3->settings->get('image_dimensions_subcategory.width') * 2, $this->journal3->settings->get('image_dimensions_subcategory.height') * 2, $this->journal3->settings->get('image_dimensions_subcategory.resize')),
                            'alt' => $fly_page['name'],
                            'href'      => $this->url->link('product/category', 'fly_page_id=' . $fly_page['fly_page_id'])
                        );
                    } else {
                        $page_as_category[] = array(
                            'thumb'     => $image,
                            'image'     => $image,
                            'name'      => $fly_page['name'],
                            'href'      => $this->url->link('product/category', 'fly_page_id=' . $fly_page['fly_page_id'])
                        );
                    }
                }
            }
            
            $data['categories'] = array_merge($data['categories'], $page_as_category);
            $data['tag_pages'] = $page_as_tag;
        }
      
			$this->response->setOutput($this->load->view('product/category', $data));
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
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
				'href' => $this->url->link('product/category', $url)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');


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
						if(isset($category_info) && $category_info){
							$data['microdatapro_data'] = $category_info;
							$data_mpd = $data;
							$data_mpd['results'] = $results;
							$this->document->setTc_og($this->load->controller('extension/module/microdatapro/tc_og', $data_mpd));
							$this->document->setTc_og_prefix($this->load->controller('extension/module/microdatapro/tc_og_prefix'));
							$data['microdatapro'] = $this->load->controller('extension/module/microdatapro/category', $data_mpd);
						}
					}
					//microdatapro 7.7 end - 2 - extra
				
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}
}
