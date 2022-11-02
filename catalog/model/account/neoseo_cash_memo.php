<?php


require_once DIR_SYSTEM . "/engine/neoseo_model.php";
class ModelAccountNeoSeoCashMemo extends NeoSeoModel
{
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->_moduleSysName = "neoseo_cash_memo";
    }
    public function getOrderProducts($order_id, $sort_product)
    {
        $sql = "";
        if ($sort_product) {
            $sort_data = ["name_asc" => " ORDER BY op.name ASC", "name_desc" => " ORDER BY op.name DESC", "model_asc" => " ORDER BY p.model ASC", "model_desc" => " ORDER BY p.model DESC", "sku_asc" => " ORDER BY p.sku ASC", "sku_desc" => " ORDER BY p.sku DESC"];
            if (array_key_exists($sort_product, $sort_data)) {
                $sql = $sort_data[$sort_product];
            }
        }
        $query = $this->db->query("SELECT op.* FROM " . DB_PREFIX . "order_product  op LEFT JOIN " . DB_PREFIX . "product p ON (op.product_id=p.product_id) WHERE order_id = '" . (int) $order_id . "'" . $sql);
        return $query->rows;
    }
    public function getDecimalPlace($currency_id)
    {
        $query = $this->db->query("SELECT decimal_place as decimals FROM `" . DB_PREFIX . "currency` WHERE currency_id = '" . (int) $currency_id . "'");
        $decimals = 2;
        if ($query->num_rows) {
            $decimals = (int) $query->row["decimals"];
        }
        return $decimals;
    }
    public function getWeightClass($weight_class_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "weight_class wc LEFT JOIN " . DB_PREFIX . "weight_class_description wcd ON (wc.weight_class_id = wcd.weight_class_id) WHERE wc.weight_class_id = '" . (int) $weight_class_id . "' AND wcd.language_id = '" . (int) $this->config->get("config_language_id") . "'");
        return $query->row;
    }
    public function getCustomerFields($customer_id)
    {
        $data = [];
        $query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "customer_scfield'");
        if (!$query->num_rows) {
            return $data;
        }
        $query = $this->db->query("SELECT name, value FROM " . DB_PREFIX . "customer_scfield WHERE customer_id = '" . (int) $customer_id . "';");
        if ($query->num_rows) {
            foreach ($query->rows as $row) {
                $data[$row["name"]] = $row["value"];
            }
        }
        return $data;
    }
    public function getCustomerFieldsNames()
    {
        $data = [];
        $query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "customer_scfield'");
        if (!$query->num_rows) {
            return $data;
        }
        $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "customer_scfield GROUP BY `name`;");
        return $query->rows;
    }
}

?>