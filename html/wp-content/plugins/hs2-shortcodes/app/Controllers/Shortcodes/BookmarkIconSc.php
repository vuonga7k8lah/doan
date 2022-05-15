<?php

namespace HSSC\Controllers\Shortcodes;

class BookmarkIconSc
{
	public function __construct()
	{
		add_shortcode(HSBLOG2_SC_PREFIX . 'bookmark_icon_sc', [$this, 'renderSc']);
	}

	/**
	 * @param array
	 * @return string
	 */
	public function renderSc($aAtts = []): string
	{
		if (!$aAtts['is_saved'] || $aAtts['is_saved'] === 'no') {
			$aAtts = shortcode_atts(
				[
					'is_saved' => 'no',
					'id'       => '1',
					'color'    => 'text-gray-600 dark:text-white'
				],
				$aAtts
			);
		} else {
			$aAtts = shortcode_atts(
				[
					'is_saved' => 'no',
					'id'       => '1',
					'color'    => 'text-gray-800 dark:text-white'
				],
				$aAtts
			);
		}

		$class = ' stroke-2 h-[22px] w-[22px] p-1px ';
		if ($aAtts['color']) {
			$class .= '' . $aAtts['color'];
		}

		$isLogged = is_user_logged_in();
		ob_start();
?>
		<div class="wil-tooltip relative">
			<button class="wil-icon-save-post flex items-center justify-center z-10 relative" <?php echo esc_attr($isLogged ? null : 'data-open-modal=wil-modal-form-sign-in'); ?> <?php echo esc_attr(!$isLogged ? null : 'data-id=' . $aAtts['id'] . ''); ?> <?php echo esc_attr(!$isLogged ? null : 'data-saved=' . $aAtts['is_saved'] . ''); ?>>
				<svg class="<?php echo esc_attr($class); ?>" fill="<?php echo esc_attr($aAtts['is_saved'] === 'yes' ? "currentColor" : "none"); ?>" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
				</svg>
			</button>
			<div class="wil-tooltip__label absolute bottom-full -translate-x-2/4 left-2/4 transform text-white dark:text-gray-900 font-medium z-50 text-base p-3px">
				<div class="bg-gray-700 dark:bg-gray-300 py-1 px-10px rounded-md leading-5">
					<span>
						<?php ($aAtts['is_saved'] === 'yes') ? esc_html_e('Unsave', 'hsblog2-shortcodes') :
							esc_html_e('Save', 'hsblog2-shortcodes'); ?>
					</span>
				</div>
			</div>
		</div>
<?php
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}
