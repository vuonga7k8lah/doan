<?php


namespace MyShopKitPopupSmartBarSlideIn\Shared\Post;


interface IDeleteUpdateService {
	public function setID( $id ): self;

	public function isPostAuthor( $id ): bool;
}
