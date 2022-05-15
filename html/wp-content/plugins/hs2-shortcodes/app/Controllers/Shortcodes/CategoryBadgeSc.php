<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Illuminate\Helpers\StringHelper;

/**
 * Class CategorySc
 * @package HSSC\Controllers\Shortcodes
 */
class CategoryBadgeSc
{
    public function __construct()
    {
        add_shortcode(HSBLOG2_SC_PREFIX . 'category', [$this, 'renderSc']);
    }

    /**
     * @param array $aAtts
     * @return string
     */
    public function renderSc($aAtts = []): string
    {
        $aAtts = shortcode_atts(
            [
                'extra_classes' => '',
                'name'          => 'Travel',
                'type'          => 'small',
                'url'           => ''
            ],
            $aAtts
        );
        $class
            = "inline-flex items-center justify-center px-3.5 text-gray-900 bg-primary font-medium rounded-3xl leading-tight bg-primary truncate";
        $typeClass = ($aAtts['type'] === 'small') ? "py-2 border-2 border-primary text-xs" : "py-3.5 text-base";
        $class .= ' ' . $typeClass;
        if ($aAtts['extra_classes']) {
            $class .= $aAtts['extra_classes'];
        }
        ob_start();
?>

        <?php if ($aAtts['url']) : ?>
            <a href="<?php echo esc_url($aAtts['url']); ?>" class="<?php echo esc_attr($class); ?>" title="<?php echo esc_attr($aAtts['name']); ?>">
                <span class="truncate"><?php StringHelper::ksesHTML($aAtts['name']); ?></span>
            </a>
        <?php else : ?>
            <span class="<?php echo esc_attr($class); ?>" title="<?php echo esc_attr($aAtts['name']); ?>">
                <span class="truncate"><?php StringHelper::ksesHTML($aAtts['name']); ?></span>
            </span>
        <?php endif; ?>

<?php
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
