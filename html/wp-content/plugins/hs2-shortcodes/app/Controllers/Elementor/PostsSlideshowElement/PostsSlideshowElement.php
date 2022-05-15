<?php

namespace HSSC\Controllers\Elementor\PostsSlideshowElement;

use Elementor\Widget_Base;
use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Illuminate\Helpers\StringHelper;
use HSSC\Illuminate\Query\PostQuery\QueryBuilder;
use HSSC\Users\Controllers\UserCountViewsController;
use HSSC\Users\Models\UserModel;
use WP_Query;

class PostsSlideshowElement extends Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return HSBLOG2_SC_PREFIX . 'posts_slide_show_element';
    }

    /**
     * Get widget title.
     *
     * Retrieve widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return esc_html__('Posts Slideshow', 'hsblog2-shortcodes');
    }

    /**
     * Get widget icon.
     *
     * Retrieves widget icon.
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
     * Retrieve the list of categories the widget belongs to.
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
     * Get Array aArgs for WP_Query dependent $aSetting
     *
     * @param array $aSettings
     * @return array
     */
    protected function getArrayQueryArgs(array $aSettings): array
    {
        $aArgs = [];
        if ($aSettings['get_post_by'] === 'specified_posts') {
            $aArgs['post__in'] = $aSettings['specified_posts'];
            $aArgs['orderby'] = 'post__in';
            if (empty($aSettings['specified_posts'])) {
                $aArgs['posts_per_page'] = 1;
            }
        }
        if ($aSettings['get_post_by'] === 'categories') {
            $aArgs['order'] = $aSettings['order'];
            $aArgs['orderby'] = $aSettings['orderby'];
            if (!empty($aSettings['categories'])) {
                $aArgs['category_name'] = implode(',', $aSettings['categories']);
            }
            $aArgs['posts_per_page'] = $aSettings['posts_number'];
        }
        $aArgs = (new QueryBuilder)->setRawArgs($aArgs)->parseArgs()->getArgs();
        return $aArgs;
    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $aSettings = $this->get_settings_for_display();
        $oQuery = new WP_Query($this->getArrayQueryArgs($aSettings));
?>
        <section class="wil-section-slider-feature-post wil-glidejs-slide-fade">
            <?php if ($aSettings['section_title']) : ?>
                <header class="flex justify-between items-center mb-5 space-x-2">
                    <div class="wil-title-section font-bold text-xl lg:text-1.375rem flex items-center text-gray-900 dark:text-gray-100">
                        <a href="<?php echo esc_url($aSettings['title_url']); ?>" class="truncate">
                            <?php StringHelper::ksesHTML($aSettings['section_title']); ?>
                        </a>
                        <i class="las la-angle-right"></i>
                    </div>
                </header>
            <?php endif; ?>
            <div class="glide-fade relative">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        <?php if (!$oQuery->have_posts()) {
                            esc_html_e('Sorry! We found no post!', 'hsblog2-shortcodes');
                        }
                        if ($oQuery->have_posts()) :
                            while ($oQuery->have_posts()) {
                                $oQuery->the_post();
                                $oPost = $oQuery->post;
                                $ID = $oPost->ID;
                                $oCategory =  App::get('FunctionHelper')::getPostTermInfoWithNumberDetermined($ID);
                                // GET COUNTVIEWS
                                $countViews = UserModel::getCountViewByPostID($oPost->ID);

                                echo '<li class="glide__slide w-full flex-shrink-0">';
                                echo App::get('FullWidthVerticalBoxItemSc')->renderSc([
                                    'id'                => $ID,
                                    'name'              => $oPost->post_title,
                                    'featured_image'    => FunctionHelper::getPostFeaturedImage($ID, 'full'),
                                    'url'               => get_permalink($ID),
                                    'number_views'      => $countViews,
                                    'number_comments'   => $oPost->comment_count,
                                    'created_at'        => FunctionHelper::getDateFormat($oPost->post_date, get_option('date_format')),
                                    'category_url'      => $oCategory[0]['url'],
                                    'category_name'     =>  $oCategory[0]['name'],
                                    'author_avatar'     =>  UserModel::getUrlAvatarAuthor($oPost->post_author),
                                    'author_name'       => get_the_author_meta('display_name', $oPost->post_author),
                                    'author_url'        => get_the_author_meta('user_url', $oPost->post_author),
                                    'is_on_section_slider' => 'yes'
                                ]);
                                echo '</li>';
                            }
                            wp_reset_postdata();
                        endif;
                        ?>
                    </ul>
                </div>
                <div class="absolute bottom-5 right-4 lg:right-auto lg:left-0 mb-1 lg:bottom-11 z-10 px-5 lg:px-0">
                    <div class="inline-flex items-center text-gray-900 dark:text-gray-100 text-xl md:text-2xl" data-glide-el="controls">
                        <button class="-prev block h-11 w-11 rounded-full bg-white dark:bg-gray-900 mr-10px disabled:text-gray-400 dark:disabled:text-gray-600" data-glide-dir="<" disabled>
                            <i class="las la-angle-left"></i>
                        </button>
                        <button class="-next block h-11 w-11 rounded-full bg-white dark:bg-gray-900 disabled:text-gray-400 dark:disabled:text-gray-600" data-glide-dir=">">
                            <i class="las la-angle-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>
<?php
    }
}
