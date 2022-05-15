<?php

namespace HSSC\Controllers\Elementor\CreativePostsFilterElement;

use HSSC\Helpers\App;

require_once plugin_dir_path(__FILE__) . '/getDataValueOfPost.php';
require_once plugin_dir_path(__FILE__) . '/getGridGapClassName.php';

/**
 * CreativePostsFilterElementContent class
 */
class CreativePostsFilterElementContent
{
    public function __construct()
    {
        add_action(
            HSBLOG2_ELEMENTOR_FILLTER_COMMON . 'CreativePostsFilterElementContent',
            [
                $this, 'renderContent'
            ],
            10,
            2
        );
    }


    /**
     * @param $oQuery
     * @param $aSettings
     * @return void
     */
    public function renderContent($oQuery, $aSettings)
    {
        $aPosts = [];
        if ($oQuery->have_posts()) {
            $aPosts = $oQuery->posts;
        }

        $gapClass = getGridGapClassName($aSettings['gap']);
        if (empty($aPosts)) {
            esc_html_e('Sorry! We found no post!', 'hs2-shortcodes');
            return "";
        }

        ob_start(); ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 <?php echo esc_attr($gapClass); ?>">

            <div class="grid grid-cols-1 <?php echo esc_attr($gapClass); ?>">
                <?php
                foreach ($aPosts as $key => $oPost) {
                    if ($key >= 2) {
                        break;
                    }
                    $aData = getDataValueOfPost($oPost, $aSettings['featured_image_size']);
                    echo App::get('CreativeTextBoxItemSc')->renderSc($aData);
                }
                ?>
            </div>
            <?php
            foreach ($aPosts as $key => $oPost) {
                if ($key < 2) {
                    continue;
                }
                if ($key >= 4) {
                    break;
                }
                $aData = getDataValueOfPost($oPost, $aSettings['featured_image_size']);
                echo App::get('CreativeVerticalBoxItemSc')->renderSc($aData);
            }
            ?>
            <div class="grid grid-cols-1 <?php echo esc_attr($gapClass); ?>">
                <?php
                foreach ($aPosts as $key => $oPost) {
                    if ($key < 4) {
                        continue;
                    }
                    if ($key >= 6) {
                        break;
                    }
                    $aData = getDataValueOfPost($oPost, $aSettings['featured_image_size']);
                    echo App::get('CreativeTextBoxItemSc')->renderSc($aData);
                }
                ?>
            </div>
            <?php
            foreach ($aPosts as $key => $oPost) {
                if ($key < 6) {
                    continue;
                }
                $aData = getDataValueOfPost($oPost, $aSettings['featured_image_size']);
                echo App::get('CreativeTextBoxItemSc')->renderSc($aData);
            }
            ?>
        </div>
<?php
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }
}
