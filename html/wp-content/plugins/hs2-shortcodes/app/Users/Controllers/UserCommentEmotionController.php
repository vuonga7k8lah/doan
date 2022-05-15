<?php


namespace HSSC\Users\Controllers;


use Exception;
use HSSC\Illuminate\Message\MessageFactory;
use HSSC\Shared\Users\JWTTrait;
use HSSC\Users\Models\CommentEmotionModel;
use WP_REST_Request;

class UserCommentEmotionController
{
    use JWTTrait;

    public function __construct()
    {
        add_action('rest_api_init', function () {
            register_rest_route(HSBLOG2_NAMESPACE . '/' . HSBLOG2_VERSION_API, 'me/comment-emotions', [
                [
                    'methods'             => 'GET',
                    'callback'            => [$this, 'getCommentEmotions'],
                    'permission_callback' => '__return_true'
                ],
                [
                    'methods'             => 'POST',
                    'callback'            => [$this, 'createCommentEmotion'],
                    'permission_callback' => '__return_true'
                ],
                [
                    'methods'             => 'PUT',
                    'callback'            => [$this, 'updateCommentEmotion'],
                    'permission_callback' => '__return_true'
                ],
                [
                    'methods'             => 'DELETE',
                    'callback'            => [$this, 'deleteCommentEmotion'],
                    'permission_callback' => '__return_true'
                ]
            ]);
        });
    }

    /**
     * @param WP_REST_Request $oRequest
     * @return void
     */
    public function getCommentEmotions(WP_REST_Request $oRequest)
    {
        $aData = $oRequest->get_params();
        $aData['user_id'] = $this->getCurrentUserId();
        try {
            return MessageFactory::factory('rest')->success(esc_html__(
                'The data has been returned successfully',
                'hs2-shortcodes'
            ), [
                'likes'    => CommentEmotionModel::countLike($aData),
                'dislikes' => CommentEmotionModel::countDislike($aData),
            ]);
        } catch (Exception $oException) {
            return MessageFactory::factory('rest')->error($oException->getMessage(), $oException->getCode());
        }
    }

    /**
     * @param WP_REST_Request $oRequest
     * @return void
     */
    public function createCommentEmotion(WP_REST_Request $oRequest)
    {
        $aData = $oRequest->get_params();
        $aData['user_id'] = $this->getCurrentUserId();
        try {

            // CHECK IF EXIST THEN REMOVE OLD STATUS AFTER CREATE
            if (CommentEmotionModel::isExist($aData)) {
                if (CommentEmotionModel::getStatus($aData) !== $aData['status']) {
                    CommentEmotionModel::delete($aData);
                } else {
                    return MessageFactory::factory('rest')->error('The data had already existed in the database', 400);
                }
            }

            if (CommentEmotionModel::insert($aData)) {
                return MessageFactory::factory('rest')->success(esc_html__(
                    'The data has been created successfully',
                    'hs2-shortcodes'
                ), ['emotions' => CommentEmotionModel::getStatus($aData)]);
            } else {
                return MessageFactory::factory('rest')->error('The parameter is not valid', 400);
            }
        } catch (Exception $oException) {
            return MessageFactory::factory('rest')->error($oException->getMessage(), $oException->getCode());
        }
    }

    /**
     * @param WP_REST_Request $oRequest
     * @return void
     */
    public function updateCommentEmotion(WP_REST_Request $oRequest)
    {
        $aData = $oRequest->get_params();
        $aData['user_id'] = $this->getCurrentUserId();
        try {
            if (CommentEmotionModel::isExist($aData)) {
                if (CommentEmotionModel::update($aData)) {
                    return MessageFactory::factory('rest')->success(esc_html__(
                        'The data has been updated successfully',
                        'hs2-shortcodes'
                    ));
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

    /**
     * @param WP_REST_Request $oRequest
     * @return void
     */
    public function deleteCommentEmotion(WP_REST_Request $oRequest)
    {
        $aData = $oRequest->get_params();
        $aData['user_id'] = $this->getCurrentUserId();
        try {
            if (CommentEmotionModel::isExist($aData)) {
                if (CommentEmotionModel::delete($aData)) {
                    return MessageFactory::factory('rest')->success(esc_html__(
                        'The data has been deleted successfully',
	                    'hs2-shortcodes'
                    ), ['emotions' => CommentEmotionModel::getStatus($aData)]);
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
