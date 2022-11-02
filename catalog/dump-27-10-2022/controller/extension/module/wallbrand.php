<?php
class ControllerExtensionModuleWallbrand extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/wallbrand');

		$this->load->model('catalog/manufacturer');
		
		$this->load->model('catalog/product');

		$this->load->model('tool/image');
		
		$data['brands'] = $this->url->link('product/manufacturer');

		$data['manufacturers'] = array();

		if (!empty($setting['manufacturer'])) {
			$manufacturers = $setting['manufacturer'];

			foreach ($manufacturers as $manufacturer_id) {
				$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);

				if ($manufacturer_info) {
					if ($manufacturer_info['image']) {
						$image = $this->model_tool_image->resize($manufacturer_info['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}

					$data['manufacturers'][] = array(
						'manufacturer_id'  => $manufacturer_info['manufacturer_id'],
						'thumb'            => $image,
						'name'             => $manufacturer_info['name'],
						'href'             => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer_info['manufacturer_id'])
					);
				}
			}
		}

		if ($data['manufacturers']) {
			return $this->load->view('extension/module/wallbrand', $data);
		}
	}
}