<?php
class ControllerModuleImageOption extends Controller {
	protected function index($setting) {
 		
 		$this->id = 'image_option';
 		
 		if (isset($this->request->get['product_id'])) {
      $product_id = (int)$this->request->get['product_id'];
    } else {
      return false;
    }
 		
 		$this->load->model('catalog/image_option'); 
 		$this->data['product_options_images'] = $this->model_catalog_image_option->getOptionsImagesByProductId($product_id);
  		$this->data['images_product_options_values'] = $this->data['product_options_images']['images'];
 		unset($this->data['product_options_images']['images']);
    
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/image_option.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/image_option.tpl';
		} else {
			$this->template = 'default/template/module/image_option.tpl';			
		}    
    
		$this->render();
	}  	
}