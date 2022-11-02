<?php
class ControllerExtensionModuleImageOption extends Controller {
	public function index($setting) {
 		
 		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			return false;
		}
 		
 		$this->load->model('extension/module/image_option'); 
		
		$product_options_images = $this->model_extension_module_image_option->getOptionsImagesByProductId($product_id);
		
  	$data['images_product_options_values'] = json_encode($product_options_images['images']);
 		unset($product_options_images['images']);
		
 		$data['product_options_images'] = json_encode($product_options_images);
		
		$data['image_option_options'] = $this->config->get('module_image_option_options');
		$data['image_option_options']['javascript'] = htmlspecialchars_decode($data['image_option_options']['javascript']);
    
		return $this->load->view('extension/module/image_option', $data);
	}  	
}