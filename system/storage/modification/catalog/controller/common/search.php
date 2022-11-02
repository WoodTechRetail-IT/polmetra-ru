<?php
class ControllerCommonSearch extends Controller {
	public function index() {
		$this->load->language('common/search');

				$this->load->language('stroimarket/stroimarket');
			

		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}


            $data['smartsearch'] = false;
            if ($this->config->get('module_smartsearch_status')) {                
                $data['smartsearch'] = true;
            }
            
		return $this->load->view('common/search', $data);
	}
}