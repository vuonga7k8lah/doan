<?php

/**
 * Plugin Name: Hs2 Shortcodes
 * Author: Wiloke
 * Author URI: https://hs2.wiloke.com/
 * Plugin URI: https://docs.wiloke.com/hs2-documentation/
 * Description: Part of Hs2 theme
 * Version: 1.0
 * Domain Path: /languages
 * Text Domain: hs2-shortcodes
 */

use HSSC\Controllers\Elementor\ColorfulPostsFilterElement\ColorfulPostsFilterElementContent;
use HSSC\Controllers\Elementor\CreativePostsFilterElement\CreativePostsFilterElementContent;
use HSSC\Controllers\Shortcodes\AuthorCardItemSc;
use HSSC\Controllers\Shortcodes\BigUniqueVerticalBoxItemSc;
use HSSC\Controllers\Shortcodes\ButtonSc;
use HSSC\Controllers\Shortcodes\CreativeHorizontalBoxItemSc;
use HSSC\Controllers\Shortcodes\FullWidthVerticalBoxItemSc;
use HSSC\Controllers\Shortcodes\LitleHorizontalBoxItemSc;
use HSSC\Controllers\Shortcodes\LitleHorizontalBoxItemWhiteSc;
use HSSC\Controllers\Shortcodes\SimpleHorizontalBoxItemSc;
use HSSC\Shared\Elementor\CommonRegistration;
use HSSC\Controllers\Shortcodes\AvatarSc;
use HSSC\Controllers\Shortcodes\BigUniqueHorizontalBoxItemSc;
use HSSC\Controllers\Shortcodes\BoxCardInfoSc;
use HSSC\Controllers\Shortcodes\ByAuthorSc;
use HSSC\Controllers\Shortcodes\CategoryBadgeSc;
use HSSC\Controllers\Shortcodes\CreativeTextBoxItemSc;
use HSSC\Controllers\Shortcodes\CreativeVerticalBoxItemSc;
use HSSC\Controllers\Shortcodes\BookmarkIconSc;
use HSSC\Controllers\Shortcodes\SimpleTextBoxItemSc;
use HSSC\Controllers\Shortcodes\SimpleVerticalBoxItemSc;
use HSSC\Controllers\Shortcodes\UniqueHorizontalBoxItemSc;
use HSSC\Controllers\Shortcodes\UniqueVerticalBoxItemSc;
use HSSC\Controllers\Shortcodes\MailPoetFormSc;
use HSSC\Controllers\Term\TermMetaDataController;
use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Reports\Controllers\ReportsController;
use HSSC\Shared\Elementor\Select2AjaxControl;
use HSSC\Users\Controllers\UserCountViewsController;
use HSSC\Widgets\Controllers\WidgetController;

define('ZMAG_ACTION_PREFIX', 'hsAction_');
define('HSBLOG2_SC_PREFIX', 'hs_');
define('HSBLOG2_VERSION', '1.0');
define('ESC_HTML_TEXT_DOMAIN', 'HsBlog2Sc');
define('HSBLOG2_NAMESPACE', 'wiloke');
define('HSBLOG2_VERSION_API', 'v2');
define('HSSC_WIDGET', '(HSBLOG) ');
define('HSSC_PATH', plugin_dir_path(__FILE__));
define('HSSC_URL', plugin_dir_url(__FILE__));
define(
	'HSBLOG2_ELEMENTOR_FILLTER_COMMON',
	ZMAG_ACTION_PREFIX . '/app/Controllers/Elementor/ElementorCommonController/handleElementorFilter/'
);
require_once HSSC_PATH . "vendor/autoload.php";

// === Helper Function
App::bind('FunctionHelper', new FunctionHelper());
App::bind('ElementorCommonRegistration', new CommonRegistration());
//===create Table Count View
new \HSSC\Users\Database\StatisticViewInDay();
new \HSSC\Users\Database\StatisticBookmark();
new \HSSC\Users\Database\StatisticFollower();
new \HSSC\Users\Database\StatisticCommentEmotion();
// Theme Options
new HSSC\Shared\ThemeOptions\ThemeOptionSkeleton();

// === bind small shortcode common === //
App::bind('MailPoetFormSc', new MailPoetFormSc());
App::bind('AvatarSc', new AvatarSc());
App::bind('AuthorCardItemSc', new AuthorCardItemSc());
App::bind('BigUniqueHorizontalBoxItemSc', new BigUniqueHorizontalBoxItemSc());
App::bind('BigUniqueVerticalBoxItemSc', new BigUniqueVerticalBoxItemSc());
App::bind('BookmarkIconSc', new BookmarkIconSc());
App::bind('BoxCardInfoSc', new BoxCardInfoSc());
App::bind('ButtonSc', new ButtonSc());
App::bind('ByAuthorSc', new ByAuthorSc());
App::bind('CategoryBadgeSc', new CategoryBadgeSc());
App::bind('CreativeHorizontalBoxItemSc', new CreativeHorizontalBoxItemSc());
App::bind('CreativeTextBoxItemSc', new CreativeTextBoxItemSc());
App::bind('CreativeVerticalBoxItemSc', new CreativeVerticalBoxItemSc());
App::bind('FullWidthVerticalBoxItemSc', new FullWidthVerticalBoxItemSc());
App::bind('LitleHorizontalBoxItemSc', new LitleHorizontalBoxItemSc());
App::bind('LitleHorizontalBoxItemWhiteSc', new LitleHorizontalBoxItemWhiteSc());
App::bind('SimpleHorizontalBoxItemSc', new SimpleHorizontalBoxItemSc());
App::bind('SimpleTextBoxItemSc', new SimpleTextBoxItemSc());
App::bind('SimpleVerticalBoxItemSc', new SimpleVerticalBoxItemSc());
App::bind('UniqueHorizontalBoxItemSc', new UniqueHorizontalBoxItemSc());
App::bind('UniqueVerticalBoxItemSc', new UniqueVerticalBoxItemSc());
App::bind('ShareToSocialSc', new \HSSC\Controllers\Shortcodes\ShareToSocialSc());
App::bind('BookmarkSc', new \HSSC\Controllers\Shortcodes\BookmarkSc());
App::bind('NumberCommentsSc', new \HSSC\Controllers\Shortcodes\NumberCommentsSc());
App::bind('NumberViewsSc', new \HSSC\Controllers\Shortcodes\NumberViewsSc());

// ======= TUAN NEWWWWWW =========
App::bind('ColorfulPostsFilterElementContent', new ColorfulPostsFilterElementContent());
App::bind('CreativePostsFilterElementContent', new CreativePostsFilterElementContent());
// ======= TUAN NEWWWWWW =========

//create-api
new \HSSC\Controllers\Elementor\ElementorCommonController();
//create-class user
new \HSSC\Users\Controllers\UserBookmarkController();
new \HSSC\Users\Controllers\UserCountViewsController();
new \HSSC\Users\Controllers\UserFollowerController();
new \HSSC\Users\Controllers\UserCommentEmotionController();
new \HSSC\Users\Controllers\UserLoginController();
new \HSSC\Users\Controllers\UserRegisterController();
new WidgetController();
new ReportsController();
new UserCountViewsController();

add_action('elementor/widgets/widgets_registered', function () {
	require_once HSSC_PATH . "elementor-items.php";
});

// === Register more Wil Elementor control === //
add_action('elementor/controls/controls_registered', function () {
	$controls_manager = \Elementor\Plugin::$instance->controls_manager;
	$controls_manager->register_control('wil_select2_ajax', new Select2AjaxControl());
});

new TermMetaDataController();

//create-api
new \HSSC\Controllers\Elementor\ElementorCommonController();

/**
 *
 * @param [type] $hook
 * @return void
 */
function enqueueSelect2JsToWidget($hook)
{
	if ('widgets.php' !== $hook && 'edit.php' !== $hook) {
		return;
	}
	wp_enqueue_script('select2-vendor-js', HSSC_URL . '/assets/js/select2.min.js', [], HSBLOG2_VERSION_API);
	wp_enqueue_style('select2-vendor-css', HSSC_URL . '/assets/css/select2.min.css', [], HSBLOG2_VERSION_API);
	wp_enqueue_style('wilselec2ajax-our-css', HSSC_URL . '/assets/css/select2Ajax.css', [], HSBLOG2_VERSION_API);
}

add_action('admin_enqueue_scripts', 'enqueueSelect2JsToWidget');

/**
 *
 * @param [type] $hook
 * @return void
 */
function enqueueSelect2CSSToElmentor($hook)
{
	wp_enqueue_style('wilselec2ajax-our-css-elementor', HSSC_URL . '/assets/css/select2Ajax.css', [],
		HSBLOG2_VERSION_API);
}

add_action('elementor/editor/after_enqueue_scripts', 'enqueueSelect2CSSToElmentor');

// CMB2 Post metaboxes //
add_action('cmb2_admin_init', 'registerPostMetaboxes');
function registerPostMetaboxes()
{
	$cmb = new_cmb2_box([
		'id'           => HSBLOG2_SC_PREFIX . 'single_sidebar',
		'title'        => esc_html__('Single Sidebar', 'hsblog2-shortcodes'),
		'object_types' => ['post'], // Post type
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true, // Show field names on the left
	]);

	$cmb->add_field([
		'name' => esc_html__('Hidden Sidebar', 'hsblog2-shortcodes'),
		'desc' => esc_html__('If checked, single sidebar will hidden at this post', 'hsblog2-shortcodes'),
		'id'   => HSBLOG2_SC_PREFIX . 'hidden_sidebar_checkbox',
		'type' => 'checkbox',
	]);
}

add_action('init', 'hs2ShortcodesDomain');

/**
 * Load plugin textdomain.
 */
function hs2ShortcodesDomain()
{
	load_plugin_textdomain('hs2-shortcodes', false, plugin_dir_path(__FILE__) . 'languages');
}
