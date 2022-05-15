<?php

/**
 * Search results are contained within a div.searchwp-live-search-results
 * which you can style accordingly as you would any other element on your site
 *
 * Some base styles are output in wp_footer that do nothing but position the
 * results container and apply a default transition, you can disable that by
 * adding the following to your theme's functions.php:
 *
 * add_filter( 'searchwp_live_search_base_styles', '__return_false' );
 *
 * There is a separate stylesheet that is also enqueued that applies the default
 * results theme (the visual styles) but you can disable that too by adding
 * the following to your theme's functions.php:
 *
 * wp_dequeue_style( 'searchwp-live-search' );
 *
 * You can use ~/searchwp-live-search/assets/styles/style.css as a guide to customize
 */
?>

<div class="rounded-xl py-2 grid grid-cols-1">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<?php
			$thumb = !!get_the_post_thumbnail_url($post) ?  get_the_post_thumbnail_url($post) : get_template_directory_uri() . '/assets/dist/images/placeholder.jpg';
			?>
			<?php $post_type = get_post_type_object(get_post_type()); ?>
			<div class="searchwp-live-search-result px-4 py-2 hover:bg-gray-100 hover:bg-opacity-60 group" role="option" id="" aria-selected="false">
				<a href="<?php echo esc_url(get_permalink()); ?>">
					<div class="flex space-x-4">
						<img class="block w-14 h-14 object-cover rounded-md group-hover:shadow-sm" src="<?php echo esc_url($thumb); ?>" alt="<?php the_title(); ?>">
						<div class="overflow-hidden">
							<h6 class="wil-line-clamp-2 text-base text-gray-800 mb-[2px] searchwp-live-search-result__title">
								<?php echo get_the_title($post); ?>
							</h6>
							<span class="text-xs text-gray-600 dark:text-gray-400 truncate flex items-center">
								<i class="las la-clock mr-[3px]"></i>
								<?php echo esc_html(date_i18n(get_option('date_format'), strtotime($post->post_date))); ?>
							</span>
						</div>
					</div>
				</a>
			</div>
		<?php endwhile; ?>

	<?php else : ?>
		<p class="searchwp-live-search-no-results text-gray-600 text-base py-12" role="option">
			<?php echo esc_html__('It looks like nothing was found at this location. Maybe try a search?', 'zimac'); ?>
		</p>
	<?php endif; ?>
</div>
