<?php

use HSSC\Helpers\App;

return [
	'general_settings' => [
		'options'  => [
			'label' => esc_html__('General Settings', 'hsblog2-shortcodes'),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		],
		'controls' => [
			'items_per_row'       => App::get('ElementorCommonRegistration')::getElItemsPerRowControl(),
			'max_row'             => App::get('ElementorCommonRegistration')::getElMaxRowsControl(),
			'gap'                 => App::get('ElementorCommonRegistration')::getElGapControl(),
			'section_title'       => [
				'label'       => esc_html__('Section Title', 'hsblog2-shortcodes'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'default'     => esc_html__('Top Authors', 'hsblog2-shortcodes'),
				'placeholder' => esc_html__('Name Section', 'hsblog2-shortcodes'),
			],
			'section_description' => [
				'label'       => esc_html__('Section Description', 'hsblog2-shortcodes'),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 10,
				'default'     => esc_html__('', 'hsblog2-shortcodes'),
				'placeholder' => esc_html__('Description your title here', 'hsblog2-shortcodes'),
			],
			'button1_name'        => [
				'label'       => esc_html__('Name Button 1', 'hsblog2-shortcodes'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__('See all authors', 'hsblog2-shortcodes'),
				'label_block' => true,
			],
			'button1_url'        => [
				'label'       => esc_html__('Url Button 1', 'hsblog2-shortcodes'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '#',
				'label_block' => true,
			],
			'button2_name'        => [
				'label'       => esc_html__('Name Button 2', 'hsblog2-shortcodes'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__('See all authors', 'hsblog2-shortcodes'),
				'label_block' => true,
			],
			'button2_url'        => [
				'label'       => esc_html__('Url Button 2', 'hsblog2-shortcodes'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '#',
				'label_block' => true,
			],
		],
	],
	'content_section'  => [
		'options'  => [
			'label' => esc_html__('Filter Setting', 'hsblog2-shortcodes'),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		],
		'controls' => [
			'role'             => [
				'label'    => esc_html__('Roles', 'hsblog2-shortcodes'),
				'type'     => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options'  => [
					'Administrator' => esc_html__('Administrator', 'hsblog2-shortcodes'),
					'Editor'        => esc_html__('Editor', 'hsblog2-shortcodes'),
					'Author'        => esc_html__('Author', 'hsblog2-shortcodes'),
					'Contributor'   => esc_html__('Contributor', 'hsblog2-shortcodes'),
					'Subscriber'    => esc_html__('Subscriber', 'hsblog2-shortcodes'),
				],
				'default'  => 'Administrator'
			],
			'orderby'          => [
				'label'   => esc_html__('Order By', 'hsblog2-shortcodes'),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'ID'              => esc_html__('ID', 'hsblog2-shortcodes'),
					'display_name'    => esc_html__('User Name', 'hsblog2-shortcodes'),
					'name'            => esc_html__('User Name', 'hsblog2-shortcodes'),
					'user_registered' => esc_html__('Registered By Date', 'hsblog2-shortcodes'),
					'post_count'      => esc_html__('User Post Count', 'hsblog2-shortcodes'),
				],
				'default' => 'user_registered'
			],
			'order'            => [
				'label'   => esc_html__('Order', 'hsblog2-shortcodes'),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'ASC'  => esc_html__('ASC', 'hsblog2-shortcodes'),
					'DESC' => esc_html__('DESC', 'hsblog2-shortcodes')
				],
				'default' => 'DESC'
			],
		]
	]
];
