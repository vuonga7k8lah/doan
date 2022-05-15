<?php

namespace HSSC\Controllers\Elementor\ColorfulPostsFilterElement;

use \Elementor\Widget_Base;
use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Illuminate\Helpers\StringHelper;
use HSSC\Illuminate\Query\PostQuery\QueryBuilder;

class ColorfulPostsFilterElement extends Widget_Base
{
	private static $uid = "";
	private static $aPagState = [];

	/**
	 * Get widget name.
	 *
	 * Retrieve ColorfulPostsFilterElement widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_name()
	{
		return 'colorful_posts_filter_element';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve ColorfulPostsFilterElement widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title()
	{
		return esc_html__('Colorful Posts Filter', 'hs2-shortcodes');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve ColorfulPostsFilterElement widget icon.
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
	 * Register oEmbed widget controls.
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
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render()
	{
		self::$uid = uniqid(ZMAG_ACTION_PREFIX);
		$aSettings = $this->get_settings_for_display();

		$aArgs = [
			'posts_per_page' => $aSettings['posts_per_page'],
			'order'          => $aSettings['order'],
			'orderby'        => $aSettings['orderby']
		];
		if ($aSettings['get_post_by'] === 'categories') {
			if (!empty($aSettings['categories'])) {
				$aArgs['category_name'] = implode(',', $aSettings['categories']);
				// Convert for use old version
				$aSettings['categories'] = FunctionHelper::convertArrayCategoriesSlugToId($aSettings['categories']);
			}
		} else {
			$aArgs['post__in'] = $aSettings['specified_posts'];
		}
		$oQuery = new \WP_Query((new QueryBuilder())->setRawArgs($aArgs)->parseArgs()->getArgs());
		self::$aPagState = FunctionHelper::checkPaginationShowByPaged($oQuery->max_num_pages, 1);
?>
		<section class="wil-section-recent-post-01 relative" data-has-filter-api data-init-page="1" data-init-cat-filter="<?php echo esc_attr(FunctionHelper::encodeBase64($aSettings['categories'] ?? [])); ?>" data-init-orderby-filter="<?php echo esc_attr($aSettings['orderby']); ?>" data-block-uid="<?php echo esc_attr(self::$uid); ?>" data-block-type="ColorfulPostsFilterElement" data-a-settings=<?php echo esc_attr(FunctionHelper::encodeBase64(FunctionHelper::removeKeyOfElementorSettings($aSettings))); ?>>
			<div>
				<?php if (!!$aSettings['section_title'] && !empty($aSettings['order_by_options'])) : ?>
					<header class="flex justify-between items-center mb-5 space-x-2">
						<?php echo (new RenderHeaderFilter($aSettings, $this::$uid, $this::$aPagState))->renderTitle(); ?>
					</header>
				<?php endif; ?>

				<div>
					<?php if (!isset($aSettings['specified_posts'])) : ?>
						<?php echo (new RenderHeaderFilter($aSettings, $this::$uid, $this::$aPagState))->renderHeader(); ?>
					<?php endif; ?>
					<div class="wilSectionFilterContent relative transition" id="<?php echo esc_attr(self::$uid) ?>">
						<?php App::get('ColorfulPostsFilterElementContent')->renderContent($oQuery, $aSettings); ?>
					</div>
					<?php echo (new RenderHeaderFilter($aSettings, $this::$uid, $this::$aPagState))->renderNextPrev('block md:hidden mt-5'); ?>
				</div>
			</div>
		</section>
<?php
	}
}
