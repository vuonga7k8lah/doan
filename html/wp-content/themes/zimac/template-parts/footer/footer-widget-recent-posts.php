<?php if (is_active_sidebar(ZIMAC_THEME_PREFIX . 'recent_posts_footer')) : ?>
    <div class="footer-widget-recent-posts space-y-8 text-gray-100">
        <?php dynamic_sidebar(ZIMAC_THEME_PREFIX . 'recent_posts_footer'); ?>
    </div>
<?php endif;
