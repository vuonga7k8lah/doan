<?php

namespace HSSC\Controllers\Shortcodes;

/**
 * Class AvatarSc
 * @package HSSC\Controllers\Shortcodes
 */
class AvatarSc
{
	public function __construct()
	{
		add_shortcode(HSBLOG2_SC_PREFIX . 'avatar', [$this, 'renderSc']);
	}

	/**
	 * @param array $aAtts
	 * @return string
	 */
	public function renderSc($aAtts = []): string
	{
		$aAtts = shortcode_atts(
			[
				'extra_classes' => 'ring-2 ring-white',
				'size_classes'  => 'h-6 w-6',
				'radius'        => 'rounded-full',
				'src'           => '',
				'name'          => 'A'
			],
			$aAtts
		);

		$hasImgClass = empty($aAtts['src']) ? 'wil-avatar-no-img' : '';

		$className
			= "wil-avatar relative flex-shrink-0 inline-flex items-center justify-center overflow-hidden text-gray-100 uppercase font-bold bg-gray-200";
		if (!empty($aAtts['extra_classes'])) {
			$className .= " {$aAtts['extra_classes']}";
		}
		if (!empty($aAtts['radius'])) {
			$className .= " {$aAtts['radius']}";
		}
		if (!empty($aAtts['size_classes'])) {
			$className .= " {$aAtts['size_classes']}";
		}
		if (!empty($hasImgClass)) {
			$className .= " {$hasImgClass}";
		}

		ob_start();
		?>

        <div class="<?php echo esc_attr($className); ?>">
			<?php if (!empty($aAtts['src'])) : ?>
                <img alt="<?php echo esc_attr($aAtts['name']); ?>" class="absolute inset-0 w-full h-full object-cover"
                     src="<?php echo esc_url($aAtts['src']) ?>"/>
			<?php endif ?>
            <span class="wil-avatar__name uppercase">
                <?php echo esc_html(substr($aAtts['name'], 0, 1)); ?>
            </span>
        </div>


		<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
