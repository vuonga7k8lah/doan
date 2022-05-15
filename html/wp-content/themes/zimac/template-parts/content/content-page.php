<?php

use ZIMAC\Helpers\Helpers;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('wil-detail-page wil-detail-page--full bg-white dark:bg-gray-800 py-13'); ?>>
    <div class="wil-container container">
        <div class="wil-prose max-w-7xl mx-auto">
            <div class="prose">
                <?php the_title('<h1 class="entry-title text-3xl md:text-4xl lg:text-4.5xl text-gray-900 dark:text-gray-100">', '</h1>'); ?>
                <?php if (Helpers::canShowPostThumbnail()) : ?>
                    <figure class="post-thumbnail">
                        <?php the_post_thumbnail('post-thumbnail', array('loading' => 'eager'));   ?>
                        <?php if (wp_get_attachment_caption(get_post_thumbnail_id())) : ?>
                            <figcaption class="wp-caption-text"><?php echo wp_kses_post(wp_get_attachment_caption(get_post_thumbnail_id())); ?></figcaption>
                        <?php endif; ?>
                    </figure>
                    <!-- .post-thumbnail -->
                <?php endif; ?>

                <div class="entry mb-13 text-gray-700 dark:text-gray-300 relative z-10">
                    <?php
                    the_content();

                    wp_link_pages(
                        array(
                            'before'            => '<div class="page-links wil-pagination flex items-center text-gray-700 dark:text-gray-300 font-medium text-lg space-x-3 mb-13">',
                            'after'             => '</div>',
                            'link_before'       => '<span class="page-link">',
                            'link_after'        => '</span>',
                        )
                    );
                    ?>
                </div>
                <hr class="w-full border-t-2 border-gray-200 dark:border-gray-700 mb-8">
            </div>

            <?php   // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;  ?>
        </div>
    </div>
</article>
