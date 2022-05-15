<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;

/**
 * Class BoxCardInfoSc
 * @package HSSC\Controllers\Shortcodes
 */
class BoxCardInfoSc
{
    function __construct()
    {
        add_shortcode(HSBLOG2_SC_PREFIX . 'box_card_info_sc', [$this, 'renderSc']);
    }

    function converNumber(int $number): string
    {
        if ($number < 1000) {
            return $number;
        }
        return ($number / 1000) . 'k';
    }

    /**
     * @param array $aAtts
     * @return string
     */
    function renderSc(array $aAtts = []): string
    {
        $aAtts = shortcode_atts([
            'extra_classes'   => 'text-gray-800 dark:text-gray-300',
            'desc_toggle'     => 'enable',
            'number_views'    => '0',
            'number_comments' => '0',
        ], $aAtts);

        $className
            = "wil-post-info flex items-center truncate space-x-3.5 xl:text-sm text-xs font-medium leading-tight";
        if ($aAtts['extra_classes']) {
            $className .= ' ' . $aAtts['extra_classes'];
        }

        $commentTitle = App::get('FunctionHelper')::translatePluralText(
            esc_html__('Comment', 'hsblog2-shortcodes'),
            esc_html__('Comments', 'hsblog2-shortcodes'),
            intval($aAtts['number_comments'])
        );

        $viewTitle = App::get('FunctionHelper')::translatePluralText(
            esc_html__('View', 'hsblog2-shortcodes'),
            esc_html__('Views', 'hsblog2-shortcodes'),
            intval($aAtts['number_views'])
        );

        ob_start();
?>

        <div class="<?php echo esc_attr($className); ?>">
            <div class="truncate relative z-10" title="<?php echo esc_attr($viewTitle); ?>">
                <i class="las la-arrow-up text-base opacity-80 leading-tight"></i>
                <span>
                    <?php echo esc_html($this->converNumber(intval($aAtts['number_views']))); ?>
                    <?php if ($aAtts['desc_toggle'] === 'enable') : ?>
                        <span class="hidden md:inline">
                            <?php
                            echo " ";
                            if ($aAtts['number_views']) {
                                echo _n('View', 'Views', $aAtts['number_views'], 'hsblog2-shortcodes');
                            } else {
                                esc_html_e('View', 'hsblog2-shortcodes');
                            }
                            ?>
                        </span>
                    <?php endif; ?>
                </span>
            </div>
            <div class="truncate relative z-10" title="<?php echo esc_attr($commentTitle); ?>">
                <i class="las la-comment text-base opacity-80 leading-tight"></i>
                <span>
                    <?php echo esc_html($this->converNumber(intval($aAtts['number_comments']))); ?>
                    <?php if ($aAtts['desc_toggle'] === 'enable') : ?>
                        <span class="hidden md:inline">
                            <?php
                            echo " ";
                            if ($aAtts['number_comments']) {
                                echo _n('Comment', 'Comments', $aAtts['number_comments'], 'hsblog2-shortcodes');
                            } else {
                                esc_html_e('Comment', 'hsblog2-shortcodes');
                            }
                            ?>
                        </span>
                    <?php endif; ?>
                </span>
            </div>
        </div>

<?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
