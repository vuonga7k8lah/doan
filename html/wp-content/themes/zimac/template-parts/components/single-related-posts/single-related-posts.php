<?php

use ZIMAC\Helpers\Helpers;
use HSSC\Shared\ThemeOptions\ThemeOptionSkeleton;

$relatedArgs = [];
$moreByAuthorArgs = [];

// GET SETTING DEFAULT WHEN NOT ACTIVE HSSC
if (!defined('HSBLOG2_SC_PREFIX')) {
    $relatedPostsTitle = esc_html__('Related Posts', 'zimac');
    $relatedArgs['category__in'] = Helpers::getArrayTermIDByPostID(true, $post->ID);
    $relatedArgs['posts_per_page'] = 4;
    // MORE BY AUTHOR
    $moreByAuthorTitle = esc_html__('More Posts By Author', 'zimac');
    $moreByAuthorArgs['author'] = $post->post_author;
    $moreByAuthorArgs['posts_per_page'] = 4;
}

// GET SETTINGS FROM THEME OPTIONS WHEN HSSC ACTIVE
if (defined('HSBLOG2_SC_PREFIX')) {
    $relatedPostsTitle = ThemeOptionSkeleton::getField('related_posts_title');
    if (ThemeOptionSkeleton::getField('related_post_taxonomy') === 'category') {
        $relatedArgs['category__in'] = Helpers::getArrayTermIDByPostID(true, $post->ID);
    } else {
        $relatedArgs['tag__in'] = Helpers::getArrayTermIDByPostID(false, $post->ID);
    }
    $relatedArgs['posts_per_page'] = ThemeOptionSkeleton::getField('related_posts_posts_per_page');
    $relatedArgs['orderby'] = ThemeOptionSkeleton::getField('related_posts_order_by');
    // MORE BY AUTHOR
    $moreByAuthorTitle = ThemeOptionSkeleton::getField('more_posts_by_author_title');
    $moreByAuthorArgs['author'] = $post->post_author;
    $moreByAuthorArgs['posts_per_page'] = ThemeOptionSkeleton::getField('more_posts_by_author_posts_per_page');
    $moreByAuthorArgs['orderby'] = ThemeOptionSkeleton::getField('more_posts_by_author_order_by');
}

$aRelatedPosts = [];
$aMoreByAuthorPosts = [];
//
if (!empty($relatedArgs['posts_per_page'])) {
    $aRelatedPosts = (new WP_Query($relatedArgs))->posts;
}
if (!empty($moreByAuthorArgs['posts_per_page'])) {
    $aMoreByAuthorPosts = (new WP_Query($moreByAuthorArgs))->posts;
}
?>

<div class="px-[10px] wil-single-related-posts-container">
    <div class="py-13 bg-primary bg-opacity-40 rounded-3.125rem">
        <div class="wil-container wil-single-related-posts container">
            <!-- RELATED POSTS (CATEGORY/TAGS) -->
            <?php if (!empty($aRelatedPosts)) : ?>
                <div class="mb-13">
                    <div class="wil-title-section font-bold text-xl lg:text-1.375rem flex items-center text-gray-900 dark:text-gray-100 mb-5">
                        <span class="truncate">
                            <?php echo esc_html($relatedPostsTitle); ?>
                        </span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 xl:gap-8">
                        <?php foreach ($aRelatedPosts as $oPost) {
                            zimac_render_post_card(['post' => $oPost]);
                        }  ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- POST MORE BY AUTHOR -->
            <?php if (!empty($aMoreByAuthorPosts)) : ?>
                <div>
                    <div class="wil-title-section font-bold text-xl lg:text-1.375rem flex items-center text-gray-900 dark:text-gray-100 mb-5">
                        <span class="truncate">
                            <?php echo esc_html($moreByAuthorTitle); ?>
                        </span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 xl:gap-8">
                        <?php foreach ($aMoreByAuthorPosts as $oPost) {
                            zimac_render_post_card(['post' => $oPost]);
                        }  ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
