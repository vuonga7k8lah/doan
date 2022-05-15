<?php

namespace MyShopKitPopupSmartBarSlideIn\Dashboard\Shared;

use Envato_Elements\Backend\Options;
use Envato_Elements\Backend\Subscription;
use MyShopKitPopupSmartBarSlideIn\Shared\AutoPrefix;
use WilcityServiceClient\Helpers\GetSettings;

trait GeneralHelper
{
    protected string $dashboardSlug = 'dashboard';
    protected string $authSlug = 'auth-settings';

    protected function getDashboardSlug(): string
    {
        return AutoPrefix::namePrefix($this->dashboardSlug);
    }

    protected function getAuthSlug(): string
    {
        return AutoPrefix::namePrefix($this->authSlug);
    }

	private function getToken()
	{
		if (class_exists('Envato_Elements\Backend\Subscription')) {
			$elements_token = Options::get_instance()->get(Subscription::SUBSCRIPTION_TOKEN_OPTION);
			if ($elements_token && !empty($elements_token['token'])) {
				return "envatoelement";
			}
		}

		$token = get_option(AutoPrefix::namePrefix('purchase_code'));
		if (!empty($token) && $token !== "free") {
			return $token;
		}

		if (class_exists('\WilcityServiceClient\Helpers\GetSettings')) {
			return GetSettings::getOptionField('secret_token');
		}

		return 'free';
	}
}
