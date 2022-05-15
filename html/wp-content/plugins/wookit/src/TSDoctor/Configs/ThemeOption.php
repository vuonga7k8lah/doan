<?php

return [
    [
        'title'            => esc_html__('Xét thông tin tuyển sinh', 'hsblog2-shortcodes'),
        'id'               => 'thong_tin_tuyen_sinh',
        'subsection'       => false,
        'icon'             => 'dashicons dashicons-id',
        'customizer_width' => '500px',
        'fields'           => []
    ],
    [
        'title'            => esc_html__('Xét thông tin tuyển sinh tiến sĩ', 'hsblog2-shortcodes'),
        'id'               => 'tuyen_sinh_tien_si',
        'subsection'       => true,
        'icon'             => 'dashicons dashicons-id',
        'customizer_width' => '500px',
        'fields'           => [
            [
                'id'      => 'chi_tieu_tien_si',
                'type'    => 'text',
                'title'   => esc_html__('Chi tiêu tuyển sinh tiến sĩ:', 'hsblog2-shortcodes'),
                'default' => '20',
            ],
            [
                'id'       => 'ngay_het_han_tien_si',
                'type'     => 'date',
                'readonly' => false,
                'title'    => esc_html__('Ngày hết hết hạn tuyển sinh:', 'hsblog2-shortcodes'),
                'default'  => date('d-m-y'),
            ]
        ]
    ],
    [
        'title'            => esc_html__('Xét thông tin tuyển sinh thạc sĩ', 'hsblog2-shortcodes'),
        'id'               => 'tuyen_sinh_thac_si',
        'subsection'       => true,
        'icon'             => 'dashicons dashicons-id',
        'customizer_width' => '500px',
        'fields'           => [
            [
                'id'      => 'chi_tieu_thac_si',
                'type'    => 'text',
                'title'   => esc_html__('Chi tiêu tuyển sinh tiến sĩ:', 'hsblog2-shortcodes'),
                'default' => '20',
            ],
            [
                'id'       => 'ngay_het_han_thac_si',
                'type'     => 'date',
                'readonly' => false,
                'title'    => esc_html__('Ngày hết hết hạn tuyển sinh:', 'hsblog2-shortcodes'),
                'default'  => date('d/m/y'),
            ]
        ]
    ]
];
