<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

class IMGeneratorSeoHelper
{
	protected $db;

	// Конструктор
	function __construct(&$db = null)
	{
		if (isset($db)) {
			$this->db = &$db;
		}
	}

	public function getDB()
	{
		if (isset($this->db)) {
			return $this->db;
		}
		return null;
	}

	public function setDB(&$db = null)
	{
		if (isset($db)) {
			$this->db = &$db;
		}
	}

	public function cloneArray($array) {
    $clone_array = array();
    foreach($array as $key => $value) {
      if(is_array($value)) $clone_array[$key] = $this->cloneArray($value);
      else if(is_object($value)) $clone_array[$key] = clone $value;
      else $clone_array[$key] = $value;
    }
    return $clone_array;
	}

	public function clearQuotes($value)
	{
		return str_replace(
		 	array('"', "'"),
		 	'',
		 	$value
		);
	}

	public function toQuotes($value)
	{
		return str_replace(
		 	'&quot;',
		 	'"',
		 	$value
		);
	}

	// Удаление запрещенных сивмолов для элементов, которые будут внутри мета
	public function replaceStrictHtmlChar($value)
	{
		return str_replace(
		 	array('"'),
			array("&quot;"),
		 	//array("'"),
		 	$value
		);
	}

	// Удаление тегов и повторяющихся пробелов
	public function stripTags($value)
	{
		return preg_replace('/\s{2,}/', ' ',
			 str_replace(
			 	array('&nbsp;'),
			 	array(' '),
			 	strip_tags(html_entity_decode($value, ENT_QUOTES, 'UTF-8'))
			 )
		);
	}

	public function startsWith($haystack, $needle)
	{
	     $length = strlen($needle);
	     return (substr($haystack, 0, $length) === $needle);
	}

	public function isSubstr($str, $substr)
	{
		$result = strpos ($str, $substr);
		if ($result === FALSE) // если это действительно FALSE, а не ноль, например
			return false;
		return true;
	}

	public function endsWith($haystack, $needle)
	{
	    $length = strlen($needle);

	    return $length === 0 ||
	    (substr($haystack, -$length) === $needle);
	}

	// Получение значения из поста
	public function getPostValue(&$data, $name, $default = '')
	{
		if (isset($data) && is_array($data)) {
			if (isset($data[$name])) {
				return $data[$name];
			}
		}
		return $default;
	}

	/**
   * mb_ucfirst - преобразует первый символ в верхний регистр
   * @param string $str - строка
   * @param string $encoding - кодировка, по-умолчанию UTF-8
   * @return string
   */
  public function mb_ucfirst($str, $encoding='UTF-8')
  {
      $str = mb_ereg_replace('^[\ ]+', '', $str);
      $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
             mb_substr($str, 1, mb_strlen($str), $encoding);
      return $str;
  }

	public function toFloat($str) {
		$temp = str_replace(',', '.', $str);
		$temp = (float)$temp;
		return $temp;
	}

	public function toDouble($str) {
		$temp = str_replace(',', '.', $str);
		$temp = (double)$temp;
		return $temp;
	}

	public function toFloatInArray(&$array, $name) {
		if ( isset($array[$name]) ) {
			$array[$name] = $this->toFloat($array[$name]);
		}
	}

	public function toDoubleInArray(&$array, $name) {
		if ( isset($array[$name]) ) {
			$array[$name] = $this->toDouble($array[$name]);
		}
	}

	public function toIntInArray(&$array, $name) {
		if ( isset($array[$name]) ) {
			$array[$name] = (int)$array[$name];
		}
	}

	// Обрезание строки по длине
	public function lenCut($value, $len)
	{
		if(isset($value) && !empty($value))
			return mb_substr($value, 0, $len);
		return '';
	}

	public function parseDateToDBString($dateString)
	{
		$date = DateTime::createFromFormat('d.m.Y', $dateString);
		if (!isset($date) || empty($date)) {
			$date = DateTime::createFromFormat('Y-m-d', $dateString);
			if (!isset($date) || empty($date)) {
				return '';
			}
		}
		return $date->format('Y-m-d');
	}

	public function inQuote($string)
	{
		return '\'' . $string . '\'';
	}

	// Составление фильтра для даты
	public function getWhereFilterDate($settings, $field_name, $clause, $wherePart)
	{
		try
		{
			if ($wherePart == '' && !empty($settings[$field_name])) {
				//$date = date_create_from_format('d.m.Y', $settings[$field_name]);
				$date = DateTime::createFromFormat('d.m.Y', $settings[$field_name]);
				if (!isset($date) || empty($date)) {
					return '';
				}
				return $clause . " '" . $date->format('Y-m-d') . "' ";
			}
			else if (!empty($settings[$field_name])) {
				//$date = date_create_from_format('d.m.Y', $settings[$field_name]);
				$date = DateTime::createFromFormat('d.m.Y', $settings[$field_name]);
				if (!isset($date) || empty($date)) {
					return '';
				}
				return " and " . $clause . " '" . $date->format('Y-m-d') . "' ";
			}
		}
		catch(Exception $ex)
		{
			return '';
		}
		return '';
	}

	// Составление фильтра для списка
	public function getWhereFilterList($data, $list_name, $clause, $wherePart)
	{
		$result = '';

		if (!isset($data[$list_name])) {
			return $result;
		}

		if (!is_array($data[$list_name])) {
			$result .= (empty($wherePart) ? '' : ' and ');
			$result .= $clause . ' = ' . (int)$data[$list_name];
		}
		else {
			// Если есть , что фильтровать
			if (count($data[$list_name]) > 0 && (!empty($data[$list_name][0]) || (''.$data[$list_name][0]) == '0')
					&& (('' . $data[$list_name][0] != '-1') || count($data[$list_name]) > 1)) {
				$result .= (empty($wherePart) ? '' : ' and ');

				if (count($data[$list_name]) == 1) {
					$result .= $clause . ' = ' . (int)$data[$list_name][0];
				}
				else {
					for ($cnt = 0; $cnt < count($data[$list_name]); $cnt++) {
						$data[$list_name][$cnt] = (int)$data[$list_name][$cnt];
					}
					$result .= $clause . ' in (' . join(', ', $data[$list_name]) . ') ';
				}
			}
		}

		return $result;
	}

	// Проверка существования колонки
	public function isHaveColumn($table, $column)
	{
		if (empty($table) || empty($column)) {
			return false;
		}

		$result = $this->db->query(
			"SHOW COLUMNS FROM "
			. " `" . DB_PREFIX . $this->db->escape($table) . "` "
			. " WHERE `Field` = '" . $this->db->escape($column) . "'"
		);
		if ($result->num_rows) {
			return true;
		}
		return false;
	}

	// Проверка колонки, тип соответствует одному из разрешенных
	public function isColumnAllowedDataTypes($table, $column, $data_types = array())
	{
		if (empty($table) || empty($column) || empty($data_types)) {
			return false;
		}

		$result = $this->db->query(
			"SHOW COLUMNS FROM "
			. " `" . DB_PREFIX . $this->db->escape($table) . "` "
			. " WHERE `Field` = '" . $this->db->escape($column) . "'"
		);
		if ($result->num_rows) {
			$data_type_low = strtolower($result->rows[0]['Type']);
			foreach($data_types as $check) {
				$check_low = strtolower($check);
				if ($this->startsWith($data_type_low, $check_low)) {
					return true;
				}
			}
		}
		return false;
	}

}
