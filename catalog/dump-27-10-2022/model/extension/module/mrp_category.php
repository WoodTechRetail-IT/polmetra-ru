<?php
class ModelExtensionModuleMrpCategory extends Model {
	public function getMrpTable($category_id) {
		$category_mrp_data = array();

		$category_mrp_query = $this->db->query("SELECT ctd.title, ct.category_mrp_id, ctd.description FROM " . DB_PREFIX . "category_mrp ct LEFT JOIN " . DB_PREFIX . "category_mrp_description ctd ON (ct.category_mrp_id = ctd.category_mrp_id) LEFT JOIN " . DB_PREFIX . "category_mrp_product ctp ON (ct.category_mrp_id = ctp.category_mrp_id)	LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = ctp.product_id) WHERE ct.category_id = '" . (int)$category_id . "' AND ctd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ct.status = '1' AND p.status = '1' AND ctp.category_mrp_id != '0' GROUP BY ct.category_mrp_id ORDER BY ct.sort_order, ctd.title");
		foreach ($category_mrp_query->rows as $category_mrp) {
			$category_mrp_product_data = array();

			$category_mrp_product_data_q = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_mrp_product ctp LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = ctp.product_id) WHERE ctp.category_mrp_id = '" . (int)$category_mrp['category_mrp_id'] . "' AND ctp.category_id = '" . (int)$category_id . "' AND p.status = '1' ORDER BY ctp.sort_order, LCASE(ctp.category_mrp_product_id)");
			$category_mrp_data[] = array(
				'title'                    => $category_mrp['title'],
				'description'              => $category_mrp['description'],
				'category_mrp_id'          => $category_mrp['category_mrp_id'],
				'category_mrp_product'     => $category_mrp_product_data_q,						
			);
		}

		return $category_mrp_data;
	}
}