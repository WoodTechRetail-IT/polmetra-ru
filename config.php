<?php
// HTTP
define('HTTP_SERVER', 'http://localhost/polmetra-ru/');

// HTTPS
define('HTTPS_SERVER', 'http://localhost/polmetra-ru/');

// DIR
define('DIR_APPLICATION', 'Z:/DevProjects/wamp-server/www/polmetra-ru/catalog/');
define('DIR_SYSTEM', 'Z:/DevProjects/wamp-server/www/polmetra-ru/system/');
define('DIR_IMAGE', 'https://polmetra.ru/image/');
define('DIR_STORAGE', 'Z:/DevProjects/wamp-server/www/polmetra-ru/storage/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');


// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', '149.154.67.20:3311');
define('DB_USERNAME', 'wooodpolm');
define('DB_PASSWORD', 'xK7aC2oG2wlY6d');
define('DB_DATABASE', 'wooodpolm');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');