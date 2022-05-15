<?php

use HSSC\Shared\ThemeOptions\ThemeOptionSkeleton;

$bg = "";
if (defined('HSBLOG2_SC_PREFIX')) {
    $bg = ThemeOptionSkeleton::getField('home_page_settings_bg') ?? [];
}
?>

<div class="wil-home-page__body relative">
    <?php if (!empty($bg)) : ?>
        <div class="absolute inset-0 z-0">
            <img class="w-full h-screen max-h-full top-0 left-0 right-0 sticky z-0" src="<?php echo esc_attr($bg ? $bg['url'] : ''); ?>" alt="home-background">
        </div>
    <?php endif; ?>
    <div class="wil-home text-gray-900 dark:text-gray-200 bg-white dark:bg-gray-800 bg-opacity-80 wil-backdrop-filter-23px relative z-1">
        <?php the_content();   ?>
    </div>
</div>