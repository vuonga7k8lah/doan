<?php if (have_posts()) { ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 xl:gap-8 mb-13">
        <?php
        while (have_posts()) {
            the_post();
            if (defined('HSBLOG2_SC_PREFIX')) {
                zimac_render_post_card_author(['post' => $post]);
            } else {
                zimac_render_post_card(['post' => $post]);
            }
        }
        wp_reset_postdata();
        ?>
    </div>
<?php
    zimac_render_post_pagination();
} else {
    zimac_render_content_none();
}
?>
