<?php

use HSSC\Helpers\App;

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
				'default'       => esc_html__('Default title', 'hs2-shortcodes'),
				'placeholder'   => esc_html__('Type your title here', 'hs2-shortcodes'),
			],
			'title_url'     => [
				'label'         => esc_html__('Title Url', 'hs2-shortcodes'),
				'type'          => \Elementor\Controls_Manager::TEXT,
				'input_type'    => 'url',
				'placeholder'   => esc_html('https://your-link.com'),
			],
			'gap'           => App::get('ElementorCommonRegistration')::getElGapControl(),
			'featured_image_size' => [
				'label'     => esc_html__('Featured Image Size', 'hs2-shortcodes'),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'medium',
				'options'   => [
					'thumbnail'     => esc_html__('Thumbnail', 'hs2-shortcodes'),
					'medium'        => esc_html__('Medium', 'hs2-shortcodes'),
					'large'         => esc_html__('Large', 'hs2-shortcodes'),
					'full'          => esc_html__('Full', 'hs2-shortcodes'),
				],
			],

		]
	],
	'content_section'  => [
		'options'  => [
			'label' => esc_html__('Filter Setting', 'hs2-shortcodes'),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		],
		'controls' => [
			'get_post_by'     => App::get('ElementorCommonRegistration')::getElGetPostByControl(),
			'categories'      => [
				'label'              => esc_html__('Categorys', 'hs2-shortcodes'),
				'type'               => 'wil_select2_ajax',
				'multiple'           => true,
				'minimumInputLength' => 0,
				'placeholder'        => esc_html__('Search ... ', 'hs2-shortcodes'),
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
				'placeholder'        => esc_html__('Search ... ', 'hs2-shortcodes'),
				'endpoint'           => rest_url('wp/v2/posts'),
				'api_args'           => [
					'per_page' => 20,
				],
				'condition'          => [
					'get_post_by' => 'specified_posts'
				]
			],
			'posts_per_page' => [
				'label' 	=> esc_html__('Number Of Posts', 'hs2-shortcodes'),
				'type' 		=> \Elementor\Controls_Manager::NUMBER,
				'min' 		=> 3,
				'max' 		=> 100,
				'step' 		=> 1,
				'default' 	=> 8,
				'condition'          => [
					'get_post_by' => 'categories'
				]
			],
			'orderby'         => array_merge(
				App::get('ElementorCommonRegistration')::getElOrderByControl(),
				['condition' => [
					'get_post_by' => 'categories'
				]]
			),
			'order'           => array_merge(
				App::get('ElementorCommonRegistration')::getElOrderControl(),
				['condition' => [
					'get_post_by' => 'categories'
				]]
			),


		]
	]
];
