<?php


namespace HSSC\Widgets\Controllers;


use ZIMAC\Helpers\Helpers;
use HSSC\Shared\ThemeOptions\ThemeOptionSkeleton;
use WP_Widget;

class SocialNetworkWidget extends WP_Widget
{
	private $aDef = [
		'title'       => 'Social',
		'description' => 'About Us Descriptions...'
	];

	public function __construct()
	{
		parent::__construct(
			'socialNetworkWidget',
			esc_html__(HSSC_WIDGET . 'About Us', 'hs2-shortcodes'),
			[
				'description' => esc_html__(HSSC_WIDGET . 'About us, socials Widget', 'hs2-shortcodes')
			]
		);
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $aInstance
	 * @return void
	 */
	public function form($aInstance)
	{
		$aInstance = wp_parse_args($aInstance, $this->aDef);
?>
		<div class="widget-group">
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
				<?php echo esc_html__('Title', 'hs2-shortcodes'); ?>
			</label>
			<input type="text" class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" value="<?php echo esc_attr($aInstance['title']); ?>">
		</div>

		<div class="widget-group">
			<label for="<?php echo esc_attr($this->get_field_id('description')); ?>">
				<?php echo esc_html__('Description', 'hs2-shortcodes'); ?>
			</label>
			<br>
			<textarea id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>" rows="5" style="width: 100%"><?php echo esc_textarea($aInstance['description']); ?></textarea>
		</div>
	<?php
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $aAtts
	 * @param [type] $aInstance
	 * @return void
	 */
	public function widget($aAtts, $aInstance)
	{
		$aInstance = wp_parse_args($aInstance, $this->aDef);

		$aSocials = [];
		$aSocialSettings =  ThemeOptionSkeleton::getField('socials_settings') ?? [];
		foreach ($aSocialSettings as $key => $value) {
			$aSocials[$key] = Helpers::getASocialFontClass($key, $value);
		}
	?>
		<?php echo $aAtts['before_widget']; ?>
		<!-- START -->
		<div class="wil-SocialNetworkWidget" style="color: inherit;">
			<h6 class="wil-SocialNetworkWidget__title wil-footer-widget-title text-base font-bold uppercase tracking-wider mb-5">
				<?php echo esc_html($aInstance['title']); ?>
			</h6>
			<div class="text-gray-500 text-body">
				<span class="block mb-5"><?php echo esc_html($aInstance['description']); ?></span>
				<?php if (!empty($aSocials)) : ?>
					<div class="flex items-center flex-wrap space-x-2 justify-start">
						<?php foreach ($aSocials as  $social =>  $aSocial) : ?>
							<?php if ($aSocial['href']) : ?>
								<a href="<?php echo esc_url($aSocial['href']); ?>" class="wil-SocialNetworkWidget__social-icon rounded-full flex items-center justify-center text-lg lg:w-11 w-8 lg:h-11 h-8 text-primary bg-white bg-opacity-5 wil-backdrop-filter-6px" rel="noopener noreferrer" target="_blank" title="<?php echo esc_attr($social); ?>">
									<i class="<?php echo esc_attr($aSocial['icon']); ?>"></i>
								</a>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<!-- END -->
		<?php echo $aAtts['after_widget']; ?>
<?php }

	/**
	 * Undocumented function
	 *
	 * @param [type] $aNewInstance
	 * @param [type] $aOldInstance
	 * @return void
	 */
	public function update($aNewInstance, $aOldInstance)
	{
		$aInstance = $aOldInstance;
		foreach ($aNewInstance as $key => $val) {
			$aInstance[$key] = strip_tags($val);
		}

		return $aInstance;
	}
}
