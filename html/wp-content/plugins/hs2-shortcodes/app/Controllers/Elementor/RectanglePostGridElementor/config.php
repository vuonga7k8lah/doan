<?php

use HSSC\Helpers\App;

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
                'default'       => esc_html__('Categories', 'hsblog2-shortcodes'),
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
        ]
    ],
    'filter_settings' => [
        'options' => [
            'label' => esc_html__('Filter Settings', 'hsblog2-shortcodes'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ],
        'controls' => [
            'get_post_by'   => App::get('ElementorCommonRegistration')::getElGetPostByControl(),
            'specified_posts' => [
                'label'         => esc_html__('Specified Posts', 'hsblog2-shortcodes'),
                'placeholder'   => esc_html__('Type specified posts', 'hsblog2-shortcodes'),
                'type'          => \Elementor\Controls_Manager::SELECT2,
                'multiple'      => true,
                'insertTag'     => function ($data, $tag) {
                    array_push($data, $tag);
                },
                'options'   => App::get('ElementorCommonRegistration')::getPostOptions(),
                'condition' => [
                    'get_post_by' => 'specified_posts'
                ]
            ],
            'categories'      => [
                'label'              => esc_html__('Categories', 'hsblog2-shortcodes'),
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

            'featured_image_size' => [
                'label'     => esc_html__('Featured Image Size', 'hsblog2-shortcodes'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'large',
                'options'   => [
                    'thumbnail'     => esc_html__('Thumbnail', 'hsblog2-shortcodes'),
                    'medium'        => esc_html__('Medium', 'hsblog2-shortcodes'),
                    'large'         => esc_html__('Large', 'hsblog2-shortcodes'),
                    'full'          => esc_html__('Full', 'hsblog2-shortcodes'),
                ],
            ],
        ]
    ]
];

return $control;
