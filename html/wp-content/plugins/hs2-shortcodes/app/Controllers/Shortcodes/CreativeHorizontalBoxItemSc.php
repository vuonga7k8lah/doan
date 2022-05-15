<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;
use HSSC\Illuminate\Helpers\StringHelper;

class CreativeHorizontalBoxItemSc
{
	public function __construct()
	{
		add_shortcode(HSBLOG2_SC_PREFIX . 'creative_horizontal_box_item', [$this, 'renderSc']);
	}

	/**
	 * @param $aAtts
	 * @return string
	 */
	public function renderSc($aAtts = []): string
	{
		$aAtts = shortcode_atts(
			[
				'id'             => '1',
				'url'            => '#',
				'featured_image' => '',
				'name'           => '',
				'number_posts'   => '',
				'extra_items'    => [] //array[name : string,img ?: string]
			],
			$aAtts
		);
		ob_start();
?>
		<a href="<?php echo esc_url($aAtts['url']); ?>" class="wil-cat-box-1 block" title="<?php echo esc_attr($aAtts['name']); ?>">
			<div class="relative pt-28 pb-3 px-3">
				<div class="absolute inset-0 bg-gray-400 rounded-4xl">
					<?php if ($aAtts['featured_image']) : ?>
						<img alt="<?php echo esc_attr($aAtts['name']); ?>" class="w-full h-full object-cover rounded-4xl" src="<?php echo esc_url($aAtts['featured_image']); ?>">
					<?php endif; ?>
				</div>
				<div class="relative flex items-center justify-between bg-primary bg-opacity-80 wil-backdrop-filter-6px rounded-full p-2 pl-4 text-gray-900">
					<?php if ($aAtts['name']) : ?>
						<span class="font-bold text-base mr-2 truncate">
							<?php StringHelper::ksesHTML($aAtts['name']); ?>
						</span>
					<?php endif; ?>
					<?php if ($aAtts['number_posts']) : ?>
						<div class="flex items-center font-medium text-xs">
							<span class="truncate flex-shrink-0"><?php echo esc_html($aAtts['number_posts']); ?></span>
						<?php endif; ?>
						<div class="flex -space-x-2 ml-1 pl-2px">
							<?php foreach ($aAtts['extra_items'] as $key => $aItem) {
								echo App::get('AvatarSc')->renderSC([
									'extra_classes' => 'font-bold bg-gray-200 ring-2 ring-white z-' . (5 - $key),
									'size_classes'  => 'w-8 h-8',
									'src'           => $aItem['img'],
									'name'          => $aItem['name']
								]);
							}; ?>
						</div>
						</div>
				</div>
			</div>
		</a>
<?php
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}
