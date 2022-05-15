<div class="prose">
    <?php
    the_content();

    $args = array(
        'before'            => '<div class="page-links wil-pagination flex items-center text-gray-700 dark:text-gray-300 font-medium text-lg space-x-3 mb-13">',
        'after'             => '</div>',
        'link_before'       => '<span class="page-link">',
        'link_after'        => '</span>',
    );

    wp_link_pages($args);
    ?>
</div><!-- .entry-content -->