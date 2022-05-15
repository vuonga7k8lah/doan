<?php

use HSSC\Shared\ThemeOptions\ThemeOptionSkeleton;

$enableThemeMode = false;
if (class_exists('HSSC\Shared\ThemeOptions\ThemeOptionSkeleton')) {
	$enableThemeMode = ThemeOptionSkeleton::getField('enable_theme_mode');
// bool
	$defaultThemeMode = ThemeOptionSkeleton::getField('default_theme_mode');
// light / dark
}
if (!$enableThemeMode) {
	return '';
}

?>

<button class="flex items-center rounded-full border-2 border-gray-200 py-1 px-1 flex-row dark:flex-row-reverse focus:outline-none "
        data-switch-night-mode="wil-switch-night-mode" tabindex="0"
        data-switch-night-mode-theme-default="<?php echo esc_attr($defaultThemeMode); ?>">
    <span class="sr-only">
        <?php echo esc_html__('Enable dark mode', 'zimac'); ?>
    </span>
    <span class="bg-primary rounded-full w-8 h-8 flex items-center justify-center text-xl text-gray-900">
        <i class="lar" data-switch-night-mode-icon></i>
    </span>
    <span class="text-gray-900 dark:text-gray-200 px-2 text-base" data-switch-night-mode-text>
        <?php echo esc_html__('Dark', 'zimac'); ?>
    </span>
    <span class="hidden" data-switch-night-mode-text-light>
        <?php echo esc_html__('Dark', 'zimac'); ?>
    </span>
    <span class="hidden" data-switch-night-mode-text-dark>
        <?php echo esc_html__('Light', 'zimac'); ?>
    </span>
</button>
