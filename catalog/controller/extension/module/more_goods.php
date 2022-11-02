<?php
class ControllerExtensionModuleMoreGoods extends Controller {
	
    private $more_goods = 'more_goods';
	
	public function index($setting) {
		
		$theme = $this->config->get('config_theme');
		
		if (file_exists(DIR_TEMPLATE . $theme . '/stylesheet/more-goods.css')) {
			$this->document->addStyle('catalog/view/theme/' . $theme . '/stylesheet/more-goods.css?ver=1.2');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/more-goods.css?ver=1.2');
		}

		$this->load->language('extension/module/' . $this->more_goods);
		
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$data['more_products'] = array();
		$data['modul_id']      = '';
				
		if( isset($setting['modul_id']) ) {
			$data['modul_id'] = $setting['modul_id'];
		}
		
		if( !$setting['limit'] ) {
			$setting['limit'] = 8;
		}
		
		if( !$setting['limitload'] ) {
			$setting['limitload'] = 8;
		}
		
		if( !$setting['line'] ) {
			$setting['line'] = 4;
		}
		
		if( $setting['status_rand'] && $setting['status_rand'] > 0 ) {
			
			$this->load->model('extension/module/' . $this->more_goods);
			
			$total_product = $this->model_catalog_product->getTotalProducts();
			$new_total     = $total_product - $setting['limit'] - 2;
			
			$filter = array(
			    'start' => rand(0, $new_total),
			    'limit' => $setting['limit']
		    );
			
			$results = $this->model_extension_module_more_goods->getRandProducts($filter);
			
		} else {
			
			if( $setting['view'] == 1 ) {
			    $orderby = 'ASC';
		    } else {
			    $orderby = 'DESC';
		    }
			
			$filter_data = array(
			    'sort'  => 'p.date_added',
			    'order' => $orderby,
			    'start' => 0,
			    'limit' => $setting['limit']
		    );
			
			$results = $this->model_catalog_product->getProducts($filter_data);
		}
		
		$data['head_name']         = $setting['head_name'];
		$data['instart_from']      = $setting['limit'];
		$data['instart_from_load'] = $setting['limitload'];
		
		switch( $setting['line'] ) {
			
			case 2 :
			    $data['swdcol'] = 'swd-md-6';
			break;
			case 3 :
			    $data['swdcol'] = 'swd-md-4';
			break;
			case 4 :
			    $data['swdcol'] = 'swd-md-3';
			break;
			case 6 :
			    $data['swdcol'] = 'swd-md-2';
			break;
			default:
			    $data['swdcol'] = 'swd-md-4';
			break;
		}
		
		
		$data['thumbr_class'] = 'swdthumb-class';
		$data['swd_scroll']   = $setting['scroll'];
		
		
		if( $results ) {
			
			$width  = $setting['width'];
		    $height = $setting['height'];
			
			foreach( $results as $result ) {
				
				if( $result['image'] ) {
                   $image = $this->model_tool_image->resize($result['image'], $width, $height);
				} else {
                   $image = $this->model_tool_image->resize('placeholder.png', $width, $height);
				}
				
				if( $this->customer->isLogged() || !$this->config->get('config_customer_price') ) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if( (float)$result['special'] ) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if( $this->config->get('config_tax') ) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if( $this->config->get('config_review_status') ) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
				

				$data['more_products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}
			
			//////////////////////////////////////////////////////////////
		    if( $this->request->server['HTTPS'] ) {
		    	$server = $this->config->get('config_ssl');
		    } else {
		        $server = $this->config->get('config_url');
		    }
		
		    $data['loadgif']  = $server . 'catalog/view/theme/' . $theme . '/image/loading-moregoods.gif';
			$data['loading_more_btn'] = $this->language->get('loading_more_btn');
			$data['error_view_js']    = $this->language->get('error_view_js');
		    //////////////////////////////////////////////////////////////

			return $this->load->view('extension/module/' . $this->more_goods, $data);
		}
	}
	
	
	public function load_more($id, $start) {
		
        $this->load->model('setting/module');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$data['more_products'] = array();
		
		$module_info = $this->model_setting_module->getModule($id);
		
		if( !$module_info['limit'] ) {
			$module_info['limit'] = 8;
		}
		
		if( !$module_info['limitload'] ) {
			$module_info['limitload'] = 8;
		}
		
		if( !$module_info['line'] ) {
			$module_info['line'] = 4;
		}
		//================================
		if( $module_info['status_rand'] && $module_info['status_rand'] > 0 ) {
			
			$this->load->model('extension/module/' . $this->more_goods);
			
			$total_product = $this->model_catalog_product->getTotalProducts();
			$new_total     = $total_product - $module_info['limitload'] - 2;
			
			$filter = array(
			    'start' => rand(0, $new_total),
			    'limit' => $module_info['limitload']
		    );
			
			$results = $this->model_extension_module_more_goods->getRandProducts($filter);
			
		} else {
			
			if( $module_info['view'] == 1 ) {
			    $orderby = 'ASC';
		    } else {
			    $orderby = 'DESC';
		    }
			
			$filter_data = array(
			    'sort'  => 'p.date_added',
			    'order' => $orderby,
			    'start' => $start,
			    'limit' => $module_info['limitload']
		    );
			
			$results = $this->model_catalog_product->getProducts($filter_data);
		}
	
		
		switch( $module_info['line'] ) {
			
			case 2 :
			    $data['swdcol'] = 'swd-md-6';
			break;
			case 3 :
			    $data['swdcol'] = 'swd-md-4';
			break;
			case 4 :
			    $data['swdcol'] = 'swd-md-3';
			break;
			case 6 :
			    $data['swdcol'] = 'swd-md-2';
			break;
			default:
			    $data['swdcol'] = 'swd-md-4';
			break;
		}
		
		$data['thumbr_class'] = 'swdthumb-class';
		
		if( $results ) {
			
			$width  = $module_info['width'];
		    $height = $module_info['height'];
		
			foreach( $results as $result ) {
				
				if( $result['image'] ) {
                   $image = $this->model_tool_image->resize($result['image'], $width, $height);
				} else {
                   $image = $this->model_tool_image->resize('placeholder.png', $width, $height);
				}
				
				if( $this->customer->isLogged() || !$this->config->get('config_customer_price') ) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if( (float)$result['special'] ) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if( $this->config->get('config_tax') ) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if( $this->config->get('config_review_status') ) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
				

				$data['more_products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}

			return $this->load->view('extension/module/more_goods_ajax', $data);
		} else {
			return false;
		}
		
	}
	
	
	public function swd_more() {
		$json = array();
		
		if( isset($this->request->post['mod_id']) && !empty($this->request->post['mod_id']) ) {
			
			$id = (int)$this->request->post['mod_id'];
			
			if( isset($this->request->post['limit_load']) && !empty($this->request->post['limit_load']) ) {
				$limit_load = $this->request->post['limit_load'];
			} else {
				$limit_load = 8;
			}
			
			if( isset($this->request->post['start']) ) {
			    $start = (int)$this->request->post['start'];
		    } else {
			    $start = $limit_load;
		    }
			
			
			if( $more = $this->load_more($id, $start) ) {
			    $json['success']  = true;
		        $json['response'] = $more;
		    } else {
			    $json['success']  = false;
		        $json['response'] = '';
		    }
		} else {
			$json['success']  = 'error';
			$json['response'] = "Eror";
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	
}
