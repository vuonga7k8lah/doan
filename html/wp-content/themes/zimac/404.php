<?php
get_header();
?>

<div class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-300 py-20">
    <div class="max-w-2xl p-4 mx-auto text-center prose">
        <h1 class="text-6xl md:text-9xl leading-none mb-3">
            <?php echo esc_html__('404', 'zimac'); ?>
        </h1>
        <span>
            <?php echo esc_html__('It looks like nothing was found at this location.', 'zimac'); ?>
            <a href="<?php echo esc_url(home_url('/')); ?>"> <?php echo esc_html__(' Return to Home Page', 'zimac'); ?></a>
        </span>

    </div>
</div>

<?php
get_footer();
