<?php


namespace HSSC\Users\Controllers;


use Exception;
use HSSC\Illuminate\Message\MessageFactory;
use HSSC\Shared\Users\JWTTrait;
use HSSC\Users\Models\BookmarkModel;
use WP_REST_Request;

class UserBookmarkController
{
    use JWTTrait;

    public function __construct()
    {
        add_action('rest_api_init', function () {
            register_rest_route(HSBLOG2_NAMESPACE . '/' . HSBLOG2_VERSION_API, 'me/bookmarks', [
                [
                    'methods'             => 'GET',
                    'callback'            => [$this, 'getStatusBookmarks'],
                    'permission_callback' => '__return_true'
                ],
                [
                    'methods'             => 'POST',
                    'callback'            => [$this, 'createBookmark'],
                    'permission_callback' => '__return_true'
                ],
                [
                    'methods'             => 'PUT',
                    'callback'            => [$this, 'updateBookmark'],
                    'permission_callback' => '__return_true'
                ],
                [
                    'methods'             => 'DELETE',
                    'callback'            => [$this, 'deleteBookmark'],
                    'permission_callback' => '__return_true'
                ]
            ]);
        });
    }

    /**
     * @param WP_REST_Request $oRequest
     * @return void
     */
    public function getStatusBookmarks(WP_REST_Request $oRequest)
    {
        $aData = $oRequest->get_params();
        $aData['user_id'] = $this->getCurrentUserId();
        try {
            if (BookmarkModel::isExist($aData)) {
                return MessageFactory::factory('rest')->success(esc_html__(
                    'The data has been returned successfully',
	                'hs2-shortcodes'
                ), [
                    'statusBookmark' => BookmarkModel::get($aData) === 'yes'
                ]);
            } else {
                return MessageFactory::factory('rest')->error("The bookmark has not existed in database", 400);
            }
        } catch (Exception $oException) {
            return MessageFactory::factory('rest')->error($oException->getMessage(), $oException->getCode());
        }
    }

    /**
     * @param WP_REST_Request $oRequest
     * @return void
     */
    public function createBookmark(WP_REST_Request $oRequest)
    {
        $aData = $oRequest->get_params();
        $aData['user_id'] = $this->getCurrentUserId();
        try {
            if (!BookmarkModel::isExist($aData)) {
                if (BookmarkModel::insert($aData)) {
                    return MessageFactory::factory('rest')->success(esc_html__(
                        'The data has been created successfully',
	                    'hs2-shortcodes'
                    ));
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
    public function updateBookmark(WP_REST_Request $oRequest)
    {
        $aData = $oRequest->get_params();
        $aData['user_id'] = $this->getCurrentUserId();
        try {
            if (BookmarkModel::isExist($aData)) {
                if (BookmarkModel::update($aData)) {
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
    public function deleteBookmark(WP_REST_Request $oRequest)
    {
        $aData = $oRequest->get_params();
        $aData['user_id'] = $this->getCurrentUserId();
        try {
            if (BookmarkModel::isExist($aData)) {
                if (BookmarkModel::delete($aData)) {
                    return MessageFactory::factory('rest')->success(esc_html__(
                        'The data has been deleted successfully',
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
}
