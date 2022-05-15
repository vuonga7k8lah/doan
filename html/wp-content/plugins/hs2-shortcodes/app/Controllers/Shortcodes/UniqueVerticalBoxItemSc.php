<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;
use HSSC\Illuminate\Helpers\StringHelper;

/**
 * Class UniqueVerticalBoxItemSc
 * @package HSSC\Controllers\Shortcodes
 */
class UniqueVerticalBoxItemSc
{
    public function __construct()
    {
        add_shortcode(HSBLOG2_SC_PREFIX . 'unique_vertical_box_item_sc', [$this, 'renderSc']);
    }

    /**
     * @param array $aAtts
     * @return string
     */
    function renderSc($aAtts = []): string
    {
        $aAtts = shortcode_atts([
            'id'                    => '1',
            'is_saved'              => '',
            'created_at'            => '',
            'name'                  => '',
            'featured_image'        => '',
            'url'                   => '',
            'number_views'          => '0',
            'number_comments'       => '0',
            'author_avatar'         => '',
            'author_name'           => '',
            'box_added_classes'     => ''
        ], $aAtts);

        ob_start();
?>
        <div class="wil-post-card-6 flex flex-col bg-white dark:bg-gray-900 relative rounded-2xl overflow-hidden">
            <div class="relative h-0 pt-56.25% bg-gray-400">
                <?php if ($aAtts['featured_image']) : ?>
                    <img alt="<?php echo esc_attr($aAtts['name']); ?>" class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_url($aAtts['featured_image']); ?>">
                <?php endif; ?>
            </div>

            <div class="flex-grow flex flex-col p-5 pt-4 text-gray-900 dark:text-gray-100 <?php echo esc_attr($aAtts['box_added_classes']); ?>">
                <div class="flex justify-between items-center">
                    <div class="flex items-center truncate">
                        <?php
                        echo App::get('AvatarSc')->renderSc([
                            'extra_classes' => '',
                            'radius'        => 'rounded-xl',
                            'size_classes'  => 'w-10 h-10',
                            'src'           => $aAtts['author_avatar'],
                            'name'          => $aAtts['author_name']
                        ]);
                        ?>
                        <?php if ($aAtts['author_name']) : ?>
                            <span class="truncate ml-10px text-base font-medium">
                                <?php echo esc_html($aAtts['author_name']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="flex-shrink-0 ml-2">
                        <?php
                        echo App::get('BoxCardInfoSc')->renderSc([
                            'desc_toggle'     => 'disable',
                            'number_views'    => $aAtts['number_views'],
                            'number_comments' => $aAtts['number_comments'],
                        ]);
                        ?>

                    </div>
                </div>
                <?php if ($aAtts['name']) : ?>
                    <h6 class="wil-line-clamp-2 mt-4 mb-5">
                        <?php StringHelper::ksesHTML($aAtts['name']); ?>
                    </h6>
                <?php endif; ?>

                <div class="flex justify-between items-center mt-auto">
                    <span class="text-xs text-gray-700 dark:text-gray-300 font-medium truncate mr-4">
                        <?php echo esc_html($aAtts['created_at']); ?>
                    </span>

                    <?php
                    echo App::get('BookmarkIconSc')->renderSc([
                        'is_saved' => $aAtts['is_saved'],
                        'id'       => $aAtts['id']
                    ]);
                    ?>
                </div>
            </div>
            <?php if ($aAtts['url']) : ?>
                <a href="<?php echo esc_url($aAtts['url']); ?>" class="absolute inset-0 z-0">
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
