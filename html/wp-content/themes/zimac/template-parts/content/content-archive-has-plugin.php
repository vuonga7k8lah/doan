<?php
// ONLY TAGS AND CATEGORY HERE

$description = get_the_archive_description();
$orderBy = [
	'title'         => esc_html__('Title DESC', 'zimac'),
	'comment_count' => esc_html__('Most Discussed', 'zimac'),
	'date'          => esc_html__('Most Recent', 'zimac'),
	'view_count'    => esc_html__('Most Viewed', 'zimac'),
];

$aTermArgs = [
	'taxonomy' => 'category',
	'number'   => 0
];
$oTermQuery = new WP_Term_Query($aTermArgs);
$aTermResults = $oTermQuery->get_terms() ?? [];
if (count($aTermResults) >= 6) {
	zimac_render_modal_categories(['termResults' => $aTermResults]);
}
?>
    <div class="wil-archive-page bg-gray-100 dark:bg-gray-800">
        <!-- HEADER WHEN ACTIVE HSSC -->
		<?php if (!empty($aTermResults)) : ?>
            <div class="py-10 bg-gray-900">
                <div class="wil-container container">
                    <div class="flex justify-between space-x-3 sm:space-x-5 xl:space-x-8">
                        <div class="flex-grow grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-5 xl:gap-8">
							<?php
							$_i = 0;
							foreach ($aTermResults as $oTerm) {
								if ($_i >= 6) {
									break;
								}
								zimac_render_category_card(['oTerm' => $oTerm]);
								$_i++;
							}
							?>
                        </div>
						<?php if (count($aTermResults) >= 6) : ?>
                            <div class="flex-shrink-0">
                                <a href="#"
                                   class="w-16 md:w-20 h-full flex flex-col items-center justify-center text-center font-bold text-xs lg:text-base text-primary rounded-2xl bg-white bg-opacity-10 focus:outline-none"
                                   title="<?php echo esc_attr__('View All Categories', 'zimac'); ?>"
                                   data-open-modal="wil-modal-list-categories">
                                <span>
                                    <?php echo esc_html__('All', 'zimac'); ?>
                                </span>
                                    <i class="las la-ellipsis-h"></i>
                                </a>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
            </div> <!-- END HEADER WHEN ACTIVE HSSC -->
		<?php endif; ?>
        <!-- CONTENT -->
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
                    <div class="wil-dropdown relative inline-block text-left">
                        <button class="wil-dropdown__btn flex focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-primary rounded-full"
                                type="button">
                            <span class="inline-flex items-center justify-between w-full px-4 py-2.5 bg-white text-sm
                            font-medium text-gray-700 hover:bg-gray-50 space-x-4 rounded-full min-w-[120px] md:min-w-[160px]">
                                <span class="text-base">
                                    <?php
                                    $intText = $orderBy[$_GET['orderBy'] ?? 'title'] ?? esc_html__('Sort by', 'zimac');
                                    echo esc_html($intText);
                                    ?>
                                </span><i class="las la-angle-down"></i>
                            </span>
                        </button>
                        <div class="wil-dropdown__panel hidden origin-top-right absolute right-0 mt-2 shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 w-52 rounded-md">
                            <div class="py-1" role="none">
								<?php
								foreach ($orderBy as $key => $value) : ?>
									<?php
									$isActive = (($key === 'title') && !($_GET['orderBy'] ?? "")) ||
										$key === ($_GET['orderBy'] ?? "");
									?>
                                    <a href="<?php echo esc_url(home_url(add_query_arg('orderBy', $key,
										$wp->request))); ?>"
                                       class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100 hover:text-gray-900 <?php echo esc_attr($isActive ?
										   "wil-nav-item__a--type3--active" : ""); ?>">
										<?php echo esc_html($value); ?>
                                    </a>
								<?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </header>
				<?php if (have_posts()) : ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 xl:gap-8 mb-13">
                        <!-- // Load posts loop. -->
						<?php while (have_posts()) {
							the_post();
							zimac_render_post_card(['post' => $post]);
						} ?>
                        <!-- // reset posts after loop. -->
						<?php wp_reset_postdata(); ?>
                    </div>

                    <!-- // Previous/next page navigation. -->
					<?php zimac_render_post_pagination(); ?>
				<?php else : ?>
                    <!-- // If no content, include the "No posts found" template. -->
					<?php zimac_render_content_none(); ?>
				<?php endif; ?>
            </div>
        </div> <!-- END CONTENT -->
    </div>
<?php get_footer();
