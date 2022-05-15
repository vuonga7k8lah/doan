<?php


namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Users\Controllers\UserCountViewsController;
use HSSC\Users\Models\UserModel;

class NumberViewsSc
{
	public function __construct()
	{
		add_shortcode(HSBLOG2_SC_PREFIX . 'number_views', [$this, 'renderSc']);
	}

	/**
	 * @param array $aAtts
	 * @return string
	 */
	public function renderSc($aAtts = []): string
	{
		if (empty($aAtts)) {
			return esc_html__('Missing Pass Parameter', 'hsblog2-shortcodes');
		}
		$aAtts['ip'] = (new UserCountViewsController())->getClientIp();
		$viewCount = UserModel::getCountView([
			'ip_address' 	=>	$aAtts['ip'],
			'user_id'		=>	$aAtts['user_id'],
			'post_id'		=>	$aAtts['post_id']
		]);

		$viewTitle = App::get('FunctionHelper')::translatePluralText(
			esc_html__('View', 'hsblog2-shortcodes'),
			esc_html__('Views', 'hsblog2-shortcodes'),
			intval($viewCount)
		);

		ob_start();
?>
		<div class="flex flex-col items-center justify-center bg-gray-800 dark:bg-gray-900 rounded-xl w-14 h-14" title="<?php echo esc_attr($viewTitle); ?>">
			<i class="las la-arrow-up text-xl leading-none mb-1"></i>
			<span class="truncate leading-none">
				<?php echo esc_html($viewCount); ?>
			</span>
		</div>
<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
