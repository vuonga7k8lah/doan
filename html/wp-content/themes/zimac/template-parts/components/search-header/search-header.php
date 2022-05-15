<header class="bg-gray-900 py-11 text-white">
    <div class="wil-container container">
        <div class="max-w-4xl mx-auto">
            <form role="search" action="<?php echo esc_url(home_url('/')); ?>" method="get">

                <?php
                $inputPlaceholder = esc_attr__('Search and Press Enter', 'zimac');
                if (class_exists('SearchWP_Live_Search')) {
                    $inputPlaceholder =  esc_attr__('Search', 'zimac');
                };
                ?>

                <input name="s" id="s" value="<?php echo get_search_query(); ?>" data-swplive="true" type="text" class="block mb-4 bg-transparent border-0 border-b-3 border-white border-opacity-20 w-full placeholder-gray-500 text-h4 md:text-h2 font-medium text-gray-200 py-2 px-0 focus:outline-none focus:ring-0 focus:border-primary truncate" placeholder="<?php echo esc_attr($inputPlaceholder); ?>">
            </form>

            <div class="text-base md:leading-tight pt-2px space-x-1 md:truncate">
                <?php
                $countResults = apply_filters(ZIMAC_THEME_PREFIX . 'get_search_result_count', 0);
                printf(
                    esc_html(
                        _n(
                            'We found %d result for your search.',
                            'We found %d results for your search.',
                            $countResults,
                            'zimac'
                        )
                    ),
                    $countResults
                ); ?>
            </div>
        </div>
    </div>
</header>
