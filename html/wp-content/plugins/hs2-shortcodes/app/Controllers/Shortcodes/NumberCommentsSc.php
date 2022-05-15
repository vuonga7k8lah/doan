<?php


namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;

class NumberCommentsSc
{
	public function __construct()
	{
		add_shortcode(HSBLOG2_SC_PREFIX . 'number_comments', [$this, 'renderSc']);
	}

	/**
	 * @param array $aAtts
	 * @return string
	 */
	public function renderSc($aAtts = []): string
	{
		if (empty($aAtts)) {
			return esc_html__('Missing Pass Parameter', 'hs2-shortcodes');
		}

		$commentTitle = App::get('FunctionHelper')::translatePluralText(
			esc_html__('Comment', 'hs2-shortcodes'),
			esc_html__('Comments', 'hs2-shortcodes'),
			intval($aAtts['number_comments'])
		);

		ob_start();
		?>
        <div class="flex flex-col items-center justify-center bg-gray-800 dark:bg-gray-900 rounded-xl w-14 h-14"
             title="<?php echo esc_attr($commentTitle); ?>">
            <i class="las la-comment text-xl leading-none mb-1"></i>
            <span class="truncate leading-none"><?php echo esc_html($aAtts['number_comments']) ?></span>
        </div>
		<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
