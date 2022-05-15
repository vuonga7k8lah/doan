<?php

namespace HSSC\Controllers\Elementor\AuthorsListElement;

use Elementor\Widget_Base;
use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Illuminate\Helpers\StringHelper;
use HSSC\Users\Models\UserModel;


/**
 * Class AuthorsListElement
 * @package HSSC\Controllers\Elementor\AuthorsListElement
 */
class AuthorsListElement extends Widget_Base
{

	/**
	 * Get widget name.
	 *
	 * Retrieve AuthorsListElement widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_name()
	{
		return HSBLOG2_SC_PREFIX . 'authors_list_shortcode';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve AuthorsListElement widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title()
	{
		return esc_html__('Authors List', 'hs2-shortcodes');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve AuthorsListElement widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_icon()
	{
		return 'fa fa-code';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the AuthorsListElement widget belongs to.
	 *
	 * @return array Widget categories.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_categories()
	{
		return ['theme-elements'];
	}

	function getGridClassName(int $itemsPerRow, int $gap): string
	{
		$commonClass = FunctionHelper::getGridClassName((int) $itemsPerRow, (int) $gap);
		return $commonClass;
	}

	/**
	 * Register AuthorsListElement widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls()
	{
		$aData = require_once plugin_dir_path(__FILE__) . '/config.php';
		foreach ($aData as $key => $aItems) {
			$this->start_controls_section(
				$key,
				$aItems['options']
			);
			foreach ($aItems['controls'] as $itemKey => $aValue) {
				$this->add_control(
					$itemKey,
					$aValue
				);
			};
			$this->end_controls_section();
		}
	}

	/**
	 * Render AuthorsListElement widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render()
	{
		$aSettings = $this->get_settings_for_display();
		$aArgs = [
			'number'   => $aSettings['items_per_row'] * $aSettings['max_row'],
			'role__in' => $aSettings['role'],
			'orderby'  => $aSettings['orderby'],
			'order'    => $aSettings['order']
		];
		$oQuery = new \WP_User_Query($aArgs);
?>
		<section class="<?php echo esc_attr(HSBLOG2_SC_PREFIX . 'AuthorsListElement'); ?>">
			<header class="max-w-screen-md mb-10">
				<h1 class="text-gray-900 dark:text-gray-100 mb-5" style="font-size:44px">
					<?php StringHelper::ksesHTML($aSettings['section_title']); ?>
				</h1>
				<span class="text-gray-700 dark:text-gray-300 text-body">
					<?php StringHelper::ksesHTML($aSettings['section_description']); ?>
				</span>
			</header>
			<div class="<?php echo $this->getGridClassName((int)$aSettings['items_per_row'], (int)$aSettings['gap']); ?>">
				<?php foreach ($oQuery->get_results() as $oUser) : 	?>
					<?php echo App::get('AuthorCardItemSc')->renderSc([
						'id'           => $oUser->ID,
						'name'         => $oUser->data->display_name,
						'number_posts' => count_user_posts($oUser->ID, 'post', true),
						'avatar'       => UserModel::getUrlAvatarAuthor($oUser->ID),
						'url'          => get_author_posts_url($oUser->ID),
						'is_following' => '',
					]); ?>
				<?php endforeach; ?>
			</div>
			<div class="flex items-center justify-center space-x-4 mt-10">
				<?php echo App::get('ButtonSc')->renderSc([
					"size_classes" 	=> "w-52 h-14",
					"name"         	=> $aSettings['button1_name'],
					"url"         	=> $aSettings['button1_url'],
					"bg_color"     	=> "bg-gray-200 dark:bg-gray-900",
				]); ?>
				<?php echo App::get('ButtonSc')->renderSc([
					"size_classes" 	=> "w-52 h-14",
					"text_color"    => "text-gray-900",
					"name"         	=> $aSettings['button2_name'],
					"url"         	=> $aSettings['button2_url'],
					"bg_color"     	=> "bg-primary",
				]); ?>
			</div>
		</section>
<?php
	}
}
