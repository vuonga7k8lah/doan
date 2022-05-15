<?php


namespace HSSC\Controllers\Shortcodes;


use HSSC\Helpers\App;
use HSSC\Shared\ThemeOptions\ThemeOptionSkeleton;

class ShareToSocialSc
{
	public function __construct()
	{
		add_shortcode(HSBLOG2_SC_PREFIX . 'share_to_social', [$this, 'renderSc']);
	}

	public function renderSc($aAtts = []): string
	{
		if (empty($aAtts)) {
			return esc_html__('Missing Pass Parameter', 'hsblog2-shortcodes');
		}
		ob_start();
?>
		<div class="flex flex-col items-center justify-center w-14">
			<div class="wil-dropdown relative inline-block text-left">
				<button class="wil-dropdown__btn flex focus:outline-none" type="button">
					<div class="flex flex-col items-center justify-center bg-transparent rounded-xl">
						<span class="uppercase text-xs text-gray-600 dark:text-red-200 font-bold">Share</span><i class="las la-share text-xl leading-none text-gray-900 dark:text-gray-100"></i>
					</div>
				</button>
				<div class="wil-dropdown__panel origin-top-right absolute mt-2 left-1/2 transform -translate-x-1/2 z-50 overflow-hidden text-sm text-gray-700 dark:text-gray-300 font-normal rounded-2xl hidden">
					<div class="flex flex-col justify-center space-y-1">

						<?php foreach (array_keys(App::get('aConfigFieldSocial')) as $key) :
							if (!empty(ThemeOptionSkeleton::getField($key))) :
						?>
								<a target="_blank" href="<?php echo esc_url(($this->getUrlSocial()[$key]) . $aAtts['post_url']); ?>" class="flex items-center justify-center bg-white dark:bg-gray-900 hover:bg-gray-200 dark:hover:bg-gray-900 w-8 h-8 rounded-full border border-gray-300 isClose">
									<i class="text-lg !leading-none lab la-<?php echo esc_attr($key); ?>"></i>
								</a>
						<?php endif;
						endforeach; ?>
					</div>
				</div>
			</div>
		</div>
<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	public function getUrlSocial(): array
	{
		return [
			'facebook'  => 'https://www.facebook.com/sharer/sharer.php?u=',
			'instagram' => 'https://www.instapaper.com/hello2?url=',
			'twitter'   => 'https://twitter.com/intent/tweet?url=',
			'pinterest' => 'http://pinterest.com/pin/create/button/?url=',
			'telegram'  => 'https://telegram.me/share/url?url=',
			'linkedin'  => 'https://www.linkedin.com/shareArticle?mini=true&url=',
			'whatsapp'  => 'https://api.whatsapp.com/send?text='
		];
	}
}
