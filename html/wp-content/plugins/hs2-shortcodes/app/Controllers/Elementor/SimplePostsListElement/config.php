<?php

use HSSC\Helpers\App;

return [
	'control' => [
		'general_settings' => [
			'options'  => [
				'label' => esc_html__('General Settings', 'hsblog2-shortcodes'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			],
			'controls' => [
				'items_per_row' => App::get('ElementorCommonRegistration')::getElItemsPerRowControl(),
				'max_row'       => App::get('ElementorCommonRegistration')::getElMaxRowsControl(),
				'gap'           => App::get('ElementorCommonRegistration')::getElGapControl()
			]
		],
		'content_section'  => [
			'options'  => [
				'label' => esc_html__('Filter Setting', 'hsblog2-shortcodes'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			],
			'controls' => [
				'get_post_by'     => App::get('ElementorCommonRegistration')::getElGetPostByControl(),
				'categories'      => [
					'label'              => esc_html__('Categorys', 'hsblog2-shortcodes'),
					'type'               => 'wil_select2_ajax',
					'multiple'           => true,
					'minimumInputLength' => 0,
					'placeholder'        => esc_html__('Search ... ', 'hsblog2-shortcodes'),
					'endpoint'           => rest_url('wp/v2/categories'),
					'api_args'           => [
						'per_page' => 20,
					],
					'condition'          => [
						'get_post_by' => 'categories'
					]
				],
				'specified_posts' => [
					'label'              => esc_html__('Specified Posts', 'hsblog2-shortcodes'),
					'type'               => 'wil_select2_ajax',
					'multiple'           => true,
					'minimumInputLength' => 0,
					'placeholder'        => esc_html__('Search ... ', 'hsblog2-shortcodes'),
					'endpoint'           => rest_url('wp/v2/posts'),
					'api_args'           => [
						'per_page' => 20,
					],
					'condition'          => [
						'get_post_by' => 'specified_posts'
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
				)
			]
		]
	]
];
