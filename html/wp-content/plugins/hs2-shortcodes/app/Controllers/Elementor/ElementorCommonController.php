<?php

namespace HSSC\Controllers\Elementor;

use Exception;
use HSSC\Helpers\App;
use HSSC\Helpers\FunctionHelper;
use HSSC\Illuminate\Message\MessageFactory;
use HSSC\Illuminate\Query\PostQuery\QueryBuilder;
use WP_Query;
use WP_REST_Request;
use function json_decode;

class ElementorCommonController
{
    public function __construct()
    {
        $this->registerRestApiSection();
        add_action('wp_enqueue_scripts', [$this, 'createGlobalAPIBase']);
    }


    public function registerRestApiSection()
    {

        add_action('rest_api_init', function () {
            register_rest_route(HSBLOG2_NAMESPACE . '/' . HSBLOG2_VERSION_API, 'elementor-filter', [
                [
                    'methods'             => 'POST',
                    'callback'            => [$this, 'handleElementorFilter'],
                    'permission_callback' => '__return_true'
                ]
            ]);
        });
    }

    public function handleElementorFilter(WP_REST_Request $oRequest)
    {
        /**
         * Cac param client can truyen len: {
         *    queryArgs: JSON.stringify( { cat: 1, paged: 1, orderby: date }),
         *    blockName:  ColorfulPostsFilterElement,
         *    aSettings:  aSettings,
         *    catId:  catId,
         * }
         *
         */
        $aParams = $oRequest->get_params();
        // Du lieu trong queyArgs js la object nen can POST len dang JSON de PHP convert to array
        $aSettings = FunctionHelper::decodeBase64($aParams['aSettings']);

        $aArgs = json_decode($aParams['queryArgs'], true);
        $aCatID = is_numeric($aParams['catId']) ? [$aParams['catId']] : FunctionHelper::decodeBase64($aParams['catId']);

        $aArgs['category__in'] = $aCatID;
        $aArgs['posts_per_page'] = $aSettings['posts_per_page'];

        $aArgs = (new QueryBuilder)->setRawArgs($aArgs)->parseArgs()->getArgs();

        try {
            $oQuery = new WP_Query($aArgs);
            $aPaginationState = FunctionHelper::checkPaginationShowByPaged($oQuery->max_num_pages, $aArgs['paged']);
            ob_start();
            if ($oQuery->have_posts()) {
                do_action(
                    HSBLOG2_ELEMENTOR_FILLTER_COMMON . $aParams['blockName'] . "Content",
                    $oQuery,
                    $aSettings
                );
            } else {
                esc_html_e('Sorry! We found no post!', 'hsblog2-shortcodes');
            }

            $content = ob_get_contents();
            ob_end_clean();

            return MessageFactory::factory('rest')->success(
                esc_html__('The posts have been fetched successfully', 'hsblog2-shortcodes'),
                array_merge([
                    'html'    => $content,
                    'blockId' => $aParams['blockId']
                ], $aPaginationState)
            );
        } catch (Exception $oException) {
            return MessageFactory::factory('rest')->error($oException->getMessage(), $oException->getCode());
        }
    }

    public function createGlobalAPIBase()
    {
        wp_localize_script('jquery', 'HSBLOG_GLOBAL', [
            'baseElementorFilterSectionApi' => get_home_url() . '/wp-json/' . HSBLOG2_NAMESPACE . '/' .
                HSBLOG2_VERSION_API . '/elementor-filter/',
            'baseBookmarkApi'               => get_home_url() . '/wp-json/' . HSBLOG2_NAMESPACE . '/' .
                HSBLOG2_VERSION_API . '/me/bookmarks',
            'baseCountViewApi'              => get_home_url() . '/wp-json/' . HSBLOG2_NAMESPACE . '/' .
                HSBLOG2_VERSION_API . '/me/count-views',
            'baseFlowedUserApi'             => get_home_url() . '/wp-json/' . HSBLOG2_NAMESPACE . '/' .
                HSBLOG2_VERSION_API . '/me/followers',
            'baseCommentEmotionApi'         => get_home_url() . '/wp-json/' . HSBLOG2_NAMESPACE . '/' .
                HSBLOG2_VERSION_API . '/me/comment-emotions'
        ]);
    }
}
