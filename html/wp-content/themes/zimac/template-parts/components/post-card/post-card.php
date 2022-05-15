<?php

use ZIMAC\Helpers\Helpers;
use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Users\Models\BookmarkModel;
use HSSC\Users\Models\UserModel;

$oPost = $args['post'];

// <------------- SU DUNG SHORTCODE NEU ACTIVE PLUGIN SC ----------------->
if (defined('HSBLOG2_SC_PREFIX')) {
    $countViews = UserModel::getCountViewByPostID($oPost->ID);
    $bookmarkStatus = BookmarkModel::get([
        'post_id' => $oPost->ID,
        'user_id' => get_current_user_id()
    ]);

    echo App::get('UniqueVerticalBoxItemSc')->renderSc([
        'id'              => $oPost->ID,
        'is_saved'        => $bookmarkStatus,
        'created_at'      => FunctionHelper::getDateFormat($oPost->post_date),
        'name'            => $oPost->post_title,
        'featured_image'  => FunctionHelper::getPostFeaturedImage($oPost->ID, 'large'),
        'url'             => get_permalink($oPost->ID),
        'number_views'    => $countViews,
        'number_comments' => get_comments_number($oPost->ID),
        'author_avatar'   => UserModel::getUrlAvatarAuthor($oPost->post_author),
        'author_name'     => get_the_author_meta('display_name', $oPost->post_author),
    ]);
    return;
}

// <------------- SU DUNG DEFAULT CODE NEU CHUA ACTIVE PLUGIN SC ----------------->
$thumbnail = get_the_post_thumbnail_url($oPost, 'large');
$authorAvatar = Helpers::getUserAvatarUrl($oPost->post_author);
$authorName = get_the_author_meta('display_name', $oPost->post_author);
?>

<div class="wil-post-card-6 relative rounded-2xl overflow-hidden">
    <?php if ($thumbnail) : ?>
        <div class="relative h-0 pt-56.25% bg-gray-400">
            <img class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($oPost->post_title); ?>">
        </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-gray-900 p-5 pt-4 text-gray-900 dark:text-gray-100 h-full">
        <div class="flex justify-between items-center">
            <div class="flex items-center truncate">
                <div class="wil-avatar relative flex-shrink-0 inline-flex items-center justify-center overflow-hidden text-gray-100 uppercase font-bold bg-gray-200 rounded-xl w-10 h-10 <?php echo esc_attr($authorAvatar ? '' : 'wil-avatar-no-img'); ?>">
                    <?php if ($authorAvatar) :  ?>
                        <img class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_url($authorAvatar); ?>" alt="<?php echo esc_attr($authorName); ?>">
                    <?php endif; ?>
                    <span class="wil-avatar__name">
                        <?php echo esc_html(substr($authorName, 0, 1)); ?>
                    </span>
                </div>
                <span class="truncate ml-10px text-base font-medium">
                    <?php echo esc_html($authorName); ?>
                </span>
            </div>
            <div class="flex-shrink-0 ml-2 relative" title="<?php echo esc_attr__('Comments', 'zimac'); ?>">
                <div class="wil-post-info flex items-center truncate space-x-3.5 xl:text-sm text-xs font-medium leading-tight text-gray-800 dark:text-gray-300">
                    <div class="truncate">
                        <i class="las la-comment text-base opacity-80 leading-tight"></i>
                        <span><?php echo esc_html($oPost->comment_count); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <h6 class="wil-line-clamp-2 mt-4 mb-5">
            <?php echo get_the_title($oPost->ID); ?>
            <?php if (is_sticky($oPost->ID)) : ?>
                <i class="las la-thumbtack ml-1"></i>
            <?php endif; ?>
        </h6>
        <div class="flex justify-between items-center">
            <span class="text-xs text-gray-700 dark:text-gray-300 font-medium truncate mr-4 ">
                <?php echo esc_html(date_i18n(get_option('date_format'), strtotime($oPost->post_date))); ?>
            </span>
        </div>
    </div>
    <a href="<?php echo esc_url(get_permalink($oPost)); ?>" class="absolute inset-0 z-0">
        <span class="sr-only"><?php echo esc_html($oPost->post_title); ?></span>
    </a>
</div>
