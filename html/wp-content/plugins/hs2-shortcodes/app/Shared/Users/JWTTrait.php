<?php


namespace HSSC\Shared\Users;


trait JWTTrait
{
    /**
     * @return int
     */
    public function getCurrentUserId(): int
    {
        $oUserData = $this->getCurrentUser();
        if (!empty($oUserData)) {
            return (int)$oUserData->userID;
        } else {
            return 0;
        }
    }

    /**
     * @return object{'userID'=> int,'userName'=> string,'userEmail': 'string'}|null
     */
    protected function getCurrentUser(): ?object
    {
        if (isset($_COOKIE['wiloke_my_jwt']) && !empty($_COOKIE['wiloke_my_jwt'])) {
            $aResponse = $this->getResponseData($_COOKIE['wiloke_my_jwt']);
            if (isset($aResponse['error']) && $aResponse['error']['message'] == 'Expired token') {
                $aToken = apply_filters(
                    'wiloke/filter/revoke-refresh-access-token',
                    [
                        'error' => [
                            'message' => esc_html__('Wiloke JWT plugin is required', 'hsblog2-shortcodes'),
                            'code'    => 404
                        ]
                    ],
                    $_COOKIE['wiloke_my_rf_token']
                );
                if (!empty($aToken) && !isset($aToken['error'])) {
                    //tạo lại giá trị cookie
                    do_action(
                        'wiloke-jwt/created-access-and-refresh-token',
                        $aToken['data']['accessToken'],
                        $aToken['data']['refreshToken']
                    );
                    $aResponse = $this->getResponseData($aToken['data']['accessToken']);
                } else {
                    $aResponse['error'] = $aToken['error'];
                }
            }
            return (isset($aResponse['error'])) ? null : $aResponse['data'];
        } else {
            return null;
        }
    }

    private function getResponseData(string $cookie)
    {
        return apply_filters(
            'wiloke-jwt/filter/verify-token',
            [
                'error' => [
                    'message' => esc_html__('Wiloke JWT plugin is required', 'hsblog2-shortcodes'),
                    'code'    => 404
                ]
            ],
            $cookie
        );
    }
}
