<?php


namespace DoAn\TSMasters\Controllers;


use MyShopKitPopupSmartBarSlideIn\Shared\AutoPrefix;
use MyShopKitPopupSmartBarSlideIn\Shared\Post\TraitPostType;


class TSMastersRegistration
{
    use TraitPostType;

    public function __construct()
    {
        add_action('init', [$this, 'registerPostType']);
        add_action( 'cmb2_admin_init', [ $this, 'registerBox' ] );
    }

    public function registerPostType()
    {
        $aConfig = include plugin_dir_path(__FILE__) . '../Configs/PostType.php';
        register_post_type($aConfig['post_type'], $aConfig);
    }

    public function registerBox()
    {
        $aConfig = include plugin_dir_path(__FILE__) . '../Configs/PostMeta.php';

        foreach ( $aConfig as $aSection ) {
            $aFields = $aSection['fields'];
            unset( $aSection['fields'] );
            $oCmb = new_cmb2_box( $aSection );
            foreach ( $aFields as $aField ) {
                $aField['id'] = AutoPrefix::namePrefix( $aField['id'] );
                $oCmb->add_field( $aField );
            }
        }
    }
}
