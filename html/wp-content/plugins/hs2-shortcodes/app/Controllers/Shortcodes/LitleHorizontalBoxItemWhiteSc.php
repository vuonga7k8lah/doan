<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;
use HSSC\Illuminate\Helpers\StringHelper;

class LitleHorizontalBoxItemWhiteSc
{
	public function __construct()
	{
		add_shortcode(HSBLOG2_SC_PREFIX . 'litle_horizontal_box_item_white', [$this, 'renderSc']);
	}

	/**
	 * @param $aAtts
	 * @return string
	 */
	public function renderSc($aAtts = []): string
	{
		$aAtts = shortcode_atts(
			[
				'id'              => '1',
				'featured_image'  => '',
				'url'             => '#',
				'name'            => '',
				'number_views'    => '',
				'number_comments' => ''
			],
			$aAtts
		);

		ob_start();
?>
		<a href="<?php echo esc_url($aAtts['url']); ?>" class="block">
			<div class="wil-post-card-9 flex items-center text-gray-900 dark:text-gray-100">
				<div class="w-20 h-20 rounded-2.5xl mr-4 flex-shrink-0 bg-gray-400 relative overflow-hidden">
					<?php if ($aAtts['featured_image']) : ?>
						<img alt="<?php echo esc_attr($aAtts['name']); ?>" class="absolute inset-0 w-full h-full object-cover rounded-2.5xl" src="<?php echo esc_attr($aAtts['featured_image']); ?>">
					<?php endif; ?>
				</div>

				<div class="overflow-hidden">
					<?php if ($aAtts['name']) : ?>
						<h6 class="wil-line-clamp-2 underline mb-10px">
							<?php StringHelper::ksesHTML($aAtts['name']); ?>
						</h6>
					<?php endif; ?>
					<?php echo App::get('BoxCardInfoSc')->renderSc([
						'number_views'    => $aAtts['number_views'],
						'number_comments' => $aAtts['number_comments'],
					]); ?>
				</div>
			</div>
		</a>
<?php
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}
