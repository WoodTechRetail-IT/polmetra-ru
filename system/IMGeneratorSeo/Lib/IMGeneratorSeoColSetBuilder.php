<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once DIR_SYSTEM . 'IMGeneratorSeo/IMGeneratorSeoHelper.php';
require_once DIR_SYSTEM . 'IMGeneratorSeo/IMGeneratorSeoConfig.php';

class IMGeneratorSeoColSetBuilder
{
	protected $db;

	protected $imhelper;

	protected $pre_set;

	protected $restricts;

	protected $col_set;

	/////////////////////////////////////////////////////////////////////////
	// Конструктор
	/////////////////////////////////////////////////////////////////////////

	function __construct(&$db = null)
	{
		if (isset($db)) {
			$this->db = &$db;
		}

		$this->imhelper = new IMGeneratorSeoHelper($this->db);

		$this->_initPreSet();

		$this->_initRestricts();
	}

	/////////////////////////////////////////////////////////////////////////
	// Инициализация
	/////////////////////////////////////////////////////////////////////////

	protected function _initPreSet()
	{
		$this->pre_set = array(
			array('table' => 'pd', 'field' => 'description'),
			array('table' => 'pd', 'field' => 'name'),
			array('table' => 'pd', 'field' => 'meta_title'),
			array('table' => 'pd', 'field' => 'meta_h1'),
			array('table' => 'p', 'field' => 'sku'),
			array('table' => 'pd', 'field' => 'meta_keyword'),
			array('table' => 'pd', 'field' => 'meta_description'),
			array('table' => 'pd', 'field' => 'tag'),
		);
	}

	protected function _initRestricts()
	{
		$this->restricts = array();
		$this->restricts['table'] = array(
			'p' => 'product',
			'pd' => 'product_description',
		);
		$this->restricts['field_type'] = array(
			'text', 'html', 'html_no_editor'
		);
		$this->restricts['field_data_type'] = array(
			'char', 'varchar',
			'tinytext', 'text', 'mediumtext', 'longtext',
		);
	}

	/////////////////////////////////////////////////////////////////////////
	// Вспомогательные функции
	/////////////////////////////////////////////////////////////////////////

	// Проверяем поддерживается ли колонка
	protected function _colCheckTableSupport($table_prefix)
	{
		if (!isset($this->restricts['table'][$table_prefix]))
			return false;
		return true;
	}

	// Проверяем поддерживается ли тип поля
	protected function _colCheckFieldTypeSupport($field_type)
	{
		if (!in_array($field_type, $this->restricts['field_type']))
			return false;
		return true;
	}

	// Такое поле существует
	protected function _colCheckExistField($table_prefix, $col)
	{
		return $this->imhelper->isHaveColumn(
			$this->restricts['table'][$table_prefix],
			$col
		);
	}

	// У поля разрешенный тип
	protected function _colCheckFieldDataTypeIsAllowed(
		$table_prefix, $col, $allowed_types
	){
		return $this->imhelper->isColumnAllowedDataTypes(
			$this->restricts['table'][$table_prefix],
			$col,
			$allowed_types
		);
	}

	protected function _colCheckFieldInPreSet(
		$table_prefix, $col
	) {
		foreach($this->pre_set as $item) {
			if (
				$item['table'] == $table_prefix
				&& strtolower($item['field']) == strtolower($col)
			) {
				return true;
			}
		}
		return false;
	}

	// Колонка уже добавлена
	protected function _colAlrearyAdd($table_prefix, $col)
	{
		foreach($this->col_set as $item)
		{
			if ( $item['table'] == $table_prefix && $item['field'] == $col )
			{
				return true;
			}
		}
		return false;
	}

	// Проверка существования колонки или
	protected function _colCheck($settings)
	{
		if (!is_array($settings))
			return;
		if (count($settings) != 5)
			return;

		$table_prefix = $settings[0];
		$col = $settings[1];
		$field_type = $settings[2];

		// Поддерживается ли таблица
		if (!$this->_colCheckTableSupport($table_prefix)) {
			return false;
		}

		// Поддерживается ли тип поля
		if (!$this->_colCheckFieldTypeSupport($field_type)) {
			return false;
		}

		// Существует ли поле
		if (!$this->_colCheckExistField($table_prefix, $col)) {
			return false;
		}

		// Поддерживается ли тип данных поля
		// При включенной проверке
		if (defined('IMGS_ADD_COLUMNS_CHECK_DATA_TYPE')){
			if (IMGS_ADD_COLUMNS_CHECK_DATA_TYPE) {
				if (!$this->_colCheckFieldDataTypeIsAllowed($table_prefix, $col, $this->restricts['field_data_type'])) {
					return false;
				}
			}
		}
		// Поддерживается ли тип данных поля
		// Если константа не инициализирована
		else if (!$this->_colCheckFieldDataTypeIsAllowed($table_prefix, $col, $this->restricts['field_data_type'])) {
			return false;
		}

		// Поле в пресете
		if ($this->_colCheckFieldInPreSet($table_prefix, $col)) {
			return false;
		}

		// Поле еще не было добавлено
		if (!$this->_colAlrearyAdd($table_prefix, $col)) {
			return true;
		}

		return false;
	}

	// Парсинг одной колонки
	protected function _parseOneCol($setting_string)
	{
		$setting_array = explode(',', $setting_string);

		// Должно быть 5 полей
		if (count($setting_array) != 5)
			return;

		// Убираем пробелы
		for ($cnt = 0; $cnt < count($setting_array); $cnt++) {
			$setting_array[$cnt] = trim($setting_array[$cnt]);
		}

		// Приводим к нижнему регистру
		$setting_array[0] = strtolower($setting_array[0]);
		$setting_array[1] = strtolower($setting_array[1]);
		$setting_array[2] = strtolower($setting_array[2]);

		if (!$this->_colCheck($setting_array))
			return;

		$result_col = array(
			'table' => $setting_array[0],
			'field' => str_replace( array('%', '?', '\'', '\"', '.'), '', $setting_array[1] ),
			'field_type' => $setting_array[2],
			'field_length' => (int)$setting_array[3],
			'field_name' => $this->db->escape( strip_tags( $setting_array[4] ) ),
			'field_sql_name' => 'ac_' . $setting_array[0] . '_' . $setting_array[1],
			'field_pattern' => '[ac_' . $setting_array[0] . '_' . $setting_array[1] . ']',
		);

		// Проверяем длину, если отрицательная, то 0
		if ($result_col['field_length'] < 0) {
			$result_col['field_length'] = 0;
		}

		if ($result_col['field_name'] == '')
		{
			$result_col['field_name'] =
				$result_col['table']
				. '_'
				. $result_col['field']
			;
		}

		$this->col_set[] = $result_col;
	}

	/////////////////////////////////////////////////////////////////////////
	// Функции
	/////////////////////////////////////////////////////////////////////////

	// Очистка
	public function clear()
	{
		$this->col_set = array();
	}

	// Загрузка
	public function load($setting_string)
	{
		$this->clear();

		if (!isset($setting_string) || empty($setting_string))
			return;

		$setting_array = explode("\n", $setting_string);

		foreach($setting_array as $item)
		{
			$this->_parseOneCol($item);
		}
	}

	// Набор колонок
	public function getColSet()
	{
		$result = $this->imhelper->cloneArray($this->col_set);
		return $result;
	}

	// Длина полей
	public function getColSetLengths()
	{
		$result = array();

		for($cnt = 0; $cnt < count($this->col_set); $cnt++)
		{
			$result[$this->col_set[$cnt]['field_sql_name']]
				= $this->col_set[$cnt]['field_length'];
		}

		return $result;
	}

	// Набор названий sql полей
	public function getColSetPatterns()
	{
		$result = array();

		for($cnt = 0; $cnt < count($this->col_set); $cnt++)
		{
			$result[] = $this->col_set[$cnt]['field_pattern'];
		}

		return $result;
	}

	// Набор паттернов
	public function getColSetSqlNames()
	{
		$result = array();

		for($cnt = 0; $cnt < count($this->col_set); $cnt++)
		{
			$result[] = $this->col_set[$cnt]['field_sql_name'];
		}

		return $result;
	}

	// Формирование выбор для селекта с товарами
	public function getSelectForProduct()
	{
		$result = '';

		for($cnt = 0; $cnt < count($this->col_set); $cnt++)
		{
			$result .=
				', '
				. 'ifnull('
					. $this->col_set[$cnt]['table']
					. '.'
					. $this->col_set[$cnt]['field']
				.	', "")'
				. ' as '
				. $this->col_set[$cnt]['field_sql_name']
				. ' '
			;
		}

		return $result;
	}

}
