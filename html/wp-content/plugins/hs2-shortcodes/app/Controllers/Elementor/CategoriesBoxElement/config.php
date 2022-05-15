<?php

use HSSC\Helpers\App;
use HSSC\Shared\Elementor\Select2AjaxControl;

$control = [
    'general_settings'   => [
        'options' => [
            'label'     => esc_html__('General Settings', 'hsblog2-shortcodes'),
            'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
        ],
        'controls'  => [
            'section_title' => [
                'label'         => esc_html__('Section Title', 'hsblog2-shortcodes'),
                'type'          => \Elementor\Controls_Manager::TEXT,
                'input_type'    => 'text',
                'default'       => esc_html__('Default title', 'hsblog2-shortcodes'),
                'placeholder'   => esc_html__('Type your title here', 'hsblog2-shortcodes'),
            ],
            'title_url'     => [
                'label'         => esc_html__('Title Url', 'hsblog2-shortcodes'),
                'type'          => \Elementor\Controls_Manager::TEXT,
                'input_type'    => 'url',
                'placeholder'   => esc_html('https://your-link.com'),
            ],
            'items_per_row' => App::get('ElementorCommonRegistration')::getElItemsPerRowControl(),
            'max_rows'      => App::get('ElementorCommonRegistration')::getElMaxRowsControl(),
            'gap'           => App::get('ElementorCommonRegistration')::getElGapControl(),
            'taxonomy_name' =>     [
                'label'     => esc_html__('Taxonomy Type', 'hsblog2-shortcodes'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'category',
                'options'   => [
                    'category'  => esc_html__('Category', 'hsblog2-shortcodes'),
                    'post_tag'  => esc_html__('Post Tag', 'hsblog2-shortcodes'),
                ]
            ],
        ]
    ],
    'filter_settings' => [
        'options' => [
            'label' => esc_html__('Filter Settings', 'hsblog2-shortcodes'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ],
        'controls' => [
            'get_term_by' =>     [
                'label'     => esc_html__('Get Term By', 'hsblog2-shortcodes'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'order',
                'options'   => [
                    'specified_terms'   => esc_html__('Specified Terms', 'hsblog2-shortcodes'),
                    'order'             => esc_html__('Order', 'hsblog2-shortcodes'),
                ],
            ],
            'specified_categories' => [
                'label'         => esc_html__('Specified Categories', 'hsblog2-shortcodes'),
                'placeholder'   => esc_html__('Type specified Categories', 'hsblog2-shortcodes'),
                'type'          => Select2AjaxControl::TYPE,
                'multiple'      => true,
                'condition' => [
                    'get_term_by'   => 'specified_terms',
                    'taxonomy_name' => 'category'
                ],
                'endpoint'  => rest_url('wp/v2/categories')
            ],
            'specified_tags' => [
                'label'         => esc_html__('Specified Tags', 'hsblog2-shortcodes'),
                'placeholder'   => esc_html__('Type specified Tags', 'hsblog2-shortcodes'),
                'type'          => Select2AjaxControl::TYPE,
                'multiple'      => true,
                'condition' => [
                    'get_term_by'   => 'specified_terms',
                    'taxonomy_name' => 'post_tag'
                ],
                'endpoint'  => rest_url('wp/v2/tags')
            ],
            'orderby'       => [
                'label'     => esc_html__('Order By', 'hsblog2-shortcodes'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'name',
                'options'   => [
                    'name'          => esc_html__('Name', 'hsblog2-shortcodes'),
                    'id'            => 'ID',
                    'term_order'    => esc_html__('Term Order', 'hsblog2-shortcodes'),
                    'count'         => esc_html__('Count', 'hsblog2-shortcodes'),
                ],
                'condition' => [
                    'get_term_by'   => 'order',
                ]
            ],
            'order'     => array_merge(
                App::get('ElementorCommonRegistration')::getElOrderControl(),
                ['condition' => [
                    'get_term_by'   => 'order',
                ]]
            ),
        ]
    ]
];

return $control;
