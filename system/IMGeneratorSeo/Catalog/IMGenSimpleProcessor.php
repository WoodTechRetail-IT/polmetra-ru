<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
  Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once DIR_SYSTEM . 'IMGeneratorSeo/IMGeneratorSeoHelper.php';
require_once DIR_SYSTEM . 'IMGeneratorSeo/IMGSLicSA100.php';

class IMGenSimpleProcessor
{
	protected $model;

	protected $settings;

	protected $module_name = 'IMGeneratorSeo(OC3)';

	protected $isv = false;

	protected $ison = false;

	protected $helper;

	protected $lang_id;

	protected $currency_code;

	// 1.7.0
	protected $type_product_info;

	function __construct(&$model)
	{
		$this->model = &$model;

		$this->helper = new IMGeneratorSeoHelper();

		$this->init();
	}

	private function init()
	{
		$this->model->load->model('setting/setting');

		$this->settings = array();

		$curr_settings = $this->model->model_setting_setting->getSetting('IMGeneratorSeoData');

		if (isset($curr_settings['IMGeneratorSeoData_simple_template'])) {
			$this->settings = $curr_settings['IMGeneratorSeoData_simple_template'];
		}

		if (isset($curr_settings['IMGeneratorSeoData_type_product_info'])) {
			$this->type_product_info = (int)$curr_settings['IMGeneratorSeoData_type_product_info'];
		}

		$this->isv = $this->validate();

		if ( isset($this->settings['on']) ) {
			if ( (int)$this->settings['on'] == 1 ) {
				$this->ison = true;
			}
		}

		$this->lang_id = $this->getCurrentLangId();

		$this->currency_code = $this->getCurrentCurrencyCode();
	}

	protected function getCurrentLangId()
	{
		// Загружаем модель
		$this->model->load->model('localisation/language');
		$list_lang = $this->model->model_localisation_language->getLanguages();
		// Загружаем текущий язык
		$language = reset($list_lang);
		// Получаем код языка из админки
		$langs_temp = $this->model->config->get('config_admin_language');
		if (isset($langs_temp) && !empty($langs_temp))
		{
		    // Получаем язык
		    $language = $list_lang[$this->model->config->get('config_admin_language')];
		}
		// Вытаскиваем текущий код (к сожалению, это конструкция не универсальна...)
		$langs_temp = $this->model->language->get('code');
		if (isset($langs_temp) && !empty($langs_temp))
		{
		    // Смотрим, есть ли такой язык
		    if (isset($list_lang[$this->model->language->get('code')]))
		    {
		        // Получаем настройки языка
		        $language = $list_lang[$this->model->language->get('code')];
		    }
		}
		// Смотрим есть ли локализация в сессии
		if (isset($this->model->session->data['language']))
		{
		    // Получаем текущий язык
		    $language = $list_lang[$this->model->session->data['language']];
		}
		// Возвращаем идентификатор
		return (int)$language['language_id'];
	}

	protected function getCurrentCurrencyCode()
	{
		$result = $this->model->config->get('config_currency');

		if (isset($this->model->session->data['currency']) && !empty($this->model->session->data['currency'])) {
			$result = $this->model->session->data['currency'];
		}

		return $result;
	}

	/////////////////////////////////////////
	// Встроенные функции
	/////////////////////////////////////////

	// Формирование одного поля товара
	protected function prepareProductOneField(
		&$data,
		$field_name,
		$field_type,
		$field_template)
	{
		//array('id' => '0','name' => 'Ничего не делать'),
		//array('id' => '1','name' => 'Заменить пустые'),
		//array('id' => '2','name' => 'Добавить вначале'),
		//array('id' => '3','name' => 'Добавить в конец'),
		//array('id' => '4','name' => 'Перезаписать')
		// Ничего не делать
		if ($field_type == 0) {
			if (isset($data[$field_name])) {
				return $data[$field_name];
			}
			return '';
		}

		// Проверяем, что если замена пустого значения, то поле не пустое
		if ($field_type == 1) {
			if (isset($data[$field_name])) {
				if (trim($data[$field_name]) != '') {
					return $data[$field_name];
				}
			}
		}

		// Теги для замены
		$replace_array_tags = array(
			'[name]',
			'[price]',
			'[special]',
			'[sku]',
			'[meta_title]',
			'[meta_h1]',
			'[meta_description]',
			'[meta_keyword]',
			'[model]',
			'[manufacturer]',
		);

		$price = $this->helper->getPostValue($data, 'price', 0);
		$special = $this->helper->getPostValue($data, 'special', 0);

		$replace_array_values = array(
			$this->helper->getPostValue($data, 'name', ''),
			(version_compare('2.2', VERSION) > 0
				? $this->model->currency->format($price)
				: $this->model->currency->format($price, $this->getCurrentCurrencyCode())),
			(version_compare('2.2', VERSION) > 0
				? $this->model->currency->format($special)
				: $this->model->currency->format($special, $this->getCurrentCurrencyCode())),
			$this->helper->getPostValue($data, 'sku', ''),
			$this->helper->getPostValue($data, 'meta_title', ''),
			$this->helper->getPostValue($data, 'meta_h1', ''),
			$this->helper->getPostValue($data, 'meta_description', ''),
			$this->helper->getPostValue($data, 'meta_keyword', ''),
			$this->helper->getPostValue($data, 'model', ''),
			$this->helper->getPostValue($data, 'manufacturer', ''),
		);

		$result = '';

		$curr_value = $this->helper->getPostValue($data, $field_name, '');

		$result = str_replace($replace_array_tags, $replace_array_values, $field_template);

		$result =
			// Результат в конце добавляется
			($field_type == '3' ? $curr_value : '')
				. $result
			// Результат вначале добавляется
			. ($field_type == '2' ? $curr_value : '')
		;

		// Подготавливаем поля
		$result = $this->helper->stripTags($result);
		if (
			$this->helper->startsWith($field_name, 'meta_')
			&& $field_name != 'meta_h1'
			&& $field_name != 'meta_title'
		) {
			$result = $this->helper->replaceStrictHtmlChar($result);
		}
		$result = $this->helper->lenCut($result, 255);

		return $result;
	}

	// Формирование всей строки товара
	protected function prepareProduct(&$data)
	{
		$fields = $this->helper->getPostValue($this->settings, 'fields', array());
		$types = $this->helper->getPostValue($this->settings, 'types', array());

		$replaced_array = array();

		foreach($fields as $field_key=>$field_data) {
			if ($this->helper->startsWith($field_key, 'p_')) {
				$field_name = substr($field_key, 2);
				$field_type = (int)$this->helper->getPostValue($types, $field_key, 0);
				$field_template = $this->helper->getPostValue($field_data, 'lang_' . $this->lang_id, '');
				$replaced_array[$field_name] = $this->prepareProductOneField(
					$data,
					$field_name,
					$field_type,
					$field_template
				);
		 	}
		}

		// Заменяем значения
		foreach($replaced_array as $key=>$item) {
			if(isset($data[$key])) {
				$data[$key] = $item;
			}
		}
	}

	protected function prepareCategoryOneField(
		&$data,
		$field_name,
		$field_type,
		$field_template)
	{
		//array('id' => '0','name' => 'Ничего не делать'),
		//array('id' => '1','name' => 'Заменить пустые'),
		//array('id' => '2','name' => 'Добавить вначале'),
		//array('id' => '3','name' => 'Добавить в конец'),
		//array('id' => '4','name' => 'Перезаписать')
		// Ничего не делать
		if ($field_type == 0) {
			if (isset($data[$field_name])) {
				return $data[$field_name];
			}
			return '';
		}

		// Проверяем, что если замена пустого значения, то поле не пустое
		if ($field_type == 1) {
			if (isset($data[$field_name])) {
				if (trim($data[$field_name]) != '') {
					return $data[$field_name];
				}
			}
		}

		// Теги для замены
		$replace_array_tags = array(
			'[name]',
			'[meta_title]',
			'[meta_h1]',
			'[meta_description]',
			'[meta_keyword]',
		);

		$replace_array_values = array(
			$this->helper->getPostValue($data, 'name', ''),
			$this->helper->getPostValue($data, 'meta_title', ''),
			$this->helper->getPostValue($data, 'meta_h1', ''),
			$this->helper->getPostValue($data, 'meta_description', ''),
			$this->helper->getPostValue($data, 'meta_keyword', ''),
		);

		$result = '';

		$curr_value = $this->helper->getPostValue($data, $field_name, '');

		$result = str_replace($replace_array_tags, $replace_array_values, $field_template);

		$result =
			// Результат в конце добавляется
			($field_type == '3' ? $curr_value : '')
				. $result
			// Результат вначале добавляется
			. ($field_type == '2' ? $curr_value : '')
		;

		// Подготавливаем поля
		$result = $this->helper->stripTags($result);
		if (
			$this->helper->startsWith($field_name, 'meta_')
			&& $field_name != 'meta_h1'
			&& $field_name != 'meta_title'
		) {
			$result = $this->helper->replaceStrictHtmlChar($result);
		}
		$result = $this->helper->lenCut($result, 255);

		return $result;
	}

	protected function prepareCategory(&$data)
	{
		$fields = $this->helper->getPostValue($this->settings, 'fields', array());
		$types = $this->helper->getPostValue($this->settings, 'types', array());

		$replaced_array = array();

		foreach($fields as $field_key=>$field_data) {
			if ($this->helper->startsWith($field_key, 'c_')) {
				$field_name = substr($field_key, 2);
				$field_type = (int)$this->helper->getPostValue($types, $field_key, 0);
				$field_template = $this->helper->getPostValue($field_data, 'lang_' . $this->lang_id, '');
				$replaced_array[$field_name] = $this->prepareCategoryOneField(
					$data,
					$field_name,
					$field_type,
					$field_template
				);
		 	}
		}

		// Заменяем значения
		foreach($replaced_array as $key=>$item) {
			if(isset($data[$key])) {
				$data[$key] = $item;
			}
		}
	}

	/////////////////////////////////////////
	// Валидация
	/////////////////////////////////////////

	protected $imlic;

	// Проверка, что у пользователя есть необходимые права
	private function validate($only_edit = false) {
		$module_name = 'IMGeneratorSeo(OC3)';

		// Если есть кэш
		if (is_object($this->model->cache)) {
			$cache_item = $this->model->cache->get(date('my').'asdfimgen'.date('dmy'));
			if(!empty($cache_item)) {
				return (bool)$cache_item['isValid'];
			}
		}

		// Стандартная валидация
		$data = array();

		$queryString =
			' select distinct `key`, `value` '
			. ' from `' . DB_PREFIX . 'setting` '
			. ' where `key` in ( '
					. ' \'IMGeneratorSeoData_key\' ' . ', '
					. ' \'IMGeneratorSeoData_enc_mess\' ' . ', '
					. ' \'' . $this->model->db->escape($module_name . 'DataDemo_date' ) . '\' '
				. ')'
		;

		$query = $this->model->db->query($queryString);

		foreach($query->rows as $row) {
			$data[$row['key']] = $row['value'];
		}

		if (!isset($this->imlic) || empty($this->imlic)) {
			$this->imlic = new IMGSLicSA100(
				$module_name,
				(isset($data['IMGeneratorSeoData_key']) ? $data['IMGeneratorSeoData_key'] : ''),
				(isset($data['IMGeneratorSeoData_enc_mess']) ? $data['IMGeneratorSeoData_enc_mess'] : ''),
				(isset($data[$module_name.'DataDemo_date']) ? $data[$module_name.'DataDemo_date'] : '')
			);
		}

		if (!$this->imlic->isValid()) {
			return false;
		}

		// Если есть кэш
		if (is_object($this->model->cache)) {
			$this->model->cache->set(
					date('my').'asdfimgen'.date('dmy'),
					array( 'isValid' => true )
			);
		}

		return true;
	}

	/////////////////////////////////////////
	// Интерфейс
	/////////////////////////////////////////

	public function getProductByTemplate(&$data)
	{
		if (
			(!$this->ison && $this->type_product_info == 0)
			|| !$this->isv
		) {
			return $data;
		}

		if ($data === false) return $data;

		if ($this->ison) {
			$this->prepareProduct($data);
		}

		if ($this->type_product_info > 0) {
			$query_get_product_info = $this->model->db->query(
				'select * '
				. ' from `' . DB_PREFIX . 'imgeneratorseo_product_info` '
				. ' where `product_id` = ' . (int)$data['product_id']
					. ' and `language_id` = ' . (int)$this->lang_id
			);

			$additional_text = '';

			if ($query_get_product_info->num_rows > 0) {
				$additional_text = $query_get_product_info->rows[0]['description'];
			}

			switch((int)$this->type_product_info)
			{
				// Осн + доп
				case 1:
					$data['description'] = $data['description'] . $additional_text
					;
					break;
				// Доп + осн
				case 2:
					$data['description'] = $additional_text . $data['description']
					;
					break;
				// Доп
				case 3:
					$data['description'] = $additional_text
					;
					break;
				default:
					break;
			}
		}

		return $data;
	}

	public function getCategoryByTemplate(&$data)
	{
		if (!$this->ison || !$this->isv) return $data;

		$this->prepareCategory($data);

		return $data;
	}

	public function getCategoriesByTemplate(&$data)
	{
		if (!$this->ison || !$this->isv) return $data;

		foreach($data as &$item) {
			$this->prepareCategory($item);
		}
		unset($item);

		return $data;
	}
}
