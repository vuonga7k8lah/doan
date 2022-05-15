<?php


namespace ZIMAC\Widget\Controllers;

use HSSC\Widgets\Controllers\MyWidgetRecentPosts;

/**
 * Class RegisterWidgetController
 * @package ZM\Widget\Controllers
 */
class RegisterWidgetController
{
	public function __construct()
	{
		add_action('widgets_init', [$this, 'registerSidebars']);
	}

	public function registerSidebars()
	{
		register_sidebar(
			[
				'name'          => esc_html__('Single Sidebar', 'zimac'),
				'description'   => esc_html__('Displaying widget items on the Sidebar area', 'zimac'),
				'id'            => ZIMAC_THEME_PREFIX . 'single-sidebar',
				'before_widget' => '<div>',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="wil-title-section mb-3 font-bold text-xl lg:text-1.375rem flex items-center text-gray-900 dark:text-gray-100 "><span class="truncate">',
				'after_title'   => '</span></div>'
			]
		);

		if (defined('HSBLOG2_SC_PREFIX')) {
			register_sidebar(
				[
					'name'          => esc_html__('Footer Recent Posts', 'zimac'),
					'description'   => esc_html__('Only use Recent Posts Widget for this area', 'zimac'),
					'id'            => ZIMAC_THEME_PREFIX . 'recent_posts_footer',
					'before_widget' => '<div>',
					'after_widget'  => '</div>',
					'before_title'  => '<h6 class="wil-footer-widget-title text-base text-white font-bold uppercase tracking-wider mb-5">',
					'after_title'   => '</h6>'
				]
			);
		}

		register_sidebar(
			[
				'name'          => esc_html__('Footer 1', 'zimac'),
				'description'   => esc_html__('Displaying widget items on the Footer 1 area', 'zimac'),
				'id'            => ZIMAC_THEME_PREFIX . 'first-footer',
				'before_widget' => '<div class="footer-widget-1">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="wil-footer-widget-title text-base text-white font-bold uppercase tracking-wider mb-5">',
				'after_title'   => '</h6>'
			]
		);

		register_sidebar(
			[
				'name'          => esc_html__('Footer 2', 'zimac'),
				'description'   => esc_html__('Displaying widget items on the Footer 2 area', 'zimac'),
				'id'            => ZIMAC_THEME_PREFIX . 'second-footer',
				'before_widget' => '<div class="footer-widget-2">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="wil-footer-widget-title text-base text-white font-bold uppercase tracking-wider mb-5">',
				'after_title'   => '</h6>'
			]
		);

		register_sidebar(
			[
				'name'          => esc_html__('Footer 3', 'zimac'),
				'description'   => esc_html__('Displaying widget items on the Footer 3 area', 'zimac'),
				'id'            => ZIMAC_THEME_PREFIX . 'third-footer',
				'before_widget' => '<div class="footer-widget-3">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="wil-footer-widget-title text-base text-white font-bold uppercase tracking-wider mb-5">',
				'after_title'   => '</h6>'
			]
		);

		register_sidebar(
			[
				'name'          => esc_html__('Footer 4', 'zimac'),
				'description'   => esc_html__('Displaying widget items on the Footer 4 area', 'zimac'),
				'id'            => ZIMAC_THEME_PREFIX . 'four-footer',
				'before_widget' => '<div class="footer-widget-4">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="wil-footer-widget-title text-base text-white font-bold uppercase tracking-wider mb-5">',
				'after_title'   => '</h6>'
			]
		);
	}
}
