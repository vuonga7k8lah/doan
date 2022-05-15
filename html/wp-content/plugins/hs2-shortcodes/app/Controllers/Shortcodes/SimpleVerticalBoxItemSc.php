<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;
use HSSC\Illuminate\Helpers\StringHelper;

/**
 * Class SimpleVerticalBoxItemSc
 * @package HSSC\Controllers\Shortcodes
 */
class SimpleVerticalBoxItemSc
{
    public function __construct()
    {
        add_shortcode(HSBLOG2_SC_PREFIX . 'simple_vertical_box_item_sc', [$this, 'renderSc']);
    }


    /**
     * @param array $aAtts
     * @return string
     */
    function renderSc($aAtts = []): string
    {
        $aAtts = shortcode_atts([
            'id'              => '1',
            'name'            => '',
            'featured_image'  => '',
            'url'             => '',
            'number_views'    => '0',
            'number_comments' => '0',
            'category_name'   => 'Travel',
            'author_avatar'   => '',
            'author_name'     => '',
        ], $aAtts);
        ob_start();
?>

        <div class="wil-post-card-4 relative rounded-4xl bg-gray-400 overflow-hidden text-gray-900">
            <div class="pt-100% lg:pt-133.33% h-0">
                <?php if ($aAtts['featured_image']) : ?>
                    <img alt="<?php echo esc_attr($aAtts['name']); ?>" class="absolute inset-0 object-cover w-full h-full" src="<?php echo esc_url($aAtts['featured_image']); ?>">
                <?php endif; ?>
            </div>
            <div class="absolute top-4 left-4 right-4 flex justify-between items-center">
                <div class="flex items-center font-medium text-base bg-white rounded-full p-3px mr-4">
                    <?php
                    echo App::get('AvatarSc')->renderSc([
                        "size_classes" => "w-7 h-7",
                        "name"       => $aAtts['author_name'],
                        "src"        => $aAtts['author_avatar'],
                    ]);
                    ?>

                    <?php if ($aAtts['author_name']) : ?>
                        <span class="ml-1 pl-2px mr-2 truncate">
                            <?php echo esc_html($aAtts['author_name']); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <?php
                if ($aAtts['category_name']) {
                    echo App::get('CategoryBadgeSc')->renderSc([
                        "name" => $aAtts['category_name'],
                    ]);
                }
                ?>

            </div>
            <div class="absolute bottom-4 left-4 right-4 bg-white dark:bg-gray-800 p-5 rounded-2.5xl">
                <?php if ($aAtts['name']) : ?>
                    <h5 class="wil-line-clamp-2 mb-10px text-gray-900 dark:text-gray-100">
                        <?php StringHelper::ksesHTML($aAtts['name']); ?>
                    </h5>
                <?php endif; ?>

                <?php
                echo App::get('BoxCardInfoSc')->renderSc([
                    "number_views"    => $aAtts['number_views'],
                    "number_comments" => $aAtts['number_comments'],
                ]);
                ?>
            </div>
            <?php if ($aAtts['url']) : ?>
                <a href="<?php echo esc_url($aAtts['url']); ?>" class="absolute inset-0">
                    <span class="sr-only"><?php echo esc_html($aAtts['name']); ?></span>
                </a>
            <?php endif; ?>
        </div>

<?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
