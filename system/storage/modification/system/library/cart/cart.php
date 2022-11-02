<?php
namespace Cart;
class Cart {

				// << Related Options
				
				//private $ro_extension_installed = null;
				private $ro_registry = null;
				
				private function ro_get_products_data(&$ro_total_quantities) {
				
					$ro_ext = \liveopencart\ext\ro::getInstance($this->ro_registry);
					
					$ro_combs_for_products = array();
					$ro_total_quantities = array(); // total quantities by related options
					
					if (	$ro_ext->installed() ) {
						if (!$this->data) {
						
							$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
	
							foreach ($cart_query->rows as $cart) {
								$cart_id = $cart['cart_id'];
								$product_id = $cart['product_id'];
								$quantity = $cart['quantity'];
								
								if ($quantity > 0) {
									$options = (array)json_decode($cart['option']);
									
									$ro_combs_for_products[$cart_id] = $ro_ext->getROCombsByPOIds($product_id, $options, true);
									
									if ($ro_combs_for_products[$cart_id]) {
										foreach ($ro_combs_for_products[$cart_id] as $ro_comb) {
											if (!isset($ro_total_quantities[$ro_comb['relatedoptions_id']])) {
												$ro_total_quantities[$ro_comb['relatedoptions_id']] = 0;
											}
											$ro_total_quantities[$ro_comb['relatedoptions_id']]+= $quantity;
										}
									}
								}
							}
						}
					}
					
					return $ro_combs_for_products;
				}
				
				// >> Related Options
			
	private $data = array();

	public function __construct($registry) {

        $this->registry = $registry;
        $this->load = $registry->get('load');
      
		$this->config = $registry->get('config');
		$this->customer = $registry->get('customer');
		$this->session = $registry->get('session');
		$this->db = $registry->get('db');

				// << Related Options
				
				//if ( $this->ro_installed() ) {
					$this->ro_registry = $registry;
				//}
				
				// >> Related Options
			
		$this->tax = $registry->get('tax');
		$this->weight = $registry->get('weight');

		// Remove all the expired carts with no customer ID
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE (api_id > '0' OR customer_id = '0') AND date_added < DATE_SUB(NOW(), INTERVAL 1 HOUR)");

		if ($this->customer->getId()) {
			// We want to change the session ID on all the old items in the customers cart
			$this->db->query("UPDATE " . DB_PREFIX . "cart SET session_id = '" . $this->db->escape($this->session->getId()) . "' WHERE api_id = '0' AND customer_id = '" . (int)$this->customer->getId() . "'");

			// Once the customer is logged in we want to update the customers cart
			$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE api_id = '0' AND customer_id = '0' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");

			foreach ($cart_query->rows as $cart) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int)$cart['cart_id'] . "'");

				// The advantage of using $this->add is that it will check if the products already exist and increaser the quantity if necessary.
				
            // gift start
            $this->add($cart['product_id'], $cart['quantity'], json_decode($cart['option']), $cart['recurring_id'], $flag_gift = $cart['gift'], $summa = $cart['summa'], $gift_type = $cart['gift_type']);
            // gift end
        
			}
		}
	}


 // gift count specification product start
    private function modificationConfigProducts($products) {
        $result = array();

        foreach ($products as $p) {
            $result[$p['product_id']] = $p;
        }

        return $result;
    }

    private function getProductForCart($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int) $this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int) $this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND product_id = '" . (int) $product_id . "' AND gift_type = '0'");

        return $query->rows;
    }

    private function getConfigCountProduct() {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "gift_count` WHERE `status` = '1'");

        return $query->rows;
    }

    private function countProductsNoGift($filter_count_product = null) {
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

    public function updateCart() {
        $count = $this->countProductsNoGift(true);
        $total = $this->getTotal();

        // проверка акции на сумму
        $this->delGiftInCart($total, 1);

        // проверка акции на количество товаров
        $this->delGiftInCart($count, 2);

        // проверка акций на количество определенного товара в корзине
        // все акции на количество определенного товара
        $gift_count = $this->getConfigCountProduct();
        foreach ($gift_count as $gift) {
            // достаем товар из корзины(у которого акция на количество)
            $products = $this->getProductForCart($gift['product_id']);

            // если есть товар в корзине считаем количесво
            if ($products) {
                $quantity_product = 0;

                foreach ($products as $p) {
                    $quantity_product += $p['quantity'];
                }

                // удаляем товары акции если количество товара в корзине меньше чем у акции в базе
                $this->delGiftInCart($quantity_product, 3, $gift['count_product_id']);
            } else {
                $this->delGiftInCart(0, 3, $gift['count_product_id']);
            }
        }
    }

    private function delGiftInCart($count, $gift_type, $gift_id = null) {
        $sql = "DELETE FROM " . DB_PREFIX . "cart WHERE gift_type = '" . (int) $gift_type . "'";

        if ($gift_id) {
            $sql .= " AND gift = '" . (int) $gift_id . "'";
        }

        $sql .= " AND summa > '" . (int) $count . "' AND api_id = '" . (isset($this->session->data['api_id']) ? (int) $this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int) $this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'";

        $this->db->query($sql);
    }

    // gift count specification product end
        
	public function getProducts() {

				// << Related Options 
				
				if ( class_exists('\liveopencart\ext\ro') ) {
					if ( \liveopencart\ext\ro::getInstance($this->ro_registry)->installed() ) {
						$ro_total_quantities = array();
						$ro_combs_for_products = $this->ro_get_products_data($ro_total_quantities);
						$ro_settings = $this->config->get('related_options');
					}
				}
				
				// >> Related Options
			
		$product_data = array();

		$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");

		foreach ($cart_query->rows as $cart) {
			$stock = true;

			$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store p2s LEFT JOIN " . DB_PREFIX . "product p ON (p2s.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p2s.product_id = '" . (int)$cart['product_id'] . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");

			if ($product_query->num_rows && ($cart['quantity'] > 0)) {

				// << Related Options 
	
				$ro_price_data = false;
				$ro_custom_fields = false;
				if ( class_exists('\liveopencart\ext\ro') ) {
					if ( \liveopencart\ext\ro::getInstance($this->ro_registry)->installed() ) {
						$ro_cart_quantity = $cart['quantity'];
						
						$ro_combs = false;
						if ($ro_combs_for_products && isset($ro_combs_for_products[$cart['cart_id']]) ) {
							$ro_combs = $ro_combs_for_products[$cart['cart_id']];
						/*	
						} elseif ( !$cart['cart_id'] && !empty($cart) ) {
							$ro_temp_options = json_decode($cart['option']);
							$ro_combs = \liveopencart\ext\ro::getInstance($this->ro_registry)->getROCombsByPOIds($cart['product_id'], $ro_temp_options, true);
						*/	
						}
						if ( $ro_combs ) {
						
							$ro_custom_fields = \liveopencart\ext\ro::getInstance($this->ro_registry)->getCustomFields($product_query->row, $ro_combs);
						
							$ro_model = $ro_custom_fields['codes']['model'];
							if ($ro_model) {
								$product_query->row['model'] = $ro_model;
							}
							
							$ro_weight = $ro_custom_fields['weight'];
							if (isset($ro_settings['spec_weight']) && $ro_settings['spec_weight'] && $ro_weight !== false ) {
								$product_query->row['weight'] = $ro_weight;
							}
							
							if ( isset($ro_settings['spec_price']) && $ro_settings['spec_price'] ) {
								$ro_price_data = \liveopencart\ext\ro::getInstance($this->ro_registry)->calcProductPriceWithRO($product_query->row['price'], $ro_combs);
								$product_query->row['price'] = $ro_price_data['price'];
							}
							
							foreach ($ro_combs as $ro_comb) {
								if ($ro_comb['quantity'] < $ro_cart_quantity && ( empty($ro_settings['allow_zero_select']) || !$ro_settings['allow_zero_select']) ) {
									$stock = false;
								}
							}
						}
					}
				}
				// >> Related Options
			

          // image_option module
          $this->load->model('extension/module/image_option');
          $model_extension_module_image_option = $this->registry->get('model_extension_module_image_option');
          $image = $model_extension_module_image_option->getProductImage($cart['product_id'], json_decode($cart['option']));
          if ($image) {
            $product_query->row['image'] = $image;
          }
      
				$option_price = 0;
				$option_points = 0;
				$option_weight = 0;

				$option_data = array();

				foreach (json_decode($cart['option']) as $product_option_id => $value) {
					$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$cart['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

					if ($option_query->num_rows) {
						if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio') {
							$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

							if ($option_value_query->num_rows) {
								if ($option_value_query->row['price_prefix'] == '+') {
									$option_price += $option_value_query->row['price'];
								} elseif ($option_value_query->row['price_prefix'] == '-') {
									$option_price -= $option_value_query->row['price'];
								}

								if ($option_value_query->row['points_prefix'] == '+') {
									$option_points += $option_value_query->row['points'];
								} elseif ($option_value_query->row['points_prefix'] == '-') {
									$option_points -= $option_value_query->row['points'];
								}

								if ($option_value_query->row['weight_prefix'] == '+') {
									$option_weight += $option_value_query->row['weight'];
								} elseif ($option_value_query->row['weight_prefix'] == '-') {
									$option_weight -= $option_value_query->row['weight'];
								}

								if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
									$stock = false;
								}

								$option_data[] = array(
									'product_option_id'       => $product_option_id,
									'product_option_value_id' => $value,
									'option_id'               => $option_query->row['option_id'],
									'option_value_id'         => $option_value_query->row['option_value_id'],
									'name'                    => $option_query->row['name'],
									'value'                   => $option_value_query->row['name'],
									'type'                    => $option_query->row['type'],
									'quantity'                => $option_value_query->row['quantity'],
									'subtract'                => $option_value_query->row['subtract'],
									'price'                   => $option_value_query->row['price'],
									'price_prefix'            => $option_value_query->row['price_prefix'],
									'points'                  => $option_value_query->row['points'],
									'points_prefix'           => $option_value_query->row['points_prefix'],
									'weight'                  => $option_value_query->row['weight'],
									'weight_prefix'           => $option_value_query->row['weight_prefix']
								);
							}
						} elseif ($option_query->row['type'] == 'checkbox' && is_array($value)) {
							foreach ($value as $product_option_value_id) {
								$option_value_query = $this->db->query("SELECT pov.option_value_id, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix, ovd.name FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (pov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

								if ($option_value_query->num_rows) {
									if ($option_value_query->row['price_prefix'] == '+') {
										$option_price += $option_value_query->row['price'];
									} elseif ($option_value_query->row['price_prefix'] == '-') {
										$option_price -= $option_value_query->row['price'];
									}

									if ($option_value_query->row['points_prefix'] == '+') {
										$option_points += $option_value_query->row['points'];
									} elseif ($option_value_query->row['points_prefix'] == '-') {
										$option_points -= $option_value_query->row['points'];
									}

									if ($option_value_query->row['weight_prefix'] == '+') {
										$option_weight += $option_value_query->row['weight'];
									} elseif ($option_value_query->row['weight_prefix'] == '-') {
										$option_weight -= $option_value_query->row['weight'];
									}

									if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
										$stock = false;
									}

									$option_data[] = array(
										'product_option_id'       => $product_option_id,
										'product_option_value_id' => $product_option_value_id,
										'option_id'               => $option_query->row['option_id'],
										'option_value_id'         => $option_value_query->row['option_value_id'],
										'name'                    => $option_query->row['name'],
										'value'                   => $option_value_query->row['name'],
										'type'                    => $option_query->row['type'],
										'quantity'                => $option_value_query->row['quantity'],
										'subtract'                => $option_value_query->row['subtract'],
										'price'                   => $option_value_query->row['price'],
										'price_prefix'            => $option_value_query->row['price_prefix'],
										'points'                  => $option_value_query->row['points'],
										'points_prefix'           => $option_value_query->row['points_prefix'],
										'weight'                  => $option_value_query->row['weight'],
										'weight_prefix'           => $option_value_query->row['weight_prefix']
									);
								}
							}
						} elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
							$option_data[] = array(
								'product_option_id'       => $product_option_id,
								'product_option_value_id' => '',
								'option_id'               => $option_query->row['option_id'],
								'option_value_id'         => '',
								'name'                    => $option_query->row['name'],
								'value'                   => $value,
								'type'                    => $option_query->row['type'],
								'quantity'                => '',
								'subtract'                => '',
								'price'                   => '',
								'price_prefix'            => '',
								'points'                  => '',
								'points_prefix'           => '',
								'weight'                  => '',
								'weight_prefix'           => ''
							);
						}
					}
				}

				$price = $product_query->row['price'];

				// Product Discounts
				$discount_quantity = 0;

				foreach ($cart_query->rows as $cart_2) {
					if ($cart_2['product_id'] == $cart['product_id']) {
						$discount_quantity += $cart_2['quantity'];
					}
				}

				$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");


				// << Related Options
				
				if ( class_exists('\liveopencart\ext\ro') ) {
					if ( \liveopencart\ext\ro::getInstance($this->ro_registry)->installed() && !empty($ro_combs) && !empty($ro_settings['spec_price']) && !empty($ro_settings['spec_price_discount']) ) {
						// Related Options discounts
						$ro_discount_query = \liveopencart\ext\ro::getInstance($this->ro_registry)->getDiscountQueryForCart($ro_combs, $ro_total_quantities);
						if ( $ro_discount_query && $ro_discount_query->num_rows ) {
							$product_discount_query = $ro_discount_query;
						}
					}
				}
				// >> Related Options
			
				if ($product_discount_query->num_rows) {
					$price = $product_discount_query->row['price'];

				// << Related Options
				if ( class_exists('\liveopencart\ext\ro') ) {
					if ( \liveopencart\ext\ro::getInstance($this->ro_registry)->installed() ) {
						if ( !empty($ro_price_data['price_modificator']) ) {
							$price = $price + $ro_price_data['price_modificator'];
						}
					}
				}
				// >> Related Options
			
				}

				// Product Specials
				$product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");


				// << Related Options
				
				if ( class_exists('\liveopencart\ext\ro') ) {
					if ( \liveopencart\ext\ro::getInstance($this->ro_registry)->installed() && !empty($ro_combs) && !empty($ro_settings['spec_price']) && !empty($ro_settings['spec_price_special']) ) {
						// Related Options specials
						$ro_special_query = \liveopencart\ext\ro::getInstance($this->ro_registry)->getSpecialQueryForCart($ro_combs);
						if ( $ro_special_query && $ro_special_query->num_rows ) {
							$product_special_query = $ro_special_query;
						}
					}
				}
			
				// >> Related Options
			
				if ($product_special_query->num_rows) {
					$price = $product_special_query->row['price'];

				// << Related Options
				if ( class_exists('\liveopencart\ext\ro') ) {
					if ( \liveopencart\ext\ro::getInstance($this->ro_registry)->installed() ) {
						if ( !empty($ro_price_data['price_modificator']) ) {
							$price = $price + $ro_price_data['price_modificator'];
						}
					}
				}
				// >> Related Options
			
				}

				// Reward Points
				$product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

				if ($product_reward_query->num_rows) {
					$reward = $product_reward_query->row['points'];
				} else {
					$reward = 0;
				}

				// Downloads
				$download_data = array();

				$download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int)$cart['product_id'] . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

				foreach ($download_query->rows as $download) {
					$download_data[] = array(
						'download_id' => $download['download_id'],
						'name'        => $download['name'],
						'filename'    => $download['filename'],
						'mask'        => $download['mask']
					);
				}

				// Stock
				if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $cart['quantity'])) {
					$stock = false;
				}

				$recurring_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recurring r LEFT JOIN " . DB_PREFIX . "product_recurring pr ON (r.recurring_id = pr.recurring_id) LEFT JOIN " . DB_PREFIX . "recurring_description rd ON (r.recurring_id = rd.recurring_id) WHERE r.recurring_id = '" . (int)$cart['recurring_id'] . "' AND pr.product_id = '" . (int)$cart['product_id'] . "' AND rd.language_id = " . (int)$this->config->get('config_language_id') . " AND r.status = 1 AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

				if ($recurring_query->num_rows) {
					$recurring = array(
						'recurring_id'    => $cart['recurring_id'],
						'name'            => $recurring_query->row['name'],
						'frequency'       => $recurring_query->row['frequency'],
						'price'           => $recurring_query->row['price'],
						'cycle'           => $recurring_query->row['cycle'],
						'duration'        => $recurring_query->row['duration'],
						'trial'           => $recurring_query->row['trial_status'],
						'trial_frequency' => $recurring_query->row['trial_frequency'],
						'trial_price'     => $recurring_query->row['trial_price'],
						'trial_cycle'     => $recurring_query->row['trial_cycle'],
						'trial_duration'  => $recurring_query->row['trial_duration']
					);
				} else {
					$recurring = false;
				}


				if ($cart['price']) {
					$newprice = $cart['price'];
					$orderpro = 1;
				} else {
					$newprice = $price + $option_price;
					$orderpro = 0;
				}
						

            // gift start
            
            if($cart['gift_type'] > 0){
                $price = 0;
                $option_price = 0;
                $gift_type = $cart['gift_type'];
                $gift_summa = $cart['summa'];
                $gift_id = $cart['gift'];
            }else{
                $gift_type = '';
                $gift_summa = '';
                $gift_id = $cart['gift'];
            } 
                
            // gift end
	
				$product_data[] = array(

				// << Related Options 
				
				'sku'         => !empty($ro_custom_fields) ? $ro_custom_fields['codes']['sku'] : $product_query->row['sku'],
				'upc'         => !empty($ro_custom_fields) ? $ro_custom_fields['codes']['upc'] : $product_query->row['upc'],
				'ean'         => !empty($ro_custom_fields) ? $ro_custom_fields['codes']['ean'] : $product_query->row['ean'],
				'location'    => !empty($ro_custom_fields) ? $ro_custom_fields['codes']['location'] : $product_query->row['location'],
				
				// >> Related Options 
			
			

          // gift start
          'gift_id' => $gift_id,
          'gift_type' => $gift_type,
          'gift_summa' => $gift_summa,
          // gift end
	

				'sku'             => $product_query->row['sku'],
			
					'cart_id'         => $cart['cart_id'],
					'product_id'      => $product_query->row['product_id'],
					'name'            => $product_query->row['name'],

					'sku'             => $product_query->row['sku'],
					'upc'             => $product_query->row['upc'],
					'ean'             => $product_query->row['ean'],
					'jan'             => $product_query->row['jan'],
					'isbn'            => $product_query->row['isbn'],
					'mpn'             => $product_query->row['mpn'],
					'location'        => $product_query->row['location'],
					'product_row'     => $cart['product_row'],
					'orderpro'        => (!empty($orderpro)) ? 1 : 0,
					'model'           => $product_query->row['model'],
					'shipping'        => $product_query->row['shipping'],
					'image'           => $product_query->row['image'],
					'option'          => $option_data,
					'download'        => $download_data,
					'quantity'        => $cart['quantity'],
					'minimum'         => $product_query->row['minimum'],
					'subtract'        => $product_query->row['subtract'],
					'stock'           => $stock,
					'price'           => $newprice,
					'total'           => $newprice * $cart['quantity'],
					'reward'          => $reward * $cart['quantity'],
					'points'          => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $cart['quantity'] : 0),
					'tax_class_id'    => $product_query->row['tax_class_id'],
					'weight'          => ($product_query->row['weight'] + $option_weight) * $cart['quantity'],
					'weight_class_id' => $product_query->row['weight_class_id'],
					'length'          => $product_query->row['length'],
					'width'           => $product_query->row['width'],
					'height'          => $product_query->row['height'],
					'length_class_id' => $product_query->row['length_class_id'],
					'recurring'       => $recurring
				);
			} else {
				$this->remove($cart['cart_id']);
			}
		}

		return $product_data;
	}

	
            public function add($product_id, $quantity = 1, $option = array(), $recurring_id = 0, $flag_gift = NULL, $summa = NULL, $gift_type = NULL) {
                if ($gift_type > 0) {
                    $this->db->query("INSERT " . DB_PREFIX . "cart 
                                    SET api_id = '" . (isset($this->session->data['api_id']) ? (int) $this->session->data['api_id'] : 0) . "',
                                    `customer_id` = '" . (int) $this->customer->getId() . "', 
                                    `session_id` = '" . $this->db->escape($this->session->getId()) . "', 
                                    `product_id` = '" . (int) $product_id . "', 
                                    `recurring_id` = '" . (int) $recurring_id . "', 
                                    `option` = '" . $this->db->escape(json_encode($option)) . "', 
                                    `quantity` = '" . (int) $quantity . "', 
                                    `date_added` = NOW(),
                                    `gift` = '" . (int)$flag_gift . "',
                                    `gift_type` = '" . (int) $gift_type . "',
                                    `summa` = '" . (float)$summa . "'");
                } else {
                    $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int) $this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int) $this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND product_id = '" . (int) $product_id . "' AND recurring_id = '" . (int) $recurring_id . "' AND `option` = '" . $this->db->escape(json_encode($option)) . "' AND `gift_type` = '0'");

                    if (!$query->row['total']) {
                        $this->db->query("INSERT " . DB_PREFIX . "cart SET api_id = '" . (isset($this->session->data['api_id']) ? (int) $this->session->data['api_id'] : 0) . "', customer_id = '" . (int) $this->customer->getId() . "', session_id = '" . $this->db->escape($this->session->getId()) . "', product_id = '" . (int) $product_id . "', recurring_id = '" . (int) $recurring_id . "', `option` = '" . $this->db->escape(json_encode($option)) . "', quantity = '" . (int) $quantity . "', date_added = NOW()");
                    } else {
                        $this->db->query("UPDATE " . DB_PREFIX . "cart SET quantity = (quantity + " . (int) $quantity . ") WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int) $this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int) $this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND product_id = '" . (int) $product_id . "' AND recurring_id = '" . (int) $recurring_id . "' AND `option` = '" . $this->db->escape(json_encode($option)) . "'");
                    }
                }
            }
	

	public function update($cart_id, $quantity) {
		$this->db->query("UPDATE " . DB_PREFIX . "cart SET quantity = '" . $quantity . "' WHERE cart_id = '" . (int)$cart_id . "' AND api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");

            // gift start

            $this->updateCart();

            // gift end
	
	}

	public function remove($cart_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int)$cart_id . "' AND api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");

            // gift start
                
            $this->updateCart();
                
            // gif end
	
	}

	public function clear() {
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
	}

	public function getRecurringProducts() {
		$product_data = array();

		foreach ($this->getProducts() as $value) {
			if ($value['recurring']) {
				$product_data[] = $value;
			}
		}

		return $product_data;
	}

	public function getWeight() {
		$weight = 0;

		foreach ($this->getProducts() as $product) {
			if ($product['shipping']) {
				$weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
			}
		}

		return $weight;
	}

	public function getSubTotal() {
		$total = 0;

		foreach ($this->getProducts() as $product) {
			$total += $product['total'];
		}

		return $total;
	}

	public function getTaxes() {
		$tax_data = array();

		foreach ($this->getProducts() as $product) {
			if ($product['tax_class_id']) {
				$tax_rates = $this->tax->getRates($product['price'], $product['tax_class_id']);

				foreach ($tax_rates as $tax_rate) {
					if (!isset($tax_data[$tax_rate['tax_rate_id']])) {
						$tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $product['quantity']);
					} else {
						$tax_data[$tax_rate['tax_rate_id']] += ($tax_rate['amount'] * $product['quantity']);
					}
				}
			}
		}

		return $tax_data;
	}

	public function getTotal() {
		$total = 0;

		foreach ($this->getProducts() as $product) {
			$total += $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'];
		}

		return $total;
	}

	public function countProducts() {
		$product_total = 0;
        $i=0;
		$products = $this->getProducts();

		foreach ($products as $product) {
			$product_total += $product['quantity'];
			$i++;
		}
        $product_total = $i;
		return $product_total;
	}

	public function hasProducts() {
		return count($this->getProducts());
	}

	public function hasRecurringProducts() {
		return count($this->getRecurringProducts());
	}

	public function hasStock() {
		foreach ($this->getProducts() as $product) {
			if (!$product['stock']) {
				return false;
			}
		}

		return true;
	}

	public function hasShipping() {
		foreach ($this->getProducts() as $product) {
			if ($product['shipping']) {
				return true;
			}
		}

		return false;
	}

	public function hasDownload() {
		foreach ($this->getProducts() as $product) {
			if ($product['download']) {
				return true;
			}
		}

		return false;
	}
}
