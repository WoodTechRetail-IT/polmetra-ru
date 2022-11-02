<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerInformationInformation extends Controller {
	public function index() {
		$this->load->language('information/information');

		$this->load->model('catalog/information');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {
			
			if ($information_info['meta_title']) {
				$this->document->setTitle($information_info['meta_title']);
			} else {
				$this->document->setTitle($information_info['title']);
			}
			
			if ($information_info['noindex'] <= 0 && $this->config->get('config_noindex_status')) {
				$this->document->setRobots('noindex,follow');
			}
			
			if ($information_info['meta_h1']) {
				$data['heading_title'] = $information_info['meta_h1'];
			} else {
				$data['heading_title'] = $information_info['title'];
			}
			
			$this->document->setDescription($information_info['meta_description']);
			$this->document->setKeywords($information_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $information_info['title'],
				'href' => $this->url->link('information/information', 'information_id=' .  $information_id)
			);

			$data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

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
        

					//microdatapro 7.7 start - 1 - main
					$data['microdatapro_data'] = $information_info;
					$data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');
					$this->document->setTc_og($this->load->controller('extension/module/microdatapro/tc_og', $data));
					$this->document->setTc_og_prefix($this->load->controller('extension/module/microdatapro/tc_og_prefix'));
					$data['microdatapro'] = $this->load->controller('extension/module/microdatapro/information', $data);
					$microdatapro_main_flag = 1;
					//microdatapro 7.7 start - 1 - main
				
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('information/information', $data));
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('information/information', 'information_id=' . $information_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

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
        

					//microdatapro 7.7 start - 1 - main
					$data['microdatapro_data'] = $information_info;
					$data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');
					$this->document->setTc_og($this->load->controller('extension/module/microdatapro/tc_og', $data));
					$this->document->setTc_og_prefix($this->load->controller('extension/module/microdatapro/tc_og_prefix'));
					$data['microdatapro'] = $this->load->controller('extension/module/microdatapro/information', $data);
					$microdatapro_main_flag = 1;
					//microdatapro 7.7 start - 1 - main
				
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}

	public function agree() {
		$this->load->model('catalog/information');

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$output = '';

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {
			$output .= html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
		}

		$this->response->addHeader('X-Robots-Tag: noindex');

		$this->response->setOutput($output);
	}
}
