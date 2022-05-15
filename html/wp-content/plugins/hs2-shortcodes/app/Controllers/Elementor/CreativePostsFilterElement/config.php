<?php

use HSSC\Helpers\App;

$control = [
    'general_settings'   => [
        'options'   => [
            'label'     => esc_html__('General Settings', 'hs2-shortcodes'),
            'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
        ],
        'controls'  => [
            'section_title' => [
                'label'         => esc_html__('Section Title', 'hs2-shortcodes'),
                'description'   => esc_html__('Leave empty if you want hidden title', 'hs2-shortcodes'),
                'type'          => \Elementor\Controls_Manager::TEXT,
                'input_type'    => 'text',
                'default'       => '',
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
            'gap'           => App::get('ElementorCommonRegistration')::getElGapControl(),
            'posts_per_page'  => [
                'label'   => esc_html__('Number Posts', 'hs2-shortcodes'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'min'     => 1,
                'max'     => 100,
                'step'    => 1,
                'default' => 6,
            ],
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


            // ===

            'order_by_options' => [
                'label'         => esc_html__('Order By Options', 'hs2-shortcodes'),
                'type'          => \Elementor\Controls_Manager::SELECT2,
                'multiple'      => true,
                'label_block'   => true,
                'options'       =>  App::get('ElementorCommonRegistration')::getOrderByOptions(),
                'description'   => esc_html__('Leave empty if do not show this filter', 'hs2-shortcodes'),
                'default'       =>  array_keys(App::get('ElementorCommonRegistration')::getOrderByOptions()),
                'condition'     => [
                    'get_post_by' => 'categories'
                ]
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
                'label'              => esc_html__('Categories', 'hs2-shortcodes'),
                'type'               => 'wil_select2_ajax',
                'multiple'           => true,
                'label_block'        => true,
                'minimumInputLength' => 1,
                'placeholder'        => esc_html__('Search ... ', 'hs2-shortcodes'),
                'endpoint'           => rest_url('wp/v2/categories'),
                'api_args'           => [
                    'per_page' => 20,
                ],
                'condition'          => [
                    'get_post_by' => 'categories'
                ]
            ],

            // ===
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
            'order'           => array_merge(
                App::get('ElementorCommonRegistration')::getElOrderControl(),
                ['condition' => [
                    'get_post_by' => 'categories'
                ]]
            )
        ]
    ]
];

return $control;
