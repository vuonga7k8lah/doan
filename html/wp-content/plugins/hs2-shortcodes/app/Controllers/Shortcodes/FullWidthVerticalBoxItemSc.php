<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;
use HSSC\Illuminate\Helpers\StringHelper;

/**
 * FullWidthVerticalBoxItemSc class
 */
class FullWidthVerticalBoxItemSc
{

    function __construct()
    {
        add_shortcode(HSBLOG2_SC_PREFIX . 'full_width_vertical_box_item_sc', [$this, 'renderSc']);
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
            'id'                => '1',
            'created_at'        => '',
            'name'              => '',
            'featured_image'    => '',
            'url'               => '',
            'category_name'     => '',
            'category_url'      => '#',
            'author_name'       => '',
            'author_avatar'     => '',
            'author_url'        => '',
            //
            'is_on_section_slider' => 'no'
            // is_on_section_slider :: 'yes'|'no'
        ], $aAtts);

        ob_start();
?>
        <div class="wil-post-large-1 grid grid-cols-1 lg:grid-cols-3 gap-5 xl:gap-8">
            <div class="row-start-1 col-start-1 relative z-10 py-8 sm:py-14 flex flex-col justify-end lg:justify-start bg-gradient-to-t from-gray-900 lg:bg-none px-5 lg:px-0 rounded-4xl lg:rounded-none">
                <div>
                    <?php if ($aAtts['category_name']) : ?>
                        <a href="<?php echo esc_url($aAtts['category_url']); ?>" class="inline-flex items-center justify-center px-3.5 text-gray-900 bg-primary font-medium rounded-3xl leading-tight py-3.5 text-base">
                            <?php echo esc_html($aAtts['category_name']); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <?php if ($aAtts['name']) : ?>
                    <h1 class="wil-line-clamp-3 text-gray-100 lg:text-gray-900 dark:text-gray-200 text-2xl lg:text-3xl xl:text-4.5xl tracking-tight my-4 lg:my-8">
                        <a href="<?php echo esc_url($aAtts['url']); ?>">
                            <?php StringHelper::ksesHTML($aAtts['name']); ?>
                        </a>
                    </h1>
                <?php endif; ?>
                <?php
                echo App::get('ByAuthorSc')->renderSc([
                    'extra_classes'             => '',
                    'text_classes'              => 'text-gray-300 lg:text-gray-800 dark:text-gray-300',
                    'avatar_size'               => 'w-10 h-10',
                    'meta'                      => $aAtts['created_at'],
                    'author_name'               => $aAtts['author_name'],
                    'author_url'                => $aAtts['author_url'],
                    'author_avatar'             => $aAtts['author_avatar'],
                ]);

                if ($aAtts['is_on_section_slider'] === 'yes') {
                    echo '<div class="h-11 w-11 border bg-black opacity-0 lg:mt-10"></div>';
                }
                ?>

            </div>
            <div class="row-start-1 col-start-1 lg:col-span-2 relative z-0 h-0 pt-133.33% md:pt-71.42% lg:pt-62.5% xl:pt-56.25% bg-gray-400 rounded-4xl my-auto mx-0">
                <a href="<?php echo esc_url($aAtts['url']); ?>">
                    <?php if ($aAtts['featured_image']) : ?>
                        <img alt="<?php echo esc_attr($aAtts['name']); ?>" class="absolute inset-0 object-cover w-full h-full rounded-4xl" src="<?php echo esc_url($aAtts['featured_image']); ?>">
                    <?php endif; ?>
                </a>
            </div>
        </div>
<?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
