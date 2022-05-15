<?php
if (!defined('HSBLOG2_SC_PREFIX')) {
    return '';
}
$currentPageType = $_GET['pageType'] ?? '';
$pLink = home_url('/?s=' . get_search_query() . '');

?>
<div>
    <div class="inline-flex list-none bg-gray-200 dark:bg-gray-800 rounded-full p-3px text-gray-700 dark:text-gray-200 mb-5">
        <li class="wil-nav-item--type2 ">
            <a class="block text-center text-xs md:text-base  px-3 md:px-5 py-2 rounded-full <?php echo esc_html(!$currentPageType ? 'wil-nav-item__a--type2--active' : ''); ?>" href="<?php echo esc_url($pLink); ?>">
                <?php echo esc_html__('Articles', 'zimac'); ?>
            </a>
        </li>
        <li class="wil-nav-item--type2 ">
            <a class="block text-center text-xs md:text-base  px-3 md:px-5 py-2 rounded-full font-medium <?php echo esc_html($currentPageType === 'categories' ? 'wil-nav-item__a--type2--active' : ''); ?>" href="<?php echo esc_url($pLink . '&pageType=categories'); ?>">
                <?php echo esc_html__('Categories', 'zimac'); ?>
            </a>
        </li>
        <li class="wil-nav-item--type2 ">
            <a class="block text-center text-xs md:text-base  px-3 md:px-5 py-2 rounded-full font-medium <?php echo esc_html($currentPageType === 'tags' ? 'wil-nav-item__a--type2--active' : ''); ?>" href="<?php echo esc_url($pLink . '&pageType=tags'); ?>">
                <?php echo esc_html__('Tags', 'zimac'); ?>
            </a>
        </li>
        <li class="wil-nav-item--type2 ">
            <a class="block text-center text-xs md:text-base  px-3 md:px-5 py-2 rounded-full font-medium <?php echo esc_html($currentPageType === 'authors' ? 'wil-nav-item__a--type2--active' : ''); ?>" href="<?php echo esc_url($pLink . '&pageType=authors'); ?>">
                <?php echo esc_html__('Authors', 'zimac'); ?>
            </a>
        </li>
    </div>
</div>
