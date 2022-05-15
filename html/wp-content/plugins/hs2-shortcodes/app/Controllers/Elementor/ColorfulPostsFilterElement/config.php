<?php

use HSSC\Helpers\App;
use HSSC\Shared\Elementor\Select2AjaxControl;

return [
	'general_settings' => [
		'options'  => [
			'label' => esc_html__('General Settings', 'hs2-shortcodes'),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		],
		'controls' => [
			'section_title' => [
				'label'         => esc_html__('Section Title', 'hs2-shortcodes'),
				'type'          => \Elementor\Controls_Manager::TEXT,
				'input_type'    => 'text',
				'default'       => esc_html__('', 'hs2-shortcodes'),
				'placeholder'   => esc_html__('Type your title here', 'hs2-shortcodes'),
			],
			'title_url'     => [
				'label'         => esc_html__('Title Url', 'hs2-shortcodes'),
				'type'          => \Elementor\Controls_Manager::TEXT,
				'input_type'    => 'url',
				'placeholder'   => esc_html('https://your-link.com'),
				'condition'     => [
					'section_title!' => ''
				]
			],
			'posts_per_page'  => [
				'label'   => esc_html__('Number Posts', 'hs2-shortcodes'),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 16,
				'step'    => 1,
				'default' => 8,
			],
			'gap'            => App::get('ElementorCommonRegistration')::getElGapControl(5),
		]
	],
	'filter_settings'  => [
		'options'  => [
			'label' => esc_html__('Filter Settings', 'hs2-shortcodes'),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		],
		'controls' => [
			'get_post_by'     => App::get('ElementorCommonRegistration')::getElGetPostByControl(),
			'order_by_options' => [
				'label'       => esc_html__('Order By Options', 'hs2-shortcodes'),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'default'     => array_keys(App::get('ElementorCommonRegistration')::getOrderByOptions()),
				'label_block' => true,
				'description' => esc_html__('Leave empty if do not show this filter', 'hs2-shortcodes'),
				'options'     => App::get('ElementorCommonRegistration')::getOrderByOptions(),
				'condition'   => [
					'get_post_by' => 'categories'
				],
				'multiple'    => true
			],
			'orderby'         => [
				'label'         => esc_html__('Order By Options Default', 'hs2-shortcodes'),
				'type'          => \Elementor\Controls_Manager::SELECT2,
				'multiple'      => false,
				'label_block'   => true,
				'options'       =>  App::get('ElementorCommonRegistration')::getOrderByOptions(),
				'description'   => esc_html__('Leave empty if do not show this filter', 'hs2-shortcodes'),
				'default'       =>  array_keys(App::get('ElementorCommonRegistration')::getOrderByOptions())[0],
				'condition'     => [
					'get_post_by' => 'categories'
				]
			],

			'categories'      => [
				'label'              => esc_html__('Categorys', 'hs2-shortcodes'),
				'type'               => 'wil_select2_ajax',
				'multiple'           => true,
				'minimumInputLength' => 0,
				'placeholder'        => 'Search ... ',
				'endpoint'           => rest_url('wp/v2/categories'),
				'api_args'           => [
					'per_page' => 20,
				],
				'condition'          => [
					'get_post_by' => 'categories'
				]
			],
			'specified_posts' => [
				'label'              => esc_html__('Specified Posts', 'hs2-shortcodes'),
				'type'               => 'wil_select2_ajax',
				'multiple'           => true,
				'minimumInputLength' => 0,
				'placeholder'        => 'Search ... ',
				'endpoint'           => rest_url('wp/v2/posts'),
				'api_args'           => [
					'per_page' => 20,
				],
				'condition'          => [
					'get_post_by' => 'specified_posts'
				]
			],
			// ===
			'show_next_prev' =>  [
				'label' => esc_html__('Pagination', 'hs2-shortcodes'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description'   => esc_html__('Disable/enable header pagination button', 'hsblog2-shortcodes'),
				'label_on' => esc_html__('Show', 'hsblog2-shortcodes'),
				'label_off' => esc_html__('Hide', 'hsblog2-shortcodes'),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition'     => [
					'get_post_by' => 'categories'
				]
			],
			'order' => array_merge(
				App::get('ElementorCommonRegistration')::getElOrderControl(),
				[
					'condition' => [
						'get_post_by' => 'categories'
					]
				]
			)
		]
	]
];
