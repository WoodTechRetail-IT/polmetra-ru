<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once DIR_SYSTEM . 'IMDBOptimizer/IMDBOLicSA100.php';
require_once DIR_SYSTEM . 'IMDBOptimizer/IMDBOClientAPI.php';

class ControllerExtensionModuleIMDBOptimizer extends Controller
{
	private $error = array();
	private $warning = array();

	// Точка входа
	public function index()
	{
		$this->load->model('setting/setting');

		$this->validate();

		$json = array();

		if ( !$this->imlic->isValid() ) {
			$json['success'] = 0;
			$json['error'] = 'license';
			$this->response->setOutput(json_encode($json));
			return;
		}

		//////////////////////////////
		// API ключ
		//////////////////////////////

		if ( !isset($this->request->get['apikey']) || empty($this->request->get['apikey']) ) {
			$json['success'] = 0;
			$json['error'] = 'no apikey';
			$this->response->setOutput(json_encode($json));
			return;
		}

		// Получаем ключ из параметров
		$apikey = $this->request->get['apikey'];

		$moduleSettings = $this->model_setting_setting->getSetting('IMDBOptimizerData');

		$settings_apikey = '';

		// Получаем ключ
		if ( isset($moduleSettings['IMDBOptimizerData_api_secret_key']) ) {
			$settings_apikey = $moduleSettings['IMDBOptimizerData_api_secret_key'];
		} else {
			$json['success'] = 0;
			$json['error'] = 'apikey';
			$this->response->setOutput(json_encode($json));
			return;
		}

		// Если ключ пустой или несоответствует
		if ( $settings_apikey == '' || $settings_apikey != $apikey ) {
			$json['success'] = 0;
			$json['error'] = 'apikey';
			$this->response->setOutput(json_encode($json));
			return;
		}

		//////////////////////////////
		// Параметры
		//////////////////////////////

		// Получаем действия
		if ( !isset($this->request->get['actions']) ) {
			$json['success'] = 0;
			$json['error'] = 'actions';
			$this->response->setOutput(json_encode($json));
			return;
		}

		$actions = strip_tags($this->request->get['actions']);

		// Проверяем, что действия указаны
		if ( trim($actions) == '' ) {
			$json['success'] = 0;
			$json['error'] = 'actions empty';
			$this->response->setOutput(json_encode($json));
			return;
		}

		//////////////////////////////
		// Генерация
		//////////////////////////////
		$clientAPI = new IMDBOClientAPI($this->db, $this->language, $this->config);

		$result = $clientAPI->execActions($actions);

		$json['success'] = 1;
		$json['result'] = $result;
		$this->response->setOutput(json_encode($json));
	}

	/////////////////////////////////////////
	// Валидация
	/////////////////////////////////////////

	protected $imlic;

	// Проверка, что у пользователя есть необходимые права
	private function validate() {
		$this->load->model('setting/setting');

		$module_name = 'IMDBOptimizer(OC3)';

		$queryString =
			' select distinct `key`, `value` '
			. ' from `' . DB_PREFIX . 'setting` '
			. ' where `key` in ( '
					. ' \'IMDBOptimizerData_key\' ' . ', '
					. ' \'IMDBOptimizerData_enc_mess\' ' . ', '
					. ' \'' . $this->db->escape($module_name) . 'DataDemo_date' . '\' '
				. ')'
		;

		$query = $this->db->query($queryString);

		foreach($query->rows as $row) {
			$data[$row['key']] = $row['value'];
		}

		if (!isset($this->imlic) || empty($this->imlic)) {
			$this->imlic = new IMDBOLicSA100(
				$module_name,
				(isset($data['IMDBOptimizerData_key']) ? $data['IMDBOptimizerData_key'] : ''),
				(isset($data['IMDBOptimizerData_enc_mess']) ? $data['IMDBOptimizerData_enc_mess'] : ''),
				(isset($data[$module_name.'DataDemo_date']) ? $data[$module_name.'DataDemo_date'] : '')
			);
		}

		if (!$this->imlic->isValid()) {
			return false;
		}
		return true;
	}

}
