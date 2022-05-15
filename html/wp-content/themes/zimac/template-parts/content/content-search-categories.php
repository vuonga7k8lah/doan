 <?php
    $number   = 18;
    $paged    = $_GET['myPaged'] ?? 1;
    $offset   = ($paged - 1) * $number;

    $aTermArgs = [
        'search'        => get_search_query(),
        'taxonomy'      => 'category',
        'orderby'       => 'name',
        'order'         => 'ASC',
        'hide_empty'    => false,
        //
        'number'        => $number,
        'paged'         => $paged,
        'offset'        => $offset,
    ];
    $aArgsNotPage = [
        'search'        => get_search_query(),
        'taxonomy'      => 'category',
        'hide_empty'    => false,
    ];

    $oQuery = new WP_Term_Query($aTermArgs);
    $totalItems = count((new WP_Term_Query($aArgsNotPage))->get_terms());
    $aTermResults = $oQuery->get_terms() ?? [];
    $totalPages = ceil($totalItems / $number);

    add_filter(ZIMAC_THEME_PREFIX . 'get_search_result_count', function () use ($totalItems) {
        return $totalItems;
    }, 10, 3);

    ?>
 <!-- THIS IS CONTENT -->
 <?php zimac_render_search_header();    ?>
 <div class="pt-10 pb-20">
     <div class="wil-container container">
         <?php zimac_render_search_page_tabs();  ?>
         <?php if (!is_wp_error($oQuery) && !empty($aTermResults)) : ?>
             <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 gap-5 xl:gap-8">
                 <?php foreach ($aTermResults as $oTerm) : ?>
                     <?php zimac_render_category_card(['oTerm' => $oTerm]); ?>
                 <?php endforeach; ?>
             </div>

         <?php else : ?>
             <?php echo esc_html__('It looks like nothing was found at this location. Maybe try a search?', 'zimac'); ?>
         <?php endif; ?>


         <?php if ($totalItems > count($aTermResults)) : ?>
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
