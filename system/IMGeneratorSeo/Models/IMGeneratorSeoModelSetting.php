<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMGeneratorSeoAbstractModel.php';

class IMGeneratorSeoModelSetting extends IMGeneratorSeoAbstractModel
{
	/////////////////////////////////////////
	// Установка
	/////////////////////////////////////////

	public function install()
	{
		// Создаем таблицу
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "imgeneratorseo_cat_lang_set` (
				`category_id` int(11) NOT NULL,
				`language_id` int(11) NOT NULL,
				`params` text NOT NULL,
				PRIMARY KEY (`category_id`, `language_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
		);

		// Создаем таблицу
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "imgeneratorseo_product_info` (
				`product_id` int(11) NOT NULL,
				`language_id` int(11) NOT NULL,
				`description` text NOT NULL,
				PRIMARY KEY (`product_id`, `language_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
		);

		// Увеличиваем размер настроек шаблона
		$this->db->query(
			'alter table `' . DB_PREFIX . 'imgeneratorseo_cat_lang_set` modify `params` mediumtext not null'
		);
	}

	/////////////////////////////////////////
	// Деинсталляция
	/////////////////////////////////////////

	public function uninstall()
	{
	}

	//////////////////////////////
	// Дополнительные функции
	//////////////////////////////

	/////////////////////////////////////////
	// Функции с настройками
	/////////////////////////////////////////

	// Дефолтные параметры
	public function getDefaultSet()
	{
		return array(
		);
	}

	// Получения настроек для языков
	public function getSettings($data)
	{
		// Настройки для языков
		$settings = array();

		// Настройки по умолчанию
		$settings = $this->getDefaultSet();

		// Получаем данные
		$category_id = $data['cat'];
		$language_id = $data['language_id'];

		// Подгружаем шабюлон
		$query = $this->db->query(
			"SELECT * "
			. " FROM `" . DB_PREFIX . "imgeneratorseo_cat_lang_set` im "
			. " WHERE im.category_id = " . (int)$category_id
				. " and im.language_id = " . (int)$language_id
		);

		if ($query->num_rows > 0)
		{
			// Вытаскиваем настройки
			foreach ($query->rows as $result)
			{
				if (!empty($result['params']))
				{
					$params = json_decode($result['params'], true);

					if (empty($params))
					{
						continue;
					}

					foreach($params as $key=>$value)
					{
						if (!is_array($value))
						{
							$params[$key] = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
						}
					}

					if (!empty($params))
					{
						// Сохраняем для языка настройки
						$settings = array_merge($settings, $params);
					}
				}
			}
		}

		return $settings;

	}

	// Сохранение настроек для языков
	public function saveSettings($data)
	{
		// Получаем данные
		$category_id = $data['cat'];
		$language_id = $data['language_id'];
		$params = json_encode($data);

		// Сохраняем настройки
		$this->db->query("INSERT INTO `" . DB_PREFIX . "imgeneratorseo_cat_lang_set` "
				. "(category_id, language_id, params) "
				. " VALUES (" . (int)$category_id . ", " . (int)$language_id . ", '"
						. $this->db->escape($params) . "' "
				.") "
			. "ON DUPLICATE KEY UPDATE "
				. " params='" . $this->db->escape($params) . "' "
		);
	}


}
