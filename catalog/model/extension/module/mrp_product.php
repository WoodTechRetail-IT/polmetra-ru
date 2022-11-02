<?php
class ModelExtensionModuleMrpProduct extends Model {
	public function getMrpTable($product_id) {
		$product_mrp_data = array();

		$product_mrp_query = $this->db->query("SELECT ctd.title, ct.product_mrp_id, ctd.description FROM " . DB_PREFIX . "product_mrp ct LEFT JOIN " . DB_PREFIX . "product_mrp_description ctd ON (ct.product_mrp_id = ctd.product_mrp_id) LEFT JOIN " . DB_PREFIX . "product_mrp_product ctp ON (ct.product_mrp_id = ctp.product_mrp_id)	LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = ctp.related_id) WHERE ct.product_id = '" . (int)$product_id . "' AND ctd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ct.status = '1' AND p.status = '1' AND ctp.product_mrp_id != '0' GROUP BY ct.product_mrp_id ORDER BY ct.sort_order, ctd.title");
		
		foreach ($product_mrp_query->rows as $product_mrp) {
			$product_mrp_product_data = array();

			$product_mrp_product_data_q = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_mrp_product ctp LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = ctp.related_id) WHERE ctp.product_mrp_id = '" . (int)$product_mrp['product_mrp_id'] . "' AND ctp.product_id = '" . (int)$product_id . "' AND p.status = '1' ORDER BY ctp.sort_order, LCASE(ctp.product_mrp_related_id)");
			
			$product_mrp_data[] = array(
				'title'                    => $product_mrp['title'],
				'description'              => $product_mrp['description'],
				'product_mrp_id'          => $product_mrp['product_mrp_id'],
				'product_mrp_product'     => $product_mrp_product_data_q,						
			);
		}

		return $product_mrp_data;
	}
}