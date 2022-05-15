<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;
use HSSC\Illuminate\Helpers\StringHelper;

class CreativeVerticalBoxItemSc
{
    public function __construct()
    {
        add_shortcode(HSBLOG2_SC_PREFIX . 'creative_vertical_box_item_sc', [$this, 'renderSc']);
    }

    /**
     * @param array $aAtts
     * @return  string
     */
    function renderSc($aAtts = []): string
    {
        $aAtts = shortcode_atts([
            'id'              => '1',
            'is_saved'        => 'no',
            'name'            => '',
            'featured_image'  => '',
            'url'             => '',
            'number_views'    => '0',
            'number_comments' => '0',
            'category_name'   => 'Travel',
            'author_avatar'   => '',
            'author_name'     => '',
        ], $aAtts);

        $svgClass = "stroke-2 h-5 w-5 p-1px text-white";
        if ($aAtts['is_saved'] === 'yes') {
            $svgClass .= " fill-current";
        } else {
            $svgClass .= " stroke-current";
        }
        $isLogged = is_user_logged_in();
        ob_start();
?>
        <div class="wil-post-card-5 relative rounded-4xl bg-gray-400 text-gray-900 group">
            <div class="pt-100% xl:pt-133.33% h-0 rounded-4xl">
                <?php if ($aAtts['featured_image']) : ?>
                    <img alt="<?php echo esc_attr($aAtts['name']); ?>" class="absolute inset-0 object-cover w-full h-full rounded-4xl" src="<?php echo esc_url($aAtts['featured_image']); ?>">
                <?php endif; ?>
            </div>
            <div class="hidden group-hover:block absolute top-4 right-4">

                <div class="wil-tooltip relative">
                    <button class="wil-icon-save-post z-10 relative flex items-center justify-center bg-white bg-opacity-30 wil-backdrop-filter-6px rounded-full w-8 h-8" <?php echo esc_attr($isLogged ? null : 'data-open-modal=wil-modal-form-sign-in'); ?> <?php echo esc_attr(!$isLogged ? null : 'data-id=' . $aAtts['id'] . ''); ?> <?php echo esc_attr(!$isLogged ? null : 'data-saved=' . $aAtts['is_saved'] . ''); ?>>
                        <svg class="<?php echo esc_attr($svgClass); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </button>
                    <div class="wil-tooltip__label absolute right-full -translate-y-2/4 top-2/4 transform text-white dark:text-gray-900 font-medium z-50 text-base p-3px">
                        <div class="bg-gray-700 dark:bg-gray-300 py-1 px-10px rounded-md leading-5">
                            <span> <?php esc_html_e('Save', 'hsblog2-shortcodes'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-4 left-4 right-4">
                <div class="bg-white dark:bg-gray-800 p-5 pt-6 rounded-2.5xl">
                    <?php if ($aAtts['category_name']) : ?>
                        <div class="absolute top-0 transform -translate-y-2/4">
                            <?php
                            echo App::get('CategoryBadgeSc')->renderSc(['name' => $aAtts['category_name']]);
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($aAtts['name']) : ?>
                        <h5 class="wil-line-clamp-2 mb-10px dark:text-gray-200">
                            <?php StringHelper::ksesHTML($aAtts['name']); ?>
                        </h5>
                    <?php endif; ?>

                    <?php
                    echo App::get('BoxCardInfoSc')->renderSc([
                        'number_views'    => $aAtts['number_views'],
                        'number_comments' => $aAtts['number_comments'],
                    ]);
                    ?>

                </div>
                <div>
                    <div class="wil-circle-9px bg-white dark:bg-gray-800 rounded-full ml-8 -mt-3px mb-3px"></div>
                    <div class="wil-circle-13px bg-white dark:bg-gray-800 rounded-full ml-6"></div>
                    <?php
                    echo App::get('AvatarSc')->renderSc([
                        'size_classes' => 'w-7 h-7',
                        'src'        => $aAtts['author_avatar'],
                        'name'       => $aAtts['author_name'],
                    ]);
                    ?>
                </div>
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
