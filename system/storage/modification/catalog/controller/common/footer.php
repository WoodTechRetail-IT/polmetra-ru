<?php
class ControllerCommonFooter extends Controller {
	public function index() {
 

            $data['smartsearch'] = false;
            $data['smartsearch_field'] = '';
            if ($this->config->get('module_smartsearch_status')) {                
                $data['smartsearch'] = true;  

                if ($this->config->get('module_smartsearch_field')) {
                    $data['smartsearch_field'] = $this->config->get('module_smartsearch_field');
                } else {
                    $data['smartsearch_field'] = 'header input[name="search"]';
                }                     

            }

            

				$data['telephone'] 				= $this->config->get('config_telephone');
				$data['address'] 				= nl2br($this->config->get('config_address'));
				$data['email'] 					= $this->config->get('config_email');
				$data['comment'] 				= $this->config->get('config_comment');	
				$data['phone'] 					= str_replace(array('(', ')', ' ', '-'), '', $this->config->get('config_telephone'));
				$data['open'] 					= nl2br($this->config->get('config_open'));
				$data['top_button'] 			= $this->config->get('config_top_button');
				$data['social'] 				= $this->config->get('config_social');
				$data['config_facebookid'] 		= $this->config->get('config_facebookid');
			    $data['config_twitterid'] 		= $this->config->get('config_twitterid');
				$data['config_telegramid'] 		= $this->config->get('config_telegramid');
			    $data['config_instagramid'] 	= $this->config->get('config_instagramid');
			    $data['config_vkid'] 			= $this->config->get('config_vkid');
			    $data['config_youtubeid'] 		= $this->config->get('config_youtubeid');
				$data['config_whatsappid'] 		= $this->config->get('config_whatsappid');
				$data['config_social_style']	= $this->config->get('config_social_style');
				$data['config_footer_email']	= $this->config->get('config_footer_email');
				$data['config_footer_address']	= $this->config->get('config_footer_address');
				$data['config_footer_open']		= $this->config->get('config_footer_open');
				$data['config_payment_icon']	= $this->config->get('config_payment_icon');
			

				// BuyOneClick
					$buyoneclick = $this->config->get('buyoneclick');
					$data['buyoneclick_status_product'] = $buyoneclick["status_product"];
					$data['buyoneclick_status_category'] = $buyoneclick["status_category"];
					$data['buyoneclick_status_module'] = $buyoneclick["status_module"];

					$data['buyoneclick_exan_status'] = $buyoneclick["exan_status"];

					$current_language_id = $this->config->get('config_language_id');
					$data['buyoneclick_success_field'] = isset($buyoneclick["success_field"][$current_language_id]) ? htmlspecialchars_decode($buyoneclick["success_field"][$current_language_id]) : '';

					$this->load->language('extension/module/buyoneclick');
					if ($data['buyoneclick_success_field'] == '') {
						$data['buyoneclick_success_field'] = $this->language->get('buyoneclick_success');
					}
				// BuyOneClickEnd
			
		$this->load->language('common/footer');

				$this->load->language('stroimarket/stroimarket');
			

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}


            $opencart_version = explode(".", VERSION)[0].explode(".", VERSION)[1];
            $set_pref = ($opencart_version > 23) ? 'module_' : '';
            $data['ldev_question_custom_css'] = $this->config->get($set_pref . 'ldev_question_custom_css');
            $data['ldev_question_custom_js'] = $this->config->get($set_pref . 'ldev_question_custom_js');
            // $data['ldev_question_microdata'] = $this->config->get($set_pref . 'ldev_question_microdata');
            

					//microdatapro 7.7 start - 1 - main
					$data['microdatapro'] = $this->load->controller('extension/module/microdatapro/company');
					$microdatapro_main_flag = 1;
					//microdatapro 7.7 end - 1 - main
					
		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['tracking'] = $this->url->link('information/tracking');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/login', '', true);
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);

            $data['yoomoney_kassa_show_in_footer'] = $this->config->get('yoomoney_kassa_enabled') && $this->config->get('yoomoney_kassa_show_in_footer');
            


					//microdatapro 7.7 start - 2 - extra
					if(!isset($microdatapro_main_flag)){
						$data['microdatapro'] = $this->load->controller('extension/module/microdatapro/company');
					}
					//microdatapro 7.7 end - 2 - extra
					
		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = ($this->request->server['HTTPS'] ? 'https://' : 'http://') . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		$data['scripts'] = $this->document->getScripts('footer');
		$data['styles'] = $this->document->getStyles('footer');
		
		return $this->load->view('common/footer', $data);
	}
}
