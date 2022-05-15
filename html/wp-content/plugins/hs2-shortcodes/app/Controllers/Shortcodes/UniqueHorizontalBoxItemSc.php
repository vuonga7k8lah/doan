<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;
use HSSC\Illuminate\Helpers\StringHelper;

class UniqueHorizontalBoxItemSc
{
	public function __construct()
	{
		add_shortcode(HSBLOG2_SC_PREFIX . 'unique_horizontal_box_item_sc', [$this, 'renderSc']);
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
				'name'           => '',
				'created_day'    => '',
				'created_month'  => '',
				'url'            => '#',
				'author_avatar'  => '',
				'author_name'    => '',
				'featured_image' => '',
				'category_name'	 => '',
			],
			$aAtts
		);

		ob_start();
?>
		<div class="wil-post-card-1 relative flex flex-col sm:flex-row sm:items-center bg-white dark:bg-gray-900 dark:bg-opacity-40 rounded-4xl p-4 sm:p-7 space-y-3 sm:space-x-5 sm:space-y-0">
			<?php if (!empty($aAtts['featured_image'])) : ?>
				<div class="w-full sm:w-32 flex-shrink-0">
					<img alt="<?php echo esc_html($aAtts['name']); ?>" class="h-46 sm:h-24 w-full object-cover rounded-2.5xl" src="<?php echo esc_url($aAtts['featured_image']); ?>">
				</div>
			<?php endif; ?>
			<div class="text-gray-900 dark:text-gray-100 overflow-hidden">
				<?php if ($aAtts['name']) : ?>
					<h6 class="wil-line-clamp-2 mb-10px">
						<?php StringHelper::ksesHTML($aAtts['name']); ?>
					</h6>

				<?php endif; ?>
				<?php echo App::get('ByAuthorSc')->renderSc([
					'meta'        => $aAtts['category_name'],
					'author_name' => $aAtts['author_name'],
					'avatar_img'  => $aAtts['author_avatar'],
					'avatar_size' => 'w-7 h-7',
				]); ?>
			</div>
			<div class="flex-shrink-0 flex-grow hidden sm:flex justify-end">
				<div class="flex flex-col">
					<div class="bg-primary bg-opacity-60 rounded-2.5xl font-bold text-gray-900 py-2 px-5 text-center items-center justify-center inline-flex flex-col">
						<?php if (($aAtts['created_day'])) : ?>
							<span class="wil-date-badge__month text-1.375rem">
								<?php echo esc_html($aAtts['created_day']); ?>
							</span>
						<?php endif; ?>
						<?php if ($aAtts['created_month']) : ?>
							<span class="wil-date-badge__date text-[11px] uppercase leading-none"><?php echo esc_html($aAtts['created_month']); ?></span>
						<?php endif; ?>
					</div>
					<span class="bg-gray-800 text-primary text-xl rounded-full flex items-center justify-center mt-2 h-8 w-full p-2">
						<i class="las la-long-arrow-alt-right"></i>
					</span>
				</div>
			</div>
			<?php if ($aAtts['url']) : ?>
				<a href="<?php echo esc_url($aAtts['url']); ?>" class="absolute inset-0">
					<span class="sr-only">
						<?php echo esc_html($aAtts['name']); ?>
					</span>
				</a>
			<?php endif; ?>
		</div>
<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
