<?php


require_once DIR_SYSTEM . "/engine/neoseo_controller.php";
class ControllerAccountNeoSeoCashMemo extends NeoSeoController
{
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->_moduleSysName = "neoseo_cash_memo";
        $this->_logFile = $this->_moduleSysName . ".log";
        $this->debug = $this->config->get($this->_moduleSysName . "_debug") == 1;
    }
    public function index()
    {
        $this->load->model("account/order");
        $this->load->model("account/neoseo_cash_memo");
        $this->load->model("tool/image");
        $this->load->model("catalog/product");
        $this->load->model("setting/setting");
        $quantityField = $this->config->get($this->_moduleSysName . "_column_quantity_field");
        if (!$quantityField) {
            $quantityField = "quantity";
        }
        $data["style"] = "admin/view/stylesheet/" . $this->_moduleSysName . ".css";
        $data = $this->language->load("account/" . $this->_moduleSysName);
        if (isset($this->request->server["HTTPS"]) && ($this->request->server["HTTPS"] == "on" || $this->request->server["HTTPS"] == "1")) {
            $data["base"] = HTTPS_SERVER;
        } else {
            $data["base"] = HTTP_SERVER;
        }
        $data["language"] = $this->language->get("code");
        $data["title"] = $this->language->get("heading_title");
        $data["supplier_info"] = nl2br($this->config->get($this->_moduleSysName . "_supplier_info"));
        $data[$this->_moduleSysName . "_order_date"] = $this->config->get($this->_moduleSysName . "_order_date");
        $data[$this->_moduleSysName . "_column_sku_status"] = $this->config->get($this->_moduleSysName . "_column_sku_status");
        $data[$this->_moduleSysName . "_column_image_status"] = $this->config->get($this->_moduleSysName . "_column_image_status");
        $data[$this->_moduleSysName . "_column_model_status"] = $this->config->get($this->_moduleSysName . "_column_model_status");
        $data[$this->_moduleSysName . "_column_unit_status"] = $this->config->get($this->_moduleSysName . "_column_unit_status");
        $data[$this->_moduleSysName . "_column_option_status"] = $this->config->get($this->_moduleSysName . "_column_option_status");
        $data[$this->_moduleSysName . "_store_url"] = $this->config->get($this->_moduleSysName . "_store_url");
        $data[$this->_moduleSysName . "_show_comment"] = $this->config->get($this->_moduleSysName . "_show_comment");
        $data[$this->_moduleSysName . "_client_side"] = $this->config->get($this->_moduleSysName . "_client_side");
        $data["orders"] = [];
        $orders = [];
        if (isset($this->request->post["selected"])) {
            $orders = $this->request->post["selected"];
        } else {
            if (isset($this->request->get["order_id"])) {
                $orders[] = $this->request->get["order_id"];
            }
        }
        $show_product_order = false;
        if (isset($this->request->get["product_order"])) {
            $show_product_order = true;
        }
        $sql = "show tables like '" . DB_PREFIX . "order_simple_fields'";
        $query = $this->db->query($sql);
        $hasSimple = 0 < $query->num_rows;
        $sql = "show tables like 'simple_custom_data'";
        $query = $this->db->query($sql);
        $hasOldSimple = 0 < $query->num_rows;
        foreach ($orders as $order_id) {
            $order_info = $this->model_account_order->getOrder($order_id);
            if ($order_info) {
                $store_info = $this->model_setting_setting->getSetting("config", $order_info["store_id"]);
                if ($store_info) {
                    $store_address = $store_info["config_address"];
                    $store_email = $store_info["config_email"];
                    $store_telephone = $store_info["config_telephone"];
                    $store_fax = $store_info["config_fax"];
                } else {
                    $store_address = $this->config->get("config_address");
                    $store_email = $this->config->get("config_email");
                    $store_telephone = $this->config->get("config_telephone");
                    $store_fax = $this->config->get("config_fax");
                }
                if ($order_info["invoice_no"]) {
                    $invoice_no = $order_info["invoice_prefix"] . $order_info["invoice_no"];
                } else {
                    $invoice_no = "";
                }
                $simpleFind = [];
                $simpleReplace = [];
                if ($hasSimple) {
                    $sql = "select * from `" . DB_PREFIX . "order_simple_fields` where order_id = " . (int) $order_id;
                    $query = $this->db->query($sql);
                    if (0 < $query->num_rows) {
                        foreach ($query->row as $key => $value) {
                            $simpleFind[] = "{simple_order_" . $key . "}";
                            $simpleReplace["simple_order_" . $key] = $value;
                        }
                    }
                }
                if ($hasOldSimple) {
                    $sql = "select data from `simple_custom_data` where object_type = 1 and object_id = " . (int) $order_id;
                    $query = $this->db->query($sql);
                    if (0 < $query->num_rows) {
                        $data = $query->row["data"];
                        foreach (unserialize($data) as $key => $item) {
                            $simpleFind[] = "{simple_order_" . $key . "}";
                            $simpleReplace["simple_order_" . $key] = $item["text"];
                        }
                    }
                }
                $this->debug("simple fields:" . print_r($simpleReplace, true));
                if ($this->config->get($this->_moduleSysName . "_customer_info_format")) {
                    $format = $this->config->get($this->_moduleSysName . "_customer_info_format");
                } else {
                    $format = "{lastname} {firstname}, тел: {telephone}";
                }
                $find = ["{firstname}", "{lastname}", "{company}", "{address_1}", "{address_2}", "{city}", "{postcode}", "{zone}", "{zone_code}", "{country}", "{telephone}", "{email}"];
                $replace = ["firstname" => $order_info["payment_firstname"], "lastname" => $order_info["payment_lastname"], "company" => $order_info["payment_company"], "address_1" => $order_info["payment_address_1"], "address_2" => $order_info["payment_address_2"], "city" => $order_info["payment_city"], "postcode" => $order_info["payment_postcode"], "zone" => $order_info["payment_zone"], "zone_code" => $order_info["payment_zone_code"], "country" => $order_info["payment_country"], "telephone" => $order_info["telephone"], "email" => $order_info["email"]];
                $customer_fields_names = $this->model_account_neoseo_cash_memo->getCustomerFieldsNames();
                if ($customer_fields_names) {
                    foreach ($customer_fields_names as $field_name) {
                        if (!isset($find[$field_name["name"]])) {
                            $find[] = "{" . $field_name["name"] . "}";
                        }
                    }
                }
                $customer_fields = $this->model_account_neoseo_cash_memo->getCustomerFields($order_info["customer_id"]);
                if ($customer_fields) {
                    foreach ($customer_fields as $field => $field_val) {
                        if (!isset($replace[$field])) {
                            $replace[$field] = $field_val;
                        }
                    }
                }
                $customer_info = str_replace(["\r\n", "\r", "\n"], "<br />", preg_replace(["/\r\r+/", "/\n\n+/"], "<br />", trim(str_replace($find, $replace, $format))));
                if ($hasSimple || $hasOldSimple) {
                    $customer_info = str_replace($simpleFind, $simpleReplace, $customer_info);
                }
                if ($this->config->get($this->_moduleSysName . "_shipping_info_format")) {
                    $format = $this->config->get($this->_moduleSysName . "_shipping_info_format");
                } else {
                    $format = "{method}\n{zone}, {postcode} {city}, {address_1} {address_2}";
                }
                $find = ["{method}", "{firstname}", "{lastname}", "{company}", "{address_1}", "{address_2}", "{city}", "{postcode}", "{zone}", "{zone_code}", "{country}", "{telephone}"];
                $replace = ["method" => $order_info["shipping_method"], "firstname" => $order_info["shipping_firstname"], "lastname" => $order_info["shipping_lastname"], "company" => $order_info["shipping_company"], "address_1" => $order_info["shipping_address_1"], "address_2" => $order_info["shipping_address_2"], "city" => $order_info["shipping_city"], "postcode" => $order_info["shipping_postcode"], "zone" => $order_info["shipping_zone"], "zone_code" => $order_info["shipping_zone_code"], "country" => $order_info["shipping_country"], "telephone" => $order_info["telephone"]];
                $shipping_info = str_replace(["\r\n", "\r", "\n"], "<br />", preg_replace(["/\r\r+/", "/\n\n+/"], "<br />", trim(str_replace($find, $replace, $format))));
                if ($hasSimple || $hasOldSimple) {
                    $shipping_info = str_replace($simpleFind, $simpleReplace, $shipping_info);
                }
                if ($this->config->get($this->_moduleSysName . "_payment_info_format")) {
                    $format = $this->config->get($this->_moduleSysName . "_payment_info_format");
                } else {
                    $format = "{method}\n{company}";
                }
                $find = ["{method}", "{firstname}", "{lastname}", "{company}", "{address_1}", "{address_2}", "{city}", "{postcode}", "{zone}", "{zone_code}", "{country}", "{telephone}"];
                $replace = ["method" => $order_info["payment_method"], "firstname" => $order_info["payment_firstname"], "lastname" => $order_info["payment_lastname"], "company" => $order_info["payment_company"], "address_1" => $order_info["payment_address_1"], "address_2" => $order_info["payment_address_2"], "city" => $order_info["payment_city"], "postcode" => $order_info["payment_postcode"], "zone" => $order_info["payment_zone"], "zone_code" => $order_info["payment_zone_code"], "country" => $order_info["payment_country"], "telephone" => $order_info["telephone"]];
                $payment_info = str_replace(["\r\n", "\r", "\n"], "<br />", preg_replace(["/\r\r+/", "/\n\n+/"], "<br />", trim(str_replace($find, $replace, $format))));
                if ($hasSimple || $hasOldSimple) {
                    $payment_info = str_replace($simpleFind, $simpleReplace, $payment_info);
                }
                $product_data = [];
                $sort_product = $this->config->get($this->_moduleSysName . "_sort_product");
                $products = $this->model_account_neoseo_cash_memo->getOrderProducts($order_id, $sort_product);
                foreach ($products as $product) {
                    $option_data = [];
                    $options = $this->model_account_order->getOrderOptions($order_id, $product["order_product_id"]);
                    foreach ($options as $option) {
                        if ($option["type"] != "file") {
                            $value = $option["value"];
                        } else {
                            $value = utf8_substr($option["value"], 0, utf8_strrpos($option["value"], "."));
                        }
                        $option_data[] = ["name" => $option["name"], "value" => $value];
                    }
                    $product_info = $this->model_catalog_product->getProduct($product["product_id"]);
                    $weight_class = $this->model_account_neoseo_cash_memo->getWeightClass($product_info["weight_class_id"]);
                    if ($weight_class) {
                        $weight_class_name = $weight_class["unit"];
                    } else {
                        $weight_class_name = "шт";
                    }
                    $quantity = $product[$quantityField];
                    if (!$quantity) {
                        $quantity = $product["quantity"];
                        $weight_class_name = "шт";
                    }
                    $product_item = array_merge($product_info, ["name" => $product["name"], "model" => $product["model"], "option" => $option_data, "quantity" => $quantity, "weight_class" => $weight_class_name, "price" => $this->currency->format($product["price"] + ($this->config->get("config_tax") ? $product["tax"] : 0), $order_info["currency_code"], $order_info["currency_value"]), "total" => $this->currency->format($product["total"] + ($this->config->get("config_tax") ? $product["tax"] * $product["quantity"] : 0), $order_info["currency_code"], $order_info["currency_value"])]);
                    $column_image_width = $this->config->get($this->_moduleSysName . "_column_image_width");
                    if (!$column_image_width) {
                        $column_image_width = 40;
                    }
                    $column_image_height = $this->config->get($this->_moduleSysName . "_column_image_height");
                    if (!$column_image_height) {
                        $column_image_height = 40;
                    }
                    if ($this->config->get($this->_moduleSysName . "_column_image_status") == 1 && isset($product_item["image"])) {
                        $product_item["image"] = $this->model_tool_image->resize($product_item["image"], $column_image_width, $column_image_height);
                    }
                    $product_data[] = $product_item;
                }
                $voucher_data = [];
                $vouchers = $this->model_account_order->getOrderVouchers($order_id);
                foreach ($vouchers as $voucher) {
                    $voucher_data[] = ["description" => $voucher["description"], "amount" => $this->currency->format($voucher["amount"], $order_info["currency_code"], $order_info["currency_value"])];
                }
                $data["text"] = nl2br($this->config->get($this->_moduleSysName . "_text"));
                if ($hasSimple || $hasOldSimple) {
                    $data["text"] = str_replace($simpleFind, $simpleReplace, $data["text"]);
                }
                $total_data = [];
                $last_total = 0;
                $totals = $this->model_account_order->getOrderTotals($order_id);
                foreach ($totals as $total) {
                    $total_data[] = ["title" => $total["title"], "text" => $this->currency->format($total["value"], $order_info["currency_code"], $order_info["currency_value"])];
                    $decimals = $this->model_account_neoseo_cash_memo->getDecimalPlace($order_info["currency_id"]);
                    $last_total = round($order_info["total"] * $order_info["currency_value"], $decimals);
                }
                $array_null = [""];
                $array_null_for_tesn = ["", ""];
                $array_null_for_unit_null = ["0"];
                $array_null_for_unit_one = ["1"];
                $array_null_for_unit_two = ["2"];
                $array_null_for_unit_three = ["3"];
                $null = explode(",", str_replace(" ", "", $this->config->get($this->_moduleSysName . "_unit_option_null")));
                $lang_units["nul"] = $null[0];
                $lang_units["ten"][] = array_merge($array_null, explode(",", str_replace(" ", "", $this->config->get($this->_moduleSysName . "_unit_option_one_nine"))));
                $lang_units["ten"][] = array_merge($array_null, explode(",", str_replace(" ", "", $this->config->get($this->_moduleSysName . "_unit_option_one_nine_thousand"))));
                $lang_units["ten"][] = array_merge($array_null, explode(",", str_replace(" ", "", $this->config->get($this->_moduleSysName . "_unit_option_one_nine_millon"))));
                $lang_units["ten"][] = array_merge($array_null, explode(",", str_replace(" ", "", $this->config->get($this->_moduleSysName . "_unit_option_one_nine_billon"))));
                $lang_units["a20"] = explode(",", str_replace(" ", "", $this->config->get($this->_moduleSysName . "_unit_option_ten_nineteen")));
                $lang_units["tens"] = array_merge($array_null_for_tesn, explode(",", str_replace(" ", "", $this->config->get($this->_moduleSysName . "_tens_option"))));
                $lang_units["hundred"] = array_merge($array_null, explode(",", str_replace(" ", "", $this->config->get($this->_moduleSysName . "_hundreds_option"))));
                $lang_units["unit"][] = array_merge(explode(",", str_replace(" ", "", $this->config->get($this->_moduleSysName . "_money_option_coins"))), $array_null_for_unit_one);
                $lang_units["unit"][] = array_merge(explode(",", str_replace(" ", "", $this->config->get($this->_moduleSysName . "_money_option_currency"))), $array_null_for_unit_null);
                $lang_units["unit"][] = array_merge(explode(",", str_replace(" ", "", $this->config->get($this->_moduleSysName . "_count_money_option_thousand"))), $array_null_for_unit_one);
                $lang_units["unit"][] = array_merge(explode(",", str_replace(" ", "", $this->config->get($this->_moduleSysName . "_count_money_option_millon"))), $array_null_for_unit_two);
                $lang_units["unit"][] = array_merge(explode(",", str_replace(" ", "", $this->config->get($this->_moduleSysName . "_count_money_option_billion"))), $array_null_for_unit_three);
                if ($this->config->get($this->_moduleSysName . "_status_sale") == 1) {
                    $total_str = _obfuscated_0D0F212B14210B1D39300611090F21251B1F1F0D275C22_(str_replace(" ", "", $last_total), $lang_units);
                } else {
                    $total_str = "";
                }
                if (file_exists(DIR_IMAGE . $this->config->get($this->_moduleSysName . "_print_img_store")) && is_file(DIR_IMAGE . $this->config->get($this->_moduleSysName . "_print_img_store"))) {
                    $store_logo_img = "image/" . $this->config->get($this->_moduleSysName . "_print_img_store");
                } else {
                    $store_logo_img = "";
                }
                $order = ["order_id" => $order_id, "invoice_no" => $invoice_no, "date_added" => date($this->language->get("date_format_short"), strtotime($order_info["date_added"])), "date_modified" => date($this->language->get("date_format_short"), strtotime($order_info["date_modified"])), "date_current" => date($this->language->get("date_format_short"), time()), "store_name" => $this->config->get($this->_moduleSysName . "_store_name") ? trim($this->config->get($this->_moduleSysName . "_store_name")) : $order_info["store_name"], "store_text" => trim($this->config->get($this->_moduleSysName . "_store_text")), "store_url" => trim($this->config->get($this->_moduleSysName . "_store_url")), "store_address" => nl2br($store_address), "store_email" => $this->config->get($this->_moduleSysName . "_store_email") ? $this->config->get($this->_moduleSysName . "_store_email") : $store_email, "store_phone" => $this->config->get($this->_moduleSysName . "_store_phone") ? $this->config->get($this->_moduleSysName . "_store_phone") : $store_telephone, "store_fax" => $store_fax, "store_owner" => $data["supplier_info"], "store_logo_img" => $store_logo_img, "width_store_logo_img" => $this->config->get($this->_moduleSysName . "_store_logo_width"), "height_store_logo_img" => $this->config->get($this->_moduleSysName . "_store_logo_height"), "text" => $data["text"], "email" => $order_info["email"], "customer_info" => $customer_info, "firstname" => $order_info["payment_firstname"], "lastname" => $order_info["payment_lastname"], "telephone" => $order_info["telephone"], "shipping_firstname" => $order_info["shipping_firstname"], "shipping_lastname" => $order_info["shipping_lastname"], "shipping_company" => $order_info["shipping_company"], "shipping_address_1" => $order_info["shipping_address_1"], "shipping_address_2" => $order_info["shipping_address_2"], "shipping_city" => $order_info["shipping_city"], "shipping_postcode" => $order_info["shipping_postcode"], "shipping_zone" => $order_info["shipping_zone"], "shipping_zone_code" => $order_info["shipping_zone_code"], "shipping_country" => $order_info["shipping_country"], "shipping_info" => $shipping_info, "shipping_method" => $order_info["shipping_method"], "payment_firstname" => $order_info["payment_firstname"], "payment_lastname" => $order_info["payment_lastname"], "payment_company" => $order_info["payment_company"], "payment_address_1" => $order_info["payment_address_1"], "payment_address_2" => $order_info["payment_address_2"], "payment_city" => $order_info["payment_city"], "payment_postcode" => $order_info["payment_postcode"], "payment_zone" => $order_info["payment_zone"], "payment_zone_code" => $order_info["payment_zone_code"], "payment_country" => $order_info["payment_country"], "payment_info" => $payment_info, "payment_method" => $order_info["payment_method"], "product" => $product_data, "voucher" => $voucher_data, "total" => $total_data, "total_str" => $total_str, "comment" => nl2br($order_info["comment"])];
                if (isset($order_info["payment_company_id"])) {
                    $order["payment_company_id"] = $order_info["payment_company_id"];
                }
                if (isset($order_info["payment_tax_id"])) {
                    $order["payment_tax_id"] = $order_info["payment_tax_id"];
                }
                if ($data[$this->_moduleSysName . "_order_date"] == "current") {
                    $order["date"] = $order["date_current"];
                } else {
                    if ($data[$this->_moduleSysName . "_order_date"] == "modified") {
                        $order["date"] = $order["date_modified"];
                    } else {
                        $order["date"] = $order["date_added"];
                    }
                }
                if ($this->config->get($this->_moduleSysName . "_print_img")) {
                    $this->load->model("tool/image");
                    $order["print_img"] = $this->model_tool_image->resize($this->config->get($this->_moduleSysName . "_print_img"), $this->config->get($this->_moduleSysName . "_print_img_width"), $this->config->get($this->_moduleSysName . "_print_img_height"));
                }
                $data["orders"][] = $order;
            }
        }
        $data["header"] = $this->load->controller("common/header");
        $data["column_left"] = $this->load->controller("common/column_left");
        $data["footer"] = $this->load->controller("common/footer");
        if (!$show_product_order) {
            $this->response->setOutput($this->load->view("account/" . $this->_moduleSysName, $data));
        } else {
            $this->response->setOutput($this->load->view("account/" . $this->_moduleSysName . "_product", $data));
        }
    }
}
function cmp_name_asc($a, $b)
{
    return strcmp($a["name"], $b["name"]);
}
function cmp_name_desc($a, $b)
{
    return -1 * strcmp($a["name"], $b["name"]);
}
function _obfuscated_0D0F212B14210B1D39300611090F21251B1F1F0D275C22_($num, $lang_units)
{
    $_obfuscated_0D273C1C1439093615053713215B230724341A1F2A1322_ = $_obfuscated_0D273C1C1439093615053713215B230724341A1F2A1322_[0] == "\$" ? substr($_obfuscated_0D273C1C1439093615053713215B230724341A1F2A1322_, 1) : $_obfuscated_0D273C1C1439093615053713215B230724341A1F2A1322_;
    list($_obfuscated_0D26080D2C2D1417332A1E24242A2D05250C123C151C32_, $_obfuscated_0D1402261A363E13042B2D3C1039343B3E2C0C1D221D11_) = explode(".", sprintf("%015.2f", floatval($_obfuscated_0D273C1C1439093615053713215B230724341A1F2A1322_)));
    $_obfuscated_0D2D173E050B0712180E132F32403E2D39360113170211_ = [];
    if (0 < intval($_obfuscated_0D26080D2C2D1417332A1E24242A2D05250C123C151C32_)) {
        foreach (str_split($_obfuscated_0D26080D2C2D1417332A1E24242A2D05250C123C151C32_, 3) as $_obfuscated_0D31020C3C3040170F342E3C09331C330C2D353D390422_ => $_obfuscated_0D1B1E3837015B09353230121629230B01162F1D142301_) {
            if (intval($_obfuscated_0D1B1E3837015B09353230121629230B01162F1D142301_)) {
                $_obfuscated_0D31020C3C3040170F342E3C09331C330C2D353D390422_ = sizeof($lang_units["unit"]) - $_obfuscated_0D31020C3C3040170F342E3C09331C330C2D353D390422_ - 1;
                $_obfuscated_0D06252D22110E3B123510023E175C0924402C27053422_ = $lang_units["unit"][$_obfuscated_0D31020C3C3040170F342E3C09331C330C2D353D390422_][3];
                list($_obfuscated_0D133B3B32360C3130093D3F241A3E391318362A221D11_, $_obfuscated_0D1E2C0908120D152C193B080932302A140E2E01080B32_, $_obfuscated_0D0A14360827390914083B1F1631031A1404040E363232_) = array_map("intval", str_split($_obfuscated_0D1B1E3837015B09353230121629230B01162F1D142301_, 1));
                $_obfuscated_0D2D173E050B0712180E132F32403E2D39360113170211_[] = $lang_units["hundred"][$_obfuscated_0D133B3B32360C3130093D3F241A3E391318362A221D11_];
                if (1 < $_obfuscated_0D1E2C0908120D152C193B080932302A140E2E01080B32_) {
                    $_obfuscated_0D2D173E050B0712180E132F32403E2D39360113170211_[] = $lang_units["tens"][$_obfuscated_0D1E2C0908120D152C193B080932302A140E2E01080B32_] . " " . $lang_units["ten"][$_obfuscated_0D06252D22110E3B123510023E175C0924402C27053422_][$_obfuscated_0D0A14360827390914083B1F1631031A1404040E363232_];
                } else {
                    $_obfuscated_0D2D173E050B0712180E132F32403E2D39360113170211_[] = 0 < $_obfuscated_0D1E2C0908120D152C193B080932302A140E2E01080B32_ ? $lang_units["a20"][$_obfuscated_0D0A14360827390914083B1F1631031A1404040E363232_] : $lang_units["ten"][$_obfuscated_0D06252D22110E3B123510023E175C0924402C27053422_][$_obfuscated_0D0A14360827390914083B1F1631031A1404040E363232_];
                }
                if (1 < $_obfuscated_0D31020C3C3040170F342E3C09331C330C2D353D390422_ && $_obfuscated_0D06252D22110E3B123510023E175C0924402C27053422_ != 0) {
                    $_obfuscated_0D2D173E050B0712180E132F32403E2D39360113170211_[] = _obfuscated_0D1B161F1E2A30401D0B153B27011003181C2128192A01_($_obfuscated_0D1B1E3837015B09353230121629230B01162F1D142301_, $lang_units["unit"][$_obfuscated_0D31020C3C3040170F342E3C09331C330C2D353D390422_][0], $lang_units["unit"][$_obfuscated_0D31020C3C3040170F342E3C09331C330C2D353D390422_][1], $lang_units["unit"][$_obfuscated_0D31020C3C3040170F342E3C09331C330C2D353D390422_][2]);
                }
            }
        }
    } else {
        $_obfuscated_0D2D173E050B0712180E132F32403E2D39360113170211_[] = $lang_units["nul"];
    }
    $_obfuscated_0D2D173E050B0712180E132F32403E2D39360113170211_[] = _obfuscated_0D1B161F1E2A30401D0B153B27011003181C2128192A01_(intval($_obfuscated_0D26080D2C2D1417332A1E24242A2D05250C123C151C32_), $lang_units["unit"][1][0], $lang_units["unit"][1][1], $lang_units["unit"][1][2]);
    $_obfuscated_0D2D173E050B0712180E132F32403E2D39360113170211_[] = $_obfuscated_0D1402261A363E13042B2D3C1039343B3E2C0C1D221D11_ . " " . _obfuscated_0D1B161F1E2A30401D0B153B27011003181C2128192A01_($_obfuscated_0D1402261A363E13042B2D3C1039343B3E2C0C1D221D11_, $lang_units["unit"][0][0], $lang_units["unit"][0][1], $lang_units["unit"][0][2]);
    return trim(preg_replace("/ {2,}/", " ", join(" ", $_obfuscated_0D2D173E050B0712180E132F32403E2D39360113170211_)));
}
function _obfuscated_0D1B161F1E2A30401D0B153B27011003181C2128192A01_($n, $f1, $f2, $f5)
{
    $n = abs(intval($n)) % 100;
    if (10 < $n && $n < 20) {
        return $_obfuscated_0D2D1E3032153B37141A352337041128331D260F1F3501_;
    }
    $n = $n % 10;
    if (1 < $n && $n < 5) {
        return $_obfuscated_0D3432241A063B0A1C343611112E2B03290B351E221422_;
    }
    if ($n == 1) {
        return $_obfuscated_0D3D2F1D0203053D125C1B30370511055B253535141632_;
    }
    return $_obfuscated_0D2D1E3032153B37141A352337041128331D260F1F3501_;
}
function _obfuscated_0D17081F1E340A31141F27131502270A2937330C393301_($s)
{
    $_obfuscated_0D3B370F1118260908291E1825321102181E25121D0E22_ = ["'а'", "'б'", "'в'", "'г'", "'д'", "'е'", "'ё'", "'ж'", "'з'", "'и'", "'й'", "'к'", "'л'", "'м'", "'н'", "'о'", "'п'", "'р'", "'с'", "'т'", "'у'", "'ф'", "'х'", "'ц'", "'ч'", "'ш'", "'щ'", "'ъ'", "'ы'", "'ь'", "'э'", "'ю'", "'я'", "'А'", "'Б'", "'В'", "'Г'", "'Д'", "'Е'", "'Ё'", "'Ж'", "'З'", "'И'", "'Й'", "'К'", "'Л'", "'М'", "'Н'", "'О'", "'П'", "'Р'", "'С'", "'Т'", "'У'", "'Ф'", "'Х'", "'Ц'", "'Ч'", "'Ш'", "'Щ'", "'Ъ'", "'Ы'", "'Ь'", "'Э'", "'Ю'", "'Я'"];
    $_obfuscated_0D162B1C371C092D312D080625053F34211B2F2B3B0422_ = ["a", "b", "v", "g", "d", "e", "yo", "zh", "z", "i", "j", "k", "l", "m", "n", "o", "p", "r", "s", "t", "u", "f", "h", "c", "ch", "sh", "sch", "", "y", "", "e", "yu", "ya", "A", "B", "V", "G", "D", "E", "Yo", "Zh", "Z", "I", "J", "K", "L", "M", "N", "O", "P", "R", "S", "T", "U", "F", "H", "C", "Ch", "Sh", "Sch", "", "Y", "", "E", "Ju", "Ya"];
    return preg_replace($_obfuscated_0D3B370F1118260908291E1825321102181E25121D0E22_, $_obfuscated_0D162B1C371C092D312D080625053F34211B2F2B3B0422_, $_obfuscated_0D3440072936372F33093B5C18251E2C2A35032F293622_);
}

?>