<?php

/**
 * Description of gift price
 * link author   https://opencartforum.com/profile/681757-fanatic/
 * @author fanatic
 * email fanatiik0@gmail.com
 */
class ControllerExtensionGiftPriceGift extends Controller {

    private $gift_type = array('summ' => 1, 'count_all' => 2, 'count' => 3);
    private $img_width = 50;
    private $img_height = 50;
    private $cart_total;
    private $cart_count;
    private $cart_products;
    private $config_summ;
    private $config_count_all;
    private $config_count_product;
    private $setting_summ_output;
    private $setting_countall_output;
    private $setting_count_output;
    private $setting_text = array();
    private $language_id;
    private $customer_group_id;

    public function index() {
        $this->load->model('extension/gift_price/gift');
        $this->load->language('extension/gift_price/gift');
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        $this->init();

        $data['gifts'] = $this->getGiftSumm();
        $data['count_specific_product'] = $this->getGiftCount();
        $data['gift_count_all'] = $this->getGiftCountAll();

        $data['redirect'] = $this->url->link('checkout/cart');

        if (isset($this->request->post['gift'])) {
            return $this->response->setOutput($this->load->view('extension/gift_price/gift', $data));
        } else {
            return $this->load->view('extension/gift_price/gift', $data);
        }
    }

    private function init() {
        if ($this->customer->isLogged()) {
            $this->customer_group_id = $this->customer->getGroupId();
        } else {
            $this->customer_group_id = 0;
        }
        $this->language_id = $this->config->get('config_language_id');
        $this->cart_total = $this->cart->getTotal();
        $this->cart_count = $this->model_extension_gift_price_gift->countProductsNoGift(true);
        $this->cart_products = $this->cart->getProducts();
        $this->config_summ = $this->getConfigSumm();
        $this->config_count_all = $this->getConfigAll();
        $this->config_count_product = $this->getConfigCountProduct();
        $this->setting_summ_output = $this->config->get('fc_gift_setting_summ_output');
        $this->setting_countall_output = $this->config->get('fc_gift_setting_countall_output');
        $this->setting_count_output = $this->config->get('fc_gift_setting_count_output');

        $this->setting_text['summ'] = array(
          'select' => $this->config->get('fc_gift_setting_summ_text_select'),
          'next' => $this->config->get('fc_gift_setting_summ_text_next'),
          'on' => $this->config->get('fc_gift_setting_summ_text_on')
        );

        $this->setting_text['countall'] = array(
          'select' => $this->config->get('fc_gift_setting_countall_text_select'),
          'next' => $this->config->get('fc_gift_setting_countall_text_next'),
          'on' => $this->config->get('fc_gift_setting_countall_text_on')
        );

        $this->setting_text['count'] = array(
          'select' => $this->config->get('fc_gift_setting_count_text_select'),
          'next' => $this->config->get('fc_gift_setting_count_text_next'),
          'on' => $this->config->get('fc_gift_setting_count_text_on')
        );

        if ($this->config->get('fc_gift_setting_image_width')) {
            $this->img_width = $this->config->get('fc_gift_setting_image_width');
        }

        if ($this->config->get('fc_gift_setting_image_height')) {
            $this->img_height = $this->config->get('fc_gift_setting_image_height');
        }
    }

    private function getConfigSumm() {
        return $this->model_extension_gift_price_gift->getConfigSumm();
    }

    private function getConfigAll() {
        return $this->model_extension_gift_price_gift->getConfigAll();
    }

    private function getConfigCountProduct() {
        return $this->model_extension_gift_price_gift->getConfigCountProduct();
    }

    private function getGiftSumm() {
        $gift_summ = array();

        if ($this->config_summ) {
            foreach ($this->config_summ as $p) {
                $customer_groups = $this->model_extension_gift_price_gift->getGroupsInCift($p['gift_id'], 1);

                if (in_array($this->customer_group_id, $customer_groups)) {
                    $check_product_in_cart = $this->model_extension_gift_price_gift->checkProductInCart($p['price'], $p['gift_id'], $this->gift_type['summ']);
                    if ($check_product_in_cart) {
                        $gift_summ[$p['gift_id']]['text'] = $this->getTextInSumma($p, $this->cart_total, true);
                    } else {
                        $products = $this->getProducts($p, $this->gift_type['summ']);
                        if ($products) {
                            $gift_summ[$p['gift_id']]['text'] = $this->getTextInSumma($p, $this->cart_total, false);
                            $gift_summ[$p['gift_id']]['products'] = $products;
                        }
                    }
                }
            }
        }

        return $gift_summ;
    }

    private function getGiftCountAll() {
        $gift_count_all = array();

        if ($this->config_count_all) {
            foreach ($this->config_count_all as $p) {
                $customer_groups = $this->model_extension_gift_price_gift->getGroupsInCift($p['count_all_id'], 2);

                if (in_array($this->customer_group_id, $customer_groups)) {
                    $check_product_in_cart = $this->model_extension_gift_price_gift->checkProductInCart($p['count_product'], $p['count_all_id'], $this->gift_type['count_all']);

                    if ($check_product_in_cart) {
                        $gift_count_all[$p['count_all_id']]['text'] = $this->getTextInCountAll($p['count_product'], $this->cart_count, true);
                    } else {
                        $products = $this->getProducts($p, $this->gift_type['count_all']);

                        if ($products) {
                            $gift_count_all[$p['count_all_id']]['text'] = $this->getTextInCountAll($p['count_product'], $this->cart_count, false);
                            $gift_count_all[$p['count_all_id']]['products'] = $products;
                        }
                    }
                }
            }
        }

        return $gift_count_all;
    }

    private function getGiftCount() {
        $count_specific_product = array();

        if ($this->config_count_product) {
            $check_config_product_in_cart = $this->model_extension_gift_price_gift->checkConfigProductInCart($this->cart_products, $this->config_count_product);

            if ($check_config_product_in_cart) {
                $products = array();
                $modification_config_products = $this->model_extension_gift_price_gift->modificationConfigProducts($this->config_count_product);

                foreach ($this->cart_products as $cart) {
                    if (key_exists($cart['product_id'], $modification_config_products)) {
                        $count = 0;
                        foreach ($this->cart_products as $cart2) {
                            if ($cart2['price'] != 0) {
                                if ($cart2['product_id'] == $cart['product_id']) {
                                    $count += $cart2['quantity'];
                                }
                            }
                        }
                        $products[$cart['product_id']] = array(
                          'quantity' => $count
                        );
                    }
                }

                if ($products) {
                    $data['count_specific_product'] = array();

                    foreach ($this->config_count_product as $c_p) {
                        $customer_groups = $this->model_extension_gift_price_gift->getGroupsInCift($c_p['count_product_id'], 3);

                        if (in_array($this->customer_group_id, $customer_groups)) {
                            $conf_product_info = $this->model_catalog_product->getProduct($c_p['product_id']);
                            $check_product_in_cart = $this->model_extension_gift_price_gift->checkProductInCart($c_p['quantity'], $c_p['count_product_id'], 3);
                            if (!$check_product_in_cart && isset($products[$c_p['product_id']])) {
                                $count_specific_product[$c_p['count_product_id']]['text'] = $this->getTextSpecificProduct($c_p['quantity'], $products[$c_p['product_id']]['quantity'], $conf_product_info['name'], false);

                                $id_products = $this->model_extension_gift_price_gift->getProductsCount($c_p['count_product_id']);

                                if ($id_products) {
                                    foreach ($id_products as $p) {
                                        $product_info = $this->model_catalog_product->getProduct($p['product_id']);

                                        $image = $this->model_tool_image->resize($product_info['image'], $this->img_width, $this->img_height);
                                        $href = $this->url->link('product/product', '&product_id=' . $product_info['product_id']);
                                        $button = $this->getFlagButton($products[$c_p['product_id']]['quantity'], $c_p['quantity']);

                                        $count_specific_product[$c_p['count_product_id']]['products'][] = array(
                                          'product_id' => $product_info['product_id'],
                                          'href' => $href,
                                          'image' => $image,
                                          'name' => $product_info['name'],
                                          'price' => $this->currency->format($product_info['price'], $this->session->data['currency']),
                                          'button' => $button,
                                          'gift_id' => $c_p['count_product_id'],
                                          'summa' => $c_p['quantity'],
                                          'gift_type' => 3
                                        );
                                    }
                                }
                            } else {
                                if (isset($products[$c_p['product_id']])) {
                                    $count_specific_product[$c_p['count_product_id']]['text'] = $this->getTextSpecificProduct($c_p['quantity'], $products[$c_p['product_id']]['quantity'], $conf_product_info['name'], true);
                                }
                            }
                        }
                    }
                }
            }
        }

        return $count_specific_product;
    }

    private function getProducts($data_gift, $gift_type) {
        switch ($gift_type) {
            case 1:
                $gift_id = $data_gift['gift_id'];
                $count = $data_gift['price'];
                $total = $this->cart_total;
                $products = $this->model_extension_gift_price_gift->getProductsInSuum($gift_id);
                break;
            case 2:
                $gift_id = $data_gift['count_all_id'];
                $count = $data_gift['count_product'];
                $total = $this->cart_count;
                $products = $this->model_extension_gift_price_gift->getProductsInCountAll($gift_id);
                break;
            case 3:
                $gift_id = $data_gift['count_product_id'];
                $count = $data_gift['quantity'];
                $products = $this->model_extension_gift_price_gift->getProductsInSuum($gift_id);
                break;
        }

        $res_products = array();

        if ($products) {
            foreach ($products as $product) {
                if ($product['image']) {
                    $image = $this->model_tool_image->resize($product['image'], $this->img_width, $this->img_height);
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $this->img_width, $this->img_height);
                }

                $button = $this->getFlagButton($total, $count);

                $res_products[] = array(
                  'product_id' => $product['product_id'],
                  'href' => $this->url->link('product/product', '&product_id=' . $product['product_id']),
                  'image' => $image,
                  'name' => $product['name'],
                  'price' => $this->currency->format($product['price'], $this->session->data['currency']),
                  'button' => $button,
                  'gift_id' => $gift_id,
                  'summa' => $count,
                  'gift_type' => $gift_type
                );
            }
        }

        return $res_products;
    }

    private function getSettingText($type_gift, $type_text, $price, $count, $product_name) {
        switch ($type_gift) {
            case 'summ':
                if (!empty($this->setting_text['summ'][$type_text][$this->language_id])) {
                    $search_text = '{summa}';
                    $replace_text = $price;
                    $result = str_replace($search_text, $replace_text, $this->setting_text['summ'][$type_text][$this->language_id]);
                } else {
                    $result = sprintf($this->language->get('text_gift_' . $type_text), $price);
                }
                break;
            case 'countall':
                if (!empty($this->setting_text['countall'][$type_text][$this->language_id])) {
                    $search_text = array('{products_text}', '{products_count}');
                    $replace_product_text = '&nbsp;<strong>' . $this->getDeclensionText($count, $this->getArrayDeclensionText()) . '</strong>&nbsp;';
                    $replace_product_count = '&nbsp;<strong>' . $count . '</strong>&nbsp;';
                    $replace_text = array($replace_product_text, $replace_product_count);
                    $result = str_replace($search_text, $replace_text, $this->setting_text['countall'][$type_text][$this->language_id]);
                } else {
                    $result = sprintf($this->language->get('text_count_all_' . $type_text), $count);
                }
                break;
            case 'count':
                if (!empty($this->setting_text['count'][$type_text][$this->language_id])) {
                    $search_text = array('{product_count}', '{product_text}', '{product_name}');
                    $replace_text = array($count, $this->getDeclensionText($count, $this->getArrayDeclensionText()), $product_name);
                    $result = str_replace($search_text, $replace_text, $this->setting_text['count'][$type_text][$this->language_id]);
                } else {
                    switch ($type_text) {
                        case 'select':
                            $result = sprintf($this->language->get('text_count_' . $type_text), $product_name);
                            break;
                        case 'next':
                            $result = sprintf($this->language->get('text_count_' . $type_text), $product_name, $count);
                            break;
                        case 'on':
                            $result = sprintf($this->language->get('text_count_' . $type_text), $count, $product_name);
                            break;
                    }
                }
                break;
        }

        return $result;
    }

    private function getTextInSumma($data, $total, $check_in_cart) {
        $result = false;

        if ($data['price'] > $total) {
            $p = $data['price'] - $total;
        } else {
            $p = $data['price'];
        }

        $p = $this->currency->format($p, $this->session->data['currency']);

        if ($check_in_cart) {
            if ($this->setting_summ_output) {
                $result = $this->getSettingText('summ', 'select', $p, false, false);
            }
        } else {
            if ($data['price'] > $total) {
                $result = $this->getSettingText('summ', 'next', $p, false, false);
            }

            if ($data['price'] <= $total) {
                $result = $this->getSettingText('summ', 'on', $p, false, false);
            }
        }

        return $result;
    }

    private function getTextInCountAll($count_product, $count_product_in_cart, $check_in_cart) {
        $result = false;
        if ($count_product > $count_product_in_cart) {
            $c_p = $count_product - $count_product_in_cart;
        } else {
            $c_p = $count_product;
        }
        if ($check_in_cart) {
            if ($this->setting_countall_output) {
                $result = $this->getSettingText('countall', 'select', false, $c_p, false);
            }
        } else {
            if ($count_product > $count_product_in_cart) {
                $result = $this->getSettingText('countall', 'next', false, $c_p, false);
            }

            if ($count_product <= $count_product_in_cart) {
                $result = $this->getSettingText('countall', 'on', false, $c_p, false);
            }
        }

        return $result;
    }

    private function getTextSpecificProduct($count_product, $config_count_product, $product_name, $check_in_cart) {
        $result = false;

        if ($count_product > $config_count_product) {
            $c_p = $count_product - $config_count_product;
        } else {
            $c_p = $count_product;
        }
        if ($check_in_cart) {
            if ($this->setting_count_output) {
                $result = $this->getSettingText('count', 'select', false, $c_p, $product_name);
            }
        } else {
            if ($count_product > $config_count_product) {
                $result = $this->getSettingText('count', 'next', false, $c_p, $product_name);
            }

            if ($count_product <= $config_count_product) {
                $result = $this->getSettingText('count', 'on', false, $c_p, $product_name);
            }
        }

        return $result;
    }

    private function getFlagButton($total, $price) {
        if ($price > $total) {
            $result = false;
        }
        if ($price <= $total) {
            $result = true;
        }

        return $result;
    }

    private function getDeclensionText($number, $data_word) {
        $result = '';

        $number = $number % 100;

        if ($number >= 11 && $number <= 19 || $number == 0) {
            $result = $data_word[2];
        } else {
            $i = $number % 10;
            switch ($i) {
                case 1:
                    $result = $data_word[0];
                    break;
                case 2:
                case 3:
                case 4:
                    $result = $data_word[1];
                    break;
                default:
                    $result = $data_word[2];
            }
        }

        return $result;
    }

    private function getArrayDeclensionText() {
        $result = array();
        $result[] = $this->language->get('text_product_one');
        $result[] = $this->language->get('text_product_two');
        $result[] = $this->language->get('text_product_three');

        return $result;
    }

}
