<?php

namespace HSSC\Controllers\Elementor\LookCoolPostsElement;

use \Elementor\Widget_Base;
use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Illuminate\Query\PostQuery\QueryBuilder;
use HSSC\Users\Controllers\UserCountViewsController;
use HSSC\Users\Models\UserModel;

class LookCoolPostsElement extends Widget_Base
{
	private $aConfig;
	/**
	 * Get widget name.
	 *
	 * Retrieve LookCoolPostsElement widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_name()
	{
		return HSBLOG2_SC_PREFIX . 'look_cool_posts_shortcode';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve LookCoolPostsElement widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title()
	{
		return esc_html__('Look Cool Posts', 'hs2-shortcodes');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve LookCoolPostsElement widget icon.
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
	 * Retrieve the list of categories the LookCoolPostsElement widget belongs to.
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

	function getGridClassName(int $itemsPerRow, int $gap): string
	{
		return FunctionHelper::getGridClassName((int) $itemsPerRow, (int) $gap);
	}

	/**
	 * Register LookCoolPostsElement widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
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

	/**
	 * Render LookCoolPostsElement widget output on the frontend.
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
			$aArgs['orderby'] = $aSettings['orderby'];
			$aArgs['order'] = $aSettings['order'];
			if (!empty($aSettings['categories'])) {
				$aArgs['category_name'] = implode(',', $aSettings['categories']);
			}
		} else {
			$aArgs['post__in'] = $aSettings['specified_posts'];
			$aArgs['orderby'] = 'post__in';
		}
		$aArgs = (new QueryBuilder)->setRawArgs($aArgs)->parseArgs()->getArgs();
		$oQuery = new \WP_Query($aArgs);
?>
		<div class="<?php echo $this->getGridClassName((int)$aSettings['items_per_row'], (int)$aSettings['gap']); ?>">
			<?php if (!$oQuery->have_posts()) {
				esc_html_e('Sorry! We found no post!', 'hs2-shortcodes');
			} else {
				$i = 1;
				while ($oQuery->have_posts()) {
					$oQuery->the_post();
					$oPost = $oQuery->post;

					// GET COUNTVIEWS
					$countViews = UserModel::getCountViewByPostID($oPost->ID);
					echo App::get('LitleHorizontalBoxItemSc')->renderSc([
						'id'              => $i,
						'featured_image'  => FunctionHelper::getPostFeaturedImage($oPost->ID),
						'name'            => $oPost->post_title,
						'url'             => get_permalink($oPost->ID),
						'number_views'    => $countViews,
						'number_comments' => $oPost->comment_count
					]);
					$i++;
				}
				wp_reset_postdata();
			}

			?>
		</div>
<?php
	}
}
