<?php


namespace HSSC\Users\Controllers;


use Exception;
use HSSC\Illuminate\Message\MessageFactory;
use HSSC\Shared\Users\JWTTrait;
use HSSC\Users\Models\FollowerModel;
use WP_REST_Request;
use WP_REST_Response;

class UserFollowerController
{
    use JWTTrait;

    public function __construct()
    {
        add_action('rest_api_init', function () {
            register_rest_route(HSBLOG2_NAMESPACE . '/' . HSBLOG2_VERSION_API, 'me/followers', [
                [
                    'methods'             => 'POST',
                    'callback'            => [$this, 'createFollower'],
                    'permission_callback' => '__return_true'
                ],
                [
                    'methods'             => 'DELETE',
                    'callback'            => [$this, 'deleteFollower'],
                    'permission_callback' => '__return_true'
                ],
                [
                    'methods'             => 'GET',
                    'callback'            => [$this, 'getFollowers'],
                    'permission_callback' => '__return_true'
                ]
            ]);
        });
    }

    /**
     * @param WP_REST_Request $oRequest
     * @return void
     */
    public function createFollower(WP_REST_Request $oRequest)
    {
        $aData = $oRequest->get_params();
        $aData['user_id'] = $this->getCurrentUserId();
        try {
            if (!FollowerModel::isExist($aData)) {
                if (FollowerModel::insert($aData)) {
                    return MessageFactory::factory('rest')->success(esc_html__('The follower info has been created successfully', 'hsblog2-shortcodes'));
                } else {
                    return MessageFactory::factory('rest')->error('The parameter is not valid', 400);
                }
            } else {
                return MessageFactory::factory('rest')->error('The data had already existed in the database', 400);
            }
        } catch (Exception $oException) {
            return MessageFactory::factory('rest')->error($oException->getMessage(), $oException->getCode());
        }
    }

    /**
     * @param WP_REST_Request $oRequest
     * @return void
     */
    public function getFollowers(WP_REST_Request $oRequest)
    {
        $aData = $oRequest->get_params();
        $aData['user_id'] = $this->getCurrentUserId();
        try {
            return MessageFactory::factory('rest')->success(esc_html__(
                'The data has been returned successfully',
                'hsblog2-shortcodes'
            ), [
                'countFollowings' => FollowerModel::getFollowing($aData),
                'countFollowers'  => FollowerModel::getFollower($aData)
            ]);
        } catch (Exception $oException) {
            return MessageFactory::factory('rest')->error($oException->getMessage(), $oException->getCode());
        }
    }

    /**
     * @param WP_REST_Request $oRequest
     * @return void
     */
    public function deleteFollower(WP_REST_Request $oRequest)
    {
        $aData = $oRequest->get_params();
        $aData['user_id'] = $this->getCurrentUserId();
        try {
            if (FollowerModel::isExist($aData)) {
                if (FollowerModel::delete($aData)) {
                    return MessageFactory::factory('rest')
                        ->success(esc_html__('The follower info has been deleted successfully', 'hsblog2-shortcodes'));
                } else {
                    return MessageFactory::factory('rest')->error('The parameter is not valid', 400);
                }
            } else {
                return MessageFactory::factory('rest')->error('The data not had already existed in the database', 400);
            }
        } catch (Exception $oException) {
            return MessageFactory::factory('rest')->error($oException->getMessage(), $oException->getCode());
        }
    }
}
