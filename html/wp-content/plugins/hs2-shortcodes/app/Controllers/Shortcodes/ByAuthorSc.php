<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;

/**
 * Class ByAuthor
 * @package HSSC\Controllers\Shortcodes
 */
class ByAuthorSc
{
    function __construct()
    {
        add_shortcode(HSBLOG2_SC_PREFIX . 'by_author', [$this, 'renderSc']);
    }

    /**
     * @param array $aAtts
     * @return string
     */
    function renderSc($aAtts = []): string
    {
        $aAtts = shortcode_atts(
            [
                'extra_classes'             => '',
                'text_classes'              => 'text-gray-800 dark:text-gray-300 xl:text-base',
                'avatar_size'               => 'h-8 w-8 xl:h-12 xl:w-12',
                'meta'                      => '',
                'author_name'               => 'A',
                'author_link'               => '',
                'author_avatar'             => '',
            ],
            $aAtts
        );
        $className = 'flex items-center font-bold text-xs';
        if ($aAtts['extra_classes']) {
            $className .= ' ' . $aAtts['extra_classes'];
        }
        if ($aAtts['text_classes']) {
            $className .= ' ' . $aAtts['text_classes'];
        }

        ob_start();
?>

        <div class="<?php echo esc_attr($className) ?>">
            <?php
            echo App::get('AvatarSc')->renderSc(
                [
                    'extra_classes' => "bg-gray-100 mr-2.5",
                    'src'           => $aAtts['author_avatar'],
                    'name'          => $aAtts['author_name'],
                    'size_classes'  => $aAtts['avatar_size']
                ]
            );
            ?>
            <div class="flex-shrink-0" title="<?php echo esc_attr($aAtts['author_name']); ?>">
                <?php if ($aAtts['author_link'] && $aAtts['author_name']) : ?>
                    <a href="<?php echo esc_url($aAtts['author_link']); ?>">
                        <span class="opacity-70 font-medium">
                            <?php
                            esc_html_e('By', 'hsblog2-shortcodes');
                            echo " ";
                            ?>
                        </span>
                        <?php echo esc_html($aAtts['author_name']); ?>
                    </a>
                <?php elseif ($aAtts['author_name']) : ?>
                    <span>
                        <span class="opacity-70 font-medium">
                            <?php
                            esc_html_e('By', 'hsblog2-shortcodes');
                            echo " ";
                            ?>
                        </span>
                        <?php echo esc_html($aAtts['author_name']); ?>
                    </span>
                <?php endif; ?>

            </div>
            <?php if ($aAtts['meta']) : ?>
                <span class="mx-2.5 hidden md:inline">•</span>
                <span class="truncate hidden md:inline" title="<?php echo esc_attr($aAtts['meta']); ?>">
                    <?php echo esc_html($aAtts['meta']); ?>
                </span>
            <?php endif; ?>
        </div>

<?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
