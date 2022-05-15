<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;
use HSSC\Illuminate\Helpers\StringHelper;

class SimpleTextBoxItemSc
{
	public function __construct()
	{
		add_shortcode(HSBLOG2_SC_PREFIX . 'simple_text_box_item_sc', [$this, 'renderSc']);
	}

	/**
	 * @param $aAtts
	 * @return string
	 */
	public function renderSc($aAtts = []): string
	{
		$aAtts = shortcode_atts(
			[
				'index'             => '',
				'name'              => '',
				'url'               => '#',
				'number_views'    	=> '0',
				'number_comments' 	=> '0'
			],
			$aAtts
		);

		ob_start();
?>
		<a href="<?php echo esc_url($aAtts['url']); ?>" class="block wil-post-trend-1">
			<article class="bg-white dark:bg-gray-900 bg-opacity-60 border-2 border-gray-300 dark:border-gray-600 dark:bg-opacity-50 rounded-4xl py-5 px-8 w-full h-full">
				<?php if ($aAtts['index']) : ?>
					<h4 class="block text-gray-500 mb-10px">
						<?php echo esc_html($aAtts['index']); ?>
					</h4>
				<?php endif; ?>
				<?php if ($aAtts['name']) : ?>
					<h6 class="wil-line-clamp-2 text-gray-900 dark:text-gray-200 text-body font-bold mb-10px leading-snug">
						<?php StringHelper::ksesHTML($aAtts['name']); ?>
					</h6>
				<?php endif; ?>
				<?php echo App::get('BoxCardInfoSc')->renderSc([
					'number_views'    => $aAtts['number_views'],
					'number_comments' => $aAtts['number_comments'],
				]) ?>
			</article>
		</a>
<?php
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}
