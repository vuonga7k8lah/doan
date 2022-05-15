<?php

namespace HSSC\Controllers\Elementor\PostsTabElement;

use \Elementor\Widget_Base;
use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Illuminate\Helpers\StringHelper;
use HSSC\Illuminate\Query\PostQuery\QueryBuilder;
use HSSC\Users\Controllers\UserCountViewsController;
use HSSC\Users\Models\UserModel;
use WP_Query;

/**
 * PostsTabElement class
 */
class PostsTabElement extends Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'posts_tab';
    }

    /**
     * Get widget title.
     *
     * Retrieve widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Posts Tabs', 'hsblog2-shortcodes');
    }

    /**
     * Get widget icon.
     *
     * Retrieve widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
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
     * @since 1.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['theme-elements'];
    }

    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls()
    {
        $aSettings = require_once plugin_dir_path(__FILE__) . "config.php";

        foreach ($aSettings as $key => $aItems) {
            $this->start_controls_section(
                $key,
                $aItems['options']
            );

            // Register Repeater control for tabs
            if (isset($aItems['repeaterControls']) && !empty($aItems['repeaterControls'])) {
                $repeater = new \Elementor\Repeater();
                foreach ($aItems['repeaterControls'] as $itemKey => $aValue) {
                    $repeater->add_control(
                        $itemKey,
                        $aValue
                    );
                };
            }
            foreach ($aItems['controls'] as $itemKey => $aValue) {
                if ($aValue['type'] === \Elementor\Controls_Manager::REPEATER) {
                    $aValue =  array_merge($aValue, ['fields'    => $repeater->get_controls()]);
                }
                $this->add_control(
                    $itemKey,
                    $aValue
                );
            };

            $this->end_controls_section();
        };
    }

    /**
     * Return class math grid-cols dependent on $itemsPerRow and $gap
     *
     * @param integer $itemsPerRow
     * @return string
     */
    function getGridClassName(int $itemsPerRow, int $gap): string
    {
        $commonClass = FunctionHelper::getGridClassName((int) $itemsPerRow, (int) $gap);

        return "glide__slide bg-white bg-opacity-60 dark:bg-gray-900 dark:bg-opacity-60 border-2 border-gray-200 dark:border-gray-800 rounded-4xl p-5 {$commonClass}";
    }

    /**
     * Get Array aArgs for WP_Query dependent $aSetting
     *
     * @param array $aSettings
     * @return array
     */
    function getArrayQueryArgs(array $aSettings): array
    {
        $aArgs = [
            'posts_per_page'        => $aSettings['items_per_row'] * $aSettings['max_rows'],
        ];
        if ($aSettings['get_post_by'] === 'specified_posts') {
            $aArgs['post__in'] = $aSettings['specified_posts'];
            $aArgs['orderby'] = 'post__in';
        }
        if ($aSettings['get_post_by'] === 'categories') {
            $aArgs['order'] = $aSettings['order'];
            $aArgs['orderby'] = $aSettings['orderby'];
            $aArgs['category__in'] = $aSettings['categories'];
        }
        $aArgs = (new QueryBuilder)->setRawArgs($aArgs)->parseArgs()->getArgs();
        return $aArgs;
    }


    /**
     * Function render buttons tab of section
     *
     * @param integer $key
     * @param array $tab
     * @return string
     */
    function _renderTabBtnItem(int $key, array $tab): string
    {
        $activeClass = $key === 0 ? 'glide__bullet--active' : '';
        ob_start();
?>
        <ul class="<?php echo esc_attr($activeClass); ?>" data-glide-dir="=<?php echo esc_attr($key); ?>">
            <li class="wil-nav-item--type2">
                <a href="#" class="block text-center text-xs md:text-base px-3 md:px-5 py-2 rounded-full font-medium">
                    <?php echo esc_html($tab['tab_title']); ?>
                </a>
            </li>
        </ul>
    <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * Function render Content tab of section
     *
     * @param array $aTabSettings
     * @return string
     */
    function _renderTabContentItem(array $aTabSettings): string
    {
        $aSettings = $this->get_settings_for_display();
        $oQuery = new WP_Query($this->getArrayQueryArgs(array_merge($aSettings, $aTabSettings)));
        ob_start();
    ?>
        <li class="<?php echo esc_attr($this->getGridClassName($aSettings['items_per_row'], $aSettings['gap'])); ?>">
            <?php if (!$oQuery->have_posts()) {
                esc_html_e('Sorry! We found no post!', 'hsblog2-shortcodes');
            }
            if ($oQuery->have_posts()) :
                while ($oQuery->have_posts()) {
                    $oQuery->the_post();
                    $oPost = $oQuery->post;

                    // GET COUNTVIEWS
                    $countViews = UserModel::getCountViewByPostID($oPost->ID);

                    echo App::get('LitleHorizontalBoxItemWhiteSc')->renderSc([
                        'id'              => $oPost->ID,
                        'name'            => $oPost->post_title,
                        'featured_image'  => FunctionHelper::getPostFeaturedImage($oPost->ID, $aTabSettings['featured_image_size']),
                        'url'             => get_permalink($oPost->ID),
                        'number_views'    => $countViews,
                        'number_comments' => $oPost->comment_count,
                    ]);
                }
                wp_reset_postdata();
            endif;
            ?>
        </li>
    <?php
        wp_reset_query();
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
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
    ?>
        <section class="wil-sidebar-tab-post glide" data-glide-animationDuration="0">
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
            <div class="grid grid-cols-3 list-none gap-2 bg-gray-200 dark:bg-gray-800 text rounded-full p-3px mb-10px text-gray-700 dark:text-gray-200" data-glide-el="controls[nav]">
                <?php foreach ($aSettings['tabs'] as $key => $value) {
                    echo $this->_renderTabBtnItem($key, $value);
                }; ?>
            </div>
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    <?php foreach ($aSettings['tabs'] as $aTabSettings) {
                        echo $this->_renderTabContentItem($aTabSettings);
                    }; ?>
                </ul>
            </div>
        </section>
<?php
    }
}
