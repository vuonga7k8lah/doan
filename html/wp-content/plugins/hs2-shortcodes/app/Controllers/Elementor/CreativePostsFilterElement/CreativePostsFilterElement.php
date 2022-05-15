<?php

namespace HSSC\Controllers\Elementor\CreativePostsFilterElement;

use \Elementor\Widget_Base;
use HSSC\Controllers\Elementor\ColorfulPostsFilterElement\RenderHeaderFilter;
use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Illuminate\Helpers\StringHelper;
use HSSC\Illuminate\Query\PostQuery\QueryBuilder;

require_once plugin_dir_path(__FILE__) . '/getDataValueOfPost.php';
require_once plugin_dir_path(__FILE__) . '/getGridGapClassName.php';
/**
 * CreativePostsFilterElement class
 */
class CreativePostsFilterElement extends Widget_Base
{

    private static $uid;
    private static $aPagState = [];

    public function __construct($data = [], $args = null)
    {
        self::$uid = uniqid(ESC_HTML_TEXT_DOMAIN, true);
        parent::__construct($data, $args);
    }


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
        return 'creative_posts_filter_element';
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
        return esc_html__('Creative Posts Filter', 'hsblog2-shortcodes');
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
        $aArgs = [
            'posts_per_page' => $aSettings['posts_per_page']
        ];

        if ($aSettings['get_post_by'] === 'categories') {
            if (!empty($aSettings['categories'])) {
                $aArgs['category_name'] = implode(',', $aSettings['categories']);
                $aSettings['categories'] = FunctionHelper::convertArrayCategoriesSlugToId($aSettings['categories']);
            }
            $aArgs['order'] = $aSettings['order'];
            $aArgs['orderby'] = $aSettings['orderby'];
        } else {
            $aArgs['post__in'] = $aSettings['specified_posts'];
        }

        $aArgs = (new QueryBuilder)->setRawArgs($aArgs)->parseArgs()->getArgs();
        $oQuery = new \WP_Query($aArgs);
        self::$aPagState = FunctionHelper::checkPaginationShowByPaged($oQuery->max_num_pages, 1);

?>
        <div class="<?php echo esc_attr(HSBLOG2_SC_PREFIX . 'CreativePostsFilterElement'); ?>" data-has-filter-api data-init-page="1" data-init-cat-filter="<?php echo esc_attr(FunctionHelper::encodeBase64($aSettings['categories'])); ?>" data-init-orderby-filter="<?php echo esc_attr($aSettings['orderby']); ?>" data-block-uid="<?php echo esc_attr(self::$uid); ?>" data-block-type="CreativePostsFilterElement" data-a-settings="<?php echo esc_attr(FunctionHelper::encodeBase64(FunctionHelper::removeKeyOfElementorSettings($aSettings))); ?>">
            <?php if (!!$aSettings['section_title'] && !empty($aSettings['order_by_options'])) : ?>
                <header class="flex justify-between items-center mb-5 space-x-2">
                    <?php echo (new RenderHeaderFilter($aSettings, $this::$uid, $this::$aPagState))->renderTitle(); ?>
                </header>
            <?php endif; ?>
            <div>
                <?php if (!isset($aSettings['specified_posts'])) : ?>
                    <?php echo (new RenderHeaderFilter($aSettings, $this::$uid, $this::$aPagState))->renderHeader(); ?>
                <?php endif; ?>
                <div class="wilSectionFilterContent" id="<?php echo esc_attr(self::$uid); ?>">
                    <?php
                    App::get('CreativePostsFilterElementContent')->renderContent($oQuery, $aSettings);
                    ?>
                </div>
                <?php echo (new RenderHeaderFilter($aSettings, $this::$uid, $this::$aPagState))->renderNextPrev('block md:hidden mt-5'); ?>
            </div>
        </div>
<?php
    }
}
