<?php


namespace DoAn\TSMasters\Controllers;


use Exception;
use DoAn\Shared\AutoPrefix;
use DoAn\TSMasters\Model\TSMasterModel;

class TSMastersController
{
    public array  $aConvertKeyFormToPostMeta = [];
    public string $fileDir                   = '';

    public function __construct()
    {
        //add_action('rest_api_init', [$this, 'registerRouters']);
        $this->aConvertKeyFormToPostMeta = [
            'upload-1' => AutoPrefix::namePrefix('registrationForm'),
            'upload-2' => AutoPrefix::namePrefix('syll'),
            'upload-3' => AutoPrefix::namePrefix('cacLoaiGiayKhac'),
            'upload-4' => AutoPrefix::namePrefix('giayChungNhanHocVien'),
            'upload-5' => AutoPrefix::namePrefix('congVanCuDiDuThi'),
            'upload-6' => AutoPrefix::namePrefix('giayKhamSucKhoe'),
            'upload-7' => AutoPrefix::namePrefix('totNghiepNuocNgoai'),
        ];
        $this->fileDir = MYSHOOKITPSS_URL_1 . '../../uploads/2022/' . date("m/");
        add_action('wp_ajax_forminator_submit_form_custom-forms', [$this, 'handleDataTSMaster']);
        add_action('wp_ajax_nopriv_forminator_submit_form_custom-forms', [$this, 'handleDataTSMaster']);
    }

    public function registerRouters()
    {
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

    /**
     * @throws Exception
     */
    public function handleDataTSMaster()
    {
        $aData = $_POST;
        if ($aData['hidden-1'] == 'submitFormRegisterMaster') {
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
                'post_type'   => AutoPrefix::namePrefix('popup'),
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
            TSMasterModel::insert([
                'postID' => $postID,
                'userID' => $userID,
                'info'   => json_encode($aData['DataFiles'])
            ]);
        }
    }

}
