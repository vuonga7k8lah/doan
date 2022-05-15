<?php

use ZIMAC\Helpers\Helpers;

$ID = get_the_author_meta('ID');
$name = get_the_author_meta('display_name');
$url = get_author_posts_url($ID);
$avatar = Helpers::getUserAvatarUrl($ID);

// Ko in ra neu ko active hs-sc va user ko co description
if (!defined('HSBLOG2_SC_PREFIX') && !get_the_author_meta('description')) {
    return '';
}
?>

<div class="flex flex-wrap wil-single-related-author justify-between sm:flex-nowrap font-medium mb-10">
    <div class="flex space-x-5 mr-4">
        <div class="wil-avatar relative flex-shrink-0 inline-flex items-center justify-center overflow-hidden text-gray-100 uppercase font-bold bg-gray-200 rounded-2.5xl w-20 h-20 ring-2 ring-white <?php echo esc_attr(!$avatar ? 'wil-avatar-no-img' : ""); ?>">
            <?php if ($avatar) : ?>
                <img alt="<?php echo esc_attr($name); ?>" class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_url($avatar); ?>">
            <?php endif; ?>
            <span class="wil-avatar__name">
                <?php echo esc_html(substr($name, 0, 1)); ?>
            </span>
        </div>
        <div>
            <span class="block uppercase text-xs tracking-wider text-gray-800 dark:text-gray-100">
                <?php echo esc_html__('written by', 'zimac'); ?>
            </span>
            <a href="<?php echo esc_url($url); ?>" class="block text-gray-900 dark:text-gray-100 text-lg">
                <?php echo esc_html($name); ?>
            </a>
            <span class="text-sm sm:text-base text-gray-700 dark:text-gray-200">
                <?php echo esc_html(get_the_author_meta('description')); ?>
                <a href="<?php echo esc_url($url); ?>" class="underline">
                    <?php echo esc_html__('continue reading', 'zimac'); ?>
                </a>
            </span>
        </div>
    </div>

    <!-- CHECK PLUGIN INSTALL HSBLOG2_SC -->
    <?php if (defined('HSBLOG2_SC_PREFIX')) : ?>
        <div class="hidden sm:block mt-2 flex-shrink-0">
            <a href="<?php echo esc_url($url); ?>" class="wil-button rounded-full h-11 text-primary bg-gray-900 text-sm lg:text-base inline-flex items-center justify-center text-center py-2 px-4 md:px-6 font-bold focus:outline-none ">
                <?php echo esc_html__('Follow', 'zimac'); ?>
            </a>
        </div>
    <?php endif; ?>
</div>
