<?php

//microdatapro 7.7 (info@microdata.pro)
class MicrodataPro {
	private $datfile = '/microdatapro.min.max.dat';

	public function __construct($registry) {
		$this->request = $registry->get('request');
		$this->config = $registry->get('config');
		$this->currency = $registry->get('currency');
		$this->tax = $registry->get('tax');
		$this->session = $registry->get('session');
		$this->db = $registry->get('db');
	}

	//opencartVersion - версия Opencart
		public function opencartVersion($d){
			$opencartVersion = explode(".", VERSION);

			return $opencartVersion[$d];
		}
	//opencartVersion

	//moduleInfo - функция информации о модуле
		public function moduleInfo($key, $admin = false){
			$domen = explode("//", $admin?HTTP_CATALOG:HTTP_SERVER);
			$information = array(
				'main_host'	=> str_replace("/", '', $domen[1]),
				'engine' 	=> VERSION,
				'version' 	=> '7.7',
				'module' 	=> 'MicrodataPro',
				'sys_key'	=> '327450',
				'sys_keyf'  => '7473'
			);

			return $information[$key];
		}
	//moduleInfo

	//clear - функция очистки данных
		public function clear($text = '') {
			if($text){
				if(is_array($text)){foreach ($text as $str_item) {$text = $str_item;break;}}
				$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8'); //переводим в теги
				$text = str_replace("><", "> <", $text); //что бы не слипался текст если есть пробел между тегами
				$text = str_replace(array("<br />", "<br>"), " ", $text); //fix br
				$text = strip_tags($text); //удаляем теги
				$find = array(PHP_EOL, "\r\n", "\r", "\n", "\t", '  ', '  ', '    ', '    ', '"', "'", "\\", '&varr;', '&nbsp;', '&pound;', '&euro;', '&para;', '&sect;', '&copy;', '&reg;', '&trade;', '&deg;', '&plusmn;', '&frac14;', '&frac12;', '&frac34;', '&times;', '&divide;', '&fnof;', '&Alpha;', '&Beta;', '&Gamma;', '&Delta;', '&Epsilon;', '&Zeta;', '&Eta;', '&Theta;', '&Iota;', '&Kappa;', '&Lambda;', '&Mu;', '&Nu;', '&Xi;', '&Omicron;', '&Pi;', '&Rho;', '&Sigma;', '&Tau;', '&Upsilon;', '&Phi;', '&Chi;', '&Psi;', '&Omega;', '&alpha;', '&beta;', '&gamma;', '&delta;', '&epsilon;', '&zeta;', '&eta;', '&theta;', '&iota;', '&kappa;', '&lambda;', '&mu;', '&nu;', '&xi;', '&omicron;', '&pi;', '&rho;', '&sigmaf;', '&sigma;', '&tau;', '&upsilon;', '&phi;', '&chi;', '&psi;', '&omega;', '&larr;', '&uarr;', '&rarr;', '&darr;', '&harr;', '&spades;', '&clubs;', '&hearts;', '&diams;', '&quot;', '&amp;', '&lt;', '&gt;', '&hellip;', '&prime;', '&Prime;', '&ndash;', '&mdash;', '&lsquo;', '&rsquo;', '&sbquo;', '&ldquo;', '&rdquo;', '&bdquo;', '&laquo;', '&raquo;'); //что чистим
				$text = str_replace($find, ' ', $text); //чистим текст
			}
			return $text;
		}
	//clear

	//clearImage - функция очистки фото от лишнего
		public function clearImage($image) {
			$image = str_replace(" ", "%20", $image);
			$image = str_replace(array('id=','"',"'",'mainimage','selector'), '', $image);

			return $image;
		}
	//clearImage

	//checkVariable - функция проверки переменных
		public function checkVariable(&$microdatapro_data, $key) {
			$opencart_variables = array(
				'category_manufacturer' => array(
					'breadcrumbs' => false,
					'description' => '',
					'results' => array(),
					'microdatapro_data' => array(
						'image' => '',
					),
				),
				'product' => array(
					'breadcrumbs' => false,
					'heading_title' => '',
					'popup' => '',
					'thumb' => '',
					'share' => '',
					'images' => array(),
					'manufacturer' => '',
					'model' => '',
					'description' => '',
					'special' => 0,
					'price' => 0,
					'options' => false,
					'microdatapro_data' => array(
						'quantity' => 0,
						'reviews' => 0,
						'rating' => 0,
						'sku' => 0,
						'upc' => 0,
						'ean' => 0,
						'isbn' => 0,
						'date_added' => date('Y.m.d'),
						'mpn' => 0,
						'results' => array()
					),
					'product_id' => 0,
					'attribute_groups' => false,
					'products' => array()
				),
				'information' => array(
				  'breadcrumbs' => false,
				  'heading_title' => '',
				  'description' => '',
				),
				'tc_og' => array(
					'microdatapro_data' => array(
						'meta_description' => 0,
						'image' => '',
					),
					'description' => '',
					'heading_title' => '',
					'breadcrumbs' => false,
				)
			);

			foreach($opencart_variables[$key] as $variable => $replacement){
				if(is_array($replacement)){
					foreach($replacement as $var => $rep){
						if(!isset($microdatapro_data[$variable][$var])){
							$microdatapro_data[$variable][$var] = $rep;
						}
					}
				}else{
					if(!isset($microdatapro_data[$variable])){
						$microdatapro_data[$variable] = $replacement;
					}
				}
			}
		}
	//checkVariable

	//storeType - функция информации о типе магазина
		public function storeType($type = false) {
			$types = array(
				'AutoPartsStore',
				'BikeStore',
				'BookStore',
				'ClothingStore',
				'ComputerStore',
				'ConvenienceStore',
				'DepartmentStore',
				'ElectronicsStore',
				'Florist',
				'FurnitureStore',
				'GardenStore',
				'GroceryStore',
				'HardwareStore',
				'HobbyShop',
				'HomeGoodsStore',
				'JewelryStore',
				'LiquorStore',
				'MensClothingStore',
				'MobilePhoneStore',
				'MovieRentalStore',
				'MusicStore',
				'OfficeEquipmentStore',
				'OutletStore',
				'PawnShop',
				'PetStore',
				'ShoeStore',
				'SportingGoodsStore',
				'TireShop',
				'ToyStore',
				'WholesaleStore'
			);
			if($type){
				return $types[$type-1];
			}else{
				return $types;
			}
		}
	//storeType

	//mbCutString - функция корректной обрезки описаний
		public function mbCutString($str, $length, $encoding='UTF-8'){
			if (function_exists('mb_strlen') && (mb_strlen($str, $encoding) <= $length)) {
				return $str;
			}
			if(function_exists('mb_substr')){
				$tmp = mb_substr($str, 0, $length, $encoding);
				return mb_substr($tmp, 0, mb_strripos($tmp, ' ', 0, $encoding), $encoding);
			}else{
				return $str;
			}
		}
	//mbCutString

	//getMinMaxCategory - функция выборки максимальных и минимальных цен категории
		public function getMinMaxCategory(&$data){
			$data['total'] = 0;
			$data['min'] = 0;
			$data['max'] = 0;
			$filedata = false;

			if(isset($this->request->get['path']) && $this->request->get['path'] && $data['range']){
				$parts = explode('_', (string)$this->request->get['path']);
				$category_id = array_pop($parts);

				if(is_file(DIR_SYSTEM . $this->datfile)){ //если есть файл с количествами в категориях
					if(date("d", filectime(DIR_SYSTEM . $this->datfile)) == date('d')){ //если файл за сегодня
						$filedata = json_decode(file_get_contents(DIR_SYSTEM . $this->datfile), true);
						if(isset($filedata[$category_id])){
							$data['total'] = $filedata[$category_id]['total'];
							$data['min'] = $filedata[$category_id]['min'];
							$data['max'] = $filedata[$category_id]['max'];
						}
					}
				}

				if(!$data['total']){ //если нет количества товаров (означает что ранее не забрали с файла)
					$mm_query = $this->getMinMaxSQL($category_id);
					if($mm_query->num_rows > 1){
						$prices = array();
						foreach($mm_query->rows as $row){
							$prices[] = $row['special']?$row['special']:$row['price'];
						}

						$data['total'] = $mm_query->num_rows;
						$data['min'] = (float)rtrim(preg_replace('/[^\d.]/', '', $this->currency->format($this->tax->calculate(round(min($prices), 2), 0, $this->config->get('config_tax')), $this->session->data['currency'])), ".");
						$data['max'] = (float)rtrim(preg_replace('/[^\d.]/', '', $this->currency->format($this->tax->calculate(round(max($prices), 2), 0, $this->config->get('config_tax')), $this->session->data['currency'])), ".");
						$filedata[$category_id]['total'] = $data['total'];
						$filedata[$category_id]['min'] = $data['min'];
						$filedata[$category_id]['max'] = $data['max'];

						$fp = fopen(DIR_SYSTEM . $this->datfile, "w");
						fwrite($fp, json_encode($filedata));
						fclose($fp);
					}
				}

				$data['range'] = $data['total']?($data['total'] - 1):0; //если товаров 1 или меньше - не размечаем
			}
		}
	//getMinMaxCategory

	//getMinMaxSQL - функция выборки макс и мин значений по категории
		private function getMinMaxSQL($category_id){
			$sql = "SELECT p.price,
							(SELECT price FROM " . DB_PREFIX . "product_special ps
								WHERE ps.product_id = p.product_id
								AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'
								AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW())
								AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))
								ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special
							FROM " . DB_PREFIX . "category_path cp
							LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)
							LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)
							LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
							WHERE cp.path_id = '" . (int)$category_id . "'
							AND p.status = 1
							AND p.price > 0
							AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
							AND p.date_available <= '" . $this->db->escape(date('Y-m-d')) . "'";

			return $this->db->query($sql);
		}
	//getMinMaxSQL

	//getMinMaxCron - функция выборки максимальных и минимальных цен категорий по CRON заданию
		public function getMinMaxCron(){
			$data = array();

			$categories_query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE status = 1 ORDER BY category_id");
			foreach($categories_query->rows as $row){
				$category_id = $row['category_id'];
				$mm_query = $this->getMinMaxSQL($category_id);

				if($mm_query->num_rows > 1){
					$prices = array();
					foreach($mm_query->rows as $row){
						$prices[] = $row['special']?$row['special']:$row['price'];
					}

					$data[$category_id]['total'] = $mm_query->num_rows;
					$data[$category_id]['min'] = (float)rtrim(preg_replace('/[^\d.]/', '', $this->currency->format($this->tax->calculate(round(min($prices), 2), 0, $this->config->get('config_tax')), $this->session->data['currency'])), ".");
					$data[$category_id]['max'] = (float)rtrim(preg_replace('/[^\d.]/', '', $this->currency->format($this->tax->calculate(round(max($prices), 2), 0, $this->config->get('config_tax')), $this->session->data['currency'])), ".");

				}
			}

			$filedata = json_encode($data);
			$fp = fopen(DIR_SYSTEM . $this->datfile, "w");
			fwrite($fp, $filedata);
			fclose($fp);

			foreach($data as $category_id => $category_data){
				echo "id - " . $category_id . ": total: " . $category_data['total'] . ", min: " . $category_data['min'] . ", max: " . $category_data['max'];
				echo "<br>";
			}

		}
	//getMinMaxCron

	//status - запуск модуля
		public function status($key = false, $admin = false){
			$license = true;
			$a=1;
			return $license;
		}
	//status

	//getModFiles - функция списка файлов для модификации
		public function getModFiles(){
			return array( //file = str; &&& => $
				'system/library/document.php' => array("public function setTitle"),
				'catalog/controller/common/header.php' => array("&&&data['title']", "&&&data['name']"),
				'catalog/view/theme/{theme}/template/common/header.twig' => array("{% for analytic", "</head>", "<body"),
				'catalog/controller/common/home.php' => array("&&&this->document->setTitle"),
				'catalog/controller/common/footer.php' => array("&&&data['contact']", "&&&data['powered']"),
				'catalog/view/theme/{theme}/template/common/footer.twig' => array("</footer>", "</body>", "</html>"),
				'catalog/controller/product/product.php' => array("&&&this->model_catalog_product->updateViewed", "&&&data['column_left']"),
				'catalog/view/theme/{theme}/template/product/product.twig' => array("{{ content_bottom", "{{ footer"),
				'catalog/controller/product/category.php' => array("&&&pagination = new", "&&&data['column_left']"),
				'catalog/view/theme/{theme}/template/product/category.twig' => array("{{ content_bottom", "{{ footer"),
				'catalog/controller/product/manufacturer.php' => array("&&&pagination = new", "&&&data['column_left']"),
				'catalog/view/theme/{theme}/template/product/manufacturer_info.twig' => array("{{ content_bottom", "{{ footer"),
				'catalog/controller/information/information.php' => array("&&&data['description']", "&&&data['column_left']"),
				'catalog/view/theme/{theme}/template/information/information.twig' => array("{{ content_bottom", "{{ footer")
			);
		}
	//getModFiles

	//getMoreFiles - функция списка дополнительных файлов для модификации
		public function getMoreFiles(){
			return array(
				'catalog/view/theme/{theme}/template/common/home.twig' => array(),
				'catalog/view/theme/{theme}/template/information/contact.twig' => array(),
				'catalog/view/theme/{theme}/template/product/manufacturer_list.twig' => array(),
				'catalog/view/theme/{theme}/template/product/review.twig' => array(),
				'catalog/view/theme/{theme}/template/product/special.twig' => array(),
				'catalog/view/theme/{theme}/template/module/alltabs.twig' => array(),
				'catalog/view/theme/{theme}/template/module/bestseller.twig' => array(),
				'catalog/view/theme/{theme}/template/module/bestsellerpercategory.twig' => array(),
				'catalog/view/theme/{theme}/template/module/featured.twig' => array(),
				'catalog/view/theme/{theme}/template/module/latest.twig' => array(),
				'catalog/view/theme/{theme}/template/module/popular.twig' => array(),
				'catalog/view/theme/{theme}/template/module/product_categorytabs.twig' => array(),
				'catalog/view/theme/{theme}/template/module/product_tab.twig' => array(),
				'catalog/view/theme/{theme}/template/module/productany.twig' => array(),
				'catalog/view/theme/{theme}/template/module/productviewed.twig' => array(),
				'catalog/view/theme/{theme}/template/module/special.twig' => array(),
				'catalog/view/theme/{theme}/template/module/specialpercategory.twig' => array(),
				'catalog/view/theme/{theme}/template/module/anylist.twig' => array(),
				'catalog/view/theme/{theme}/template/module/product_review.twig' => array(),
				'catalog/view/theme/{theme}/template/module/product_viewed.twig' => array(),
				'catalog/view/theme/{theme}/template/extension/module/alltabs.twig' => array(),
				'catalog/view/theme/{theme}/template/extension/module/bestseller.twig' => array(),
				'catalog/view/theme/{theme}/template/extension/module/bestsellerpercategory.twig' => array(),
				'catalog/view/theme/{theme}/template/extension/module/featured.twig' => array(),
				'catalog/view/theme/{theme}/template/extension/module/latest.twig' => array(),
				'catalog/view/theme/{theme}/template/extension/module/popular.twig' => array(),
				'catalog/view/theme/{theme}/template/extension/module/product_categorytabs.twig' => array(),
				'catalog/view/theme/{theme}/template/extension/module/product_tab.twig' => array(),
				'catalog/view/theme/{theme}/template/extension/module/productany.twig' => array(),
				'catalog/view/theme/{theme}/template/extension/module/productviewed.twig' => array(),
				'catalog/view/theme/{theme}/template/extension/module/special.twig' => array(),
				'catalog/view/theme/{theme}/template/extension/module/specialpercategory.twig' => array(),
				'catalog/view/theme/{theme}/template/extension/module/anylist.twig' => array(),
				'catalog/view/theme/{theme}/template/extension/module/product_review.twig' => array(),
				'catalog/view/theme/{theme}/template/extension/module/product_viewed.twig' => array(),
			);
		}
	//getMoreFiles

	//find_old - функция списка возможных вариаций старой разметки
		public function find_old() {
			return array(
		    'itemscope',
		    'itemscope=""',
		    'content="http://schema.org/InStock"',
				'itemtype="http://schema.org/Organization"',
				'itemtype="http://schema.org/Store"',
				'itemprop="priceRange"',
				'itemprop="hasMap"',
				'itemprop="telephone"',
				'itemprop="sameAs"',
				'itemprop="address"',
				'itemprop="addressLocality"',
				'itemprop="postalCode"',
				'itemprop="streetAddress"',
				'itemprop="geo"',
				'itemprop="latitude"',
				'itemprop="longitude"',
				'itemprop="location"',
				'itemprop="potentialAction"',
				'itemprop="target"',
				'itemprop="query-input"',
				'itemprop="openingHoursSpecification"',
				'itemprop="dayOfWeek"',
				'itemprop="opens"',
				'itemprop="closes"',
				'itemprop="brand"',
				'itemprop="manufacturer"',
				'itemprop="model"',
				'itemprop="gtin12"',
				'itemprop="category"',
				'itemprop="ratingCount"',
				'itemprop="itemCondition"',
				'itemprop="review"',
				'itemprop="author"',
				'itemprop="datePublished"',
				'itemprop="dateModified"',
				'itemprop="reviewRating"',
				'itemprop="additionalProperty"',
				'itemprop="value"',
				'itemprop="isRelatedTo"',
				'itemtype="http://schema.org/NewsArticle"',
				'itemprop="mainEntityOfPage"',
				'itemprop="headline"',
				'itemprop="author"',
				'itemprop="contentUrl"',
				'itemprop="width"',
				'itemprop="height"',
				'itemprop="publisher"',
				'itemprop="logo"',
		    'itemprop="itemListElement"',
		    'itemprop="itemListOrder"',
		    'itemprop="numberOfItems"',
		    'itemtype="http://schema.org/ListItem"',
		    'itemtype="http://schema.org/BreadcrumbList"',
		    'itemtype="http://schema.org/Thing"',
		    'itemtype="http://data-vocabulary.org/Breadcrumb"',
		    'itemprop="item"',
		    'itemprop="title"',
		    'itemprop="name"',
		    'itemprop="position"',
		    'itemprop="description"',
		    'itemtype="http://schema.org/Product"',
		    'itemprop="url"',
		    'itemprop="image"',
		    'itemprop="aggregateRating"',
				'itemtype="http://schema.org/AggregateRating"',
		    'itemprop="reviewCount"',
		    'itemprop="ratingValue"',
		    'itemprop="bestRating"',
		    'itemprop="worstRating"',
		    'itemtype="http://schema.org/Offer"',
		    'itemprop="offers"',
		    'itemprop="price"',
		    'itemprop="priceCurrency"',
		    'itemtype="http://schema.org/ItemList"',
		    'itemprop="propertiesList"',
		    'itemprop="availability"',
				'vocab="http://schema.org/"',
				'typeof="BreadcrumbList"',
				'property="itemListElement"',
				'typeof="ListItem"',
				'property="item"',
				'typeof="WebPage"',
				'property="name"',
				'property="position"',
				'itemtype="http://schema.org/AggregateOffer"',
				'itemprop="offerCount"',
				'itemprop="highPrice"',
				'itemprop="lowPrice"',
				'itemprop="priceCurrency"',
				'xmlns:v="http://rdf.data-vocabulary.org/#"',
				'typeof="v:Breadcrumb"',
				'rel="v:url"',
				'property="v:title"',
				'itemprop="email"',
				'itemprop="openingHours"',
				'property="og:',
				'itemtype="http://schema.org/PostalAddress"',
				'itemprop="addressCountry"'
		  );
		}
	//find_old

}
