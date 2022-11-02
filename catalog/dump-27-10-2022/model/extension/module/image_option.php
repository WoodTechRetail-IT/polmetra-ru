<?php
class ModelExtensionModuleImageOption extends Model {

  public function getOptionsImagesByProductId($ac93e3d0a5bb3b13c4167f8bb6ed0d545) {
    
    $this->load->model('tool/image'); 
    $this->load->model('catalog/product');
    
    $a6eda9cd8e59f361c57cdc39c9b5912fc = $this->model_catalog_product->getProductOptions($ac93e3d0a5bb3b13c4167f8bb6ed0d545);

    $a992b2903ea62a5a9ed5ae08d8661f004 = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image_option WHERE product_id = " . (int)$ac93e3d0a5bb3b13c4167f8bb6ed0d545);   

    $aa995ec2dbfa18848fb033433cc694c13 = array();  
    $a648a9f3ee2f3d33b3bdf609402f66cbb = array();
    foreach ($a992b2903ea62a5a9ed5ae08d8661f004->rows as $a078a98a9653ecfdc601731154c83b0a8) {
        
        foreach ($a6eda9cd8e59f361c57cdc39c9b5912fc as $a6891c8dd1ec13d3a2f236245734b8637) {
          if ($a6891c8dd1ec13d3a2f236245734b8637['type'] == 'select' || $a6891c8dd1ec13d3a2f236245734b8637['type'] == 'radio' || $a6891c8dd1ec13d3a2f236245734b8637['type'] == 'checkbox' || $a6891c8dd1ec13d3a2f236245734b8637['type'] == 'image') { 
            foreach ($a6891c8dd1ec13d3a2f236245734b8637['product_option_value'] as $a3000610f491d7d09ff9135742b765f97) {
              if ($a3000610f491d7d09ff9135742b765f97['option_value_id'] == $a078a98a9653ecfdc601731154c83b0a8['option_value_id']) {

                $a078a98a9653ecfdc601731154c83b0a8['product_option_value_id'] = $a3000610f491d7d09ff9135742b765f97['product_option_value_id'];

                $a078a98a9653ecfdc601731154c83b0a8['image'] = $a078a98a9653ecfdc601731154c83b0a8['image'];
                $a078a98a9653ecfdc601731154c83b0a8['image_thumb'] = $this->model_tool_image->resize($a078a98a9653ecfdc601731154c83b0a8['image'], 280, 570);
                $a078a98a9653ecfdc601731154c83b0a8['image_popup'] = $this->model_tool_image->resize($a078a98a9653ecfdc601731154c83b0a8['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height'));
                
                $aa995ec2dbfa18848fb033433cc694c13[$a3000610f491d7d09ff9135742b765f97['product_option_value_id']][] = $a078a98a9653ecfdc601731154c83b0a8;
                
                if (!isset($a648a9f3ee2f3d33b3bdf609402f66cbb[$a078a98a9653ecfdc601731154c83b0a8['image']]) || !in_array($a3000610f491d7d09ff9135742b765f97['product_option_value_id'], $a648a9f3ee2f3d33b3bdf609402f66cbb[$a078a98a9653ecfdc601731154c83b0a8['image']])) {
                  $a648a9f3ee2f3d33b3bdf609402f66cbb[$a078a98a9653ecfdc601731154c83b0a8['image']][] = $a3000610f491d7d09ff9135742b765f97['product_option_value_id'];
                }
                
                break 2;                
              }
            }
          }  
        }
    }    

    $aa995ec2dbfa18848fb033433cc694c13['images'] = $a648a9f3ee2f3d33b3bdf609402f66cbb;
    
    return $aa995ec2dbfa18848fb033433cc694c13; 
  }
  
  public function getProductImage ($ac93e3d0a5bb3b13c4167f8bb6ed0d545, $a6eda9cd8e59f361c57cdc39c9b5912fc) {
    
        $ad7c151b2c8eb703deb5109a446f104b8 = array();
    foreach ($a6eda9cd8e59f361c57cdc39c9b5912fc as $a7b7092d3b2b98ff5ee8b970c288ea3b5 => $ab5f2cd8885bd4c393cb730976130d467) {
      if (is_array($ab5f2cd8885bd4c393cb730976130d467)) {
        foreach ($ab5f2cd8885bd4c393cb730976130d467 as $af0552c3d2a45d8972051898b92e65014) {
          $ad7c151b2c8eb703deb5109a446f104b8[] = (int)$af0552c3d2a45d8972051898b92e65014;
        }
      } else {      
        $ad7c151b2c8eb703deb5109a446f104b8[] = (int)$ab5f2cd8885bd4c393cb730976130d467;
      }
    }

    if ($ad7c151b2c8eb703deb5109a446f104b8) {
      
            $a317cde9518d32051bf873e23813e74e2 = $this->db->query("SELECT pov.option_value_id 
        FROM " . DB_PREFIX . "product_option_value pov 
        WHERE pov.product_option_value_id IN (" .  implode(',', $ad7c151b2c8eb703deb5109a446f104b8) . ")" . " 
          AND pov.product_id = '" . (int)$ac93e3d0a5bb3b13c4167f8bb6ed0d545 . "'");
      $a3a406ea5f6337707747e0271d8575a0a = array();
      foreach ($a317cde9518d32051bf873e23813e74e2->rows as $a078a98a9653ecfdc601731154c83b0a8) {
        $a3a406ea5f6337707747e0271d8575a0a[] = $a078a98a9653ecfdc601731154c83b0a8['option_value_id'];
      }      

            $a992b2903ea62a5a9ed5ae08d8661f004 = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image_option WHERE product_id = " . (int)$ac93e3d0a5bb3b13c4167f8bb6ed0d545);   
      $a648a9f3ee2f3d33b3bdf609402f66cbb = array();
      foreach ($a992b2903ea62a5a9ed5ae08d8661f004->rows as $a078a98a9653ecfdc601731154c83b0a8) {
        if (!isset($a648a9f3ee2f3d33b3bdf609402f66cbb[$a078a98a9653ecfdc601731154c83b0a8['image']]) || !in_array($a078a98a9653ecfdc601731154c83b0a8['option_value_id'], $a648a9f3ee2f3d33b3bdf609402f66cbb[$a078a98a9653ecfdc601731154c83b0a8['image']])) {
          $a648a9f3ee2f3d33b3bdf609402f66cbb[$a078a98a9653ecfdc601731154c83b0a8['image']][] = $a078a98a9653ecfdc601731154c83b0a8['option_value_id'];
        }        
      }
      
            foreach ($a648a9f3ee2f3d33b3bdf609402f66cbb as $aecae6246b1a7928696d8190ca90a0aeb => $ae8257df71c8594792165b3bc8cc7bdf6) {
        $ac5bf74ce9ca1f23eba5c0107c2941814 = true;
        foreach ($ae8257df71c8594792165b3bc8cc7bdf6 as $a89f9daa71aa1ccd66de713a12d8e91db) {
          if (!in_array($a89f9daa71aa1ccd66de713a12d8e91db, $a3a406ea5f6337707747e0271d8575a0a)) {
            $ac5bf74ce9ca1f23eba5c0107c2941814 = false;
          }
        }
        if ($ac5bf74ce9ca1f23eba5c0107c2941814) {
          return $aecae6246b1a7928696d8190ca90a0aeb;
        }
      }
    }
    return false;
  }
}
//author sv2109 (sv2109@gmail.com) license for 1 product copy granted for 3DMetalhead ( )
