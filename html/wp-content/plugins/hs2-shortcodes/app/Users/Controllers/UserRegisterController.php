<?php


namespace HSSC\Users\Controllers;


use HSSC\Illuminate\Message\MessageFactory;

class UserRegisterController
{
	public function __construct()
	{
		add_action('rest_api_init', function () {
			register_rest_route(HSBLOG2_NAMESPACE . '/' . HSBLOG2_VERSION_API, 'sign-up', [
				[
					'methods'             => 'POST',
					'callback'            => [$this, 'handleSignUp'],
					'permission_callback' => '__return_true'
				]
			]);
		});
	}

	public function handleSignUp(\WP_REST_Request $oRequest)
	{
		$aData = $oRequest->get_params();
		try {
			if (!is_email($aData['email'])) {
				return MessageFactory::factory('rest')->error('Invalid Email address', 401);
			}
			if (!empty(username_exists($aData['username']))) {
				return MessageFactory::factory('rest')->error('Username already exists', 401);
			}
			if (!empty(email_exists($aData['email']))) {
				return MessageFactory::factory('rest')->error('Email already exists', 401);
			}
			$userId = wp_insert_user([
				'user_login' => $aData['username'],
				'user_email' => $aData['email'],
				'user_pass'  => $aData['password']
			]);
			if (is_wp_error($userId)) {
				return MessageFactory::factory('rest')->error($userId->get_error_message(), 401);
			} else {
				return MessageFactory::factory('rest')->success(esc_html__('Congrats, You have registered successfully', 'hsblog2-shortcodes'), [
					'userId' => $userId,
				]);
			}
		} catch (\Exception $oException) {
			return MessageFactory::factory('rest')->error($oException->getMessage(), $oException->getCode());
		}
	}
}
