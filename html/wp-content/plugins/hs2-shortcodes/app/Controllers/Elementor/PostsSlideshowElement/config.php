<?php

use HSSC\Helpers\App;

return [
	'general_settings' => [
		'options'  => [
			'label' => esc_html__('General Settings', 'hsblog2-shortcodes'),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		],
		'controls' => [
			'section_title' => [
				'label'         => esc_html__('Section Title', 'hsblog2-shortcodes'),
				'type'          => \Elementor\Controls_Manager::TEXT,
				'input_type'    => 'text',
				'placeholder'   => esc_html__('Type your title here', 'hsblog2-shortcodes'),
			],
			'title_url'     => [
				'label'         => esc_html__('Title Url', 'hsblog2-shortcodes'),
				'type'          => \Elementor\Controls_Manager::TEXT,
				'input_type'    => 'url',
				'placeholder'   => esc_html('https://your-link.com'),
			],
		]
	],
	'content_section'  => [
		'options'  => [
			'label' => esc_html__('Filter Setting', 'hsblog2-shortcodes'),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		],
		'controls' => [
			'get_post_by'   	=> App::get('ElementorCommonRegistration')::getElGetPostByControl(),
			'specified_posts' 	=> [
				'label'              => esc_html__('Specified Posts', 'hsblog2-shortcodes'),
				'type'               => 'wil_select2_ajax',
				'multiple'           => true,
				'minimumInputLength' => 1,
				'placeholder'        => esc_attr__('Search posts', 'hsblog2-shortcodes'),
				'endpoint'           => rest_url('wp/v2/posts'),
				'api_args'           => [
					'per_page' => 20,
				],
				'condition'          => [
					'get_post_by' => 'specified_posts'
				]
			],
			'categories'      => [
				'label'              => esc_html__('Categories', 'hsblog2-shortcodes'),
				'type'               => 'wil_select2_ajax',
				'multiple'           => true,
				'minimumInputLength' => 1,
				'placeholder'        => esc_attr__('Search categories', 'hsblog2-shortcodes'),
				'endpoint'           => rest_url('wp/v2/categories'),
				'api_args'           => [
					'per_page' => 20,
				],
				'condition'          => [
					'get_post_by' => 'categories'
				]
			],
			'posts_number' =>
			[
				'label' => esc_html__('Posts Number', 'hsblog2-shortcodes'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 3,
				'condition' => [
					'get_post_by' => 'categories'
				]
			],
			'orderby'       => array_merge(
				App::get('ElementorCommonRegistration')::getElOrderByControl(),
				['condition' => [
					'get_post_by' => 'categories'
				]]
			),
			'order'         => array_merge(
				App::get('ElementorCommonRegistration')::getElOrderControl(),
				['condition' => [
					'get_post_by' => 'categories'
				]]
			),
		]
	]
];
