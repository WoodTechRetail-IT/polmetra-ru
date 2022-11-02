<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

class IMDBOptimizerHelper
{
	protected $db;
	
	// Конструктор
	function __construct(&$db = null)
	{
		if (isset($db)) {
			$this->db = &$db;
		} else {
			$this->db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
		}
	}	

	public static function getSalt($maxlen = 10)
	{
		$result = '';

		if ($maxlen <= 0) {
			return $result;
		}

		for($cnt = 0; $cnt < $maxlen; $cnt += 5) {
			$result .= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 5);
		}

		return substr($result, 0, $maxlen);
	}

	////////////////////////////
	// Данные о файле (static)
	////////////////////////////
	public static function getFileStatistic($path = null)
	{
		$result = array(
			'exist' => 0,
			'size' => 0,
			'size_normal' => '0 B',
		);

		if (!isset($path) || empty($path)) {
			return $result;
		}

		if (!file_exists($path)) {
			return $result;
		}
		$result['exist'] = 1;

		$filesize = filesize($path);
		$result['size'] = $filesize;

		$counterFileSize = 0;

		while ($filesize > 1024 && $counterFileSize <= 4) {
			$filesize = ($filesize/1024);
			$filesize = round($filesize, 3);
			$counterFileSize++;
		}

		$filesize = round($filesize, 2);

		switch($counterFileSize)
		{
			case 0:
				$result['size_normal'] = $filesize . ' B';
				break;
			case 1:
				$result['size_normal'] = $filesize . ' KB';
				break;
			case 2:
				$result['size_normal'] = $filesize . ' MB';
				break;
			case 3:
				$result['size_normal'] = $filesize . ' GB';
				break;
			case 4:
				$result['size_normal'] = $filesize . ' TB';
				break;
			default:
				$result['size_normal'] = $result['size'] . ' B';
				break;
		}

		return $result;
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

	// Обрезание строки по длине
	public function lenCut($value, $len)
	{
		if(isset($value) && !empty($value))
			// 1.3
			return mb_substr($value, 0, $len);
		return '';
	}


	// Удаление запрещенных сивмолов для элементов, которые будут внутри мета
	public function replaceStrictHtmlChar($value)
	{
		return str_replace(
		 	array('"'),
		 	array("'"),
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
				return $this->db->escape($clause) . " '" . $date->format('Y-m-d') . "' ";
			}
			else if (!empty($settings[$field_name])) {
				//$date = date_create_from_format('d.m.Y', $settings[$field_name]);
				$date = DateTime::createFromFormat('d.m.Y', $settings[$field_name]);
				if (!isset($date) || empty($date)) {
					return '';
				}
				return " and " . $this->db->escape($clause) . " '" . $date->format('Y-m-d') . "' ";
			}
		}
		catch(Exception $ex)
		{
			return '';
		}
		return '';
	}

	// В кавычках одинарных и escape
	public function inQuoteEsc($value) 
	{
		return $this->inQuote($this->db->escape($value));
	}

	// Добавление одинарных кавычек без всего остального
	public function inQuote($value) 
	{
		return '\'' . $value . '\'';
	}

	/////////////////////////////////
	// Определение наличия колонок - поддерживаемых возможностей
	/////////////////////////////////
	// Существует ли таблица
	public function isTableExists($table)
	{
		$result = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . $this->db->escape($table) . "' ");
			
		if ($result->num_rows) {
			return true;
		} 
		return false;
	}

	// Есть ли в таблице столбец
	public function isTableHaveColumn($table, $column)
	{
		$result = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . $this->db->escape($table) . "` "
			. " LIKE '" . $this->db->escape($column) . "'");
			
		if ($result->num_rows) {
			return true;
		} 
		return false;
	}
	
	// Получение настроек колонки meta_h1
	public function getMetaH1ColumnInfo()
	{
		$result = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'meta_h1'");
		if ($result->num_rows) {
			return $result->rows;
		} 
		return null;
	}
	
	// Есть главная категория
	public function isHaveMainCategory()
	{
		return $this->isTableHaveColumn('product_to_category', 'main_category');
	}
	
	// Есть поле h1
	public function isHaveMetaH1()
	{
		return $this->isTableHaveColumn('product_description', 'meta_h1');
	}
	
}
