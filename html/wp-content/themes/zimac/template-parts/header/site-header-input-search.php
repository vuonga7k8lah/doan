<?php

use HSSC\Shared\ThemeOptions\ThemeOptionSkeleton;

$inputPlaceholder = esc_attr__('Search travel, lifestyle…', 'zimac');
$toggleHeaderSearch = 'enable';
if (defined('HSBLOG2_SC_PREFIX')) {
    $toggleHeaderSearch =  ThemeOptionSkeleton::getField('toggle_header_search');
    $inputPlaceholder =  ThemeOptionSkeleton::getField('header_search_placeholder');
}
//
if ($toggleHeaderSearch !== 'enable') {
    return '';
}

?>

<form class="wil-search-form relative flex-shrink-0 w-56 lg:w-60" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
    <button class="absolute right-1 mr-1px top-1/2 transform -translate-y-1/2 text-gray-900 bg-primary rounded-full w-8 h-8 flex justify-center items-center focus:outline-none " type="submit">
        <i class="las la-search text-lg leading-none"></i>
    </button>
    <input type="search" value="<?php echo get_search_query(); ?>" name="s" data-swplive="true" class="w-full h-10 lg:h-11 text-sm lg:text-base rounded-full pr-10 text-gray-900 dark:text-gray-100 placeholder-gray-700 dark:placeholder-gray-300 border-gray-300 bg-transparent focus:border-primary focus:ring-0" aria-label="<?php echo esc_attr($inputPlaceholder); ?>" placeholder="<?php echo esc_attr($inputPlaceholder); ?>">
</form>
