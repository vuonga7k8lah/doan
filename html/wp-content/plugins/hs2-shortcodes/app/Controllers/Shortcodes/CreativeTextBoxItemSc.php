<?php

namespace HSSC\Controllers\Shortcodes;


use HSSC\Helpers\App;
use HSSC\Illuminate\Helpers\StringHelper;

class CreativeTextBoxItemSc
{
	public function __construct()
	{
		add_shortcode(HSBLOG2_SC_PREFIX . 'creative_text_box_item_sc', [$this, 'renderSc']);
	}


	public function renderSc($aAtts = [], $content = ''): string
	{
		$aAtts = shortcode_atts(
			[
				'id'            => '1',
				'created_day'   => '',
				'created_month' => '',
				'name'          => '',
				'url'           => '#',
				'author_avatar' => '',
				'author_name'   => '',
				'category_name' => '',
				'is_saved'      => 'no'
			],
			$aAtts
		);

		ob_start();
?>

		<div class="wil-post-card-3 relative flex flex-col bg-white dark:bg-gray-900 dark:bg-opacity-40 p-5 rounded-4xl text-gray-900 dark:text-gray-100">
			<div class="space-y-3 mb-3">
				<?php if (!empty($aAtts['created_day']) && !empty($aAtts['created_month'])) : ?>
					<div class="bg-primary bg-opacity-60 rounded-2.5xl font-bold text-gray-900 py-2 px-5 text-center items-center justify-center inline-flex flex-col">
						<span class="wil-date-badge__month text-1.375rem"><?php echo esc_html($aAtts['created_day']); ?></span>
						<span class="wil-date-badge__date text-[11px] uppercase leading-none"><?php echo esc_html($aAtts['created_month']); ?></span>
					</div>
				<?php endif; ?>
				<?php if (!empty($aAtts['name'])) : ?>
					<h6 class="wil-line-clamp-2 mb-10px">
						<?php StringHelper::ksesHTML($aAtts['name']); ?>
					</h6>
				<?php endif; ?>
			</div>
			<div class="mt-auto flex justify-between items-center space-x-1">
				<div class="truncate">
					<?php echo App::get('ByAuthorSc')->renderSc([
						'meta'          => $aAtts['category_name'],
						'author_name'   => $aAtts['author_name'],
						'author_avatar' => $aAtts['author_avatar'],
						'avatar_size' 	=> 'h-7 w-7'
					]); ?>
				</div>
				<?php echo App::get('BookmarkIconSc')->renderSc([
					'is_saved' => $aAtts['is_saved'],
					'id'       => $aAtts['id']
				]); ?>
			</div>
			<a href="<?php echo esc_url($aAtts['url']); ?>" class="absolute inset-0 z-0">
				<span class="sr-only"><?php echo esc_html($aAtts['name']); ?></span></a>
		</div>
<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
