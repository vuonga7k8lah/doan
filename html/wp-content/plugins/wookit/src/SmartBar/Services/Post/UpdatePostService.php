<?php


namespace MyShopKitPopupSmartBarSlideIn\SmartBar\Services\Post;


use Exception;
use MyShopKitPopupSmartBarSlideIn\Illuminate\Message\MessageFactory;
use MyShopKitPopupSmartBarSlideIn\Shared\AutoPrefix;
use MyShopKitPopupSmartBarSlideIn\Shared\Post\IDeleteUpdateService;
use MyShopKitPopupSmartBarSlideIn\Shared\Post\IService;
use MyShopKitPopupSmartBarSlideIn\Shared\Post\TraitIsPostAuthor;
use MyShopKitPopupSmartBarSlideIn\Shared\Post\TraitIsPostType;
use MyShopKitPopupSmartBarSlideIn\Shared\Post\TraitMaybeAssertion;
use MyShopKitPopupSmartBarSlideIn\Shared\Post\TraitMaybeSanitizeCallback;

class UpdatePostService extends PostService implements IService, IDeleteUpdateService {
	use TraitDefinePostFields;
	use TraitMaybeAssertion;
	use TraitMaybeSanitizeCallback;
	use TraitIsPostAuthor;
	use TraitIsPostType;

	private $postID;

	public function setID( $id ): self {
		$this->postID = $id;

		return $this;
	}

	/**
	 * @throws Exception
	 */
	public function validateFields(): IService {
		if ( empty( $this->postID ) ) {
			throw new \Exception( esc_html__( 'The ID is required.', 'myshopkit-popup-smartbar-slidein' ) );
		}

		$this->isPostAuthor( $this->postID );
		$this->isPostType( $this->postID, AutoPrefix::namePrefix( 'smartbar' ) );

		foreach ( $this->defineFields() as $friendlyKey => $aField ) {
			if ( isset( $aField['isReadOnly'] ) || ! isset( $this->aRawData[ $friendlyKey ] ) ||
			     ! isset( $this->aRawData[ $friendlyKey ] ) ) {
				continue;
			} else {
				$value = $this->aRawData[ $friendlyKey ];
				$aAssertionResponse = $this->maybeAssert( $aField, $value );
				if ( $aAssertionResponse['status'] === 'error' ) {
					throw new \Exception( $aAssertionResponse['message'] );
				}

				$this->aData[ $aField['key'] ] = $this->maybeSanitizeCallback( $aField, $value );
			}
		}

		$this->aData['ID'] = $this->postID;

		return $this;
	}

	public function performSaveData(): array {
		try {
			$this->validateFields();
			$id = wp_update_post( $this->aData );
			if ( is_wp_error( $id ) ) {
				return MessageFactory::factory()->error( $id->get_error_message(), $id->get_error_code() );
			}

			return MessageFactory::factory()->success(
				esc_html__( 'Congrats! The popup has been updated successfully.', 'myshopkit-popup-smartbar-slidein' ),
				[
					'id' => $id
				]
			);
		}
		catch ( \Exception $oException ) {
			return MessageFactory::factory()->error( $oException->getMessage(), $oException->getCode() );
		}
	}

	/**
	 * @param array $aRawData
	 *
	 * @return IService
	 */
	public function setRawData( array $aRawData ): IService {
		$this->aRawData = $aRawData;

		return $this;
	}
}
