<?php
class ModelExtensionModuleFlyPages extends Model {
    public function getPage($fly_page_id) {
        $query = $this->db->query("SELECT DISTINCT *, fpd.title AS name FROM " . DB_PREFIX . "fly_page fp LEFT JOIN " . DB_PREFIX . "fly_page_description fpd ON (fp.fly_page_id = fpd.fly_page_id) LEFT JOIN " . DB_PREFIX . "fly_page_to_store fp2s ON (fp.fly_page_id = fp2s.fly_page_id) WHERE fp.fly_page_id = '" . (int)$fly_page_id . "' AND fpd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND fp2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND fp.status = '1'");

        if (isset($query->row['setting'])) $query->row['setting'] = json_decode($query->row['setting'], true);
        
        return $query->row;
    }

    public function getPages() {
        $query = $this->db->query("SELECT DISTINCT fp.fly_page_id FROM " . DB_PREFIX . "fly_page fp LEFT JOIN " . DB_PREFIX . "fly_page_to_store fp2s ON (fp.fly_page_id = fp2s.fly_page_id) WHERE fp2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND fp.status = '1' ORDER BY fp.sort_order");
        return $query->rows;
    }
    
    public function getPagesByManufacturer($manufacturer_id) {
        $query = $this->db->query("SELECT DISTINCT fpm.fly_page_id, fpd.title, fp.image, fp.setting FROM " . DB_PREFIX . "fly_page_to_manufacturer fpm LEFT JOIN " . DB_PREFIX . "fly_page fp ON (fpm.fly_page_id = fp.fly_page_id) LEFT JOIN " . DB_PREFIX . "fly_page_description fpd ON (fpm.fly_page_id = fpd.fly_page_id) LEFT JOIN " . DB_PREFIX . "fly_page_to_store fp2s ON (fpm.fly_page_id = fp2s.fly_page_id) WHERE fpm.manufacturer_id = '" . (int)$manufacturer_id . "' AND fpd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND fp2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND fp.status = '1' ORDER BY fp.sort_order");
        
        $data = array();
        
        foreach ($query->rows as $page) {
            $data[] = array(
                'fly_page_id'   => $page['fly_page_id'],
                'name'          => $page['title'],
                'image'         => $page['image'],
                'setting'       => json_decode($page['setting'], true)
            );
        }
        
        return $data;
    }
    
    public function getPagesByCategory($category_id) {
        $query = $this->db->query("SELECT DISTINCT fpc.fly_page_id, fpd.title, fp.image, fp.setting FROM " . DB_PREFIX . "fly_page_to_category fpc LEFT JOIN " . DB_PREFIX . "fly_page fp ON (fpc.fly_page_id = fp.fly_page_id) LEFT JOIN " . DB_PREFIX . "fly_page_description fpd ON (fpc.fly_page_id = fpd.fly_page_id) LEFT JOIN " . DB_PREFIX . "fly_page_to_store fp2s ON (fpc.fly_page_id = fp2s.fly_page_id) WHERE fpc.category_id = '" . (int)$category_id . "' AND fpd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND fp2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND fp.status = '1' ORDER BY fp.sort_order");
        
        $data = array();
        
        foreach ($query->rows as $page) {
            $data[] = array(
                'fly_page_id'   => $page['fly_page_id'],
                'name'          => $page['title'],
                'image'         => $page['image'],
                'setting'       => json_decode($page['setting'], true)
            );
        }
        
        return $data;
    }
    
    public function getPageLayoutId($fly_page_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "fly_page_to_layout WHERE fly_page_id = '" . (int)$fly_page_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
        
        if ($query->num_rows) {
            return $query->row['layout_id'];
        } else {
            return 0;
        }
    }
}