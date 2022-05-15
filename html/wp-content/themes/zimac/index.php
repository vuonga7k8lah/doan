<?php

/**
 * The main template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Hsblog2
 * @since 1.0.0
 */

get_header();
?>
<div class="wil-home-page bg-gray-100 dark:bg-gray-800">
    <div class="wil-container container">
        <div class="py-8">
            <?php if (have_posts()) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 xl:gap-8 mb-13">
                    <?php while (have_posts()) {
                        the_post();
                        zimac_render_post_card(['post' => $post]);
                    }  ?>
                </div>
                <?php zimac_render_post_pagination(); ?>
            <?php else : ?>
                <?php zimac_render_content_none(); ?>
            <?php endif; ?>
	        <?php wp_reset_postdata(); ?>
        </div>
    </div>
</div>
<?php
get_footer();
