<?php


namespace DoAn\Popup\Controllers;


use DoAn\Shared\AutoPrefix;


class PopupRegistration {
	private string $scheduleKey = 're_update_config';

	public function __construct() {
		add_action( 'cmb2_admin_init', [ $this, 'registerBox' ] );
		add_action( 'init', [ $this, 'registerPopup' ] );
	}

	public function registerBox() {
		$aConfig = include MYSHOOKITPSS_PATH_1 . 'src/Popup/Configs/PostMeta.php';

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

	public function registerPopup() {
		register_post_type( AutoPrefix::namePrefix( 'popup' ),
			include MYSHOOKITPSS_PATH_1 . 'src/Popup/Configs/PostType.php' );
        //add_post_type_support(  AutoPrefix::namePrefix( 'popup' ), 'author' );
	}
}
