<?php

namespace HSSC\Controllers\Elementor\AmazingPostsShowcaseElement;

use \Elementor\Widget_Base;
use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Illuminate\Helpers\StringHelper;
use HSSC\Illuminate\Query\PostQuery\QueryBuilder;
use HSSC\Users\Models\BookmarkModel;
use HSSC\Users\Models\UserModel;

/**
 * Class AmazingPostsShowcaseElement
 * @package HSSC\Controllers\Elementor\AmazingPostsShowcaseElement
 */
class AmazingPostsShowcaseElement extends Widget_Base
{
	/**
	 * Get widget name.
	 *
	 * Retrieve AmazingPostsShowcaseElement widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_name()
	{
		return HSBLOG2_SC_PREFIX . 'amazing_posts_showcase_element_shortcode';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve AmazingPostsShowcaseElement widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title()
	{
		return esc_html__('Amazing Posts Showcase', 'hsblog2-shortcodes');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve AmazingPostsShowcaseElement widget icon.
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
	 * Retrieve the list of categories the AmazingPostsShowcaseElement widget belongs to.
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
	 * Undocumented function
	 *
	 * @param integer $gap
	 * @return  [ 'sm' => $smGap, 'lg' => $gap];
	 */
	function getGapNumberClassName(int $gap): array
	{

		if ($gap > 7) {
			$smGap = 5;
		} else {
			$smGap = $gap;
		}
		return [
			'sm' => $smGap,
			'lg' => $gap,
		];
	}


	/**
	 * Register AmazingPostsShowcaseElement widget controls.
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
	 * Undocumented function
	 *
	 * @param [array] $aPosts
	 * @return array [$aGridPosts1, $aGridPosts2, $aGridPosts3];
	 */
	function getArrayGridPosts(array $aPosts): array
	{
		if (empty($aPosts)) {
			return [];
		}
		$aGridPosts1 = array_filter($aPosts, function ($key) {
			return $key % 3 === 0;
		}, ARRAY_FILTER_USE_KEY);

		$aGridPosts2 = array_filter($aPosts, function ($key) {
			return $key % 3 === 1;
		}, ARRAY_FILTER_USE_KEY);

		$aGridPosts3 = array_filter($aPosts, function ($key) {
			return  $key % 3 === 2;
		}, ARRAY_FILTER_USE_KEY);

		if (count($aGridPosts3) >= 2 && count($aGridPosts3)  < count($aGridPosts2)) {
			$aGridPosts3[] = $aGridPosts2[array_key_last($aGridPosts2)];
			array_pop($aGridPosts2);
		}
		return [
			$aGridPosts1,
			$aGridPosts2,
			$aGridPosts3,
		];
	}

	/**
	 * Render AmazingPostsShowcaseElement widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render()
	{

		$aSettings = $this->get_settings_for_display();
		$aArgs = [];
		if ($aSettings['get_post_by'] === 'categories') {
			$aArgs['orderby'] = $aSettings['orderby'];
			$aArgs['order'] = $aSettings['order'];
			if (!empty($aSettings['categories'])) {
				$aArgs['category_name'] = implode(',', $aSettings['categories']);
			}
			$aArgs['posts_per_page'] =  $aSettings['posts_per_page'];
		} else {
			$aArgs['post__in'] = $aSettings['specified_posts'];
			$aArgs['orderby'] = 'post__in';
			$aArgs['posts_per_page'] =  empty($aSettings['specified_posts']) ? 8 : -1;
		}
		$aArgs = (new QueryBuilder)->setRawArgs($aArgs)->parseArgs()->getArgs();
		$oQuery = new \WP_Query($aArgs);
		$aPosts = [];
		if ($oQuery->have_posts()) {
			$aPosts = $oQuery->posts;
		}

		$aGridPosts = $this->getArrayGridPosts($aPosts);

		$smGap = $this->getGapNumberClassName((int)$aSettings['gap'])['sm'];
		$gap = $this->getGapNumberClassName((int)$aSettings['gap'])['lg'];
?>
		<div class="<?php echo esc_attr(HSBLOG2_SC_PREFIX . 'AmazingPostsShowcaseElement'); ?>">
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
			<?php if (empty($aPosts)) {
				esc_html_e('Sorry! We found no post!', 'hsblog2-shortcodes');
				return "";
			} ?>
			<div class="<?php echo esc_attr("space-y-6 sm:space-y-0 sm:grid sm:grid-cols-2 lg:grid-cols-4 gap-{$smGap} xl:gap-{$gap}"); ?>">

				<div class="<?php echo esc_attr("space-y-{$smGap} xl:space-y-{$gap}"); ?>">
					<?php
					$aGridPosts1 = $aGridPosts[0] ?? [];
					foreach ($aGridPosts1 as $oPost) {
						// GET COUNTVIEWS
						$countViews = UserModel::getCountViewByPostID($oPost->ID);

						echo App::get('UniqueVerticalBoxItemSc')->renderSc([
							'id'              => $oPost->ID,
							'is_saved'        => BookmarkModel::get([
								'post_id' => $oPost->ID,
								'user_id' => get_current_user_id()
							]),
							'created_at'      => FunctionHelper::getDateFormat($oPost->post_date),
							'name'            => $oPost->post_title,
							'featured_image'  => FunctionHelper::getPostFeaturedImage($oPost->ID, $aSettings['featured_image_size']),
							'url'             => get_permalink($oPost->ID),
							'number_views'    => $countViews,
							'number_comments' => get_comments_number($oPost->ID),
							'author_avatar'   => UserModel::getUrlAvatarAuthor($oPost->post_author),
							'author_name'     => get_the_author_meta('display_name', $oPost->post_author),
						]);
					}
					?>
				</div>
				<div class="<?php echo esc_attr("col-start-1 lg:col-start-2 row-start-1 col-span-2 space-y-{$smGap} xl:space-y-{$gap}"); ?> ">
					<?php
					$aGridPosts2 =  $aGridPosts[1] ?? [];

					foreach ($aGridPosts2 as $oPost) {
						$oCategory =  App::get('FunctionHelper')::getPostTermInfoWithNumberDetermined($oPost->ID);
						// GET COUNTVIEWS
						$countViews = UserModel::getCountViewByPostID($oPost->ID);
						echo App::get('BigUniqueVerticalBoxItemSc')->renderSc([
							'id'              	=> $oPost->ID,
							'is_saved'          => BookmarkModel::get([
								'post_id' => $oPost->ID,
								'user_id' => get_current_user_id()
							]),
							'created_at'      	=> FunctionHelper::getDateFormat($oPost->post_date),
							'name'            	=> $oPost->post_title,
							'desc'              => $oPost->post_excerpt,
							'featured_image'  	=> FunctionHelper::getPostFeaturedImage($oPost->ID, $aSettings['featured_image_size']),
							'url'             	=> get_permalink($oPost->ID),
							'number_views'      => $countViews,
							'number_comments' 	=> get_comments_number($oPost->ID),
							'author_avatar'   	=> UserModel::getUrlAvatarAuthor($oPost->post_author),
							'author_name'     	=> get_the_author_meta('display_name', $oPost->post_author),
							'category_name'     => $oCategory[0]['name'],
						]);
					}
					?>
				</div>
				<div class="<?php echo esc_attr("lg:col-end-5 space-y-{$smGap} xl:space-y-{$gap}"); ?>">
					<?php
					$aGridPosts3 =  $aGridPosts[2] ?? [];

					foreach ($aGridPosts3 as $oPost) {
						// GET COUNTVIEWS
						$countViews = UserModel::getCountViewByPostID($oPost->ID);

						echo App::get('UniqueVerticalBoxItemSc')->renderSc([
							'id'              => $oPost->ID,
							'is_saved'        => BookmarkModel::get([
								'post_id' => $oPost->ID,
								'user_id' => get_current_user_id()
							]),
							'created_at'      => FunctionHelper::getDateFormat($oPost->post_date),
							'name'            => $oPost->post_title,
							'featured_image'  => FunctionHelper::getPostFeaturedImage($oPost->ID, $aSettings['featured_image_size']),
							'url'             => get_permalink($oPost->ID),
							'number_views'    => $countViews,
							'number_comments' => $oPost->comment_count,
							'author_avatar'   => UserModel::getUrlAvatarAuthor($oPost->post_author),
							'author_name'     => get_the_author_meta('display_name', $oPost->post_author),
						]);
					}
					?>
				</div>
			</div>
		</div>
<?php
	}
}
