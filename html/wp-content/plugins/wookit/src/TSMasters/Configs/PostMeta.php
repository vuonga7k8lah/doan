<?php
use DoAn\Shared\AutoPrefix;
return [
    'TSMasters_general_settings_section' => [
        'id'           => 'TSMasters_general_settings_section',
        'title'        => esc_html__('Hồ sơ đăng ký dự tuyển gồm:', 'do an'),
        'object_types' => [AutoPrefix::namePrefix('TSMasters')],
        'fields'       => [
            'registrationForm'         => [
                'name'       => esc_html__('1.Đơn đăng ký dự tuyển 1', 'do an'),
                'id'         => 'registrationForm',
                'type' => 'file',
                'value' => MYSHOOKITPSS_URL.'../../uploads/2022/04/21.doc',
                'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'text' => array(
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text' => 'Replacement', // default: "Remove Image"
                    'file_text' => 'Replacement', // default: "File:"
                    'file_download_text' => 'Replacement', // default: "Download"
                    'remove_text' => 'Replacement', // default: "Remove"
                )
            ],
            'syll' => [
                'name'             => esc_html__('2.Sơ yếu lý lịch(có xác nhận của cơ quan quản lý)', 'do an'),
                'disc'=>'',
                'id'         => 'syll',
                'type' => 'file_list',
                'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'desc'    => '',
                'text' => array(
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text' => 'Replacement', // default: "Remove Image"
                    'file_text' => 'Replacement', // default: "File:"
                    'file_download_text' => 'Replacement', // default: "Download"
                    'remove_text' => 'Replacement', // default: "Remove"
                )
            ],
            'cacLoaiGiayKhac'     => [
                'name'       => esc_html__('3.Bản sao công chứng các loại giấy tờ liên quan', 'do an'),
                'id'         => 'cacLoaiGiayKhac',
                'disc'=>'1. Bằng và bảng điểm tốt nghiệp đại học
                         2. Các loại giấy tờ xác nhận ưu tiên nếu có
                ',
                'type' => 'file_list',
                'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'desc'    => '',
                'text' => array(
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text' => 'Replacement', // default: "Remove Image"
                    'file_text' => 'Replacement', // default: "File:"
                    'file_download_text' => 'Replacement', // default: "Download"
                    'remove_text' => 'Replacement', // default: "Remove"
                )
            ],
            'giayChungNhanHocVien'     => [
                'name'       => esc_html__('4.Giấy chứng nhận', 'do an'),
                'id'         => 'giayChungNhanHocVien',
                'disc'=>'Giấy chứng nhận hoàn thành chương trình bổ sung kiến thức của Học viện Kỹ thuật mật mã trong hạn không quá 1 năng từ ngày cấp',
                'type' => 'file_list',
                'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'desc'    => '',
                'text' => array(
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text' => 'Replacement', // default: "Remove Image"
                    'file_text' => 'Replacement', // default: "File:"
                    'file_download_text' => 'Replacement', // default: "Download"
                    'remove_text' => 'Replacement', // default: "Remove"
                )
            ],
            'congVanCuDiDuThi' => [
                'name'             => esc_html__('5.Công văn gửi đi dự thi của thủ trưởng cơ quan quản lý', 'do an'),
                'disc'=>'',
                'id'         => 'congVanCuDiDuThi',
                'type' => 'file_list',
                'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'desc'    => '',
                'text' => array(
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text' => 'Replacement', // default: "Remove Image"
                    'file_text' => 'Replacement', // default: "File:"
                    'file_download_text' => 'Replacement', // default: "Download"
                    'remove_text' => 'Replacement', // default: "Remove"
                )
            ],
            'giayKhamSucKhoe' => [
                'name'             => esc_html__('6.Giấy chứng nhận đủ sức khoẻ để học tập của bệnh viện đa khoa có thời hạn trong 6 tháng',
                    'do an'),
                'disc'=>'',
                'id'         => 'congVanCuDiDuThi',
                'type' => 'file_list',
                'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'desc'    => '',
                'text' => array(
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text' => 'Replacement', // default: "Remove Image"
                    'file_text' => 'Replacement', // default: "File:"
                    'file_download_text' => 'Replacement', // default: "Download"
                    'remove_text' => 'Replacement', // default: "Remove"
                )
            ],
            'totNghiepNuocNgoai' => [
                'name'             => esc_html__('7.Thí sinh tốt nghiệp nước ngoài ',
                    'do an'),
                'disc'=>'',
                'id'         => 'totNghiepNuocNgoai',
                'type' => 'file_list',
                'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
                // 'query_args' => array( 'type' => 'image' ), // Only images attachment
                // Optional, override default text strings
                'desc'    => '',
                'text' => array(
                    'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
                    'remove_image_text' => 'Replacement', // default: "Remove Image"
                    'file_text' => 'Replacement', // default: "File:"
                    'file_download_text' => 'Replacement', // default: "Download"
                    'remove_text' => 'Replacement', // default: "Remove"
                )
            ],
        ]
    ]
];
