<?php

use HSSC\Users\Controllers\UserCountViewsController;
use HSSC\Users\Models\UserModel;

get_header();

while (have_posts()) :
    the_post();
    $post = get_post();
    $isHiddenSidbar = false;
    if (defined('HSBLOG2_SC_PREFIX')) {
        $isHiddenSidbar = get_post_meta(get_the_ID(), HSBLOG2_SC_PREFIX . 'hidden_sidebar_checkbox', 1);
    }

    $isSidebarActive = is_active_sidebar(ZIMAC_THEME_PREFIX . 'single-sidebar') && !$isHiddenSidbar;
    $hasFeaturedImage = !!get_the_post_thumbnail_url(null, 'full');
    $isMetaSticky = defined('HSBLOG2_ACTION_PREFIX');
?>
    <div class="wil-detail-page wil-detail-page--1 bg-white dark:bg-gray-800 py-13 <?php echo esc_attr(!$isSidebarActive ? 'wil-detail-page--full' : "wil-detail-page--has-sidebar"); ?> <?php echo esc_attr($isMetaSticky ? 'wil-detail-page--has-meta-sticky' : '') ?>">
        <div class="wil-container container">

            <!-- ===  HEADER HERE === -->
            <?php if ($hasFeaturedImage) : ?>
                <?php zimac_render_single_header(); ?>
            <?php endif; ?>

            <div class="grid grid-cols-1 <?php echo esc_attr($isSidebarActive ? 'lg:grid-cols-3 gap-5 xl:gap-8' : ""); ?>">
                <!-- ===  SINGLE CONTENT HERE === -->
                <div class="<?php echo esc_attr($isSidebarActive ? 'lg:col-span-2' : ""); ?>">
                    <?php $bodyClass = ($isSidebarActive && $isMetaSticky) ? 'mr-auto lg:mr-0 ml-auto 2xl:mr-auto' : "mx-auto"; ?>
                    <div class="max-w-screen-md <?php echo esc_attr($bodyClass); ?>">
                        <div class="relative flex">
                            <!-- === POST-INFO & SHARED here if actve HS-SC plugin === -->
                            <?php if ($isMetaSticky) : ?>
                                <div class="wil-detail-page__meta-sticky hidden lg:flex items-start flex-shrink-0 z-10">
                                    <div class="sticky top-8">
                                        <?php zimac_render_single_meta_data([
                                            'user_id'        => get_current_user_id(),
                                            'post_id'        => $post->ID,
                                            'number_comment' => $post->comment_count,
                                            'post_url'       => get_permalink()
                                        ]);   ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="wil-detail-page__content mb-13 text-gray-700 dark:text-gray-300 relative z-10 flex-grow">
                                <!-- HEADER -->
                                <?php if (!$hasFeaturedImage) : ?>
                                    <?php zimac_render_single_header3(); ?>
                                <?php endif; ?>
                                <!-- ENTRY CONTENT -->
                                <?php zimac_render_content_single(); ?>

                            </div>
                        </div>

                        <div class="relative flex">
                            <!-- THE HIDDEN STICKY SPACE -->
                            <?php if ($isMetaSticky) : ?>
                                <div class="wil-detail-page__meta-sticky hidden lg:flex items-start flex-shrink-0 z-0">
                                    <div class="sticky top-8"></div>
                                </div>
                            <?php endif; ?>
                            <div class="flex-grow grid">
                                <!-- === SINGE LIST TAGS === -->
                                <?php zimac_render_single_list_tags(); ?>

                                <!-- === POST-INFO & SHARED here if actve HS-SC plugin === -->
                                <?php if ($isMetaSticky) : ?>
                                    <div class="wil-detail-page__sm-meta-share flex lg:hidden mb-10">
                                        <?php zimac_render_single_meta_data([
                                            'user_id'        => get_current_user_id(),
                                            'post_id'        => $post->ID,
                                            'number_comment' => $post->comment_count,
                                            'post_url'       => get_permalink(),
                                            'gridClassName'  => 'grid-cols-4',
                                        ]);   ?>
                                    </div>
                                <?php endif; ?>

                                <!-- === Author === -->
                                <?php zimac_render_single_author(); ?>
                                <hr class="w-full border-t-2 border-gray-200 dark:border-gray-600 mb-8" />

                                <!-- === Comments === -->
                                <?php if (comments_open() || get_comments_number()) :
                                    comments_template();
                                endif; ?>
                            </div>
                        </div>


                    </div>
                </div>

                <!-- // ===  SIDEBAR HERE === -->
                <?php if ($isSidebarActive) : ?>
                    <div class="w-full max-w-screen-md mr-auto ml-auto mb-8">
                        <?php zimac_render_single_sidebar(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- ===  RELATED-POSTS HERE IF ACTIVE HSBLOG-SC plugin === -->
        <?php zimac_render_single_related_posts(); ?>
    </div>
<?php

    // UPDATE COUNTVIEWS FOR SINGLE
    if (defined('HSBLOG2_ACTION_PREFIX')) {
        $aDataCountViews = (new UserCountViewsController())->handleDataCountViews([]);
        if (UserModel::isViewedToday($aDataCountViews)) {
            UserModel::updateCountView($aDataCountViews);
        } else {
            UserModel::insertCountView($aDataCountViews);
        }
    }

endwhile; // End of the loop.

get_footer();
