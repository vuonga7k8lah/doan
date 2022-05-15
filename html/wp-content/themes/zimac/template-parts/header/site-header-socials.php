<?php

use ZIMAC\Helpers\Helpers;
use HSSC\Shared\ThemeOptions\ThemeOptionSkeleton;

$aSocials = [];
if (defined('HSBLOG2_SC_PREFIX')) {
    $aSocialSettings =  ThemeOptionSkeleton::getField('socials_settings') ?? [];
    if (!is_array($aSocialSettings)) {
        return '';
    }
    foreach ($aSocialSettings as $key => $value) {
        $aSocials[$key] = Helpers::getASocialFontClass($key, $value);
    }
}
?>

<div class="flex items-center flex-wrap space-x-2 text-gray-900 dark:text-gray-300">
    <?php
    foreach ($aSocials as $social => $aSocial) {
        if (empty($aSocial) || !$aSocial['href']) continue;

        echo '<a class="my-1 rounded-full flex items-center justify-center text-lg lg:w-11 w-8 lg:h-11 h-8 border-2 border-gray-300" href="' . esc_url($aSocial['href']) . '" target="_blank" rel="noopener noreferrer" title="' . esc_attr($social) . '">';
        echo '<i class="lab ' . esc_attr($aSocial['icon']) . '"></i>';
        echo '</a>';
    }
    ?>
</div>
