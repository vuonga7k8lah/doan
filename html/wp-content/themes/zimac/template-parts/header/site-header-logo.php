<?php

use HSSC\Shared\ThemeOptions\ThemeOptionSkeleton;

$blogInfo    = get_bloginfo('name');
$description  = get_bloginfo('description', 'display');
$homeUrl = home_url('/');

if (defined('HSBLOG2_SC_PREFIX')) : ?>
    <?php
    $logoImg =  ThemeOptionSkeleton::getField('logo_img')['url'] ?? '';
    $logoImgDark =  ThemeOptionSkeleton::getField('logo_img_dark')['url'] ?? '';
    ?>

    <div class="wil-header-01__top-logo text-gray-800 dark:text-gray-200">

        <a href="<?php echo esc_url($homeUrl); ?>" class="<?php echo esc_attr($logoImg ? "wil-logo" : ($args['textAlign'] ?? "text-center")); ?> wil-logo--type1 block">
            <?php if (!!$logoImg) : ?>
                <img alt="Logo" class="block dark:hidden" src="<?php echo esc_url($logoImg); ?>">
                <img alt="Logo" class="hidden dark:block" src="<?php echo esc_url($logoImgDark); ?>">
            <?php else : ?>
                <h1>
                    <?php echo esc_html($blogInfo); ?>
                </h1>
                <span class="block">
                    <?php echo esc_html($description); ?>
                </span>
            <?php endif; ?>
        </a>
    </div>

<?php else : ?>

    <div class="wil-header-01__top-logo text-gray-800 dark:text-gray-200">
        <a href="<?php echo esc_url($homeUrl); ?>" class="text-center wil-logo--type1 block">
            <h1>
                <?php echo esc_html($blogInfo); ?>
            </h1>
            <span class="block">
                <?php echo esc_html($description); ?>
            </span>
        </a>
    </div>

<?php endif; ?>
