<?php

namespace HSSC\Controllers\Shortcodes;

/**
 * ButtonSc class
 */
class ButtonSc
{
    function __construct()
    {
        add_shortcode(HSBLOG2_SC_PREFIX . 'button_sc', [$this, 'renderSc']);
    }


    public function renderLink(array $aAtts, string $classNames): string
    {
        ob_start(); ?>
        <a href="<?php echo esc_html($aAtts['url']); ?>" class="<?php echo esc_attr($classNames); ?>">
            <?php echo esc_html($aAtts['name']); ?>
        </a>
    <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function renderButton(array $aAtts, string $classNames): string
    {
        ob_start(); ?>

        <button class="<?php echo esc_attr($classNames); ?>">
            <?php echo esc_html($aAtts['name']); ?>
        </button>
<?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * renderSc function
     *
     * @param array $aAtts
     * @return string
     */
    function renderSc($aAtts = []): string
    {
        $aAtts = shortcode_atts([
            "extra_classes"     => "rounded-full",
            "size_classes"      => "h-14 w-full",
            "text_color"        => "text-gray-900 dark:text-gray-200",
            "text_size"         => "text-xs lg:text-sm xl:text-body",
            "bg_color"          => "bg-gray-200 dark:bg-gray-900",
            "name"              => esc_html__('Click Me', 'hsblog2-shortcodes'),
            "url"              =>   "#",
        ], $aAtts);

        $classNames = "wil-button inline-flex items-center justify-center text-center py-2 px-4 md:px-6 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500";
        if ($aAtts['extra_classes']) {
            $classNames .= " {$aAtts['extra_classes']}";
        }
        if ($aAtts['size_classes']) {
            $classNames .= " {$aAtts['size_classes']}";
        }
        if ($aAtts['text_color']) {
            $classNames .= " {$aAtts['text_color']}";
        }
        if ($aAtts['text_size']) {
            $classNames .= " {$aAtts['text_size']}";
        }
        if ($aAtts['bg_color']) {
            $classNames .= " {$aAtts['bg_color']}";
        }
        if (!$aAtts['url']) {
            return $this->renderButton($aAtts, $classNames);
        }
        return $this->renderLink($aAtts, $classNames);
    }
}
