<header class="mb-8 mx-auto space-y-5">
    <?php if (get_the_post_thumbnail_url(null, 'full')) : ?>
        <img alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full rounded-4xl" src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'full')); ?>">
    <?php endif; ?>
    <?php zimac_render_single_header_common_meta(); ?>
</header>
