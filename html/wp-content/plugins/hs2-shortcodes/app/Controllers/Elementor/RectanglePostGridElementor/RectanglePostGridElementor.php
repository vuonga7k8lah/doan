<?php

namespace HSSC\Controllers\Elementor\RectanglePostGridElementor;

use \Elementor\Widget_Base;
use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Illuminate\Helpers\StringHelper;
use HSSC\Illuminate\Query\PostQuery\QueryBuilder;
use HSSC\Users\Models\UserModel;
use WP_Query;

/**
 * RectanglePostGridElementor class
 */
class RectanglePostGridElementor extends Widget_Base
{
	/**
	 * Get widget name.
	 *
	 * Retrieve widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'rectangle_post_grid';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title()
	{
		return esc_html__('Rectangle Post Grid', 'hs2-shortcodes');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'fa fa-code';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories()
	{
		return ['theme-elements'];
	}

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls()
	{
		$aSettings = require_once plugin_dir_path(__FILE__) . "config.php";
		foreach ($aSettings as $key => $aItems) {
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
		};
	}

	/**
	 * Return class math grid-cols dependent on $itemsPerRow and $gap
	 *
	 * @param integer $itemsPerRow
	 * @return string
	 */
	function getGridClassName(int $itemsPerRow, int $gap): string
	{
		$commonClass = FunctionHelper::getGridClassName((int) $itemsPerRow, (int) $gap);
		return $commonClass;
	}

	/**
	 * Get Array aArgs for WP_Query dependent $aSetting
	 *
	 * @param array $aSettings
	 * @return array
	 */
	function getArrayQueryArgs(array $aSettings): array
	{
		$aArgs = [
			'posts_per_page' 		=> $aSettings['items_per_row'] * $aSettings['max_rows'],
			'orderby' 				=> $aSettings['orderby'],
		];

		if ($aSettings['get_post_by'] === 'specified_posts') {
			$aArgs['post__in'] = $aSettings['specified_posts'];
			$aArgs['orderby'] = 'post__in';
		}

		if ($aSettings['get_post_by'] === 'categories') {
			$aArgs['order'] = $aSettings['order'];
			if (!empty($aSettings['categories'])) {
				$aArgs['category_name'] = implode(',', $aSettings['categories']);
			}
		}

		$aArgs = (new QueryBuilder)->setRawArgs($aArgs)->parseArgs()->getArgs();

		return $aArgs;
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render()
	{
		$aSettings = $this->get_settings_for_display();
		$oQuery = new WP_Query($this->getArrayQueryArgs($aSettings));
?>
		<section class="hsblog-rectangle-post-grid-wrapper">
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
			<div class="<?php echo esc_attr($this->getGridClassName($aSettings['items_per_row'], $aSettings['gap'])); ?>">
				<?php
				if (!$oQuery->have_posts()) {
					esc_html_e('Sorry! We found no post!', 'hs2-shortcodes');
				}
				if ($oQuery->have_posts()) :

					while ($oQuery->have_posts()) {
						$oQuery->the_post();
						$oPost = $oQuery->post;
						// GET COUNTVIEWS
						$countViews = UserModel::getCountViewByPostID($oPost->ID);

						echo App::get('SimpleVerticalBoxItemSc')->renderSc([
							'id'              => $oPost->ID,
							'name'            => $oPost->post_title,
							'featured_image'  => FunctionHelper::getPostFeaturedImage($oPost->ID, $aSettings['featured_image_size']),
							'url'             => get_permalink($oPost->ID),
							'number_views'    => $countViews,
							'number_comments' => $oPost->comment_count,
							'category_name'   => FunctionHelper::getPostTermInfoWithNumberDetermined($oPost->ID)[0]['name'],
							'author_avatar'   => UserModel::getUrlAvatarAuthor($oPost->post_author),
							'author_name'     => get_the_author_meta('display_name'),
						]);
					}
					wp_reset_postdata();
				endif;
				?>
			</div>
		</section>
<?php
	}
}
