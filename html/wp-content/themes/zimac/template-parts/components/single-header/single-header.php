<?php

use ZIMAC\Helpers\Helpers;

$ID = get_the_author_meta('ID');
$categories = get_the_category();
$authorName = get_the_author_meta('display_name');
$avatar = Helpers::getUserAvatarUrl($ID);
?>

<header class="mb-13">
    <div class="wil-post-large-1 grid grid-cols-1 lg:grid-cols-3 gap-5 xl:gap-8">
        <div class="row-start-1 col-start-1 relative z-10 py-8 sm:py-14 flex flex-col justify-end lg:justify-start bg-gradient-to-t from-gray-900 lg:bg-none px-5 lg:px-0 rounded-4xl lg:rounded-none">
            <div>
                <?php
                if (!empty($categories)) : ?>
                    <?php foreach ($categories as $oTerm) : ?>
                        <a href="<?php echo esc_url(get_category_link($oTerm)); ?>" class="inline-flex items-center justify-center px-3.5 text-gray-900 bg-primary font-medium rounded-3xl leading-tight py-2 border-2 border-primary text-xs mr-1 mt-1">
                            <?php echo esc_html($oTerm->name); ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <h1 class="text-gray-100 lg:text-gray-900 dark:text-gray-200 text-2xl lg:text-3xl xl:text-4.5xl tracking-tight my-4 lg:my-8">
                <?php the_title(); ?>
            </h1>
            <div class="flex items-center font-bold text-xs text-gray-300 lg:text-gray-800 dark:text-gray-300 xl:text-base">
                <div class="wil-avatar relative flex-shrink-0 inline-flex items-center justify-center overflow-hidden text-gray-100 uppercase font-bold bg-gray-200 rounded-full h-8 w-8 xl:h-10 xl:w-10 mr-2.5 <?php echo esc_attr(!$avatar ? 'wil-avatar-no-img' : ""); ?>">
                    <?php if ($avatar) : ?>
                        <img alt="<?php echo esc_attr($authorName); ?>" class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_url($avatar); ?>">
                    <?php endif; ?>
                    <span class="wil-avatar__name">
                        <?php echo esc_html(substr($authorName, 0, 1)); ?>
                    </span>

                </div>
                <div class="flex-shrink-0">
                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                        <span class="opacity-70 font-medium"><?php echo esc_html__('By', 'zimac'); ?></span>
                        <?php echo esc_html($authorName); ?>
                    </a>
                </div>
                <span class="mx-2.5 hidden md:inline">•</span>
                <span class="truncate hidden md:inline">
                    <?php echo esc_html(get_the_date(get_option('date_format'))); ?>
                </span>
            </div>
        </div>
        <?php if (get_the_post_thumbnail_url(null, 'full')) : ?>
            <div class="row-start-1 col-start-1 lg:col-span-2 relative z-0 h-0 pt-133.33% md:pt-71.42% lg:pt-62.5% xl:pt-56.25% bg-gray-400 rounded-4xl">
                <img alt="<?php echo esc_attr(get_the_title()); ?>" class="absolute inset-0 object-cover w-full h-full rounded-4xl" src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'full')); ?>">
            </div>
        <?php endif; ?>
    </div>
</header>
