<?php


namespace MyShopKitPopupSmartBarSlideIn\Popup\Services\PostMeta;


trait TraitDefinePostMetaFields {
	protected array $aFields = [];

	public function defineFields(): array {
		$this->aFields = [
			'config' => [
				'key'              => 'config',
				'assert'           => [
					'callbackFunc' => 'isArray'
				]
			]
		];

		return $this->aFields;
	}
}
