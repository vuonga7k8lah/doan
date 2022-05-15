<?php
namespace MyShopKitPopupSmartBarSlideIn\DoanApp\Controllers;
use Exception;
use MyShopKitPopupSmartBarSlideIn\Illuminate\Message\MessageFactory;
use WP_Post;
use WP_Query;
use WP_REST_Request;

class BlogAppController
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'registerRouters']);
    }

    public function registerRouters()
    {
        register_rest_route(MYSHOOKITPSS_REST, 'app-blogs',
            [
                [
                    'methods'             => 'GET',
                    'callback'            => [$this, 'getPosts'],
                    'permission_callback' => '__return_true'
                ]
            ]
        );
        register_rest_route(MYSHOOKITPSS_REST, 'pages/(?P<id>(\d+))',
            [
                [
                    'methods'             => 'GET',
                    'callback'            => [$this, 'getPage'],
                    'permission_callback' => '__return_true'
                ]
            ]
        );
    }

    public function getPosts(WP_REST_Request $oRequest)
    {
        try {
            $oQuery = new WP_Query([
                'posts_per_page' => 20
            ]);
            if (!$oQuery->have_posts()) {
                wp_reset_postdata();
                return MessageFactory::factory('rest')->success(
                    esc_html__('We found no posts', 'myshopkit-popup-smartbar-slidein'),
                    [
                        'items' => []
                    ]
                );
            }

            /**
             * @var WP_Post $aCoupon
             */

            while ($oQuery->have_posts()) {
                $oQuery->the_post();
                $id = $oQuery->post->ID;

                $aItems[] = [
                    'id'      => $id,
                    'title'   => $oQuery->post->post_title,
                    'link'    => get_permalink($id),
                    'content' => get_the_content($id)
                ];
            }
            $maxPages = $oQuery->max_num_pages;
            wp_reset_postdata();

            return MessageFactory::factory('rest')->success(
                sprintf('We found %s items', count($aItems)),
                [
                    'items'    => $aItems,
                    'maxPages' => $maxPages
                ]
            );
        } catch (Exception $exception) {
            return MessageFactory::factory('rest')->error($exception->getMessage(), $exception->getCode());
        }
    }
}
