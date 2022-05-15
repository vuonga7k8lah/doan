<?php

namespace DoAn\Shared;

class ThemeOption
{
    public static string $key      = 'wiloke_themeoptions';
    public static array  $aOptions = [];

    public static function getChiTieuTuyenTienSi()
    {
        $aOption = self::getOptions(true);
        return $aOption['chi_tieu_tien_si'];
    }

    public static function getOptions($isFocus = false)
    {
        if (self::$aOptions && !$isFocus) {
            return self::$aOptions;
        }

        self::$aOptions = get_option(self::$key);

        return self::$aOptions;
    }

    public static function getNgayHetHanTienSi()
    {
        $aOption = self::getOptions(true);
        return $aOption['ngay_het_han_tien_si'];
    }

    public static function getChiTieuThacSi()
    {
        $aOption = self::getOptions(true);
        return $aOption['chi_tieu_thac_si'];
    }

    public static function getNgayHetHanThacSi()
    {
        $aOption = self::getOptions(true);
        return $aOption['ngay_het_han_thac_si'];
    }
}
