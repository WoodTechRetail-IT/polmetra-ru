<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerStartupSeoUrl extends Controller {
	
	//seopro start
		private $seo_pro;
		public function __construct($registry) {
			parent::__construct($registry);	
			$this->seo_pro = new SeoPro($registry);
		}
	//seopro end
	
	public function index() {

		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);

      // OCFilter start
      if ($this->registry->get('ocfilter')) {
        $this->url->addRewrite($this->ocfilter->seo);
      }
      // OCFilter end
      
		}

	
		// Decode URL
		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);

			// SEO URL Generator PRO . Begin
			$parts = array_filter($parts);
			
			$last_part = end($parts);
			// SEO URL Generator PRO . End
			
		//seopro prepare route
		if($this->config->get('config_seo_pro')){		
			$parts = $this->seo_pro->prepareRoute($parts);
		}
		//seopro prepare route end

			// remove any empty arrays from trailing
			if (utf8_strlen(end($parts)) == 0) {
				array_pop($parts);
			}

			foreach ($parts as $part) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE keyword = '" . $this->db->escape($part) . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);

					if ($url[0] == 'product_id') {
						$this->request->get['product_id'] = $url[1];
					}

					if ($url[0] == 'category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
					}

					if ($url[0] == 'manufacturer_id') {
						$this->request->get['manufacturer_id'] = $url[1];
					}


          // OCFilter start
          if ($url[0] == 'ocfilter_page_id') {
            $this->request->get['ocfilter_page_id'] = $url[1];
            
            continue;
          }
          // OCFilter end
      
					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}

					if ($query->row['query'] && $url[0] != 'information_id' && $url[0] != 'manufacturer_id' && $url[0] != 'category_id' && $url[0] != 'product_id') {
						$this->request->get['route'] = $query->row['query'];
					}
				} else {
					if(!$this->config->get('config_seo_pro')){		


						// SEO URL Generator PRO . Begin
						$new_url = false;

						// Attention!
						// Sometimes users fill SEO URL with postfix ".html" instead of to turn on it in the SeoPro settings
						// For those cases $last_part not contain ".html" so it is impossible to find anything in redirects
						// That's why we need to check SEO URL if they contain postfix ".html"

						$parts2 = explode('/', trim(utf8_strtolower($this->request->get['_route_']), '/'));

						$last_part2 = str_replace('.html', '', end($parts2));

						$a_parts = $parts;

						if ($last_part != $last_part2) {
							array_push($a_parts, $last_part2);
						}

						// Проверяем все части УРЛа, а не только крайнюю справа!
						$in = '';

						$i = 0;
						foreach ($a_parts as $item) {
							$in .= ($i) ? ', ' : '';
							$in .= '\'' . $this->db->escape($item) . '\'';
							$i++;
						}

						$sql = "SELECT * FROM " . DB_PREFIX . "seo_url_generator_redirects WHERE seo_url_old IN ($in) AND store_id = '" . (int)$this->config->get('config_store_id') . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY seo_url_id DESC";

						$query = $this->db->query($sql);

						$keys_with_redirects = array();
						$essence_to_keys = array();
						$res = array();

						if ($query->rows) {
							foreach ($query->rows as $item) {
								$keys_with_redirects[] = mb_strtolower($item['seo_url_old']); // strtolower for SeoPro
								$essence_to_keys[mb_strtolower($item['seo_url_old'])] = $item['query']; // strtolower for SeoPro
							}
						}

						if ($last_part != $last_part2) {
							$last_part = $last_part2;
						}

						// strtolower for SeoPro
						if (in_array(mb_strtolower($last_part), $keys_with_redirects)) {
							// Последний алиас есть в базе редиректов
							$res = explode('=', $essence_to_keys[$last_part]);
						} else {
							// There isn't $last_part in redirects, but there is parent essence
							// So we need to find out what type of essence is it
							$sql = "SELECT query, keyword FROM " . DB_PREFIX . "seo_url WHERE keyword = '" . $this->db->escape($last_part) . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY seo_url_id DESC LIMIT 1";

							$query = $this->db->query($sql);

							if ($query->row) {
								$res = explode('=', $query->row['query']);
							}
						}

						// Определяем сущность текущей страницы
						if ($res) {
							if ('product_id' == $res[0]) {
								$new_url = $this->url->link('product/product', 'product_id=' . $res[1]);
							}

							if ('category_id' == $res[0]) {
								$new_url = $this->url->link('product/category', 'path=' . $res[1]);
							}

							if ('manufacturer_id' == $res[0]) {
								$new_url = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $res[1]);
							}

							if ('information_id' == $res[0]) {
								$new_url = $this->url->link('information/information', 'information_id=' . $res[1]);
							}
						}

						if ($new_url) {
							$this->response->redirect($new_url, 301);
							exit;
						}
						// SEO URL Generator PRO . End

						$this->request->get['route'] = 'error/not_found';
					}

					break;
				}
			}

			if (!isset($this->request->get['route'])) {
				if (isset($this->request->get['product_id'])) {
					$this->request->get['route'] = 'product/product';
				} elseif (isset($this->request->get['path'])) {
					$this->request->get['route'] = 'product/category';

        } elseif (isset($this->request->get['fly_page_id'])) {
            $this->request->get['route'] = 'product/category';
      
				} elseif (isset($this->request->get['manufacturer_id'])) {
					$this->request->get['route'] = 'product/manufacturer/info';
				} elseif (isset($this->request->get['information_id'])) {
					$this->request->get['route'] = 'information/information';
				}
			}
		}
		
		//seopro validate
		if($this->config->get('config_seo_pro')){		
			$this->seo_pro->validate();
		}
	//seopro validate
		
	}

	public function rewrite($link) {
		$url_info = parse_url(str_replace('&amp;', '&', $link));

		if($this->config->get('config_seo_pro')){		
		$url = null;
			} else {
		$url = '';
		}

		$data = array();

		parse_str($url_info['query'], $data);
		
		//seo_pro baseRewrite
		if($this->config->get('config_seo_pro')){		
			list($url, $data, $postfix) =  $this->seo_pro->baseRewrite($data, (int)$this->config->get('config_language_id'));	
		}
		
		

		
		//seo_pro baseRewrite

		foreach ($data as $key => $value) {
			if (isset($data['route'])) {
				if (($data['route'] == 'product/product' && $key == 'product_id') || ($data['route'] == 'product/category' && $key == 'fly_page_id') || (($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

					if ($query->num_rows && $query->row['keyword']) {
						$url .= '/' . $query->row['keyword'];

						unset($data[$key]);
					}
				} elseif ($key == 'path') {
					$categories = explode('_', $value);

					foreach ($categories as $category) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE `query` = 'category_id=" . (int)$category . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

						if ($query->num_rows && $query->row['keyword']) {
							$url .= '/' . $query->row['keyword'];
						} else {
							$url = '';

							break;
						}
					}

					unset($data[$key]);
				}
			}
		}

		//seo_pro add blank url
		unset($data['route']);

		$query = '';

		if ($data) {
			foreach ($data as $key => $value) {
				$query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((is_array($value) ? http_build_query($value) : (string)$value));
			}

			if ($query) {
				$query = '?' . str_replace('&', '&amp;', trim($query, '&'));
			}
		}
		
		if($this->config->get('config_seo_pro')) {		
			$condition = ($url !== null);
		} else {
			$condition = $url;
		}

		if ($condition) {
			if($this->config->get('config_seo_pro')){		
				if($this->config->get('config_page_postfix') && $postfix) {
					$url .= $this->config->get('config_page_postfix');
				} elseif($this->config->get('config_seopro_addslash') || !empty( $query)) {
					$url .= '/';
				} 
			}

			return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
		} else {
			return $link;
		}
	}
}
