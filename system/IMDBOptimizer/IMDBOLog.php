<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

class IMDBOLog
{
	protected $file_log;

	protected $file_log_text;

	protected $prefix;

	protected $delim;

	const NL = "\n";

	const NL2 = "\n\n";

	////////////////////////////
	// Конструктор
	////////////////////////////
	function __construct($path = null, $salt = '')
	{
		if (!isset($path) || empty($path)) {
			$this->file_log = DIR_SYSTEM . 'IMDBOptimizer/Log/' . date('Y-m-d');
			if (isset($salt) && !empty($salt)) {
				$this->file_log .= '_' . $salt;
			}
			$this->file_log .= '.log';
		} else {
			$this->file_log = $path;
		}

		$this->delim = "\n-------------------------------\n";

		$this->prefix = '';
	}

	////////////////////////////
	// Путь
	////////////////////////////
	public function getFileLogName()
	{
		return $this->file_log;
	}

	public function setFileLogName($value)
	{
		$this->file_log = $value;
	}

	////////////////////////////
	// Префикс
	////////////////////////////
	public function getPrefix()
	{
		return $this->prefix;
	}

	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;
	}

	////////////////////////////
	// Лог
	////////////////////////////
	public function add($message = '')
	{
		$this->file_log_text = $this->delim;

		$this->file_log_text .= date("Y-m-d H:i:s") . self::NL2;

		// Custom prefix
		if (!empty($this->prefix)) {
			$this->file_log_text .=	$this->prefix . self::NL2;
		}

		if (!empty($message)) {
			$this->file_log_text .= $message . self::NL2;
		} else {
			$this->file_log_text .= "Error: empty message!" . self::NL2;
		}

		$this->file_log_text .= $this->delim;

		file_put_contents($this->file_log, $this->file_log_text, FILE_APPEND | LOCK_EX);
	}

}
