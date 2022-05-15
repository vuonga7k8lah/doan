<?php

namespace HSSC\Widgets\Controllers;

use WP_Term_Query;
use WP_Widget;

class MyWidgetCategories extends WP_Widget
{

	/**
	 * Sets up a new Categories widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct()
	{
		$widgetOps = array(
			'classname'                   => 'my_widget_categories',
			'description'                 => esc_html__('A list of categories.', 'hs2-shortcodes'),
			'customize_selective_refresh' => true,
		);
		parent::__construct('MyWidgetCategories', esc_html__(HSSC_WIDGET . 'Categories', 'hs2-shortcodes'), $widgetOps);
	}

	/**
	 *
	 * @param [type] $args
	 * @param [type] $instance
	 * @return void
	 */
	public function widget($args, $instance)
	{
		// ADD DEFAULT
		$instance =  array_merge([
			'number'	=> 5,
			'order'		=> "DESC",
			'orderby'	=> "name",
		], $instance);

		$defaultTitle = esc_html__('Categories', 'hs2-shortcodes');
		$title	= !empty($instance['title']) ? $instance['title'] : $defaultTitle;
		$title	= apply_filters('widget_title', $title, $instance, $this->id_base);

		$catArgs = array(
			'taxonomy'	=> 'category',
			'number'   	=>  $instance['number'],
			'order'   	=>  $instance['order'],
			'orderby'   =>  $instance['orderby'],
		);
		$theQuery = new WP_Term_Query($catArgs);

		echo $args['before_widget'];

		if ($title) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
?>
		<div class="grid grid-cols-2 gap-2">
			<?php foreach ($theQuery->get_terms() as $oTerm) :  ?>
				<?php zimac_render_category_card(['oTerm' => $oTerm]); ?>
			<?php endforeach; ?>
			<a href="<?php echo esc_url(home_url('/?s=&pageType=categories')); ?>" class="wil-cat-box-1 w-full relative rounded-2xl overflow-hidden bg-primary font-bold text-gray-900">
				<div class="pt-62.5% md:pt-56.25% lg:pt-53.8% h-0"></div>
				<div class="absolute inset-0 flex flex-col items-center justify-center ">
					<span><?php echo esc_html__('All Categories', 'hs2-shortcodes'); ?></span>
					<i class="las la-ellipsis-h text-2xl leading-none"></i>
				</div>
			</a>
		</div>

	<?php
		echo $args['after_widget'];
	}

	/**
	 *
	 * @param [type] $newInstance
	 * @param [type] $oldInstance
	 * @return void
	 */
	public function update($newInstance, $oldInstance)
	{
		// ADD DEFAULT
		$newInstance =  array_merge([
			'number'	=> 5,
			'order'		=> "DESC",
			'orderby'	=> "name",
		], $newInstance);

		$instance               = $oldInstance;
		$instance['title']      = sanitize_text_field($newInstance['title']);
		$instance['number']    	= (int) $newInstance['number'];
		$instance['order']    	= $newInstance['order'];
		$instance['orderby']    = $newInstance['orderby'];

		return $instance;
	}

	/**
	 * Outputs the settings form for the Categories widget.
	 * @param array $instance Current settings.
	 */
	public function form($instance)
	{
		// Defaults.
		$instance     = wp_parse_args((array) $instance, array('title' => ''));
		$number    = isset($instance['number']) ? absint($instance['number']) : 5;
		$orderBy    = isset($instance['orderby']) ? $instance['orderby'] : 'name';
		$order    = isset($instance['order']) ? $instance['order'] : 'ASC';
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo esc_html__('Title:', 'hs2-shortcodes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php echo esc_html__('Number of categories:', 'hs2-shortcodes'); ?></label>
			<input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php echo esc_html__('Order By:', 'hs2-shortcodes'); ?></label>
			<select class="tiny-text" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
				<option <?php selected($orderBy, 'name'); ?> value="name">
					<?php echo esc_html__('Name', 'hs2-shortcodes'); ?>
				</option>
				<option <?php selected($orderBy, 'count'); ?> value="count">
					<?php echo esc_html__('Count', 'hs2-shortcodes'); ?>
				</option>
				<option <?php selected($orderBy, 'slug'); ?> value="slug">
					<?php echo esc_html__('Slug', 'hs2-shortcodes'); ?>
				</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php echo esc_html__('Order:', 'hs2-shortcodes'); ?></label>
			<select class="tiny-text" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
				<option <?php selected($order, 'DESC'); ?> value="DESC">
					<?php echo esc_html__('DESC', 'hs2-shortcodes'); ?>
				</option>
				<option <?php selected($order, 'ASC'); ?> value="ASC">
					<?php echo esc_html__('ASC', 'hs2-shortcodes'); ?>
				</option>
			</select>
		</p>
<?php
	}
}
