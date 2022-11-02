<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCommonHeader extends Controller {
	public function index() {
		// Analytics
		$this->load->model('setting/extension');

		$data['analytics'] = array();

		$analytics = $this->model_setting_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get('analytics_' . $analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->config->get('analytics_' . $analytic['code'] . '_status'));
			}
		}

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}


					//microdatapro 7.7 start - 1 - main
					$data['tc_og'] = $this->document->getTc_og();
					$data['tc_og_prefix'] = $this->document->getTc_og_prefix();
					$microdatapro_main_flag = 1;
					//microdatapro 7.7 end - 1 - main
					

            if ($this->config->get('module_smartsearch_status')) {
                $this->document->addStyle('catalog/view/theme/default/stylesheet/smartsearch.css');
            }
            
		$data['title'] = $this->document->getTitle();

$this->load->model('catalog/information');
				$data['informations'] = array();
				foreach ($this->model_catalog_information->getInformations() as $result) {
					if ($result['top']) {
						$data['informations'][] = array(
							'title' => $result['title'],
							'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
						);
					}
				}
		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['robots'] = $this->document->getRobots();
		$data['styles'] = $this->document->getStyles();

				// << Related Options
				
				$this->load->model('extension/liveopencart/related_options');
				if ( $this->model_extension_liveopencart_related_options->installed()) {
					$ro_basic_scripts = $this->model_extension_liveopencart_related_options->getBasicScripts();
					foreach ( $ro_basic_scripts as $ro_basic_script) {
						$this->document->addScript($ro_basic_script);
					}
				}
				// >> Related Options
			
		$data['scripts'] = $this->document->getScripts('header');
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');


					//microdatapro 7.7 start - 2 - extra
					if(!isset($microdatapro_main_flag)){
						$data['tc_og'] = $this->document->getTc_og();
						$data['tc_og_prefix'] = $this->document->getTc_og_prefix();
					}
					//microdatapro 7.7 end - 2 - extra
					
		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

				$this->load->language('stroimarket/stroimarket');
				$data['cart_total'] 	= $this->cart->countProducts();
				$data['open'] 			= $this->config->get('config_open');
				$data['address'] 		= $this->config->get('config_address');
				$data['email'] 			= $this->config->get('config_email');
				$data['firstname'] 		= $this->customer->getFirstName();
				$data['compare_total'] 	= (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0);
			
		
		
		$host = isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')) ? HTTPS_SERVER : HTTP_SERVER;
		if ($this->request->server['REQUEST_URI'] == '/') {
			$data['og_url'] = $this->url->link('common/home');
		} else {
			$data['og_url'] = $host . substr($this->request->server['REQUEST_URI'], 1, (strlen($this->request->server['REQUEST_URI'])-1));
		}
		
		$data['og_image'] = $this->document->getOgImage();
		


		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());

				$data['wishlist_total'] = $this->model_account_wishlist->getTotalWishlist();	
            
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));

				$data['wishlist_total'] = (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0);	
            
		}

		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));
		
		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->customer->isLogged();

        if (isset($data['logo']) && $data['logo'] != '' ) {
        	$this->registry->set('jetcache_images_logo', $data['logo']);
        } else {
        	if (isset($this->data['logo']) && $this->data['logo'] != '' ) {
            	$this->registry->set('jetcache_images_logo', $this->data['logo']);
        	}
        }
    
		$data['account'] = $this->url->link('account/account', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['contact'] = $this->url->link('information/contact');

				$data['compare'] = $this->url->link('product/compare');
			
		$data['telephone'] = $this->config->get('config_telephone');

					$buyoneclick = $this->config->get('buyoneclick');
					$data['buyoneclick_status_product'] = $buyoneclick["status_product"];
					$data['buyoneclick_status_category'] = $buyoneclick["status_category"];
					$data['buyoneclick_status_module'] = $buyoneclick["status_module"];

					$data['buyoneclick_style_status'] = $buyoneclick["style_status"];
					$data['buyoneclick_validation_type'] = $buyoneclick["validation_type"];

					$data['buyoneclick_exan_status'] = $buyoneclick["exan_status"];

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
				

				$data['tel'] = str_replace(array('(', ')', ' ', '-'), '', $this->config->get('config_telephone'));
			
		
		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['currency'] = $this->load->controller('common/currency');
		if ($this->config->get('configblog_blog_menu')) {
			$data['blog_menu'] = $this->load->controller('blog/menu');
		} else {
			$data['blog_menu'] = '';
		}
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');
		$data['menu'] = $this->load->controller('common/menu');

                $data['config'] = $this->config;
            


				$data['custom_css'] = html_entity_decode($this->config->get('config_custom_css') ? $this->config->get('config_custom_css') : '', ENT_QUOTES, 'UTF-8');
				$data['custom_js'] = html_entity_decode($this->config->get('config_custom_js') ? $this->config->get('config_custom_js') : '', ENT_QUOTES, 'UTF-8');
			
		return $this->load->view('common/header', $data);
	}
}
