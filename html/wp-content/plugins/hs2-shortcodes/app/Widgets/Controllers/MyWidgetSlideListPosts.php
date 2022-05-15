<?php

namespace HSSC\Widgets\Controllers;

use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Shared\Elementor\CommonRegistration;
use HSSC\Users\Models\BookmarkModel;
use HSSC\Users\Models\UserModel;
use WP_Query;
use WP_Widget;

class MyWidgetSlideListPosts extends WP_Widget
{

	/**
	 * Sets up a new Categories widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct()
	{
		$widgetOps = array(
			'classname'                   => 'my_widget_slide_list_posts',
			'description'                 => esc_html__('A Slider list of posts.', 'hs2-shortcodes'),
			'customize_selective_refresh' => true,
		);
		parent::__construct('MyWidgetSlideListPosts', esc_html__(HSSC_WIDGET . 'Posts Slider', 'hs2-shortcodes'), $widgetOps);
	}

	public function renderSlidePanelItem(array $instance): string
	{
		$queryArgs = array(
			'posts_per_page'   	=>  absint($instance['posts_per_page'] ?? 3),
			'order'   			=>  $instance['order'] ?? '',
			'orderby'   		=>  $instance['orderby'] ?? '',
			'post__in'			=>  $instance['posts'] ?? '',
			'post_status' 		=> 'publish',
			'ignore_sticky_posts' => 1,
		);

		if (empty($instance['posts'])) {
			$queryArgs['tag__in'] = $instance['tags'] ?? '';
		}
		if (empty($instance['tags']) && empty($instance['posts'])) {
			$queryArgs['category__in'] = $instance['categories'] ?? '';
		}

		$oQuery = new WP_Query($queryArgs);
		ob_start();
?>

		<?php if (!$oQuery->have_posts()) {
			esc_html_e('Sorry! We found no post!', 'hsblog2-shortcodes');
		}
		if ($oQuery->have_posts()) :
			while ($oQuery->have_posts()) {
				$oQuery->the_post();
				$oPost = $oQuery->post;
				$countViews = UserModel::getCountViewByPostID($oPost->ID);
				echo '<div class="glide__slide">';
				echo App::get('UniqueVerticalBoxItemSc')->renderSc([
					'id'              => $oPost->ID,
					'is_saved'        => BookmarkModel::get([
						'post_id' => $oPost->ID,
						'user_id' => get_current_user_id()
					]),
					'created_at'      	=> FunctionHelper::getDateFormat($oPost->post_date),
					'name'            	=> $oPost->post_title,
					'featured_image'  	=> FunctionHelper::getPostFeaturedImage($oPost->ID, 'medium'),
					'url'             	=> get_permalink($oPost->ID),
					'number_views'    	=> $countViews,
					'number_comments' 	=> $oPost->comment_count,
					'author_avatar'   	=> UserModel::getUrlAvatarAuthor($oPost->post_author),
					'author_name'     	=> get_the_author_meta('display_name', $oPost->post_author),
					'box_added_classes'	=> 'rounded-2xl border-2 border-t-0 border-gray-300 dark:border-gray-600 rounded-t-none'
				]);
				echo '</div>';
			}
		endif;
		?>
		<?php wp_reset_postdata(); ?>

	<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	public function renderSlideHeaderItem(string $title, array $instance): string
	{
		ob_start();
	?>
		<header class="flex items-center justify-between mb-5 cursor-default">
			<div class="wil-title-section font-bold text-xl lg:text-1.375rem flex items-center text-gray-900 dark:text-gray-100">
				<?php if ($title) : ?>
					<span class="truncate"><?php echo $title; ?></span>
				<?php endif; ?>
			</div>
			<div class="wil-NextPrev glide__arrows inline-flex items-center justify-between bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-full text-xl md:text-2xl py-2 px-4 w-24 h-9 md:h-11" data-glide-el="controls">
				<button class="-prev block disabled:text-gray-400 dark:disabled:text-gray-600 focus:outline-none" data-glide-dir="<" disabled>
					<i class="las la-angle-left"></i></button>
				<button class="-next block disabled:text-gray-400 focus:outline-none" data-glide-dir=">">
					<i class="las la-angle-right"></i></button>
			</div>
		</header>
	<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	public function widget($args, $instance)
	{

		$instance = wp_parse_args($instance, [
			'posts_per_page' 	=> 3,
			'order'				=> "DESC",
			'orderby'			=> "name",
			'posts'				=> "",
			'tags'				=> "",
			'categories'		=> "",
		]);

		$defaultTitle = '';
		$title         = !empty($instance['title']) ? $instance['title'] : $defaultTitle;
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		echo $args['before_widget'];

	?>
		<div class="glide">
			<!-- SLIDE TRIGGER -->
			<?php echo $this->renderSlideHeaderItem($title, $instance); ?>
			<!-- SLIDE PANEL -->
			<div class="glide__track" data-glide-el="track">
				<div class="glide__slides">
					<?php echo $this->renderSlidePanelItem($instance); ?>
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

		$newInstance = wp_parse_args($newInstance, [
			'posts_per_page' 	=> 3,
			'order'				=> "DESC",
			'orderby'			=> "name",
			'posts'				=> "",
			'tags'				=> "",
			'categories'		=> "",
		]);

		$instance = $oldInstance;
		$instance['title'] = sanitize_text_field($newInstance['title']);
		$instance['posts_per_page']	= (int) $newInstance['posts_per_page'] ?? 3;
		$instance['order']	= $newInstance['order'];
		$instance['orderby'] = $newInstance['orderby'];
		//
		$instance['posts'] = esc_sql($newInstance['posts'] ?? []);
		$instance['tags'] = esc_sql($newInstance['tags'] ?? []);
		$instance['categories']	= esc_sql($newInstance['categories'] ?? []);
		return $instance;
	}

	public function renderTabSetting(array $instance): string
	{

		$instance = wp_parse_args($instance, [
			'posts_per_page' 	=> 3,
			'order'				=> "DESC",
			'orderby'			=> "name",
			'posts'				=> "",
			'tags'				=> "",
			'categories'		=> "",
		]);

		// POST PER PAGE
		$numberFieldID = $this->get_field_id('posts_per_page');
		$numberFieldName = $this->get_field_name('posts_per_page');
		$numberFieldData = absint($instance['posts_per_page'] ?? 3);
		// ORDER BY
		$orderByFieldID = $this->get_field_id('orderby');
		$orderByFieldName = $this->get_field_name('orderby');
		$orderByFieldData = $instance['orderby'] ?? 'ID';
		// ORDER
		$orderFieldID = $this->get_field_id('order');
		$orderFieldName = $this->get_field_name('order');
		$orderFieldData = $instance['order'] ?? 'DESC';
		// POST Specified Posts
		$specifiedPostFieldName = $this->get_field_name('posts');
		$aSpecifiedPostsFieldData = $instance['posts'] ?? [];
		// TAGs
		$tagsFieldName = $this->get_field_name('tags');
		$aTagsFieldData = $instance['tags'] ?? [];
		// CATEGORIES
		$categoriesFieldName = $this->get_field_name('categories');
		$aCategoriesFieldData = $instance['categories'] ?? [];

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
			return esc_html__('Something wrent error!', 'hsblog2-shortcodes');
		}

		ob_start();
	?>
		<p style="font-size: 14px; font-weight: 500; margin: 20px 0;">
			<?php echo esc_html__('Fillter Settings', 'hsblog2-shortcodes'); ?></p>
		<div style="padding-left: 20px; margin: 20px 0; border-left: 2px; border-style: solid; border-color: #135e96;">
			<div style="display: flex; justify-content: space-between; margin: 10px 0;">
				<!-- NUMBER -->
				<p style="display: flex; flex-direction: column;">
					<label for="<?php echo esc_html($numberFieldID); ?>">
						<?php echo esc_html__('Number Posts:', 'hsblog2-shortcodes'); ?></label>
					<input class="tiny-text" id="<?php echo esc_html($numberFieldID); ?>" name="<?php echo esc_html($numberFieldName); ?>" type="number" step="1" min="1" value="<?php echo $numberFieldData; ?>" size="3" />
				</p>
				<!-- ORDER BY -->
				<p style="display: flex; flex-direction: column;">
					<label for="<?php echo esc_html($orderByFieldID); ?>">
						<?php echo esc_html__('Order By:', 'hsblog2-shortcodes'); ?></label>
					<select class="tiny-text" id="<?php echo esc_html($orderByFieldID); ?>" name="<?php echo esc_html($orderByFieldName); ?>">
						<?php
						foreach (CommonRegistration::getOrderByOptions() as $key => $value) {
							echo '<option ' . selected($orderByFieldData, $key) . ' value="' . esc_attr($key) . '">';
							echo esc_html($value);
							echo '</option>';
						}
						?>
					</select>
				</p>
				<!-- ORDER -->
				<p style="display: flex; flex-direction: column;">
					<label for="<?php echo esc_html($orderFieldID); ?>"><?php echo esc_html__('Order:', 'hsblog2-shortcodes'); ?></label>
					<select class="tiny-text" id="<?php echo esc_html($orderFieldID); ?>" name="<?php echo esc_html($orderFieldName); ?>">
						<option <?php selected($orderFieldData, 'DESC'); ?> value="DESC">
							<?php echo esc_html__('DESC', 'hsblog2-shortcodes'); ?>
						</option>
						<option <?php selected($orderFieldData, 'ASC'); ?> value="ASC">
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
		$instance	= wp_parse_args((array) $instance, array('title' => ''));
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo esc_html__('Title:', 'hsblog2-shortcodes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<?php echo $this->renderTabSetting($instance); ?>
		<?php echo '<script src="' . HSSC_URL . '/assets/js/select2ForWidget.js' . '"></script>'; ?>

<?php
	}
}
