<?php

namespace HSSC\Widgets\Controllers;

use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Shared\Elementor\CommonRegistration;
use HSSC\Users\Models\UserModel;
use WP_Query;
use WP_Widget;

class MyWidgetPostTabs extends WP_Widget
{

	/**
	 * Sets up a new Categories widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct()
	{
		$widgetOps = array(
			'classname'                   => 'my_widget_post_tabs',
			'description'                 => esc_html__('A block posts tabs.', 'hs2-shortcodes'),
			'customize_selective_refresh' => true,
		);
		parent::__construct('MyWidgetPostTabs', esc_html__(HSSC_WIDGET . 'Posts Tabs', 'hs2-shortcodes'), $widgetOps);
	}

	public function renderTabPanelItem(int $index, array $instance): string
	{
		$instance['label' . $index] = $instance['label' . $index] ?? 'tab';
		if (!$instance['label' . $index]) {
			return '';
		}

		// ADD DEFAULT
		$instance =  array_merge([
			'posts_per_page' . $index	=> 3,
			'order' . $index			=> "DESC",
			'orderby' . $index			=> "name",
			'posts' . $index			=> "",
			'tags' . $index				=> "",
			'categories' . $index		=> "",
		], $instance);

		$queryArgs = [
			'posts_per_page'   	=>  absint($instance['posts_per_page' . $index] ?? 3),
			'order'   			=>  $instance['order' . $index],
			'orderby'   		=>  $instance['orderby' . $index],
			'post__in'			=>  $instance['posts' . $index],
			'post_status' 		=> 'publish',
			'ignore_sticky_posts' => 1,
		];
		if (empty($instance['posts' . $index])) {
			$queryArgs['tag__in'] = $instance['tags' . $index];
		}
		if (empty($instance['tags']) && empty($instance['posts' . $index])) {
			$queryArgs['category__in'] = $instance['categories' . $index];
		}

		$oQuery = new WP_Query($queryArgs);

		if (is_wp_error($oQuery)) {
			return esc_html__('Something wrent error!', 'hs2-shortcodes');
		}
		ob_start();
?>
		<div class="glide__slide space-y-5 bg-white bg-opacity-60 dark:bg-gray-900 dark:bg-opacity-60 border-2 border-gray-200 dark:border-gray-800 rounded-4xl p-5">
			<?php
			if (!$oQuery->have_posts()) {
				esc_html_e('Sorry! We found no post!', 'hs2-shortcodes');
			}
			if ($oQuery->have_posts()) :
				while ($oQuery->have_posts()) {
					$oQuery->the_post();
					$oPost = $oQuery->post;
					$countViews = UserModel::getCountViewByPostID($oPost->ID);
					echo App::get('LitleHorizontalBoxItemWhiteSc')->renderSc([
						'id'              => $oPost->ID,
						'name'            => $oPost->post_title,
						'featured_image'  => FunctionHelper::getPostFeaturedImage($oPost->ID, 'thumbnail'),
						'url'             => get_permalink($oPost->ID),
						'number_views'    => $countViews,
						'number_comments' => $oPost->comment_count,
					]);
				}
			endif; 	?>
			<?php wp_reset_postdata(); ?>
		</div>
	<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	public function renderTabLabelItem(int $index, array $instance): string
	{
		$label =  $instance['label' . $index] ?? "Tab " . $index;
		if (!$label) {
			return '';
		}
		ob_start();
	?>
		<ul data-glide-dir="=<?php echo esc_attr(absint($index) - 1); ?>">
			<li class="wil-nav-item--type2">
				<a href="#<?php echo esc_attr($label); ?>" class="block text-center text-xs md:text-base px-3 md:px-5 py-2 rounded-full font-medium">
					<?php echo esc_html($label); ?>
				</a>
			</li>
		</ul>
	<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	public function widget($args, $instance)
	{
		echo $args['before_widget'];
	?>
		<div class="wil-sidebar-tab-post glide" data-glide-animationDuration="0">
			<!-- TAB TRIGGER -->
			<div class="grid grid-cols-3 list-none gap-2 bg-gray-200 dark:bg-gray-800 text rounded-full p-3px mb-10px text-gray-700 dark:text-gray-200" data-glide-el="controls[nav]">
				<?php echo $this->renderTabLabelItem(1, $instance); ?>
				<?php echo $this->renderTabLabelItem(2, $instance); ?>
				<?php echo $this->renderTabLabelItem(3, $instance); ?>
			</div>
			<!-- TAB PANEL -->
			<div class="glide__track" data-glide-el="track">
				<div class="glide__slides">
					<?php echo $this->renderTabPanelItem(1, $instance); ?>
					<?php echo $this->renderTabPanelItem(2, $instance); ?>
					<?php echo $this->renderTabPanelItem(3, $instance); ?>
				</div>
			</div>

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


		$instance	= $oldInstance;
		foreach ([1, 2, 3] as $key) {
			$instance =  array_merge([
				'posts_per_page' . $key		=> 3,
				'order' . $key				=> "DESC",
				'orderby' . $key			=> "name",
				'posts' . $key				=> "",
				'tags' . $key				=> "",
				'categories' . $key			=> "",
			], $instance);

			$instance['label' . $key]	=  sanitize_text_field($newInstance['label' . $key]);
			$instance['posts_per_page' . $key]	= (int) $newInstance['posts_per_page' . $key];
			$instance['order' . $key]	= $newInstance['order' . $key];
			$instance['orderby' . $key]	= $newInstance['orderby' . $key];
			//
			$instance['posts' . $key]	= esc_sql($newInstance['posts' . $key] ?? []);
			$instance['tags' . $key]	= esc_sql($newInstance['tags' . $key] ?? []);
			$instance['categories' . $key]	= esc_sql($newInstance['categories' . $key] ?? []);
		}
		return $instance;
	}

	public function renderTabSetting(int $indexx, array $instance): string
	{
        $index=$indexx?:1;
		$instance =  array_merge([
			'posts_per_page' . $index 		=> 3,
			'order' . $index				=> "DESC",
			'orderby' . $index				=> "ID",
			'posts' . $index				=> "",
			'tags' . $index					=> "",
			'categories' . $index			=> "",
		], $instance);

		// LABEL
		$labelID = $this->get_field_id('label' . $index);
		$labelName = $this->get_field_name('label' . $index);
		$label = $instance['label' . $index] ?? 'Tab ' . $index;
		// POST PER PAGE
		$numberID = $this->get_field_id('posts_per_page' . $index);
		$numberName = $this->get_field_name('posts_per_page' . $index);
		$number = absint($instance['posts_per_page' . $index] ?? 3);
		// ORDER BY
		$orderByID = $this->get_field_id('orderby' . $index);
		$orderByName = $this->get_field_name('orderby' . $index);
		$orderBy = $instance['orderby' . $index] ?? 'ID';
		// ORDER
		$orderID = $this->get_field_id('order' . $index);
		$orderName = $this->get_field_name('order' . $index);
		$order = $instance['order' . $index] ?? 'DESC';
		// POST SLUGS
		$specifiedPostFieldName = $this->get_field_name('posts' . $index);
		$aSpecifiedPostsFieldData = $instance['posts' . $index] ?? [];
		// TAG SLUGS
		$tagsFieldName = $this->get_field_name('tags' . $index);
		$aTagsFieldData = $instance['tags' . $index] ?? [];
		// CATEGORY SLUGS
		$categoriesFieldName = $this->get_field_name('categories' . $index);
		$aCategoriesFieldData = $instance['categories' . $index] ?? [];

		// GET POSTS DEFAULT
		$aDefaultPosts = [];
		if (!empty($aSpecifiedPostsFieldData)) {
			$aDefaultPosts = get_posts([
				'include' => $aSpecifiedPostsFieldData
			]);
		}
		// GET TAGS DEFAULT
		$aDefaultTags = [];
		if (!empty($aTagsFieldData)) {
			$aDefaultTags = get_terms([
				'taxonomy' => 'post_tag',
				'include' => $aTagsFieldData
			]) ?? [];
		}
		// GET CATEGORIES DEFAULT
		$aDefaultCategories = [];
		if (!empty($aCategoriesFieldData)) {
			$aDefaultCategories = get_terms([
				'taxonomy' => 'category',
				'include' => $aCategoriesFieldData
			]) ?? [];
		}

		// Something wrent error
		if (is_wp_error($aDefaultCategories) || is_wp_error($aDefaultTags)  || is_wp_error($aDefaultPosts)) {
			return esc_html__('Something wrent error!', 'hs2-shortcodes');
		}

		ob_start();
	?>
		<details>
			<summary style="font-size: 14px;  font-weight: 500; margin: 20px 0;">
				<?php echo esc_html__('Tab ' . $index . ' Fillter Settings', 'hs2-shortcodes'); ?></summary>
			<div style="padding-left: 20px; margin: 20px 0; border-left: 2px; border-style: solid; border-color: #135e96;">
				<p>
					<label for="<?php echo esc_html($labelID); ?>">
						<?php echo esc_html__('Label: (Levea empty if do not use this tab)', 'hs2-shortcodes'); ?></label>
					<input class="widefat" id="<?php echo esc_html($labelID); ?>" name="<?php echo esc_html($labelName); ?>" type="text" value="<?php echo esc_attr($label); ?>" />
				</p>
				<div style="display: flex; justify-content: space-between; margin: 10px 0;">
					<!-- NUMBER -->
					<p style="display: flex; flex-direction: column;">
						<label for="<?php echo esc_html($numberID); ?>">
							<?php echo esc_html__('Number Posts:', 'hsblog2-shortcodes'); ?></label>
						<input class="tiny-text" id="<?php echo esc_html($numberID); ?>" name="<?php echo esc_html($numberName); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
					</p>
					<!-- ORDER BY -->
					<p style="display: flex; flex-direction: column;">
						<label for="<?php echo esc_html($orderByID); ?>">
							<?php echo esc_html__('Order By:', 'hsblog2-shortcodes'); ?></label>
						<select class="tiny-text" id="<?php echo esc_html($orderByID); ?>" name="<?php echo esc_html($orderByName); ?>">
							<?php
							foreach (CommonRegistration::getOrderByOptions() as $key => $value) {
								echo '<option ' . selected($orderBy, $key) . ' value="' . esc_attr($key) . '">';
								echo esc_html($value);
								echo '</option>';
							}
							?>
						</select>
					</p>
					<!-- ORDER -->
					<p style="display: flex; flex-direction: column;">
						<label for="<?php echo esc_html($orderID); ?>"><?php echo esc_html__('Order:', 'hsblog2-shortcodes'); ?></label>
						<select class="tiny-text" id="<?php echo esc_html($orderID); ?>" name="<?php echo esc_html($orderName); ?>">
							<option <?php selected($order, 'DESC'); ?> value="DESC">
								<?php echo esc_html__('DESC', 'hsblog2-shortcodes'); ?>
							</option>
							<option <?php selected($order, 'ASC'); ?> value="ASC">
								<?php echo esc_html__('ASC', 'hsblog2-shortcodes'); ?>
							</option>
						</select>
					</p>

				</div>
				<!-- POSTs -->
				<p style="display: flex; flex-direction: column; margin-bottom: 10px;">
					<label>
						<?php echo esc_html__('Specified Posts:', 'hsblog2-shortcodes'); ?>
					</label>
					<select name="<?php echo esc_html($specifiedPostFieldName . '[]'); ?>" class="js-tuan-select2-ajax" multiple="multiple" data-ajax--url="<?php echo esc_url(rest_url('wp/v2/posts')); ?>" data-placeholder="Select an option" data-allow-clear="true">
						<?php
						foreach ($aDefaultPosts as $oPost) {
							echo '<option selected="selected" value="' . esc_attr($oPost->ID) . '">' . esc_html($oPost->post_title) . '</option>';
						}
						?>
					</select>
					<span style="color: #8c8f94;" class="help-block">
						<?php echo esc_html__('Chosse Specified Posts. If you enter this field, you do not need to setting the fields below', 'hsblog2-shortcodes'); ?>
					</span>
				</p>
				<!-- TAGs -->
				<p style="display: flex; flex-direction: column; margin-bottom: 10px;">
					<label><?php echo esc_html__('Tags:', 'hsblog2-shortcodes'); ?></label>
					<select name="<?php echo esc_html($tagsFieldName . '[]'); ?>" class="js-tuan-select2-ajax" multiple="multiple" data-ajax--url="<?php echo esc_url(rest_url('wp/v2/tags')); ?>" data-placeholder="Select tags." data-allow-clear="true">
						<?php
						foreach ($aDefaultTags as $oTag) {
							echo '<option selected="selected" value="' . esc_attr($oTag->term_id) . '">' . esc_html($oTag->name) . '</option>';
						}
						?>
					</select>
					<span style="color: #8c8f94;" class="help-block"><?php echo esc_html__('Display post by tags. Only enter this field or categories field below', 'hsblog2-shortcodes'); ?></span>
				</p>
				<!-- CATEGORIES -->
				<p style="display: flex; flex-direction: column; margin-bottom: 10px;">
					<label>
						<?php echo esc_html__('Categories:', 'hsblog2-shortcodes'); ?>
					</label>
					<select name="<?php echo esc_html($categoriesFieldName . '[]'); ?>" class="js-tuan-select2-ajax" multiple="multiple" data-ajax--url="<?php echo esc_url(rest_url('wp/v2/categories')); ?>" data-placeholder="Select an option" data-allow-clear="true">
						<?php
						foreach ($aDefaultCategories as $oCate) {
							echo '<option selected="selected" value="' . esc_attr($oCate->term_id) . '">' . esc_html($oCate->name) . '</option>';
						}
						?>
					</select>
					<span style="color: #8c8f94;" class="help-block"><?php echo esc_html__('Display post by categories. Only enter this field or tags field above', 'hsblog2-shortcodes'); ?></span>
				</p>
			</div>
		</details>
	<?php

		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	/**
	 * Outputs the settings form for the Categories widget.
	 * @param array $instance Current settings.
	 */
	public function form($instance)
	{
		$instance     = wp_parse_args((array) $instance, array('title' => ''));
	?>
		<div>
			<?php echo $this->renderTabSetting(1, $instance); ?>
			<?php echo $this->renderTabSetting(2, $instance); ?>
			<?php echo $this->renderTabSetting(3, $instance); ?>
		</div>
		<?php echo '<script src="' . HSSC_URL . '/assets/js/select2ForWidget.js' . '"></script>'; ?>

<?php
	}
}
