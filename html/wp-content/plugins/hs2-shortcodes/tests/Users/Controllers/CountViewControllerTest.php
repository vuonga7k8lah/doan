<?php

namespace HSSCTEST\Controllers;

use HSSC\Users\Controllers\UserCountViewsController;
use HSSC\Users\Models\UserModel;
use HSSCTEST\CommonController;

class CountViewControllerTest extends CommonController
{
	private $aPost
		= [
			'content' => 'test',
			'title'   => 'tets',
		];
	private $aData
		= [
			'ip_address' => '202.888.168',
			'country'    => 'viet nam',
			'count'      => 1,

		];
	private $fPostID;

	public function setUp()
	{
		parent::setUp(); // TODO: Change the autogenerated stub
		$this->fPostID = $this->insertPost();
	}

	public function testInsertViewed()
	{
		$status = (new UserCountViewsController())->handleCountViews();
		$this->assertIsNumeric($status, 'actual value is Numeric');
		$statusNotLoggedIn = UserModel::isViewedToday();
		$this->assertTrue($statusNotLoggedIn);
		return [
			'ip_address' => $this->aData['ip_address'],
			'post_id'    => $this->fPostID,
			'user_id'    => 1
		];
	}

	/**
	 * @depends testInsertViewedHadUserId
	 */
	public function testUpdateInfo($aData)
	{
		$status = (new UserCountViewsController())->handleCountViews();
		$this->assertIsNumeric($status, 'actual value is Numeric');
		$countView = UserModel::getCountView();
		$this->assertEquals(2, $countView);
	}
	public function insertPost()
	{
		return wp_insert_post([
			'post_title'   => $this->aPost['title'],
			'post_content' => $this->aPost['content']
		]);
	}
}