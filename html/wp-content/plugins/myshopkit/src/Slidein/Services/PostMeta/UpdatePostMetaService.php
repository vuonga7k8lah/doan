<?php


namespace MyShopKitPopupSmartBarSlideIn\Slidein\Services\PostMeta;

class UpdatePostMetaService extends PostMetaService
{
    public function updatePostMeta(array $aRawData): array
    {
        $this->setIsUpdate(true);
        $this->setRawData($aRawData);

        return $this->performSaveData();
    }
}
