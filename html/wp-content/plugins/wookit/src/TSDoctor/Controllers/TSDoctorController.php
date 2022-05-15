<?php


namespace DoAn\TSDoctor\Controllers;


use Exception;
use DoAn\Shared\AutoPrefix;
use DoAn\TSDoctor\Model\TSDoctorModel;


class TSDoctorController
{
    protected array $aConvertKeyFormToPostMeta = [];

    public function __construct()
    {
        $prefix = 'doctor_';
        // add_action('rest_api_init', [$this, 'registerRouters']);
        $this->aConvertKeyFormToPostMeta = [
            'upload-1'  => AutoPrefix::namePrefix($prefix . 'RegistrationForm'),
            'upload-2'  => AutoPrefix::namePrefix($prefix . 'lylichkhoahoc'),
            'upload-3'  => AutoPrefix::namePrefix($prefix . 'phieuDangKyDuTuyenTienSi'),
            'upload-4'  => AutoPrefix::namePrefix($prefix . 'cacLoaiGiayKhac'),
            'upload-5'  => AutoPrefix::namePrefix($prefix . 'chungTrinhNgoaiNgu'),
            'upload-6'  => AutoPrefix::namePrefix($prefix . 'soYeuLyLich6Thang'),
            'upload-7'  => AutoPrefix::namePrefix($prefix . 'giayKhamSucKhoe'),
            'upload-8'  => AutoPrefix::namePrefix($prefix . 'thuGioiThieuCua1NhaKhoaHoc'),
            'upload-9'  => AutoPrefix::namePrefix($prefix . 'CongVanCuDiDuTuyenTrucTiep'),
            'upload-10' => AutoPrefix::namePrefix($prefix . 'duThaoVeDeCuongNghienCuu'),
            'upload-11' => AutoPrefix::namePrefix($prefix . 'congTrinhNghienCuuKhoaHocDaCongBo')
        ];
        $this->fileDir = MYSHOOKITPSS_URL_1 . '../../uploads/2022/' . date("m/");
        add_action('wp_ajax_forminator_submit_form_custom-forms', [$this, 'handleDataTSDoctor']);
        add_action('wp_ajax_nopriv_forminator_submit_form_custom-forms', [$this, 'handleDataTSDoctor']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueScriptsToDashboard']);
    }

    public function registerRouters()
    {
        register_rest_route(MYSHOOKITPSS_REST_BASE, 'slideins',
            [
                [
                    'methods'             => 'POST',
                    'callback'            => [$this, 'createSlideins'],
                    'permission_callback' => '__return_true'
                ]
            ]
        );

        register_rest_route(MYSHOOKITPSS_REST_BASE, 'delete-slideins',
            [
                [
                    'methods'             => 'POST',
                    'callback'            => [$this, 'deleteSlideins'],
                    'permission_callback' => '__return_true'
                ],
            ]
        );
    }

    public function enqueueScriptsToDashboard($hook)
    {
        wp_enqueue_script(
            AutoPrefix::namePrefix('doan-script'),
            plugin_dir_url(__FILE__) . '../Assets/Js/Script.js',
            ['jquery'],
            MYSHOOKITPSS_VERSION_1,
            true
        );
    }

    /**
     * @throws Exception
     */
    public function handleDataTSDoctor()
    {
        $aData = $_POST;
        if ($aData['hidden-1'] == 'submitFormRegisterDoctor') {
            $dataFile = str_replace('\\', '', $aData['forminator-multifile-hidden']);
            $aData['DataFiles'] = json_decode($dataFile, true);
            unset($aData['forminator-multifile-hidden']);

            $userID = $aData['hidden-2'];
            $oUserInfo = get_userdata($userID);
            if (!$oUserInfo) {
                throw new Exception("user not exist");
            }
            $postID = wp_insert_post([
                'post_title'  => $oUserInfo->display_name . '-' . $oUserInfo->user_email,
                'post_type'   => AutoPrefix::namePrefix('smartbar'),
                'post_status' => 'publish',
                'post_author' => $oUserInfo->ID,
            ]);
            if (is_wp_error($postID)) {
                throw new Exception($postID->get_error_message(), $postID->get_error_code());
            }
            foreach ($aData['DataFiles'] as $key => $aItem) {
                if (!empty($aItem)) {
                    foreach ($aItem as $aValue) {
                        $aPostMeta[$postID] = $this->fileDir . $aValue['file_name'];
                    }
                    update_post_meta($postID, $this->aConvertKeyFormToPostMeta[$key], $aPostMeta);
                }
            }
            TSDoctorModel::insert([
                'postID' => $postID,
                'userID' => $userID,
                'info'   => json_encode($aData['DataFiles'])
            ]);
        }
    }

}
