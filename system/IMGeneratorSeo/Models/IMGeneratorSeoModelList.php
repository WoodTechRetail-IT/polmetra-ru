<?php
/*
	Author: Igor Mirochnik
	Site: http://ida-freewares.ru
	Site: http://im-cloud.ru
	Email: dev.imirochnik@gmail.com
	Type: commercial
*/

require_once 'IMGeneratorSeoAbstractModel.php';

class IMGeneratorSeoModelList extends IMGeneratorSeoAbstractModel
{
	//////////////////////////////
	// Дополнительные функции
	//////////////////////////////


	//////////////////////////////
	// Списки
	//////////////////////////////

	// Получение списка производителей
	// Получение списка производителей
	public function getManufacturer()
	{
		$all_items_default = $this->language->get('all_items_default');

		$resultList = array();

		/*
		$resultList[] = array(
			'id' => -1,
			'name'        => $all_items_default,
			'image'  	  => '',
			'sort_order'  => -1
		);
		*/

		// Получаем список производителей
		$query = $this->db->query("SELECT * "
				. " FROM `" . DB_PREFIX . "manufacturer` m "
				. " ORDER BY m.sort_order asc, name asc"
		);

		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['manufacturer_id'],
				'name' => $result['name'],
				'image' => $result['image'],
				'sort_order' => $result['sort_order']
			);
		}

		return $resultList;
	}

	// Получение списка магазинов
	public function getStore()
	{
		$all_items_default = $this->language->get('all_items_default');

		$resultList = array();

		$resultList[] = array(
			'id' => -1,
			'name' => $all_items_default,
		);

		$resultList[] = array(
			'id' => 0,
			'name' => $this->config->get('config_name') . $this->language->get('text_default'),
		);

		// Получаем список производителей
		$query = $this->db->query("SELECT * "
				. " FROM `" . DB_PREFIX . "store` m "
				. " ORDER BY name asc"
		);

		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['store_id'],
				'name' => $result['name'],
			);
		}

		return $resultList;
	}

	// Получение списка атрибутов
	public function getAttributeList()
	{
		$language_id = (int)$this->config->get('config_language_id');

		$resultList = array();

		// Получаем список атрибутов
		$query = $this->db->query(
			"SELECT a.attribute_id, a.name "
			. " FROM `" . DB_PREFIX . "attribute_description` a "
			. " where a.language_id = " . (int)$language_id
			. " ORDER BY a.name"
		);

		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['attribute_id'],
				'name' => $result['name'],
				'viewname' => $result['name'],
				'pattern' => '[attr_' . $result['name'] . ']',
			);
		}
		return $resultList;

	}

	// Получение списка атрибутов
	public function getAttributeListWithGroup()
	{
		$language_id = (int)$this->config->get('config_language_id');

		$resultList = array();

		// Получаем список атрибутов
		$query = $this->db->query(
			"SELECT a.attribute_id, "
			 	. " concat(ifnull(agd.name,''), '_', ad.name) as name, "
				. " concat(ifnull(agd.name,''), ' - ', ad.name) as viewname "
				. " "
			. " FROM `" . DB_PREFIX . "attribute_description` ad "
				. " join `" . DB_PREFIX . "attribute` a"
					. " on a.attribute_id = ad.attribute_id"
				. " left join `" . DB_PREFIX . "attribute_group` ag"
					. " on ag.attribute_group_id = a.attribute_group_id"
				. " left join `" . DB_PREFIX . "attribute_group_description` agd"
					. " on ag.attribute_group_id = agd.attribute_group_id"
						. " and agd.language_id = " . (int)$language_id
			. " where ad.language_id = " . (int)$language_id
			. " ORDER BY agd.name, ad.name "
		);

		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['attribute_id'],
				'name' => $result['name'],
				'viewname' => $result['viewname'],
				'pattern' => '[attr_' . $result['name'] . ']',
			);
		}

		return $resultList;
	}

	// Получение списка атрибутов по фильтру
	public function getAttrsByFilter($filter, $limit, $is_group = false)
	{
		$resultList = array();

		$language_id = (int)$this->config->get('config_language_id');

		$sqlQuery = '';

		if ($is_group) {
			$sqlQuery =
				"SELECT a.attribute_id, "
					. " concat(ifnull(agd.name,''), '_', ad.name) as name, "
					. " concat(ifnull(agd.name,''), ' - ', ad.name) as viewname "
					. " "
				. " FROM `" . DB_PREFIX . "attribute_description` ad "
					. " join `" . DB_PREFIX . "attribute` a"
						. " on a.attribute_id = ad.attribute_id"
					. " left join `" . DB_PREFIX . "attribute_group` ag"
						. " on ag.attribute_group_id = a.attribute_group_id"
					. " left join `" . DB_PREFIX . "attribute_group_description` agd"
						. " on ag.attribute_group_id = agd.attribute_group_id"
							. " and agd.language_id = " . (int)$language_id
				. " where ad.language_id = " . (int)$language_id
					. " and concat(ifnull(agd.name,''), ' - ', ad.name) like '%" . $this->db->escape($filter) . "%'"
				. " ORDER BY agd.name, ad.name "
				. " LIMIT " . (int)$limit
			;
		} else {
			$sqlQuery =
				"SELECT a.attribute_id, a.name, "
					. " a.name as viewname "
				. " FROM `" . DB_PREFIX . "attribute_description` a "
				. " where a.language_id = " . (int)$language_id
					. " and a.name like '%" . $this->db->escape($filter) . "%'"
				. " ORDER BY a.name"
				. " LIMIT " . (int)$limit
			;
		}

		$query = $this->db->query($sqlQuery);

		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
				'name' => html_entity_decode($result['viewname'], ENT_QUOTES, 'UTF-8'),
				'text' => html_entity_decode($result['viewname'], ENT_QUOTES, 'UTF-8'),
			);
		}

		return $resultList;
	}

	// Получение списка атрибутов продукта
	public function getProductAttributeList($product_id, $language_id)
	{
		$language_id_list = (int)$this->config->get('config_language_id');
		$resultList = array();

		// Получаем список атрибутов
		$query = $this->db->query(
			"SELECT ad.attribute_id, "
				. " ad.name, "
				. " pa.text as value "
			. " FROM `" . DB_PREFIX . "attribute_description` ad "
				. " join `" . DB_PREFIX . "attribute` a "
					. " on a.attribute_id = ad.attribute_id "
				. " join `" . DB_PREFIX . "product_attribute` pa"
					. " on a.attribute_id = pa.attribute_id "
						. " and pa.language_id = " . (int)$language_id
						. " and pa.product_id = " . (int)$product_id
			. " where ad.language_id = " . (int)$language_id_list
			. " ORDER BY ad.name"
		);

		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['attribute_id'],
				'name' => $result['name'],
				'pattern' => '[attr_' . $result['name'] . ']',
				'value' => $result['value']
			);
		}

		return $resultList;
	}

	// Получение списка атрибутов продукта
	public function getProductAttributeListWithGroup($product_id, $language_id)
	{
		$language_id_list = (int)$this->config->get('config_language_id');
		$resultList = array();

		// Получаем список атрибутов
		$query = $this->db->query(
			"SELECT ad.attribute_id, "
				. " concat(ifnull(agd.name,''), '_', ad.name) as name, "
				. " pa.text as value "
			. " FROM `" . DB_PREFIX . "attribute_description` ad "
				. " join `" . DB_PREFIX . "attribute` a "
					. " on a.attribute_id = ad.attribute_id "
				. " join `" . DB_PREFIX . "product_attribute` pa"
					. " on a.attribute_id = pa.attribute_id "
						. " and pa.language_id = " . (int)$language_id
						. " and pa.product_id = " . (int)$product_id
				. " left join `" . DB_PREFIX . "attribute_group` ag"
					. " on ag.attribute_group_id = a.attribute_group_id"
				. " left join `" . DB_PREFIX . "attribute_group_description` agd"
					. " on ag.attribute_group_id = agd.attribute_group_id"
						. " and agd.language_id = " . (int)$language_id
			. " where ad.language_id = " . (int)$language_id_list
			. " ORDER BY agd.name, ad.name"
		);

		// Формируем результирующий массив
		foreach ($query->rows as $result) {
			$resultList[] = array(
				'id' => $result['attribute_id'],
				'name' => $result['name'],
				'pattern' => '[attr_' . $result['name'] . ']',
				'value' => $result['value']
			);
		}

		return $resultList;
	}

	// Получение списка категорий
	public function getCategoriesFull($parent_delimeter = ' > ')
	{
		// Получаем список категорий на текущем языке
		$query = $this->db->query(
			"SELECT c.category_id, c.parent_id, cd.name "
			. " FROM `" . DB_PREFIX . "category` c "
				. " LEFT JOIN `" . DB_PREFIX . "category_description` cd "
					. " ON (c.category_id = cd.category_id) "
			. " WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' "
			. " ORDER BY cd.name asc"
		);

		$cat_list_parent = array();
		foreach ($query->rows as $result) {
			$cat_list_parent[$result['parent_id']][] = array(
				'id' => $result['category_id'],
				'name' => $result['name'],
			);
		}

		$result = array();

		$this->_getCategoriesFromPA($result, $cat_list_parent);

		return $result;
	}

	// Рекурсивнвый обход и построение дерева
	protected function _getCategoriesFromPA(
		&$result,
		&$cat_list_parent,
		$curr_parent_id = 0,
		$parent_prefix = ''
	) {
		// Если существуют первые ноды
		if (isset($cat_list_parent[$curr_parent_id]))
		{
			// Проходимся по нодам
			foreach($cat_list_parent[$curr_parent_id] as $item)
			{
				// Собираем первые ноды
				$result[] = array(
					'id' => $item['id'],
					'name' => $parent_prefix . $item['name'],
				);

				// Собираем чайлды нодов
				$this->_getCategoriesFromPA(
					$result,
					$cat_list_parent,
					$item['id'],
					$parent_prefix . $item['name'] . ' > '
				);
			}
		}
	}

}
