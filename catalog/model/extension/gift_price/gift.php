<?php

/**
 * Description of gift price
 * link author   https://opencartforum.com/profile/681757-fanatic/
 * @author fanatic
 * email fanatiik0@gmail.com
 */
class ModelExtensionGiftPriceGift extends Model {

    public function getGiftText($gift_id, $gift_type) {
        $result = '';

        $this->load->language('extension/gift_price/gift');
        $this->load->model('catalog/product');

        $text_shtuk = $this->language->get('text_shtuk');

        switch ($gift_type) {
            case 1:
                $text_gift = $this->language->get('text_gift');
                $text_action = $this->language->get('text_action');
                $text_action_summa = $this->language->get('text_action_summa');

                $gift_info = $this->getGiftSumm($gift_id);

                $result = $text_gift . '<br>' . $text_action . ' ' . $text_action_summa . $this->currency->format($gift_info['price'], $this->session->data['currency']);
                break;
            case 3:
                $text_gift = $this->language->get('text_gift');
                $text_action = $this->language->get('text_action');
                $text_action_count = $this->language->get('text_action_count');

                $gift_info = $this->getGiftCount($gift_id);
                $product_info = $this->model_catalog_product->getProduct($gift_info['product_id']);

                $result = $text_gift . '<br>' . $text_action . sprintf($text_action_count, $product_info['name']) . '- ' . $gift_info['quantity'] . $text_shtuk;
                break;
            case 2:
                $text_gift = $this->language->get('text_gift');
                $text_action = $this->language->get('text_action');
                $text_action_count_all = $this->language->get('text_action_count_all');

                $gift_info = $this->getGiftCountAll($gift_id);

                $result = $text_gift . '<br>' . $text_action . $text_action_count_all . '- ' . $gift_info['count_product'] . $text_shtuk;
                break;
        }
        return $result;
    }

    public function getProductsInSuum($gift_id) {
        $sql = "SELECT p.product_id, pd.name, p.image, gprice.gift_id, p.price, pd.description FROM `" . DB_PREFIX . "gift_product` gp
						JOIN `" . DB_PREFIX . "product` p ON(p.product_id = gp.product_id)
						JOIN `" . DB_PREFIX . "product_description` pd	ON(pd.product_id = gp.product_id)
						JOIN `" . DB_PREFIX . "product_to_store` p2s ON (pd.product_id = p2s.product_id) 
						JOIN `" . DB_PREFIX . "gift_price` gprice	ON(gp.gift_id = gprice.gift_id)
						WHERE gp.gift_id = '" . (int) $gift_id . "' AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "' 
						AND p.status = '1'  AND p2s.store_id = '" . (int) $this->config->get('config_store_id') . "'";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getProductsInCountAll($count_all_id) {
        $sql = "SELECT p.product_id, pd.name, p.image, gcall.count_all_id as gift_id, p.price, pd.description FROM `" . DB_PREFIX . "gift_count_all_product` gcallp
						JOIN `" . DB_PREFIX . "product` p ON(p.product_id = gcallp.product_id)
						JOIN `" . DB_PREFIX . "product_description` pd	ON(pd.product_id = gcallp.product_id)
						JOIN `" . DB_PREFIX . "product_to_store` p2s ON (pd.product_id = p2s.product_id) 
						JOIN `" . DB_PREFIX . "gift_count_all` gcall	ON(gcall.count_all_id = gcallp.count_all_id)
						WHERE gcall.count_all_id = '" . (int) $count_all_id . "' AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "' 
						AND p.status = '1'  AND p2s.store_id = '" . (int) $this->config->get('config_store_id') . "'";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function checkProductInCart($summ, $gift_id, $gift_type) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "cart`
        WHERE `api_id` = '" . (isset($this->session->data['api_id']) ? (int) $this->session->data['api_id'] : 0) . "'
        AND `customer_id` = '" . (int) $this->customer->getId() . "'
        AND `session_id` = '" . $this->db->escape($this->session->getId()) . "'
        AND `summa` = '" . (int) $summ . "'
        AND `gift_type` = '" . (int) $gift_type . "'
        AND `gift` = '" . (int) $gift_id . "'");

        if ($query->row['total']) {
            return true;
        }

        return false;
    }

    public function getProduct($product_id) {
        $query = $this->db->query("SELECT pd.name, p.product_id, p.image FROM `" . DB_PREFIX . "product` p
                    LEFT JOIN `" . DB_PREFIX . "product_description` pd ON(p.product_id = pd.product_id)
                    LEFT JOIN `" . DB_PREFIX . "product_to_store` p2s ON(p.store_id = p2s.store_id)
                    WHERE p.product_id = '" . (int) $product_id . "'
                    AND p2s.store_id = '" . (int) $this->config->get('config_store_id') . "'
                    AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "'");

        return $query->row;
    }

    public function getProductsCount($count_product_id) {
        $query = $this->db->query("SELECT `product_id` FROM `" . DB_PREFIX . "gift_count_product` WHERE `count_product_id` = '" . (int) $count_product_id . "'");

        return $query->rows;
    }

    public function checkConfigProductInCart($cart_products, $config_products) {
        $c_p = $this->modificationConfigProducts($config_products);

        foreach ($cart_products as $cart) {
            if (key_exists($cart['product_id'], $c_p)) {
                return true;
            }
        }

        return false;
    }

    public function modificationConfigProducts($products) {
        $result = array();

        foreach ($products as $p) {
            $result[$p['product_id']] = $p;
        }

        return $result;
    }

    public function getConfigSumm() {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "gift_price` WHERE `status` = '1'");

        return $query->rows;
    }

    public function getConfigAll() {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "gift_count_all` WHERE `status` = '1'");

        return $query->rows;
    }

    public function getConfigCountProduct() {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "gift_count` WHERE `status` = '1'");

        return $query->rows;
    }

    private function getGiftSumm($gift_id) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "gift_price` WHERE `gift_id` = '" . (int) $gift_id . "'");

        return $query->row;
    }

    private function getGiftCount($gift_id) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "gift_count` WHERE `count_product_id` = '" . (int) $gift_id . "'");

        return $query->row;
    }

    private function getGiftCountAll($gift_id) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "gift_count_all` WHERE `count_all_id` = '" . (int) $gift_id . "'");

        return $query->row;
    }

    public function countProductsNoGift($filter_count_product = false) {
        $product_total = 0;
        $cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int) $this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int) $this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");

        if ($filter_count_product) {
            $action_products = $this->modificationConfigProducts($this->getConfigCountProduct());

            foreach ($cart_query->rows as $cart) {
                if ($cart['gift_type'] == 0 && !key_exists($cart['product_id'], $action_products)) {
                    $product_total += $cart['quantity'];
                }
            }
        } else {
            foreach ($cart_query->rows as $cart) {
                if ($cart['gift_type'] == 0) {
                    $product_total += $cart['quantity'];
                }
            }
        }

        return $product_total;
    }

    public function getGroupsInCift($gift_id, $gift_type) {
        $result = array();
        $sql = "SELECT `customer_group_id` FROM `" . DB_PREFIX . "gift_to_customer_group` WHERE `gift_id` = '" . (int) $gift_id . "' AND `gift_type` = '" . (int) $gift_type . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->rows as $group) {
                $result[] = $group['customer_group_id'];
            }
        } 

        return $result;
    }

    private function getProductForCart($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int) $this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int) $this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND product_id = '" . (int) $product_id . "' AND gift_type = '0'");

        return $query->rows;
    }

    public function deleteGiftInType($gift_type) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE gift_type = '" . (int) $gift_type . "' AND api_id = '" . (isset($this->session->data['api_id']) ? (int) $this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int) $this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
    }

    public function deleteGifts() {
        $this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE gift_type > 0 AND api_id = '" . (isset($this->session->data['api_id']) ? (int) $this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int) $this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
    }
    
    public function deleteGift($gift_id, $summa, $gift_type){
        $this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE gift_type = '" . (int)$gift_type . "' AND gift = '" . (int)$gift_id . "' AND summa = '" . (int) $summa . "' AND api_id = '" . (isset($this->session->data['api_id']) ? (int) $this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int) $this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
    }
    
    public function checkingSettingsForAddGifts(){
        $gift_id = $this->request->post['gift_id'];
        $summa = $this->request->post['summa'];
        $gift_type = $this->request->post['gift_type'];
        
        $config_add_gift = $this->config->get('fc_gift_setting_add_gift');
        
        if($config_add_gift == 'one'){
            $this->deleteGifts();
        }else{
            $config_add_gift_summa = $this->config->get('fc_gift_setting_add_gift_summa');
            $config_add_gift_countall = $this->config->get('fc_gift_setting_add_gift_countall');
            $config_add_gift_count = $this->config->get('fc_gift_setting_add_gift_count');
            
            switch($gift_type){
                case 1:
                    if($config_add_gift_summa == 'action_one'){
                        $this->deleteGiftInType($gift_type);
                    }
                    break;
                case 2:
                    if($config_add_gift_countall == 'action_one'){
                        $this->deleteGiftInType($gift_type);
                    }
                    break;
                case 3:
                    if($config_add_gift_count == 'action_one'){
                        $this->deleteGiftInType($gift_type);
                    }
                    break;
            }
            
        }
        
        $this->deleteGift($gift_id, $summa, $gift_type);
        
    }

}
