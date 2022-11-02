<?php
class ModelCatalogImageOption extends Model {

  public function getOptionsImagesByProductId($product_id) {
    
    $this->load->model('tool/image'); 
    $this->load->model('catalog/product');
    
    $product_options = $this->model_catalog_product->getProductOptions($product_id);
    
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image_option WHERE product_id = " . (int)$product_id);   
     
    $data = array();  
    $images = array();
    foreach ($query->rows as $result) {
        
        foreach ($product_options as $option) {
          if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') { 
            foreach ($option['option_value'] as $option_value) {
              if ($option_value['option_value_id'] == $result['option_value_id']) {

                $result['product_option_value_id'] = $option_value['product_option_value_id'];
                //$result['option'] = $option;
                //$result['option_value'] = $option_value;
                $result['image'] = $result['image'];
                $result['image_thumb'] = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
                $result['image_popup'] = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
                
                $data[$option_value['product_option_value_id']][] = $result;
                
                if (!isset($images[$result['image']]) || !in_array($option_value['product_option_value_id'], $images[$result['image']])) {
                  $images[$result['image']][] = $option_value['product_option_value_id'];
                }
                
                break 2;
                
              }
            }
          }  
        }
    }    

    $data['images'] = $images;
    
    return $data; 
  }
  
  public function getProductImage ($product_id, $product_options) {
    
    //get checked product option values
    $product_option_values = array();
    foreach ($product_options as $product_option_id => $product_option_value) {
      if (is_array($product_option_value)) {
        foreach ($product_option_value as $product_option_value_id) {
          $product_option_values[] = (int)$product_option_value_id;
        }
      } else {      
        $product_option_values[] = (int)$product_option_value;
      }
    }

    if ($product_option_values) {
      
      //get options_values form product_options_values
      $option_value_query = $this->db->query("SELECT pov.option_value_id 
        FROM " . DB_PREFIX . "product_option_value pov 
        WHERE pov.product_option_value_id IN (" .  implode(',', $product_option_values) . ")" . " 
          AND pov.product_id = '" . (int)$product_id . "'");
      $checked_option_values = array();
      foreach ($option_value_query->rows as $result) {
        $checked_option_values[] = $result['option_value_id'];
      }      

      //get all options for images
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image_option WHERE product_id = " . (int)$product_id);   
      $images = array();
      foreach ($query->rows as $result) {
        if (!isset($images[$result['image']]) || !in_array($result['option_value_id'], $images[$result['image']])) {
          $images[$result['image']][] = $result['option_value_id'];
        }        
      }
      
      //for each image check if all options checked, return this image if all checked 
      foreach ($images as $image => $options_values) {
        $all_options_checked = true;
        foreach ($options_values as $option_value_id) {
          if (!in_array($option_value_id, $checked_option_values)) {
            $all_options_checked = false;
          }
        }
        if ($all_options_checked) {
          return $image;
        }
      }
    }
    return false;
  }
}