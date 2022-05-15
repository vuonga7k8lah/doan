<?php
/*
* Template Name: User Submitted Posts
* Template Post Type: page
*/
?>

<?php get_header(); ?>

<?php
while (have_posts()) :
    the_post();
    zimac_render_content_submitted_posts();
endwhile; ?>

<?php get_footer();
