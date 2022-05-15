<?php

use HSSC\Helpers\App;
use HSSC\Users\Models\UserModel;

$number   = 12;
$paged    = $_GET['myPaged'] ?? 1;
$offset   = ($paged - 1) * $number;

$aArgs = [
    'search'            => '*' . get_search_query() . '*',
    'search_columns'    => ['user_nicename'],
    'number'            => $number,
    'paged'             => $paged,
    'offset'            => $offset,
];

$oQuery = new WP_User_Query($aArgs);
$totalItems = $oQuery->get_total();
$aResults = $oQuery->get_results() ?? [];
$totalPages = ceil($totalItems / $number);

add_filter(ZIMAC_THEME_PREFIX . 'get_search_result_count', function () use ($totalItems) {
    return $totalItems;
}, 10, 3);

?>
<!-- THIS IS CONTENT -->
<?php zimac_render_search_header(); ?>
<div class="pt-10 pb-20">
    <div class="wil-container container">
        <?php zimac_render_search_page_tabs();  ?>


        <?php if (!is_wp_error($oQuery) && !empty($aResults)) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5 xl:gap-8">
                <?php foreach ($aResults as $oUser) : ?>
                    <?php echo App::get('AuthorCardItemSc')->renderSc([
                        'id'           => $oUser->ID,
                        'name'         => $oUser->data->display_name,
                        'number_posts' => count_user_posts($oUser->ID, 'post', true),
                        'avatar'       => UserModel::getUrlAvatarAuthor($oUser->ID),
                        'url'          => get_author_posts_url($oUser->ID),
                        'type'         => "",
                    ]); ?>
                <?php endforeach; ?>
            </div>

        <?php else : ?>
            <?php echo esc_html__('It looks like nothing was found at this location. Maybe try a search?', 'zimac'); ?>
        <?php endif; ?>


        <?php if ($totalItems > count($aResults)) : ?>
            <div id="pagination" class="clearfix mt-10">
                <?php
                echo paginate_links(array(
                    'format'        => '?myPaged=%#%',
                    'current'       => $paged,
                    'total'         => $totalPages,
                    'prev_text'     => '<span class="w-10 h-10 bg-white dark:bg-black flex items-center justify-center rounded-full text-2xl"><span class="sr-only">Next</span><i class="las la-angle-left"></i></span>',
                    'next_text'     => '<span class="w-10 h-10 bg-white dark:bg-black flex items-center justify-center rounded-full text-2xl"><span class="sr-only">Next</span><i class="las la-angle-right"></i></span>',
                ));
                ?>
            </div>
        <?php endif; ?>

    </div>
</div>
