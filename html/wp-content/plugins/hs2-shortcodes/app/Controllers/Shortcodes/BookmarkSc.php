<?php


namespace HSSC\Controllers\Shortcodes;


use HSSC\Users\Models\BookmarkModel;

class BookmarkSc
{
	public function __construct()
	{
		add_shortcode(HSBLOG2_SC_PREFIX . 'bookmark', [$this, 'renderSc']);
	}

	public function renderSc($aAtts = []): string
	{
		if (empty($aAtts)) {
			return esc_html__('Missing Pass Parameter', 'hsblog2-shortcodes');
		}
		$aDataCover = [
			'post_id' => $aAtts['post_id'],
			'user_id' => $aAtts['user_id'],
		];
		$isLogged = is_user_logged_in();

		$status = !!BookmarkModel::isExist($aDataCover) ? BookmarkModel::get($aDataCover) : 'no';
		$class = ' stroke-2 h-5 w-5 p-1px dark:text-white ' . ($status === 'yes' ? 'text-gray-800' : 'text-gray-600');
		ob_start();
?>
		<div class="flex flex-col items-center justify-center bg-transparent rounded-xl w-14">
			<span class="uppercase text-xs text-gray-600 dark:text-red-200 font-bold">
				<?php echo esc_html__('SAVE', 'hsblog2-shortcodes'); ?>
			</span>
			<button class="wil-icon-save-post flex items-center justify-center z-10 relative" <?php echo esc_attr($isLogged ? null : 'data-open-modal=wil-modal-form-sign-in'); ?> <?php echo esc_attr(!$isLogged ? null : 'data-id=' . $aAtts['post_id'] . ''); ?> <?php echo esc_attr(!$isLogged ? null : 'data-saved=' . $status . ''); ?>>
				<svg class="<?php echo esc_attr($class); ?>" fill="<?php echo esc_attr($status === 'yes' ? "currentColor" : "none"); ?>" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
				</svg>
			</button>
		</div>
<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
