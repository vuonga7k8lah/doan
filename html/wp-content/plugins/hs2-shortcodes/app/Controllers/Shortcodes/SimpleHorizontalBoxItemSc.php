<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;
use HSSC\Illuminate\Helpers\StringHelper;

class SimpleHorizontalBoxItemSc
{
	public function __construct()
	{
		add_shortcode(HSBLOG2_SC_PREFIX . 'simple_horizontal_box_item', [$this, 'renderSc']);
	}

	/**
	 * @param $aAtts
	 * @return string
	 */
	public function renderSc($aAtts): string
	{
		$aAtts = shortcode_atts(
			[
				'id'             => '1',
				'is_saved'       => 'no',
				'name'           => '',
				'category_name'  => '',
				'author_name'    => '',
				'author_avatar'  => '',
				'created_At'           => '',
				'featured_image' => '',
				'url'            => '#'
			],
			$aAtts
		);

		ob_start();
?>
		<div class="wil-post-card-8 relative rounded-4xl bg-gray-400 overflow-hidden">
			<div class="pt-66.6% h-0">
				<?php if ($aAtts['featured_image']) : ?>
					<img alt="<?php echo esc_attr($aAtts['name']); ?>" class="absolute inset-0 object-cover w-full h-full" src="<?php echo esc_attr($aAtts['featured_image']); ?>">
				<?php endif; ?>
			</div>
			<div class="absolute top-4 left-4 right-4 flex justify-between items-center">
				<?php echo App::get('CategoryBadgeSc')->renderSc([
					'name'          => $aAtts['category_name'],
					'extra_classes' => ''
				]); ?>
			</div>
			<div class="absolute bottom-0 left-0 right-0 top-1/4 bg-gradient-to-t from-gray-900 z-0 opacity-70"></div>
			<div class="absolute bottom-0 left-0 right-0 p-4">
				<div class="flex items-center justify-between text-white space-x-3">
					<h6 class="wil-line-clamp-2 mb-10px">
						<?php StringHelper::ksesHTML($aAtts['name']); ?>
					</h6>
					<?php echo App::get('BookmarkIconSc')->renderSc([
						'is_saved' => $aAtts['is_saved'],
						'id'       => $aAtts['id'],
						'color'    => 'text-white'
					]); ?>
				</div>
				<div class="flex items-center font-medium xl:font-bold text-xs xl:text-base text-gray-100 bg-white bg-opacity-20 wil-backdrop-filter-10px rounded-full p-1">
					<?php echo App::get('AvatarSc')->renderSC([
						'size_classes'  => 'h-10 w-10',
						'src'           => $aAtts['author_avatar'],
						'name'          => $aAtts['author_name'],
						'extra_classes' => 'font-bold bg-gray-200'
					]); ?>
					<?php if ($aAtts['author_name']) : ?>
						<span class="ml-10px truncate">
							<span class="font-medium"><?php esc_html_e('By', 'hsblog2-shortcodes'); ?></span>
							<span><?php echo ' ' . esc_html($aAtts['author_name']) ?></span>
						</span>
					<?php endif; ?>
					<?php if ($aAtts['created_At']) : ?>
						<span class="mx-10px truncate hidden md:inline">•</span><span class="truncate hidden
                        md:inline"><?php echo esc_html($aAtts['created_At']); ?></span>
					<?php endif; ?>
				</div>
			</div>
			<?php if ($aAtts['url']) : ?>
				<a href="<?php echo esc_url($aAtts['url']); ?>" class="absolute inset-0"><span class="sr-only"><?php echo esc_url($aAtts['name']); ?></span></a>
			<?php endif; ?>
		</div>
<?php
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}
