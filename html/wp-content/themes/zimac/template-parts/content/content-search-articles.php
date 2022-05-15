 <!-- THIS IS CONTENT -->
 <?php
    add_filter(ZIMAC_THEME_PREFIX . 'get_search_result_count', function () {
        global $wp_query;
        return $wp_query->found_posts;
    }, 10, 3);
    ?>

 <?php zimac_render_search_header(); ?>
 <div class="pt-10 pb-20">
     <div class="wil-container container">
         <?php zimac_render_search_page_tabs();  ?>

         <?php
            if (!have_posts()) {
                echo esc_html__('It looks like nothing was found at this location. Maybe try a search?', 'zimac');
            }
            ?>

         <?php if (have_posts()) : ?>
             <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 xl:gap-8 mb-13">
                 <?php while (have_posts()) : ?>
                     <?php
                        the_post();
                        zimac_render_post_card(['post' => $post]);
                        ?>
                 <?php endwhile; ?>
                 <?php wp_reset_postdata(); ?>
             </div>
             <?php zimac_render_post_pagination(); ?>
         <?php endif; ?>

     </div>
 </div>
