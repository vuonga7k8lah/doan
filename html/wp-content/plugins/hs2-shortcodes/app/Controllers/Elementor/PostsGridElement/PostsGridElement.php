<?php

namespace HSSC\Controllers\Elementor\PostsGridElement;

use \Elementor\Widget_Base;
use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Illuminate\Helpers\StringHelper;
use HSSC\Illuminate\Query\PostQuery\QueryBuilder;
use HSSC\Users\Models\BookmarkModel;
use HSSC\Users\Models\UserModel;
use WP_Query;

class PostsGridElement extends Widget_Base
{
	/**
	 * Get widget name.
	 *
	 * Retrieve PostsGridElement widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_name()
	{
		return HSBLOG2_SC_PREFIX . 'posts_grid_shortcode';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve PostsGridElement widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title()
	{
		return esc_html__('Posts Grid', 'hsblog2-shortcodes');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve PostsGridElement widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_icon()
	{
		return 'fa fa-code';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the PostsGridElement widget belongs to.
	 *
	 * @return array Widget categories.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_categories()
	{
		return ['theme-elements'];
	}

	protected function _register_controls()
	{
		$aData = require_once plugin_dir_path(__FILE__) . '/config.php';
		foreach ($aData as $key => $aItems) {
			$this->start_controls_section(
				$key,
				$aItems['options']
			);
			foreach ($aItems['controls'] as $itemKey => $aValue) {
				$this->add_control(
					$itemKey,
					$aValue
				);
			};
			$this->end_controls_section();
		}
	}

	protected function getGridClassName(int $itemsPerRow, int $gap): string
	{
		$commonClass = FunctionHelper::getGridClassName((int) $itemsPerRow, (int) $gap);
		return $commonClass;
	}

	/**
	 * Render PostsGridElement widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render()
	{
		$aSettings = $this->get_settings_for_display();
		$aArgs = [
			'posts_per_page'      => $aSettings['items_per_row'] * $aSettings['max_row'],
		];
		if ($aSettings['get_post_by'] === 'categories') {
			if (!empty($aSettings['categories'])) {
				$aArgs['category_name'] = implode(',', $aSettings['categories']);
			}
			$aArgs['orderby'] = $aSettings['orderby'];
			$aArgs['order'] = $aSettings['order'];
		} else {
			$aArgs['post__in'] = $aSettings['specified_posts'];
		}

		$aArgs = (new QueryBuilder)->setRawArgs($aArgs)->parseArgs()->getArgs();
		$oQuery = new WP_Query($aArgs);

?>
		<section class="hsblog-post-grid-wrapper">
			<?php if ($aSettings['section_title']) : ?>
				<header class="flex justify-between items-center mb-5 space-x-2">
					<div class="wil-title-section font-bold text-xl lg:text-1.375rem flex items-center text-gray-900 dark:text-gray-100">
						<a href="<?php echo esc_url($aSettings['title_url']); ?>" class="truncate">
							<?php StringHelper::ksesHTML($aSettings['section_title']); ?>
						</a>
						<i class="las la-angle-right"></i>
					</div>
				</header>
			<?php endif; ?>
			<div class="<?php echo $this->getGridClassName((int)$aSettings['items_per_row'], (int)$aSettings['gap']); ?>">

				<?php
				if (!$oQuery->have_posts()) {
					esc_html_e('Sorry! We found no post!', 'hsblog2-shortcodes');
				} else {
					while ($oQuery->have_posts()) {
						$oQuery->the_post();
						$oPost = $oQuery->post;
						$id = $oPost->ID;
						$aCategory = wp_get_post_terms($id, 'category', ['number' => 1]);
						echo App::get('SimpleHorizontalBoxItemSc')->renderSc([
							'id'             => $id,
							'is_saved'       => BookmarkModel::get([
								'post_id' => $id,
								'user_id' => get_current_user_id()
							]),
							'name'           => $oPost->post_title,
							'category_name'  => !empty($aCategory) ? esc_html($aCategory[0]->name) : "",
							'author_name'    => get_the_author_meta('display_name'),
							'author_avatar'  => UserModel::getUrlAvatarAuthor($oPost->post_author),
							'created_At'     => FunctionHelper::getDateFormat($oPost->post_date),
							'featured_image' => FunctionHelper::getPostFeaturedImage($oPost->ID, $aSettings['featured_image_size']),
							'url'            => get_permalink($oPost->ID),
						]);
					}
					wp_reset_postdata();
				}
				?>
			</div>
		</section>
<?php
	}
}
