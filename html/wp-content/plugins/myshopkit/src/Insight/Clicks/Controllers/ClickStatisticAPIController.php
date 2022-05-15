<?php


namespace MyShopKitPopupSmartBarSlideIn\Insight\Clicks\Controllers;


use Exception;
use MyShopKitPopupSmartBarSlideIn\Illuminate\Message\MessageFactory;
use MyShopKitPopupSmartBarSlideIn\Insight\Clicks\Database\ClickStatisticTbl;
use MyShopKitPopupSmartBarSlideIn\Insight\Clicks\Models\ClickStatisticModel;
use MyShopKitPopupSmartBarSlideIn\Insight\Interfaces\IInsightController;
use MyShopKitPopupSmartBarSlideIn\Insight\Shared\TraitCheckCustomDateInMonth;
use MyShopKitPopupSmartBarSlideIn\Insight\Shared\TraitReportStatistic;
use MyShopKitPopupSmartBarSlideIn\Insight\Shared\TraitUpdateDeleteCreateInsightValidation;
use MyShopKitPopupSmartBarSlideIn\Insight\Shared\TraitVerifyParamStatistic;
use MyShopKitPopupSmartBarSlideIn\Shared\AutoPrefix;
use MyShopKitPopupSmartBarSlideIn\Shared\Middleware\TraitMainMiddleware;
use MyShopKitPopupSmartBarSlideIn\Shared\TraitHelper;
use WP_REST_Request;
use WP_REST_Response;

class ClickStatisticAPIController implements IInsightController
{
    private string $postType = '';
    use TraitUpdateDeleteCreateInsightValidation;
    use TraitCheckCustomDateInMonth;
    use TraitReportStatistic;
    use TraitHelper;
    use TraitVerifyParamStatistic;
    use TraitMainMiddleware;

    public function __construct()
    {
        add_action('rest_api_init', [$this, 'registerRouters']);
	    add_action('wp_ajax_' . MYSHOOKITPSS_PREFIX . 'getPopupClicks', [$this, 'ajaxGetClicks']);
	    add_action('wp_ajax_' . MYSHOOKITPSS_PREFIX . 'getSmartBarClicks', [$this, 'ajaxGetClicks']);
	    add_action('wp_ajax_' . MYSHOOKITPSS_PREFIX . 'getSlideInClicks', [$this, 'ajaxGetClicks']);
    }

	public function ajaxGetClicks()
	{
		$aParams = $_POST['params'] ?? [];
		$oRequest = new WP_REST_Request();
		if (!empty($aParams)) {
			foreach ($aParams as $key => $val) {
				$oRequest->set_param($key, $val);
			}
		}

		$oResponse = $this->reportClicks($oRequest);
		MessageFactory::factory('ajax')->success(
			$oResponse->get_data()['message'],
			$oResponse->get_data()['data']
		);
	}

    public function registerRouters()
    {
        register_rest_route(MYSHOOKITPSS_REST, 'insights/clicks',
            [
                [
                    'methods'             => 'GET',
                    'callback'            => [$this, 'reportClicks'],
                    'permission_callback' => '__return_true'
                ]
            ]
        );


        register_rest_route(MYSHOOKITPSS_REST, 'insights/clicks/(?P<id>(\d+))',
            [
                [
                    'methods'             => 'GET',
                    'callback'            => [$this, 'reportClickBySpecifyingPostID'],
                    'permission_callback' => '__return_true'
                ],
                [
                    'methods'             => 'POST',
                    'callback'            => [$this, 'updateClick'],
                    'permission_callback' => '__return_true'
                ],
                [
                    'methods'             => 'DELETE',
                    'callback'            => [$this, 'deleteClick'],
                    'permission_callback' => '__return_true'
                ]
            ]
        );
    }

    public function deleteClick(WP_REST_Request $oRequest)
    {

        $aValidation = $this->validateCreateOrUpdateInsight($oRequest->get_param('id'), true,
            AutoPrefix::namePrefix('popup'));

        if (($aValidation['status'] == 'success')) {
            $id = ClickStatisticModel::delete($aValidation['data']['postID'], $aValidation['data']['shopID']);
            if (!empty($id)) {
                return MessageFactory::factory('rest')
                    ->success(esc_html__('The clicks has deleted in database successfully',
                        'myshopkit-popup-smartbar-slidein'));
            } else {
                return MessageFactory::factory('rest')
                    ->error(esc_html__('We could not deleted the clicks in database',
                        'myshopkit-popup-smartbar-slidein'), 401);
            }
        } else {
            return MessageFactory::factory('rest')->error($aValidation['message'], $aValidation['code']);
        }
    }

    public function reportClicks(WP_REST_Request $oRequest)
    {
            $aAdditional = [
                'from' => $oRequest->get_param('from'),
                'to'   => $oRequest->get_param('to')
            ];
            $postType = $oRequest->get_param('postType');
            $filter = $oRequest->get_param('filter');
            $filter = empty($filter) ? 'today' : $filter;

            try {
                $this->verifyParamStatistic($postType, $filter, $aAdditional);
                $this->postType = AutoPrefix::namePrefix($postType);
                $aData = $this->getReport($filter,$aAdditional);

                return MessageFactory::factory('rest')->success(
                    'success',
                    [
                        'type'     => 'click',
                        'summary'  => $aData['summary'],
                        'timeline' => $aData['timeline']
                    ]
                );
            } catch (Exception $exception) {
                return MessageFactory::factory('rest')->error($exception->getMessage(), $exception->getCode());
            }
    }

    public function reportClickBySpecifyingPostID(WP_REST_Request $oRequest)
    {
        $postType = $oRequest->get_param('postType');
        $postID = $oRequest->get_param('id');
        $filter = $oRequest->get_param('filter');
        $filter = empty($filter) ? 'today' : $filter;
        $aValidation = $this->processMiddleware([
            'IsCampaignExist',
            'IsCampaignTypeExist'
        ], [
            'postID'   =>$postID,
            'postType' => AutoPrefix::namePrefix($postType),
        ]);
        if ($aValidation['status'] === 'success') {
            $aAdditional = [
                'from' => $oRequest->get_param('from'),
                'to'   => $oRequest->get_param('to')
            ];

            try {
                $this->verifyParamStatistic($postType, $filter, $aAdditional);
                $this->postType = AutoPrefix::namePrefix($postType);
                $aData = $this->getReport($filter,$aAdditional, $postID);

                return MessageFactory::factory('rest')->success(
                    'success',
                    [
                        'type'     => 'click',
                        'summary'  => $aData['summary'],
                        'timeline' => $aData['timeline']
                    ]
                );
            } catch (Exception $exception) {
                return MessageFactory::factory('rest')->error($exception->getMessage(), $exception->getCode());
            }
        } else {
            return MessageFactory::factory('rest')->error(
                $aValidation['message'],
                $aValidation['code']
            );
        }

    }

    /**
     * id la popup id
     *
     * @param WP_REST_Request $oRequest
     *
     * @return WP_REST_Response
     * @throws Exception
     */
    public function updateClick(WP_REST_Request $oRequest): WP_REST_Response
    {
        $postType = $oRequest->get_param('postType');
        $postID = $oRequest->get_param('id');
        try {
            $this->verifyParamStatistic($postType);
            $aValidationResponse = $this->processMiddleware([
                'IsCampaignExist',
                'IsCampaignTypeExist'
            ], [
                'postID'   =>$postID,
                'postType' => AutoPrefix::namePrefix($postType),
            ]);
            if (($aValidationResponse['status'] == 'success')) {
                $aResult = $this->updateClickedToday(
                    $postID
                );
                if ($aResult['status'] == 'success') {
                    $this->postType = AutoPrefix::namePrefix($postType);
                    $aData = $this->getReport(
                        'today',
                        [],
                        $postID
                    );

                    return MessageFactory::factory('rest')
                        ->success(
                            $aResult['message'],
                            [
                                'id'       => $aResult['data']['id'],
                                'type'     => 'click',
                                'summary'  => $aData['summary'],
                                'timeline' => $aData['timeline']
                            ]
                        );
                } else {
                    return MessageFactory::factory('rest')
                        ->error($aResult['message'], $aResult['code']);
                }
            } else {
                return MessageFactory::factory('rest')
                    ->error($aValidationResponse['message'], $aValidationResponse['code']);
            }
        } catch (Exception $exception) {
            return MessageFactory::factory('rest')
                ->error($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * Lưu lại số lượt click trong ngày hôm nay. Nếu đã có click rồi thì tự động tăng thêm 1
     *
     * @param $postID
     *
     * @return array
     */
    public function updateClickedToday($postID): array
    {
        if (ClickStatisticModel::isClickedToday($postID)) {
            $clickID = ClickStatisticModel::getIDWithPostID( $postID);
            $total = (int)ClickStatisticModel::getField($clickID, 'total') + 1;
            $status = ClickStatisticModel::update([
                'total' => $total,
                'ID'    => $clickID
            ]);

            if (!empty($status)) {
                return MessageFactory::factory()
                    ->success(
                        esc_html__('The clicks has updated in database successfully', 'myshopkit-popup-smartbar-slidein'),
                        [
                            'id' => $clickID
                        ]
                    );
            } else {
                return MessageFactory::factory()->error(
                    esc_html__('We could not updated the click', 'myshopkit-popup-smartbar-slidein'),
                    401
                );
            }
        } else {
            $status = ClickStatisticModel::insert([
                'postID' => $postID
            ]);

            if (!empty($status)) {
                return MessageFactory::factory()->success(
                    esc_html__('The clicks has updated in database successfully', 'myshopkit-popup-smartbar-slidein'),
                    [
                        'id' => (string)$status
                    ]
                );
            } else {
                return MessageFactory::factory()->error(esc_html__('We could not updated the click', 'myshopkit-popup-smartbar-slidein'),
                    401);
            }
        }
    }

    public function getTable(): string
    {
        return ClickStatisticTbl::getTblName();
    }

    public function generateResponseClass(string $queryFilter): string
    {
        $ucFirstFilter = ucfirst($queryFilter);

        return "MyShopKitPopupSmartBarSlideIn\Insight\Shared\\$ucFirstFilter\\$ucFirstFilter" . "Response";
    }

    public function generateQueryClass(string $queryFilter): string
    {
        $ucFirstFilter = ucfirst($queryFilter);

        return "MyShopKitPopupSmartBarSlideIn\Insight\Shared\\$ucFirstFilter\\$ucFirstFilter" . "Query";
    }

    public function getSummary(): string
    {
        return "SUM(total) as summary";
    }

    public function getPostType(): string
    {
        return $this->postType;
    }
}
