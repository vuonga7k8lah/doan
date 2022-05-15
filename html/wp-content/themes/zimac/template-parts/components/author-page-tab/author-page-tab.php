<?php
if (!defined('HSBLOG2_SC_PREFIX')) {
    return '';
}
$currentPageType = $_GET['pageType'] ?? '';

?>

<div class="inline-flex list-none bg-gray-200 dark:bg-gray-800 rounded-full p-3px text-gray-700 dark:text-gray-200 mb-5">
    <li class="wil-nav-item--type2">
        <a class="block text-center text-xs md:text-base px-3 md:px-5 py-2 rounded-full font-medium <?php echo esc_html(!$currentPageType ? 'wil-nav-item__a--type2--active' : ''); ?>" href="<?php echo esc_url(home_url(add_query_arg([], $wp->request))); ?>">
            <?php echo esc_html__('Articles', 'zimac'); ?>
        </a>
    </li>
    <li class="wil-nav-item--type2">
        <a class="block text-center text-xs md:text-base px-3 md:px-5 py-2 rounded-full font-medium <?php echo esc_html($currentPageType === 'about' ? 'wil-nav-item__a--type2--active' : ''); ?>" href="<?php echo esc_url(home_url(add_query_arg('pageType', 'about', $wp->request))); ?>">
            <?php echo esc_html__('About', 'zimac'); ?>
        </a>
    </li>
    <?php if (get_current_user_id() === get_queried_object()->ID) :  ?>
        <li class="wil-nav-item--type2">
            <a class="block text-center text-xs md:text-base px-3 md:px-5 py-2 rounded-full font-medium <?php echo esc_html($currentPageType === 'saved' ? 'wil-nav-item__a--type2--active' : ''); ?>" href="<?php echo esc_url(home_url(add_query_arg('pageType', 'saved', $wp->request))); ?>">
                <?php echo esc_html__('Saved', 'zimac'); ?>
            </a>
        </li>
    <?php endif; ?>
</div>
