<?php
$description = get_the_archive_description();
?>

<div class="wil-archive-page bg-gray-100 dark:bg-gray-800">
    <div class="wil-container container">
        <div class="py-8">
            <header class="flex justify-between items-center mb-5">
                <div class="wil-title-section flex items-center text-gray-900 dark:text-gray-100">
                    <div>
                        <h1 class="truncate font-bold text-xl lg:text-1.375rem">
							<?php echo get_the_archive_title(); ?>
                        </h1>
						<?php if ($description) : ?>
                            <span class="archive-description">
                                <?php echo wp_kses_post(wpautop($description)); ?>
                            </span>
						<?php endif; ?>
                    </div>
                </div>
            </header>
			<?php if (have_posts()) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 xl:gap-8 mb-13">
					<?php while (have_posts()) {
						the_post();
						zimac_render_post_card(['post' => $post]);
					} ?>
                </div>
				<?php zimac_render_post_pagination(); ?>
			<?php else : ?>
				<?php zimac_render_content_none(); ?>
			<?php endif; ?>
	        <?php wp_reset_postdata(); ?>
        </div>
    </div>
</div>
