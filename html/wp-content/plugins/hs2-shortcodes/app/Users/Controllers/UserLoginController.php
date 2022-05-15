<?php


namespace HSSC\Users\Controllers;


use HSSC\Illuminate\Message\MessageFactory;

class UserLoginController
{
	public function __construct()
	{
		add_action('rest_api_init', function () {
			register_rest_route(HSBLOG2_NAMESPACE . '/' . HSBLOG2_VERSION_API, 'sign-in', [
				[
					'methods'             => 'POST',
					'callback'            => [$this, 'handleSignIn'],
					'permission_callback' => '__return_true'
				]
			]);
		});
	}

	public function handleSignIn(\WP_REST_Request $oRequest)
	{
		$aData = $oRequest->get_params();
		try {
			$oUser = wp_authenticate($aData['username'], $aData['password']);
			if (is_wp_error($oUser)) {
				return MessageFactory::factory('rest')->error($oUser->get_error_message(), 401);
			} else {
				return MessageFactory::factory('rest')->success(esc_html__(
					'Congrats, You have logged in successfully',
					'hsblog2-shortcodes'
				), [
					'userData' => $oUser->data
				]);
			}
		} catch (\Exception $oException) {
			return MessageFactory::factory('rest')->error($oException->getMessage(), $oException->getCode());
		}
	}
}
