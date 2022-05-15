<?php
/**
 * Plugin Name:Do An Tot Nghiep
 * Plugin URI: https://vuongdttn1998.com
 * Description: He thong tuyen sinh sau dai hoc
 * Version: 1.0.4g
 * Author: Wiloke
 * Author URI: https://vuongdttn
 * Text Domain:
 */



define('MYSHOOKITPSS_VERSION_1', uniqid());
define('MYSHOOKITPSS_NAMESPACE_1', 'mskpss');
define('MYSHOOKITPSS_HOOK_PREFIX_1', 'mskpss/');
define('MYSHOOKITPSS_PREFIX_1', 'mskpss_');


define('MYSHOOKITPSS_URL_1', plugin_dir_url(__FILE__));
define('MYSHOOKITPSS_PATH_1', plugin_dir_path(__FILE__));



require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

require_once(MYSHOOKITPSS_PATH_1 . 'src/SmartBar/smartbar.php');
require_once(MYSHOOKITPSS_PATH_1 . 'src/Popup/popup.php');
require_once(MYSHOOKITPSS_PATH_1 . 'src/TSMasters/TSMasters.php');
require_once(MYSHOOKITPSS_PATH_1 . 'src/TSDoctor/TSDoctor.php');
require_once(MYSHOOKITPSS_PATH_1 . 'src/RabbitMQ/RabbitMQ.php');
