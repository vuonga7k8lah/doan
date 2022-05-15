<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;
use HSSC\Illuminate\Helpers\StringHelper;

/**
 * BigUniqueVerticalBoxItemSc
 */
class BigUniqueVerticalBoxItemSc
{
    public function __construct()
    {
        add_shortcode(HSBLOG2_SC_PREFIX . 'big_unique_vertical_box_item_sc', [$this, 'renderSc']);
    }

    /**
     * renderSc
     *
     * @param  mixed $aAtts
     * @return string
     */
    public function renderSc($aAtts = []): string
    {
        $aAtts = shortcode_atts([
            'id'                => '1',
            'is_saved'          => 'no',
            'created_at'        => '',
            'name'              => '',
            'desc'              => '',
            'featured_image'    => '',
            'url'               => '',
            'number_views'      => '0',
            'number_comments'   => '0',
            'category_name'     => '',
            'author_name'       => '',
            'author_avatar'     => '',
        ], $aAtts);
        ob_start();
?>
        <div class="wil-post-card-7 flex w-full">
            <div class="flex-shrink-0 mr-2 md:mr-4">
                <div class="wil-post-info2 grid grid-rows-3 gap-2 md:gap-3 text-sm leading-none font-medium text-primary">
                    <div>
                        <?php echo App::get('AvatarSc')->renderSc([
                            'extra_classes' => '',
                            'size_classes'  => 'h-12 w-12',
                            'radius'        => 'rounded-xl',
                            'src'           => $aAtts['author_avatar'],
                            'name'          => $aAtts['author_name'],
                        ]) ?>
                    </div>
                    <div class="flex flex-col items-center justify-center bg-gray-800 dark:bg-gray-900 da rounded-xl w-12 h-12">
                        <i class="las la-arrow-up text-base leading-none mb-1"></i>
                        <span class="truncate">
                            <?php echo esc_html($aAtts['number_views']); ?>
                        </span>
                    </div>
                    <div class="flex flex-col items-center justify-center bg-gray-800 dark:bg-gray-900 rounded-xl w-12 h-12">
                        <i class="las la-comment text-base leading-none mb-1"></i>
                        <span class="truncate">
                            <?php echo esc_html($aAtts['number_comments']); ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="relative flex-grow rounded-2xl overflow-hidden">
                <?php if ($aAtts['url']) : ?>
                    <a href="<?php echo esc_url($aAtts['url']); ?>" class="absolute inset-0 z-10"></a>
                <?php endif; ?>
                <div class="relative h-0 pt-56.25% bg-gray-400">
                    <?php if ($aAtts['featured_image']) : ?>
                        <img alt="<?php echo esc_attr($aAtts['name']); ?>" class="absolute inset-0 w-full h-full object-cover" src="<?php echo esc_attr($aAtts['featured_image']); ?>">
                    <?php endif; ?>
                </div>
                <div class="bg-white dark:bg-gray-900 p-5 text-gray-900 dark:text-gray-100">
                    <div>
                        <span class="inline-flex items-center justify-center px-3.5 text-gray-900 bg-primary font-medium rounded-3xl leading-tight py-2 border-2 border-primary text-xs">
                            <?php echo esc_html($aAtts['category_name']); ?>
                        </span>
                    </div>
                    <?php if ($aAtts['name']) : ?>
                        <h6 class="wil-line-clamp-2 md:text-lg lg:text-2xl my-10px">
                            <?php StringHelper::ksesHTML($aAtts['name']); ?>
                        </h6>
                    <?php endif; ?>
                    <?php if ($aAtts['desc']) : ?>
                        <span class="wil-line-clamp-2 mb-8 text-base text-gray-700 dark:text-gray-300">
                            <?php echo esc_html($aAtts['desc']); ?>
                        </span>
                    <?php endif; ?>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-700 dark:text-gray-300 font-medium truncate mr-4">
                            <?php echo esc_html($aAtts['created_at']); ?>
                        </span>
                        <?php echo App::get('BookmarkIconSc')->renderSc([
                            'is_saved' => $aAtts['is_saved'],
                            'id'       => $aAtts['id'],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
<?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
