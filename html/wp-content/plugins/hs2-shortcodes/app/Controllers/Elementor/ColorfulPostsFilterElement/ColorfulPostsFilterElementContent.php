<?php

namespace HSSC\Controllers\Elementor\ColorfulPostsFilterElement;

use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Illuminate\Helpers\StringHelper;
use HSSC\Users\Models\BookmarkModel;
use HSSC\Users\Models\UserModel;

class ColorfulPostsFilterElementContent
{

	public $gap;

	public function __construct()
	{
		add_action(
			HSBLOG2_ELEMENTOR_FILLTER_COMMON . 'ColorfulPostsFilterElementContent',
			[
				$this, 'renderContent'
			],
			10,
			2
		);
	}

	function getGapClassName(): string
	{
		$gap = $this->gap;
		// GAP
		if ($gap > 5) {
			$gapSm = 5;
		} else {
			$gapSm = $gap;
		}

		return esc_attr(" gap-{$gapSm} xl:gap-{$gap} ");
	}




	/**
	 * @param $oQuery
	 * @param $aSettings
	 * @return void
	 */
	public function renderContent($oQuery, $aSettings)
	{
		$i = 0;
		if (!$oQuery->have_posts()) {
			esc_html_e('Sorry! We found no post!', 'hs2-shortcodes');
			return '';
		}
		$this->gap = $aSettings['gap'];

		ob_start();

		echo '<div class="grid grid-cols-12' . esc_attr($this->getGapClassName()) . '">';

		while ($oQuery->have_posts()) {
			$oQuery->the_post();

			if ($i < 3) {
				$this->firstBlock($oQuery->post, $i === 0, $i === 2 || $i >= count($oQuery->posts) - 1);
			} else if ($i === 3) {
				$this->secondBlock($oQuery->post);
			} else {
				$this->thirdBlock($oQuery->post, $i === 4, $i >= count($oQuery->posts) - 1);
			}

			$i++;
		}

		echo '</div>';

		wp_reset_postdata();

		$content = ob_get_contents();
		ob_end_clean();
		echo $content;
	}




	/**
	 * @param $oPost
	 * @param $i
	 */
	public function firstBlock($oPost, $isFisrt, $isLast)
	{
		if ($isFisrt) {
			$gapClass = esc_attr($this->getGapClassName());
			echo '<div class="col-start-1 col-span-12 lg:col-span-6 xl:col-span-5 grid grid-cols-1 ' . $gapClass . '">';
		}
		$aCategory = wp_get_post_terms($oPost->ID, 'category', ['number' => 1]);
		echo App::get('UniqueHorizontalBoxItemSc')->renderSc([
			'id'             => $oPost->ID,
			'name'           => $oPost->post_title,
			'created_day'    => FunctionHelper::getDateFormat($oPost->post_date, 'd'),
			'created_month'  => FunctionHelper::getDateFormat($oPost->post_date, 'M'),
			'url'            => get_permalink($oPost->ID),
			'author_avatar'  => UserModel::getUrlAvatarAuthor($oPost->post_author),
			'author_name'    => get_the_author_meta('display_name'),
			'featured_image' => FunctionHelper::getPostFeaturedImage($oPost->ID, 'large'),
			'category_name'  => !empty($aCategory) ? esc_html($aCategory[0]->name) : "",
		]);
		if ($isLast) {
			echo '</div>';
		}
	}

	/**
	 * @param $oPost
	 */

	public function secondBlock($oPost)
	{
?>
		<div class="col-end-13 col-span-12 lg:col-span-6 xl:col-span-7">
			<?php
			$aCategory = wp_get_post_terms($oPost->ID, 'category', ['number' => 1]);
			?>
			<div class="wil-post-card-2 relative rounded-4xl p-2 sm:p-4 pt-40 sm:pt-64 text-white flex justify-end bg-gray-400 w-full h-full">

				<img alt="<?php echo esc_attr($oPost->post_title); ?>" class="absolute inset-0 w-full h-full object-cover rounded-4xl" src="<?php echo esc_attr(FunctionHelper::getPostFeaturedImage($oPost->ID, 'large')); ?>" />

				<div class="absolute inset-0 rounded-4xl bg-gradient-to-t from-gray-900 opacity-50"></div>
				<div class="md:min-w-0 min-h-[30vh]"></div>
				<div class="absolute bottom-4 left-4 right-4 bg-white bg-opacity-20 wil-backdrop-filter-10px p-4 md:p-7 rounded-3xl md:flex
                items-center space-y-4 md:space-y-0 justify-between z-1">
					<div class="md:pr-4">
						<a href="<?php echo esc_url(get_permalink($oPost->ID)); ?>" class="inline-flex items-center justify-center px-3.5 text-gray-900 bg-primary font-medium rounded-3xl leading-tight py-2 border-2 border-primary text-xs">
							<?php echo esc_html(!empty($aCategory) ? esc_html($aCategory[0]->name) : ""); ?>
						</a>
						<h3 class="wil-line-clamp-3 text-2xl md:text-3xl my-3"><?php StringHelper::ksesHTML(get_the_title($oPost->ID)); ?></h3>
						<?php echo App::get('ByAuthorSc')->renderSc([
							'text_classes'  => 'text-white xl:text-base',
							'avatar_size'   => 'w-7 h-7',
							'meta'          => FunctionHelper::getDateFormat($oPost->post_date),
							'author_name'   => get_the_author_meta('display_name'),
							'author_avatar' => UserModel::getUrlAvatarAuthor($oPost->post_author),
						]) ?>
					</div>
					<span class="flex-shrink-0 bg-gray-900 bg-opacity-30 text-primary text-1.375rem rounded-3xl flex items-center justify-center h-10 md:h-16 md:w-16 p-2">
						<i class="las la-long-arrow-alt-right"></i>
					</span>
				</div>
				<a href="<?php echo esc_url(get_permalink($oPost->ID)); ?>" class="absolute inset-0 z-2">
					<span class="sr-only">
						<?php StringHelper::ksesHTML(get_the_title($oPost->ID)); ?>
					</span>
				</a>
			</div>
		</div>
<?php
	}

	/**
	 * @param $oPost
	 * @param $i
	 */
	public function thirdBlock($oPost, $isFisrt = false, $isLast = false)
	{

		if ($isFisrt) {
			$gapClass = esc_attr($this->getGapClassName());
			echo ' <div class="col-start-1 col-span-12">
            <div class="w-full h-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 ' . $gapClass . '">';
		}
		$aCategory = wp_get_post_terms($oPost->ID, 'category', ['number' => 1]);
		echo App::get('CreativeTextBoxItemSc')->renderSc([
			'id'            => $oPost->ID,
			'created_day'   => FunctionHelper::getDateFormat($oPost->post_date, 'd'),
			'created_month' => FunctionHelper::getDateFormat($oPost->post_date, 'M'),
			'name'          => $oPost->post_title,
			'url'           => get_permalink($oPost->ID),
			'author_avatar' => UserModel::getUrlAvatarAuthor($oPost->post_author),
			'author_name'   => get_the_author_meta('display_name'),
			'category_name' => !empty($aCategory) ? esc_html($aCategory[0]->name) : "",
			'is_saved'      => BookmarkModel::get([
				'post_id' => $oPost->ID,
				'user_id' => get_current_user_id()
			]),
		]);
		if ($isLast) {
			echo ' </div>  </div> ';
		}
	}
}
