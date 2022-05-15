<?php


use DoAn\Shared\AutoPrefix;

$prefix = 'doctor_';
return [
    'smartbar_general_settings_section' => [
        'id'           => 'smartbar_general_settings_section',
        'title'        => esc_html__('Hồ sơ đăng ký dự tuyển Tiến sĩ gồm:', 'myshopkit-popup-smartbar-slidein'),
        'object_types' => [AutoPrefix::namePrefix('smartbar')],
        'fields'       => [
            'registrationForm'     => [
                'name'         => esc_html__('1.Đơn đăng ký dự tuyển ', 'do an'),
                'id'           => $prefix . 'RegistrationForm',
                'type'         => 'file_list',
                'preview_size' => [100, 100], // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'text'         => [
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text'     => 'Remove Image', // default: "Remove Image"
                    'file_text'             => 'File', // default: "File:"
                    'file_download_text'    => 'Xem Chi Tiết', // default: "Download"
                    'remove_text'           => 'Xoá', // default: "Remove"
                ]
            ],
            'lylichkhoahoc'                 => [
                'name'         => esc_html__('2.Lý lịch khoa học', 'do an'),
                'id'           => $prefix.'lylichkhoahoc',
                'type'         => 'file_list',
                'preview_size' => [100, 100], // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'text'         => [
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text'     => 'Remove Image', // default: "Remove Image"
                    'file_text'             => 'File', // default: "File:"
                    'file_download_text'    => 'Xem Chi Tiết', // default: "Download"
                    'remove_text'           => 'Xoá', // default: "Remove"
                ]
            ],
            'phieuDangKyDuTuyenTienSi'      => [
                'name'         => esc_html__('3.Phiếu đăng ký dự tuyển trình độ tiến sỹ', 'do an'),
                'id'           => $prefix.'phieuDangKyDuTuyenTienSi',
                'type'         => 'file_list',
                'preview_size' => [100, 100], // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'text'         => [
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text'     => 'Remove Image', // default: "Remove Image"
                    'file_text'             => 'File', // default: "File:"
                    'file_download_text'    => 'Xem Chi Tiết', // default: "Download"
                    'remove_text'           => 'Xoá', // default: "Remove"
                ]
            ],
            'cacLoaiGiayKhac'      => [
                'name'         => esc_html__('4.Bằng và bảng điểm tốt nghiệp đại học bản sao có công chứng và bằng tốt nghiệp và bảng điểm thạc sĩ(theo đối tượng)', 'do an'),
                'id'           => $prefix.'cacLoaiGiayKhac',
                'type'         => 'file_list',
                'preview_size' => [100, 100], // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'text'         => [
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text'     => 'Remove Image', // default: "Remove Image"
                    'file_text'             => 'File', // default: "File:"
                    'file_download_text'    => 'Xem Chi Tiết', // default: "Download"
                    'remove_text'           => 'Xoá', // default: "Remove"
                ]
            ],
            'chungTrinhNgoaiNgu' => [
                'name'         => esc_html__('5.Bản sao có công chứng văn bằng, chứng chỉ ngoại ngữ còn thời hạn theo quy định',
                    'do an'),
                'id'           => $prefix.'chungTrinhNgoaiNgu',
                'disc'         => 'Giấy chứng nhận hoàn thành chương trình bổ sung kiến thức của Học viện Kỹ thuật mật mã trong hạn không quá 1 năng từ ngày cấp',
                'type'         => 'file_list',
                'preview_size' => [100, 100], // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'text'         => [
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text'     => 'Remove Image', // default: "Remove Image"
                    'file_text'             => 'File', // default: "File:"
                    'file_download_text'    => 'Xem Chi Tiết', // default: "Download"
                    'remove_text'           => 'Xoá', // default: "Remove"
                ]
            ],
            'soYeuLyLich6Thang'     => [
                'name'         => esc_html__('6.Sơ yếu lý lịch trong thời gian 06 tháng tính từ đến nộp hồ sơ đăng ký dự tuyển', 'do an'),
                'id'           => $prefix.'soYeuLyLich6Thang',
                'type'         => 'file_list',
                'desc'         => 'Sơ yếu lý lịch trong thời gian 06 tháng tính từ đến nộp hồ sơ đăng ký dự tuyển, có xác nhận của thủ trưởng cơ quan quản lý',
                'preview_size' => [100, 100], // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'text'         => [
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text'     => 'Remove Image', // default: "Remove Image"
                    'file_text'             => 'File', // default: "File:"
                    'file_download_text'    => 'Xem Chi Tiết', // default: "Download"
                    'remove_text'           => 'Xoá', // default: "Remove"
                ]
            ],
            'giayKhamSucKhoe'      => [
                'name'         => esc_html__('7.Giấy chứng nhận đủ sức khoẻ để học tập của bệnh viện đa khoa có thời hạn trong 6 tháng',
                    'do an'),
                'id'           => $prefix.'giayKhamSucKhoe',
                'type'         => 'file_list',
                'preview_size' => [100, 100], // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'text'         => [
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text'     => 'Remove Image', // default: "Remove Image"
                    'file_text'             => 'File', // default: "File:"
                    'file_download_text'    => 'Xem Chi Tiết', // default: "Download"
                    'remove_text'           => 'Xoá', // default: "Remove"
                ]
            ],
            'thuGioiThieuCua1NhaKhoaHoc'   => [
                'name'         => esc_html__('8.Thư giới thiệu của ít nhất 01 nhà khoa học',
                    'do an'),
                'id'           => $prefix.'thuGioiThieuCua1NhaKhoaHoc',
                'type'         => 'file_list',
                'preview_size' => [100, 100], // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'text'         => [
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text'     => 'Remove Image', // default: "Remove Image"
                    'file_text'             => 'File', // default: "File:"
                    'file_download_text'    => 'Xem Chi Tiết', // default: "Download"
                    'remove_text'           => 'Xoá', // default: "Remove"
                ]
            ],
            'CongVanCuDiDuTuyenTrucTiep'   => [
                'name'         => esc_html__('9.Công văn cử đi dự tuyển của cơ quan quản lý trực tiếp theo quy định hiện hành về việc đào tạo và bồ dưỡng công chức,viên chức(nếu người dự tuyển là công chức viên chức)',
                    'do an'),
                'id'           => $prefix.'CongVanCuDiDuTuyenTrucTiep',
                'type'         => 'file_list',
                'preview_size' => [100, 100], // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'text'         => [
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text'     => 'Remove Image', // default: "Remove Image"
                    'file_text'             => 'File', // default: "File:"
                    'file_download_text'    => 'Xem Chi Tiết', // default: "Download"
                    'remove_text'           => 'Xoá', // default: "Remove"
                ]
            ],
            'duThaoVeDeCuongNghienCuu'   => [
                'name'         => esc_html__('10.Dự thảo nghiên cứu và dự kiến kế hoạch học tập, nghiên cứu toàn khoá',
                    'do an'),
                'id'           => $prefix.'duThaoVeDeCuongNghienCuu',
                'type'         => 'file_list',
                'preview_size' => [100, 100], // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'text'         => [
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text'     => 'Remove Image', // default: "Remove Image"
                    'file_text'             => 'File', // default: "File:"
                    'file_download_text'    => 'Xem Chi Tiết', // default: "Download"
                    'remove_text'           => 'Xoá', // default: "Remove"
                ]
            ],
            'congTrinhNghienCuuKhoaHocDaCongBo'   => [
                'name'         => esc_html__('11.Danh mục và bản sao công trình nghiên cứu khoa học công bố',
                    'do an'),
                'id'           => $prefix.'congTrinhNghienCuuKhoaHocDaCongBo',
                'type'         => 'file_list',
                'preview_size' => [100, 100], // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'text'         => [
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text'     => 'Remove Image', // default: "Remove Image"
                    'file_text'             => 'File', // default: "File:"
                    'file_download_text'    => 'Xem Chi Tiết', // default: "Download"
                    'remove_text'           => 'Xoá', // default: "Remove"
                ]
            ]
        ]
    ]
];
