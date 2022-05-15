<?php

namespace HSSC\Controllers\Elementor\SimplePostsListElement;

use Elementor\Widget_Base;
use HSSC\Controllers\Elementor\ElementorWidgetTrait;
use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Illuminate\Query\PostQuery\QueryBuilder;
use HSSC\Users\Models\UserModel;

class SimplePostsListElement extends Widget_Base
{
	use ElementorWidgetTrait;

	private $aConfig;

	/**
	 * Get widget name.
	 *
	 * Retrieve SimplePostsListElement widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_name()
	{
		return HSBLOG2_SC_PREFIX . 'simple_posts_lists_shortcode';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve SimplePostsListElement widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title()
	{
		return esc_html__('Simple Posts Lists', 'hsblog2-shortcodes');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve SimplePostsListElement widget icon.
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
	 * Retrieve the list of categories the oEmbed widget belongs to.
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

	/**
	 * Register SimplePostsListElement widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	function getGridClassNameOldVersionHasGap(int $itemsPerRow, int $gap): string
	{
		$lg = $itemsPerRow - 1;
		if ($lg > 4) {
			$lg = 4;
		}
		$compare = $gap - 3;
		switch ($compare) {
			case $compare > 12:
				$lgGap = $compare;
				break;
			case ($compare === 0):
				$lgGap = 0;
				break;
			default:
				$lgGap = 1;
		}

		return esc_attr("space-y-6 sm:space-y-0 sm:grid sm:grid-cols-2 lg:grid-cols-{$lg} xl:grid-cols-{$itemsPerRow} gap-{$lgGap} xl:gap-{$gap}");
	}

	function getGridClassName(int $itemsPerRow, int $gap): string
	{
		$commonClass = FunctionHelper::getGridClassName((int) $itemsPerRow, (int) $gap);
		return $commonClass;
	}

	protected function _register_controls()
	{

		foreach ($this->getConfiguration('control') as $key => $aItems) {
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
	 * Render SimplePostsListElement widget output on the frontend
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
			$aArgs['orderby'] = 'post__in';
		}
		$aArgs = (new QueryBuilder)->setRawArgs($aArgs)->parseArgs()->getArgs();
		$oQuery = new \WP_Query($aArgs);
?>
		<section class="<?php echo esc_attr(HSBLOG2_SC_PREFIX . 'SimplePostsListElement') ?>">
			<div class="<?php echo $this->getGridClassName((int)$aSettings['items_per_row'], (int)$aSettings['gap']); ?>">
				<?php if (!$oQuery->have_posts()) {
					wp_reset_postdata();
					echo esc_html__('Sorry! We found no post!', 'hsblog2-shortcodes');
				}
				$i = 1;
				while ($oQuery->have_posts()) {
					$oQuery->the_post();
					$oPost = $oQuery->post;
					// GET COUNTVIEWS
					$countViews = UserModel::getCountViewByPostID($oPost->ID);
					echo App::get('SimpleTextBoxItemSc')->renderSc([
						'index'           => $i < 10 ? '0' . $i : $i,
						'name'            => $oPost->post_title,
						'url'             => get_permalink($oPost->ID),
						'number_views'    => $countViews,
						'number_comments' => $oPost->comment_count
					]);
					$i++;
				}
				wp_reset_postdata(); ?>
			</div>
		</section>
<?php
	}
}
