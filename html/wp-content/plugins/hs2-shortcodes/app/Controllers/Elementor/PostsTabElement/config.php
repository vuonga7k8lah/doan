<?php

use HSSC\Shared\Elementor\Select2AjaxControl;
use HSSC\Helpers\App;

$control = [
    'general_settings'   => [
        'options'   => [
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
        ]
    ],
    'tabs_settings'   => [
        'options'       => [
            'label' => esc_html__('Tabs Settings', 'hsblog2-shortcodes'),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ],
        // add this setting if this contains Repeater controls
        'repeaterControls'  => [
            'tab_title'     =>  [
                'label'     => esc_html__('Title', 'hsblog2-shortcodes'),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => esc_html__('Tab #n', 'hsblog2-shortcodes'),
            ],
            'get_post_by'   => App::get('ElementorCommonRegistration')::getElGetPostByControl(),
            'specified_posts'   => [
                'label'         => esc_html__('Specified Posts', 'hsblog2-shortcodes'),
                'placeholder'   => esc_html__('Type specified posts', 'hsblog2-shortcodes'),
                'multiple'      => true,
                'condition'     => [
                    'get_post_by'   => 'specified_posts'
                ],
                'type'          => Select2AjaxControl::TYPE,
                'endpoint'      => rest_url('wp/v2/posts'),
                'minimumInputLength' => 1,
            ],
            'categories'    => [
                'label'         => esc_html__('Slect Categories', 'hsblog2-shortcodes'),
                'placeholder'   => esc_html__('Type categories', 'hsblog2-shortcodes'),
                'multiple'      => true,
                'condition'     => [
                    'get_post_by' => 'categories'
                ],
                'type'          => Select2AjaxControl::TYPE,
                'endpoint'      => rest_url('wp/v2/categories'),
                'minimumInputLength' => 1,
            ],
            'orderby'   => array_merge(
                App::get('ElementorCommonRegistration')::getElOrderByControl(),
                [
                    'condition' => [
                        'get_post_by' => 'categories'
                    ]
                ]
            ),
            'order'     => array_merge(
                App::get('ElementorCommonRegistration')::getElOrderControl(),
                [
                    'condition' => [
                        'get_post_by' => 'categories'
                    ]
                ]
            ),
            'featured_image_size' => [
                'label'     => esc_html__('Featured Image Size', 'hsblog2-shortcodes'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'thumbnail',
                'options'   => [
                    'thumbnail'     => esc_html__('Thumbnail', 'hsblog2-shortcodes'),
                    'medium'        => esc_html__('Medium', 'hsblog2-shortcodes'),
                    'large'         => esc_html__('Large', 'hsblog2-shortcodes'),
                    'full'          => esc_html__('Full', 'hsblog2-shortcodes'),
                ],
            ],
        ],
        'controls'      => [
            'tabs' => [
                'label'     => esc_html__('Repeater tabs', 'hsblog2-shortcodes'),
                'type'      => \Elementor\Controls_Manager::REPEATER,
                'default'   => [
                    [
                        'tab_title'         => esc_html__('Tab #1', 'hsblog2-shortcodes'),
                        'get_post_by'       => 'specified_posts',
                        'specified_posts'   => []
                    ]
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        ],
    ]
];

return $control;
