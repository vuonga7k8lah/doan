<?php

namespace ZIMAC\Menu\Controllers;

class RegisterMenuController
{
	public function __construct()
	{
		add_action('init', [$this, 'registerMenu']);
	}

	public function registerMenu()
	{
		register_nav_menus([
			ZIMAC_THEME_PREFIX . '_menu'         => esc_html__('Zimac Menu', 'zimac'),
			ZIMAC_THEME_PREFIX . '_sidebar_menu' => esc_html__('Zimac Sidebar Menu', 'zimac'),
		]);
	}
}
