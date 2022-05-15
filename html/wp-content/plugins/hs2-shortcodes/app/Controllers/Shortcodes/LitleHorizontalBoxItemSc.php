<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;
use HSSC\Illuminate\Helpers\StringHelper;

class LitleHorizontalBoxItemSc
{
	public function __construct()
	{
		add_shortcode(HSBLOG2_SC_PREFIX . 'litle_horizontal_box_item', [$this, 'renderSC']);
	}

	/**
	 * @param $aAtts
	 * @return string
	 */
	public function renderSC($aAtts = []): string
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
			<div class="wil-post-card-10 p-5 flex items-center text-white bg-white bg-opacity-5 wil-backdrop-filter-10px rounded-4xl">
				<?php if ($aAtts['featured_image']) : ?>
					<img alt="<?php echo esc_url($aAtts['name']); ?>" class="w-20 h-20 object-cover rounded-full mr-4 flex-shrink-0" src="<?php echo esc_url($aAtts['featured_image']); ?>">
				<?php endif; ?>
				<div class="block">
					<?php if ($aAtts['name']) : ?>
						<h6 class="wil-line-clamp-2 mb-10px">
							<?php StringHelper::ksesHTML($aAtts['name']); ?>
						</h6>
					<?php endif; ?>
					<?php echo App::get('BoxCardInfoSc')->renderSc([
						'extra_classes'   => 'text-gray-300',
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
