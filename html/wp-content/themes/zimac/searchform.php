<?php
$zmFormId = 'zm';
?>
<form class="zm-form wil-search-form relative flex-shrink-0 w-56 lg:w-60" role="search" method="get"
      action="<?php echo esc_url(home_url('/')); ?>">
    <button class="absolute right-1 mr-1px top-1/2 transform -translate-y-1/2 text-gray-900 bg-primary rounded-full w-8 h-8 flex justify-center items-center focus:outline-none "
            type="submit">
        <i class="las la-search text-lg leading-none"></i>
    </button>
    <input type="search"
           value="<?php echo esc_attr(zimac_get_search_query()); ?>"
           name="s"
           data-swplive="true"
           class="zm-form-input w-full h-10 lg:h-11 text-sm lg:text-base rounded-full pr-10 text-gray-900 dark:text-gray-100 placeholder-gray-700 dark:placeholder-gray-300 border-gray-300 bg-transparent focus:border-primary focus:ring-0"
           placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'zimac'); ?>"
    >
</form>
