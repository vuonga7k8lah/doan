<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;
use HSSC\Illuminate\Helpers\StringHelper;

class BigUniqueHorizontalBoxItemSc
{
	public function __construct()
	{
		add_shortcode(HSBLOG2_SC_PREFIX . 'big_unique_horizontal_box_item', [$this, 'renderSc']);
	}

	/**
	 * @param array $aAtts
	 * @return string
	 */
	public function renderSc($aAtts = []): string
	{
		$aAtts = shortcode_atts(
			[
				'id'             => '1',
				'featured_image' => '',
				'category_name'  => '',
				'name'           => '',
				'created_at'     => '',
				'url'            => '#',
				'author_avatar'  => '',
				'author_name'    => '',
			],
			$aAtts
		);

		ob_start();
?>
		<div class="wil-post-card-2 rounded-4xl p-2 sm:p-4 pt-40 sm:pt-64 relative text-white flex justify-end bg-gray-400 w-full h-full">
			<?php if (!empty($aAtts['featured_image'])) : ?>
				<img alt="<?php echo esc_attr($aAtts['name']); ?>" class="absolute inset-0 w-full h-full object-cover rounded-4xl" src="<?php echo esc_url($aAtts['featured_image']); ?>">
			<?php endif; ?>
			<div class="absolute inset-0 rounded-4xl bg-gradient-to-t from-gray-900 opacity-50"></div>
			<div class="relative bg-white bg-opacity-20 wil-backdrop-filter-10px p-4 md:p-7 rounded-3xl md:flex items-center justify-between w-full space-y-4 md:space-y-0">
				<div class="md:pr-4">
					<?php echo App::get('CategoryBadgeSc')->renderSc([
						'name' => $aAtts['category_name'],
					]); ?>
					<h3 class="wil-line-clamp-3 text-2xl md:text-3xl my-3">
						<?php StringHelper::ksesHTML($aAtts['name']); ?>
					</h3>
					<?php
					echo App::get('ByAuthorSc')->renderSc([
						'meta'    		=> $aAtts['created_at'],
						'author_name' 	=> $aAtts['author_name'],
						'author_avatar' => $aAtts['author_avatar'],
						'avatar_size' 	=> 'w-7 h-7'
					]);
					?>
				</div>
				<span class="flex-shrink-0 bg-gray-900 bg-opacity-30 text-primary text-1.375rem rounded-3xl flex items-center justify-center h-10 md:h-16 md:w-16 p-2">
					<i class="las la-long-arrow-alt-right"></i>
				</span>
			</div>
			<?php if (!empty($aAtts['url'])) : ?>
				<a href="<?php echo esc_url($aAtts['url']); ?>" class="absolute inset-0">
					<span class="sr-only"><?php echo esc_html($aAtts['name']); ?></span>
				</a>
			<?php endif; ?>
		</div>
<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
