<?php
/*
* Template Name: Home Template
* Template Post Type: page
*/

get_header();
?>

<?php
while (have_posts()) :
    the_post();
    zimac_render_content_home();
endwhile; // End of the loop.

get_footer();
