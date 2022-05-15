<?php

namespace HSSC\Widgets\Controllers;

use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Users\Models\UserModel;
use WP_Query;
use WP_Widget;

class MyWidgetRecentPosts extends WP_Widget
{

	public function __construct()
	{
		$aWidgetOps = array(
			'classname'                   => 'my_widget_recent_entries',
			'description'                 => esc_html__('Your site&#8217;s most recent Posts.', 'hs2-shortcodes'),
			'customize_selective_refresh' => true,
		);
		parent::__construct('MyWidgetRecentPosts', esc_html__(HSSC_WIDGET . 'Recent Posts', 'hs2-shortcodes'), $aWidgetOps);
	}

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget($args, $instance)
	{
		if (!isset($args['widget_id'])) {
			$args['widget_id'] = $this->id;
		}

		$defaultTitle = "";
		$title = (!empty($instance['title'])) ? $instance['title'] : $defaultTitle;

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		$number = (!empty($instance['number'])) ? absint($instance['number']) : 3;
		$itemPerRows = (!empty($instance['item_per_rows'])) ? absint($instance['item_per_rows']) : 3;
		if (!$number) {
			$number = 3;
		}
		if (!$itemPerRows) {
			$itemPerRows = 3;
		}

		$r = new WP_Query(
			/**
			 * Filters the arguments for the Recent Posts widget.
			 *
			 * @param array $args     An array of arguments used to retrieve the recent posts.
			 * @param array $instance Array of settings for the current widget.
			 */
			apply_filters(
				'widget_posts_args',
				array(
					'posts_per_page'      => $number,
					'no_found_rows'       => true,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
				),
				$instance
			)
		);

		if (!$r->have_posts()) {
			return;
		}
?>

		<?php echo $args['before_widget']; ?>

		<?php
		if ($title) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$format = current_theme_supports('html5', 'navigation-widgets') ? 'html5' : 'xhtml';

		/** This filter is documented in wp-includes/widgets/class-wp-nav-menu-widget.php */
		$format = apply_filters('navigation_widgets_format', $format);

		if ('html5' === $format) {
			// The title may be filtered: Strip out HTML and make sure the aria-label is never empty.
			$title      = trim(strip_tags($title));
			$ariaLabel = $title ? $title : $defaultTitle;
			echo '<nav role="navigation" aria-label="' . esc_attr($ariaLabel) . '">';
		}

		$mainClass = '';
		switch ($itemPerRows) {
			case '1':
				$mainClass = 'lg:grid-cols-1';
				break;
			case '2':
				$mainClass = 'lg:grid-cols-2';
				break;
			case '3':
				$mainClass = 'lg:grid-cols-3';
				break;
			case '4':
				$mainClass = 'lg:grid-cols-4';
				break;
			case '5':
				$mainClass = 'lg:grid-cols-5';
				break;
			default:
				$mainClass = 'lg:grid-cols-3';
				break;
		}

		?>

		<div class="grid grid-cols-1 gap-5 xl:gap-8 <?php echo esc_attr($mainClass); ?>">
			<?php foreach ($r->posts as $oPost) : ?>
				<?php
				$countViews = UserModel::getCountViewByPostID($oPost->ID);
				echo App::get('LitleHorizontalBoxItemSc')->renderSc([
					'id'              => $oPost->ID,
					'name'            => $oPost->post_title,
					'featured_image'  => FunctionHelper::getPostFeaturedImage($oPost->ID, 'medium'),
					'url'             => get_permalink($oPost->ID),
					'number_views'    => $countViews,
					'number_comments' => $oPost->comment_count,
				]);
				?>
			<?php endforeach; ?>
		</div>

		<?php
		if ('html5' === $format) {
			echo '</nav>';
		}

		echo $args['after_widget'];
	}

	/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @param array $newInstance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $oldInstance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update($newInstance, $oldInstance)
	{
		$instance              = $oldInstance;
		$instance['title']     = sanitize_text_field($newInstance['title']);
		$instance['number']    = (int) $newInstance['number'] ?? 3;
		$instance['item_per_rows']    = (int) $newInstance['item_per_rows'] ?? 3;
		return $instance;
	}

	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @param array $instance Current settings.
	 */
	public function form($instance)
	{
		$title     = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number    = isset($instance['number']) ? absint($instance['number']) : 3;
		$itemPerRows    = isset($instance['item_per_rows']) ? absint($instance['item_per_rows']) : 3;
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo esc_html__('Title:', 'hs2-shortcodes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php echo esc_html__('Number of posts:', 'hs2-shortcodes'); ?></label>
			<input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('item_per_rows'); ?>"><?php echo esc_html__('Items per row:', 'hsblog2-shortcodes'); ?></label>
			<input class="tiny-text" id="<?php echo $this->get_field_id('item_per_rows'); ?>" name="<?php echo $this->get_field_name('item_per_rows'); ?>" type="number" step="1" min="1" max="6" value="<?php echo $itemPerRows; ?>" size="3" />
		</p>
<?php
	}
}
