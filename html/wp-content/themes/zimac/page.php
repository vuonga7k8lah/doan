<?php get_header(); ?>
<?php
while (have_posts()) :
    the_post();
    zimac_render_content_page();

endwhile; ?>

<?php get_footer();
