<?php

use HSSC\Helpers\App;

$aConfigFieldSocial = [
	'facebook'  => esc_html__('Facebook', 'hsblog2-shortcodes'),
	'instagram' => esc_html__('Instagram', 'hsblog2-shortcodes'),
	'twitter'   => esc_html__('Twitter', 'hsblog2-shortcodes'),
	'pinterest' => esc_html__('Pinterest', 'hsblog2-shortcodes'),
	'telegram'  => esc_html__('Telegram', 'hsblog2-shortcodes'),
	'linkedin'  => esc_html__('Linkedin', 'hsblog2-shortcodes')
];
App::bind('aConfigFieldSocial', $aConfigFieldSocial);
foreach (array_keys($aConfigFieldSocial) as $key) {
	$afieldSocial[] = [
		'id'      => $key,
		'type'    => 'switch',
		'title'   => sprintf(esc_html__('Enable Share To %s', 'hsblog2-shortcodes'), $aConfigFieldSocial[$key]),
		'default' => true,
	];
}
return [
	'args' => [
		// TYPICAL -> Change these values as you need/desire
		'opt_name'             => 'wiloke_options',
		// This is where your data is stored in the database and also becomes your global variable name.
		'display_name'         => 'Tuyển Sinh Sau Đại Học',
		// Name that appears at the top of your panel
		'display_version'      => HSBLOG2_VERSION,
		// Version that appears at the top of your panel
		'menu_type'            => 'submenu',
		//Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
		'allow_sub_menu'       => false,
		// Show the sections below the admin menu item or not
		'menu_title'           => esc_html__('Theme Options', 'hsblog'),
		'page_title'           => esc_html__('Theme Options', 'hsblog'),
		// You will need to generate a Google API key to use this feature.
		// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
		'google_api_key'       => '',
		// Set it you want google fonts to update weekly. A google_api_key value is required.
		'google_update_weekly' => false,
		// Must be defined to add google fonts to the typography module
		'async_typography'     => true,
		// Use a asynchronous font on the front end or font string
		'admin_bar'            => true,
		// Show the panel pages on the admin bar
		'admin_bar_icon'       => 'dashicons-portfolio',
		// Choose an icon for the admin bar menu
		'admin_bar_priority'   => 50,
		// Choose an priority for the admin bar menu
		'global_variable'      => '',
		// Set a different name for your global variable other than the opt_name
		'dev_mode'             => false,
		// Show the time the page took to load, etc
		'update_notice'        => false,
		// If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
		'customizer'           => false,
		// OPTIONAL -> Give you extra features
		'page_priority'        => null,
		'page_parent'          => 'themes.php',
		'page_permissions'     => 'manage_options',
		// Permissions needed to access the options panel.
		'menu_icon'            => '',
		// Specify a custom URL to an icon
		'last_tab'             => '',
		// Force your panel to always open to a specific tab (by id)
		'page_icon'            => 'icon-themes',
		// Icon displayed in the admin panel next to your menu_title
		'page_slug'            => '',
		'save_defaults'        => true,
		// On load save the defaults to DB before user clicks save or not
		'default_show'         => false,
		// If true, shows the default value next to each field that is not the default value.
		'default_mark'         => '',
		// What to print by the field's title if the value shown is default. Suggested: *
		'show_import_export'   => true,
		// Shows the Import/Export panel when not used as a field.
		// CAREFUL -> These options are for advanced use only
		'transient_time'       => 60 * MINUTE_IN_SECONDS,
		'output'               => true,
		// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
		'output_tag'           => true,
		// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
		'database'             => '',
		// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
		'system_info'          => false,
		// REMOVE

		// HINTS
		'hints'                => [
			'icon'          => 'el el-question-sign',
			'icon_position' => 'right',
			'icon_color'    => 'lightgray',
			'icon_size'     => 'normal',
			'tip_style'     => [
				'color'   => 'light',
				'shadow'  => true,
				'rounded' => false,
				'style'   => '',
			],
			'tip_position'  => [
				'my' => 'top left',
				'at' => 'bottom right',
			],
			'tip_effect'    => [
				'show' => [
					'effect'   => 'slide',
					'duration' => '500',
					'event'    => 'mouseover',
				],
				'hide' => [
					'effect'   => 'slide',
					'duration' => '500',
					'event'    => 'click mouseleave',
				],
			],
		]
	],

	'sections' => apply_filters(HSBLOG2_SC_PREFIX . '/configuration/themeoptions', [
		// === SECTION GENERAL Settings
		[
			'title'            => esc_html__('General', 'hsblog2-shortcodes'),
			'id'               => 'general_settings',
			'subsection'       => false,
			'icon'             => 'dashicons dashicons-admin-tools',
			'customizer_width' => '500px',
			'fields'           => []
		],
		// === <SUB> SECTION Logo Settings
		[
			'title'            => esc_html__('Logo', 'hsblog2-shortcodes'),
			'id'               => 'logo_settings',
			'icon'             => 'dashicons dashicons-format-gallery',
			'customizer_width' => '500px',
			'subsection'		=> true,
			'fields'           => [
				[
					'id'       => 'logo_img',
					'type'     => 'media',
					'url'      => true,
					'title'    => esc_html__('Logo Image', 'hsblog2-shortcodes'),
					'desc'     => esc_html__('Basic media uploader with disabled URL input field.', 'hsblog2-shortcodes'),
					'subtitle' => esc_html__('Upload any media using the WordPress native uploader', 'hsblog2-shortcodes'),
					'default'  => array(
						'url' => ''
					),
				],
				[
					'id'       => 'logo_img_dark',
					'type'     => 'media',
					'url'      => true,
					'title'    => esc_html__('Light Logo Image', 'hsblog2-shortcodes'),
					'desc'     => esc_html__('Basic media uploader with disabled URL input field.', 'hsblog2-shortcodes'),
					'subtitle' => esc_html__('Upload any media using the WordPress native uploader. This Logo image will be used in dark mode', 'hsblog2-shortcodes'),
					'default'  => array(
						'url' => ''
					),
				],
			]
		],
		// === SUB SECTION Follow Us Settings
		[
			'title'            => esc_html__('Follow Us', 'hsblog2-shortcodes'),
			'id'               => 'follow_us_settings',
			'subsection'       => true,
			'icon'             => 'dashicons dashicons-networking',
			'customizer_width' => '500px',
			'fields'           => [
				[
					'id' 		=> 'socials_settings',
					'title'    	=> esc_html__('Socials setting', 'hsblog2-shortcodes'),
					'subtitle'	=> esc_html__('Change url of your social, leave empty if do not use', 'hsblog2-shortcodes'),
					'type' 		=> 'text',
					'data' 		=> [
						'facebook' 	=> 'Facebook URL',
						'instagram' => 'Instagram URL',
						'linkedin' 	=> 'Linkedin URL',
						'youtube' 	=> 'Youtube URL',
						'twitter' 	=> 'Twitter URL',
						'whatsapp' 	=> 'WhatsApp URL',
					],
					'placeholder' 		=> [
						'facebook' 	=> 'Facebook URL',
						'instagram' => 'Instagram URL',
						'linkedin' 	=> 'Linkedin URL',
						'youtube' 	=> 'Youtube URL',
						'twitter' 	=> 'Twitter URL',
						'whatsapp' 	=> 'WhatsApp URL',
					],
					'default' 		=> [
						'facebook' 	=> '#',
						'instagram' => '#',
						'linkedin' 	=> '#',
						'youtube' 	=> '#',
						'twitter' 	=> '#',
						'whatsapp' 	=> '#',
					],
				],
			]
		],

		// === SUB SECTION Default theme mode Settings
		[
			'title'            => esc_html__('Theme Mode', 'hsblog2-shortcodes'),
			'id'               => 'default_theme_mode_section',
			'subsection'       => true,
			'icon'             => 'dashicons dashicons-art',
			'customizer_width' => '500px',
			'fields'           => [
				[
					'id'       => 'enable_theme_mode',
					'type'     => 'switch',
					'title'    => __('Switch On Theme mode', 'hsblog2-shortcodes'),
					'subtitle' => __('Enable/Disable Theme mode', 'hsblog2-shortcodes'),
					'default'  => true,
				],
				[
					'id'       => 'default_theme_mode',
					'type'     => 'radio',
					'title'    => esc_html__('Default Theme Mode', 'hsblog2-shortcodes'),
					'subtitle'	=> esc_html__('Choose the Theme mode default (Dark mode/Light mode)', 'hsblog2-shortcodes'),
					'data'  => array(
						'dark' 	=>  esc_html__('Dark Mode', 'hsblog2-shortcodes'),
						'light' =>  esc_html__('Light Mode', 'hsblog2-shortcodes'),
					),
					'default' => 'light',
					'required' => [
						['enable_theme_mode', '=', true]
					]
				],
			]
		],

		// === SECTION SignIn/SignUp Settings
		[
			'title'            => esc_html__('SignIn/SignUp', 'hsblog2-shortcodes'),
			'id'               => 'sign_in_sign_up_setting',
			'subsection'       => false,
			'icon'             => 'dashicons dashicons-admin-users',
			'customizer_width' => '500px',
			'fields'           => []
		],
		// === SUB SECTION Toggle Search Settings
		[
			'title'            => esc_html__('Socials Login', 'hsblog2-shortcodes'),
			'id'               => 'sign_in_sign_up_social_login',
			'subsection'       => true,
			'icon'             => 'dashicons dashicons-facebook',
			'customizer_width' => '500px',
			'fields'           => [
				[
					'id'       	=> 'sign_in_sign_up_social_login_facebook',
					'type'     	=> 'text',
					'title'    	=> esc_html__('Facebook Simple link href', 'hsblog2-shortcodes'),
					'subtitle'	=> esc_html__('Input Facebook Simple link href (Leave empty if do not use)', 'hsblog2-shortcodes'),
					'desc'   	=> esc_html__('Active Nextend Social Login Plugin to use this setting. Setting Facebook, change to Usage tab and coppy simple link href and paste to this field', 'hsblog2-shortcodes'),
					'default'	=> '#'
				],
				[
					'id'       	=> 'sign_in_sign_up_social_login_twitter',
					'type'     	=> 'text',
					'title'    	=> esc_html__('Twitter Simple link href', 'hsblog2-shortcodes'),
					'subtitle'	=> esc_html__('Input Twitter Simple link href (Leave empty if do not use)', 'hsblog2-shortcodes'),
					'desc'   	=> esc_html__('Active Nextend Social Login Plugin to use this setting. Setting Twitter, change to Usage tab and coppy simple link href and paste to this field', 'hsblog2-shortcodes'),
					'default'	=> '#'
				],
				[
					'id'       	=> 'sign_in_sign_up_social_login_google',
					'type'     	=> 'text',
					'title'    	=> esc_html__('Google Simple link href', 'hsblog2-shortcodes'),
					'subtitle'	=> esc_html__('Input Google Simple link href (Leave empty if do not use)', 'hsblog2-shortcodes'),
					'desc'   	=> esc_html__('Active Nextend Social Login Plugin to use this setting. Setting Google, change to Usage tab and coppy simple link href and paste to this field', 'hsblog2-shortcodes'),
					'default'	=> '#'
				],
			]
		],
		[
			'title'            => esc_html__('Login in Home page', 'hsblog2-shortcodes'),
			'id'               => 'sign_in_sign_up_login_frontend',
			'subsection'       => true,
			'icon'             => 'dashicons dashicons-admin-page',
			'customizer_width' => '500px',
			'fields'           => [
				[
					'id'       => 'sign_in_sign_up_login_frontend_enable_login',
					'type'     => 'switch',
					'title'    => esc_html__('Login in Popup', 'hsblog2-shortcodes'),
					'subtitle' => esc_html__('Login in Popup at home page', 'hsblog2-shortcodes'),
					'desc' 	   => esc_html__('On/Off Login mode in the popup at home page, including login and registration', 'hsblog2-shortcodes'),
					'default'  => true,
				],
				[
					'id'       => 'sign_in_sign_up_login_frontend_enable_register',
					'type'     => 'switch',
					'title'    => esc_html__('Register in Popup', 'hsblog2-shortcodes'),
					'subtitle' => esc_html__('Register in Popup at home page', 'hsblog2-shortcodes'),
					'desc' 	   => esc_html__('On/Off Register mode in the popup at home page. (This function will also be disabled, if member registration was turn off in Settings -> Reneral -> Membership)', 'hsblog2-shortcodes'),
					'default'  => true,
				],
			]
		],

		// === SECTION Header Settings
		[
			'title'            => esc_html__('Header', 'hsblog2-shortcodes'),
			'id'               => 'header_settings',
			'subsection'       => false,
			'icon'             => 'dashicons dashicons-heading',
			'customizer_width' => '500px',
			'fields'           => []
		],
		// === SUB SECTION Toggle Search Settings
		[
			'title'            => esc_html__('Header Search', 'hsblog2-shortcodes'),
			'id'               => 'header_search',
			'subsection'       => true,
			'icon'             => 'dashicons dashicons-search',
			'customizer_width' => '500px',
			'fields'           => [
				[
					'id'       => 'toggle_header_search',
					'type'     => 'radio',
					'title'    => esc_html__('Enable/Disable Input Search', 'hsblog2-shortcodes'),
					'subtitle'	=> esc_html__('Enable or Disable visibility Input search on header', 'hsblog2-shortcodes'),
					'data'  => array(
						'disable' 		=>  esc_html__('Disable', 'hsblog2-shortcodes'),
						'enable' 		=>  esc_html__('Enable', 'hsblog2-shortcodes'),
					),
					'default' => 'enable'
				],
				[
					'id'       	=> 'header_search_placeholder',
					'type'     	=> 'text',
					'title'    	=> esc_html__('Input search placeholder', 'hsblog2-shortcodes'),
					'subtitle'	=> esc_html__('Change placeholder for input search', 'hsblog2-shortcodes'),
					'default'   => esc_html__('Search travel, lifestyle…', 'hsblog2-shortcodes')
				],
			]
		],
		// === SUB SECTION USER Settings
		[
			'title'            => esc_html__('Header Admin User', 'hsblog2-shortcodes'),
			'id'               => 'header_admin_user',
			'subsection'       => true,
			'icon'             => 'dashicons dashicons-admin-users',
			'customizer_width' => '500px',
			'fields'           => [
				[
					'id'       	=> 'header_admin_user_account_page_link',
					'type'     	=> 'text',
					'title'    	=> esc_html__('Account page', 'hsblog2-shortcodes'),
					'subtitle'	=> esc_html__('Input url of the account page (leave empty if do not use)', 'hsblog2-shortcodes'),
					'desc'		=> esc_html__('Create a page for user account, then input url of the account page to this field', 'hsblog2-shortcodes'),
					'default'   => esc_html__('#', 'hsblog2-shortcodes')
				],
				[
					'id'       	=> 'header_admin_user_wrire_artile_page_link',
					'type'     	=> 'text',
					'title'    	=> esc_html__('Write article page', 'hsblog2-shortcodes'),
					'subtitle'	=> esc_html__('Input url of the write article page (leave empty if do not use)', 'hsblog2-shortcodes'),
					'desc'		=> esc_html__('Create a page for user write article, then input url of the write article page to this field', 'hsblog2-shortcodes'),
					'default'   => esc_html__('#', 'hsblog2-shortcodes')
				],
				[
					'id'       	=> 'header_admin_user_help_page_link',
					'type'     	=> 'text',
					'title'    	=> esc_html__('Help page', 'hsblog2-shortcodes'),
					'subtitle'	=> esc_html__('Input url of the help page (leave empty if do not use)', 'hsblog2-shortcodes'),
					'desc'		=> esc_html__('Create a help page, then input url help page to this field', 'hsblog2-shortcodes'),
					'default'   => esc_html__('#', 'hsblog2-shortcodes')
				],
			]
		],

		// === SECTION Footer Settings
		[
			'title'            => esc_html__('Footer', 'hsblog2-shortcodes'),
			'id'               => 'footer_settings',
			'subsection'       => false,
			'icon'             => 'dashicons dashicons-feedback',
			'customizer_width' => '500px',
			'fields'           => []
		],
		// === SECTION FOOTER BG
		[
			'title'            => esc_html__('Background', 'hsblog2-shortcodes'),
			'id'               => 'footer_settings_bg',
			'subsection'       => true,
			'icon'             => 'dashicons dashicons-image',
			'customizer_width' => '500px',
			'fields'           => [
				[
					'id'       => 'footer_settings_bg_img',
					'type'     => 'media',
					'url'      => true,
					'title'    => esc_html__('Background Image', 'hsblog2-shortcodes'),
					'subtitle' => esc_html__('Upload footer background image using the WordPress native uploader', 'hsblog2-shortcodes'),
					'default'  => array(
						'url' => ''
					),
				]
			]
		],
		// === SECTION Copyright Settings
		[
			'title'            => esc_html__('Copyright', 'hsblog2-shortcodes'),
			'id'               => 'copyright',
			'subsection'       => true,
			'icon'             => 'dashicons dashicons-sos',
			'customizer_width' => '500px',
			'fields'           => [
				[
					'id'       => 'copyright_setting',
					'type'     => 'ace_editor',
					'title'    => esc_html__('Copyright content', 'hsblog2-shortcodes'),
					'subtitle' => esc_html__('Change the footer copyright HTML content', 'hsblog2-shortcodes'),
					'mode'     => 'html',
					'theme'    => 'monokai',
					'default'  => esc_html__("Copyright © 2021 Wiloke.com. Address: 1002312 State Street, 20th Floor Boston A", 'hsblog2-shortcodes')
				]
			]
		],
		// === SECTION HOME PAGE Settings
		[
			'title'            => esc_html__('Home Page', 'hsblog2-shortcodes'),
			'id'               => 'home_page_settings',
			'subsection'       => false,
			'icon'             => 'dashicons dashicons-admin-home',
			'customizer_width' => '500px',
			'fields'           => [
				[
					'id'       => 'home_page_settings_bg',
					'type'     => 'media',
					'url'      => true,
					'title'    => esc_html__('Background Image', 'hsblog2-shortcodes'),
					'desc'     => esc_html__('Basic media uploader with disabled URL input field.', 'hsblog2-shortcodes'),
					'subtitle' => esc_html__('Upload any media using the WordPress native uploader', 'hsblog2-shortcodes'),
					'default'  => array(
						'url' => ''
					),
				]
			]
		],
		// === SECTION SINGLE Settings
		[
			'title'            => esc_html__('Single Listing', 'hsblog2-shortcodes'),
			'id'               => 'single_listing',
			'subsection'       => false,
			'icon'             => 'dashicons dashicons-share-alt2',
			'customizer_width' => '500px',
			'fields'           => []
		],
		// === <SUB> SECTION Single PostType
		[
			'title'            => esc_html__('Single Template', 'hsblog2-shortcodes'),
			'id'               => 'single_template_settings',
			'subsection'       => true,
			'icon'             => 'dashicons dashicons-book',
			'customizer_width' => '500px',
			'fields'           => [
				[
					'id'         => 'single_template_default',
					'title'      => esc_html__('Single Template Default', 'hsblog2-shortcodes'),
					'type'       => 'select',
					'desc'       => esc_html__('Select single template default for add new post', 'hsblog2-shortcodes'),
					'options' 	 => [
						'template1' 		=> 'Template 1',
						'template2' 		=> 'Template 2',
						'template3' 		=> 'Template 3',
					],
					'default'  => 'template1',
				],
			]
		],
		// === <SUB> SECTION Social Share Settings
		[
			'title'            => esc_html__('Social Share Settings', 'hsblog2-shortcodes'),
			'id'               => 'social_share_setting',
			'subsection'       => true,
			'icon'             => 'dashicons dashicons-share-alt2',
			'customizer_width' => '500px',
			'fields'           => $afieldSocial
		],
		// === <SUB> SECTION Related Posts Settings
		[
			'title'            => esc_html__('Related Posts Settings', 'hsblog2-shortcodes'),
			'id'               => 'related_posts_setting',
			'subsection'       => true,
			'icon'             => 'dashicons dashicons-book',
			'customizer_width' => '500px',
			'fields'           => [
				[
					'id'         => 'related_posts_title',
					'title'      => esc_html__('Section Title', 'hsblog2-shortcodes'),
					'type'       => 'Text',
					'desc'       => esc_html__('Type your title here', 'hsblog2-shortcodes'),
					'default'    => esc_html__('Related Posts', 'hsblog2-shortcodes')
				],
				[
					'id'       => 'related_post_taxonomy',
					'type'     => 'select',
					'title'    => esc_html__('Select Option', 'hsblog2-shortcodes'),
					'desc'     => esc_html__('Select post taxonomy for realted post', 'hsblog2-shortcodes'),
					'options'  => [
						'category' 		=> 'Category',
						'post_tag' 		=> 'Tag',
					],
					'default'  => 'category',
				],
				[
					'id'         => 'related_posts_posts_per_page',
					'title'      => esc_html__('Number Posts', 'hsblog2-shortcodes'),
					'type'       => 'text',
					'attributes' => [
						'type' => 'number',
					],
					'default'    => 4
				],
				[
					'id'      => 'related_posts_order_by',
					'type'    => 'select',
					'title'   => esc_html__('Order By', 'hsblog2-shortcodes'),
					'options' => App::get('ElementorCommonRegistration')::getOrderByOptions(),
					'default' => array_key_first(App::get('ElementorCommonRegistration')::getOrderByOptions())
				]
			]
		],
		// === <SUB> SECTION More Posts By Author Settings
		[
			'title'            => esc_html__('More Posts By Author Settings', 'hsblog2-shortcodes'),
			'id'               => 'more_posts_by_author',
			'subsection'       => true,
			'icon'             => 'dashicons dashicons-businessperson',
			'customizer_width' => '500px',
			'fields'           => [
				[
					'id'         => 'more_posts_by_author_title',
					'title'      => esc_html__('Section Title', 'hsblog2-shortcodes'),
					'type'       => 'Text',
					'desc'       => esc_html__('Type your title here', 'hsblog2-shortcodes'),
					'default'    => esc_html__('More Posts By Author', 'hsblog2-shortcodes')
				],
				[
					'id'         => 'more_posts_by_author_posts_per_page',
					'title'      => esc_html__('Number Posts', 'hsblog2-shortcodes'),
					'type'       => 'text',
					'attributes' => [
						'type' => 'number',
					],
					'default'    => 4
				],
				[
					'id'      => 'more_posts_by_author_order_by',
					'type'    => 'select',
					'title'   => esc_html__('Order By', 'hsblog2-shortcodes'),
					'options' => App::get('ElementorCommonRegistration')::getOrderByOptions(),
					'default' => array_key_first(App::get('ElementorCommonRegistration')::getOrderByOptions())
				]
			]
		],

		// === SECTION Author Page Settings
		[
			'title'            => esc_html__('Author Page', 'hsblog2-shortcodes'),
			'id'               => 'author_page_settings',
			'subsection'       => false,
			'icon'             => 'dashicons dashicons-money',
			'customizer_width' => '500px',
			'fields'           => []
		],

		// === <SUB> SECTION Author Default Hero BG
		[
			'title'            => esc_html__('Header Section', 'hsblog2-shortcodes'),
			'id'               => 'author_page_header_section',
			'subsection'       => true,
			'icon'             => 'dashicons dashicons-id',
			'customizer_width' => '500px',
			'fields'           => [
				[
					'id'       => 'author_page_header_section_default_bg',
					'type'     => 'media',
					'url'      => true,
					'readonly' => false,
					'title'    => esc_html__('Default Image Background', 'hsblog2-shortcodes'),
					'subtitle' => esc_html__('Upload image use default for header background', 'hsblog2-shortcodes'),
					'default'  => array(
						'url' => 'https://images.pexels.com/photos/1450082/pexels-photo-1450082.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'
					),
				],

			]
		],
	])
];
