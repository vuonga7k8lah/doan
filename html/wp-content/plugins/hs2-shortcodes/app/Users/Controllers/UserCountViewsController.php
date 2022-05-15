<?php


namespace HSSC\Users\Controllers;


use Exception;
use HSSC\Illuminate\Message\MessageFactory;
use HSSC\Shared\Users\JWTTrait;
use HSSC\Users\Models\UserModel;
use WP_REST_Request;

class UserCountViewsController
{
    use JWTTrait;

    public function __construct()
    {
        add_action('rest_api_init', function () {
            register_rest_route(HSBLOG2_NAMESPACE . '/' . HSBLOG2_VERSION_API, 'me/count-views', [
                [
                    'methods'             => 'GET',
                    'callback'            => [$this, 'getCountViews'],
                    'permission_callback' => '__return_true'
                ],
                [
                    'methods'             => 'POST',
                    'callback'            => [$this, 'createCountView'],
                    'permission_callback' => '__return_true'
                ],
                [
                    'methods'             => 'PUT',
                    'callback'            => [$this, 'updateCountView'],
                    'permission_callback' => '__return_true'
                ],
                [
                    'methods'             => 'DELETE',
                    'callback'            => [$this, 'deleteCountView'],
                    'permission_callback' => '__return_true'
                ]
            ]);
        });
    }

    /**
     * @param WP_REST_Request $oRequest
     * @return void
     */
    public function getCountViews(WP_REST_Request $oRequest)
    {
        $aData = $oRequest->get_params();
        $aData['user_id'] = $this->getCurrentUserId();
        try {
            $aData = $this->handleDataCountViews($aData);
            if (UserModel::isViewedToday($aData)) {
                return MessageFactory::factory('rest')->success(esc_html__(
                    'The data has been returned successfully',
	                'hs2-shortcodes'
                ), [
                    'countViews' => UserModel::getCountView($aData)
                ]);
            } else {
                return MessageFactory::factory('rest')->error("The bookmark has not existed in database", 400);
            }
        } catch (Exception $oException) {
            return MessageFactory::factory('rest')->error($oException->getMessage(), $oException->getCode());
        }
    }

    /**
     * @param array{post_id: int,user_id: int,ip_address: string, country: string ,count: int} $aData
     * @return array
     */
    public function handleDataCountViews($aInputData): array
    {
        $aData['ip_address'] = (!isset($aInputData['ip_address']) || empty($aInputData['ip_address'])) ? $this->getClientIp() : $aInputData['ip_address'];
        $aData['country'] = $this->getLocationInfoByIp($aData['ip_address']);
        $aData['post_id'] = (!isset($aInputData['post_id']) || empty($aInputData['post_id'])) ? get_the_ID() : $aInputData['post_id'];
        $aData['user_id'] = (!isset($aInputData['user_id']) || empty($aInputData['user_id'])) ? get_current_user_id() : $aInputData['user_id'];
        if (UserModel::isViewedToday($aData)) {
            $aData['count'] = UserModel::getCountView($aData) + 1;
            $aData['ID'] = empty($aData['user_id']) ? UserModel::getIdViewed($aData) : 0;
        }
        return $aData;
    }

    /**
     * @return string
     */
    public function getClientIp(): string
    {
        // MYSELF
        return $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['HTTP_X_FORWARDED'] ?? $_SERVER['HTTP_FORWARDED_FOR'] ?? $_SERVER['HTTP_FORWARDED'] ?? $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    }

    public function getLocationInfoByIp($ip): string
    {
        return json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"))->geoplugin_countryName ?? 'UNKNOWN';
    }

    /**
     * @param WP_REST_Request $oRequest
     * @return void
     */
    public function createCountView(WP_REST_Request $oRequest)
    {
        $aData = $oRequest->get_params();
        $aData['user_id'] = $this->getCurrentUserId();
        try {
            $aData = $this->handleDataCountViews($aData);
            if (!UserModel::isViewedToday($aData)) {
                if (UserModel::insertCountView($aData)) {
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
    public function updateCountView(WP_REST_Request $oRequest)
    {
        $aData = $oRequest->get_params();
        $aData['user_id'] = $this->getCurrentUserId();
        try {
            $aData = $this->handleDataCountViews($aData);
            if (UserModel::isViewedToday($aData)) {
                if (UserModel::updateCountView($aData)) {
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
    public function deleteCountView(WP_REST_Request $oRequest)
    {
        $aData = $oRequest->get_params();
        $aData['user_id'] = $this->getCurrentUserId();
        try {
            $aData = $this->handleDataCountViews($aData);
            if (UserModel::isViewedToday($aData)) {
                if (UserModel::deleteCountView($aData)) {
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
