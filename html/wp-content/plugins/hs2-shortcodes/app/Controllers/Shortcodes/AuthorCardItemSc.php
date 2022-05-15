<?php

namespace HSSC\Controllers\Shortcodes;

use HSSC\Helpers\App;

/**
 * AuthorCardItemSc class
 */
class AuthorCardItemSc
{
    function __construct()
    {
        add_shortcode(HSBLOG2_SC_PREFIX . 'author_card_item_sc', [$this, 'renderSc']);
    }

    /**
     * 'renderFollowBtn function'
     *
     * @param ["default" | "follow" | "following"] $type
     * @return void
     */
    private function renderFollowBtn($type, $useID)
    {
        (string)$html = '';
        switch ($type) {
            case "default":
                $html = '<span class="w-11 h-11 bg-gray-200 group-hover:bg-primary rounded-full flex items-center justify-center text-xl">
                        <i class="las la-long-arrow-alt-right"></i>
                    </span>';
                break;
            case "follow":
                $html = '<button class="bg-gray-200 hover:bg-primary rounded-full flex items-center justify-center text-xs font-medium px-6 py-2 relative z-20" data-user-id="' . esc_attr($useID) . '" data-is-following="no" >';
                $html .= esc_attr__('Follow', 'hsblog2-shortcodes');
                $html .= '</button>';
                break;
            case "following":
                $html = '<button class="bg-primary rounded-full flex items-center justify-center text-xs font-medium px-6 py-2 relative z-20" data-user-id="' . esc_attr($useID) . '" data-is-following="yes" >';
                $html .=  esc_attr__('Following', 'hsblog2-shortcodes');
                $html .= '</button>';
                break;
            default:
                $html = '<span class="w-11 h-11 bg-gray-200 group-hover:bg-primary rounded-full flex items-center justify-center text-xl">
                        <i class="las la-long-arrow-alt-right"></i>
                    </span>';
                break;
        }
        echo $html;
    }

    /**
     * @param array $aAtts
     * @return string
     */
    public function renderSc($aAtts = []): string
    {
        $aAtts = shortcode_atts([
            'id'            => '1',
            'name'          => '',
            'number_posts'  => '0',
            'avatar'        => '',
            'url'           => '#',
            'type'          => "default"
            // type?: "default" | "follow" | "following";
        ], $aAtts);
        ob_start();
?>

        <div class="group relative flex flex-col items-center text-gray-900 bg-white bg-opacity-60 dark:bg-gray-900 dark:bg-opacity-50 border-2 border-gray-300 dark:border-gray-600 rounded-4xl p-5">
            <?php
            echo App::get('AvatarSc')->renderSc([
                'extra_classes' => 'mb-10px text-2xl',
                'size_classes'  => 'w-20 h-20',
                'src'           => $aAtts['avatar'],
                'name'          => $aAtts['name'],
            ]);
            ?>
            <?php if ($aAtts['name']) : ?>
                <span class="font-bold text-lg dark:text-gray-100">
                    <?php echo esc_html($aAtts['name']); ?>
                </span>
            <?php endif; ?>
            <span class="text-base font-medium text-gray-700 dark:text-gray-400 mb-4">
                <?php
                printf(
                    App::get('FunctionHelper')::translatePluralText(
                        esc_html__('%s Post', 'hsblog2-shortcodes'),
                        esc_html__('%s Posts', 'hsblog2-shortcodes'),
                        intval($aAtts['number_posts'])
                    ),
                    $aAtts['number_posts']
                );
                ?>
            </span>

            <!-- === render Follow button === -->
            <?php $this->renderFollowBtn($aAtts['type'], $aAtts['id']); ?>
            <a href="<?php echo esc_url($aAtts['url']); ?>" class="block absolute inset-0 z-10"></a>
        </div>

<?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
