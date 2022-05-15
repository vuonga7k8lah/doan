<?php

namespace HSSC\Controllers\Elementor\CategoriesBoxElement;

use \Elementor\Widget_Base;
use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Illuminate\Helpers\StringHelper;

/**
 * CategoriesBoxElement class
 */
class CategoriesBoxElement extends Widget_Base
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
		return 'categories_box_element';
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
		return esc_html__('Category Box Grid', 'hs2-shortcodes');
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
	public function get_categories(): array
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
	function getArrayQueryArgs(): array
	{
		$aSettings = $this->get_settings_for_display();
		$aArgs = [
			'taxonomy' 		=>  $aSettings['taxonomy_name'],
			'number' 		=> $aSettings['items_per_row'] * $aSettings['max_rows'],
			'orderby' 		=> $aSettings['orderby'],
		];
		if ($aSettings['specified_categories']) {
			$aArgs['include'] = $aSettings['specified_categories'];
			$aArgs['orderby'] = 'include';
		}
		if ($aSettings['specified_tags']) {
			$aArgs['include'] = $aSettings['specified_tags'];
			$aArgs['orderby'] = 'include';
		}
		return $aArgs;
	}

	/**
	 * Return 3 featured Image by termId
	 *
	 * @param integer $termId
	 * @return array array[name : string,img ?: string]
	 */
	function getThreeAuthorByTerm(int $termId): array
	{
		$posts = get_posts([
			'numberposts' 	=> 3,
			'category'		=> $termId
		]);
		$aAuthors = [];
		foreach ($posts  as $oPost) {
			$aAuthors[] = [
				'name' 	=> $oPost->post_title,
				'img' 	=> FunctionHelper::getPostFeaturedImage($oPost->ID, 'large'),
			];
		}
		return $aAuthors;
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
		$aTerms = get_terms($this->getArrayQueryArgs());
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

				<?php if (empty($aTerms)) {
					esc_html_e('Sorry! We found no term!', 'hs2-shortcodes');
				} else {
					foreach ($aTerms as $oTerm) {
						$numberPostsText = $oTerm->count . " " . App::get('FunctionHelper')::translatePluralText(
							esc_html__('Post', 'hs2-shortcodes'),
							esc_html__('Posts', 'hsblog2-shortcodes'),
							intval($oTerm->count)
						);
						echo App::get('CreativeHorizontalBoxItemSc')->renderSc([
							'id'             => $oTerm->term_id,
							'url'            => get_term_link($oTerm->term_id),
							'featured_image' => FunctionHelper::getTermFeaturedImage($oTerm->term_id),
							'name'           =>  $oTerm->name,
							'number_posts'   => $numberPostsText,
							'extra_items'    => $this->getThreeAuthorByTerm($oTerm->term_id)
						]);
					};
				}

				?>
			</div>
		</section>
<?php
	}
}
