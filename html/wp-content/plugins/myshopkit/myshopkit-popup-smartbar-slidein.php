<?php
/**
 * Plugin Name: MyShopKit Popup SmartBar SlideIn
 * Plugin URI: https://popup-smartbar-slidein.myshopkit.app
 * Description: The one kit to boost sales
 * Version: 1.0.4
 * Author: Wiloke
 * Author URI: https://wiloke.com
 * Text Domain: myshopkit-popup-smartbar-slidein
 */


define('MYSHOOKITPSS_VERSION', '1.2.2');
define('MYSHOOKITPSS_NAMESPACE', 'myshopkit');
define('MYSHOOKITPSS_HOOK_PREFIX', 'myshopkit/');
define('MYSHOOKITPSS_PREFIX', 'myshopkit_');
define('MYSHOOKITPSS_REST_VERSION', 'v1');
define('MYSHOOKITPSS_REST_BASE', MYSHOOKITPSS_NAMESPACE . '/' . MYSHOOKITPSS_REST_VERSION);
define('MYSHOOKITPSS_REST_NAMESPACE', 'myshopkit');
define('MYSHOOKITPSS_DS', '/');

define('MYSHOOKITPSS_REST', MYSHOOKITPSS_REST_NAMESPACE . MYSHOOKITPSS_DS . MYSHOOKITPSS_REST_VERSION);
define('MYSHOOKITPSS_URL', plugin_dir_url(__FILE__));
define('MYSHOOKITPSS_PATH', plugin_dir_path(__FILE__));


use MyShopKitPopupSmartBarSlideIn\Dashboard\Controllers\AuthController;
use MyShopKitPopupSmartBarSlideIn\MailServices;
use MyShopKitPopupSmartBarSlideIn\Shared\App;
use MyShopKitPopupSmartBarSlideIn\Shared\AutoPrefix;

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

//Tao file ConfigTemplate
App::bind('TemplateMeta', require_once(MYSHOOKITPSS_PATH . 'src/Shared/Configs/TemplateMeta.php'));

require_once(MYSHOOKITPSS_PATH . 'src/MailServices/MailServices.php');
require_once(MYSHOOKITPSS_PATH . 'src/Insight/Insight.php');
require_once(MYSHOOKITPSS_PATH . 'src/SmartBar/smartbar.php');
require_once(MYSHOOKITPSS_PATH . 'src/Popup/popup.php');
require_once(MYSHOOKITPSS_PATH . 'src/Discount/Discount.php');
require_once(MYSHOOKITPSS_PATH . 'src/Dashboard/Dashboard.php');
require_once(MYSHOOKITPSS_PATH . 'src/Product/Product.php');
require_once(MYSHOOKITPSS_PATH . 'src/Page/Page.php');
require_once(MYSHOOKITPSS_PATH . 'src/General/General.php');
require_once(MYSHOOKITPSS_PATH . 'src/PostScript/PostScript.php');
require_once(MYSHOOKITPSS_PATH . 'src/Images/Images.php');
require_once(MYSHOOKITPSS_PATH . 'src/Slidein/Slidein.php');
