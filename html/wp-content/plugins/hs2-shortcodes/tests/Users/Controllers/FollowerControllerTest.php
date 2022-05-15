<?php


namespace HSSCTEST\Controllers;


use HSSC\Users\Models\FollowerModel;
use HSSCTEST\CommonController;

class FollowerControllerTest extends CommonController
{
	public    $userId = 1;
	protected $aInfoUser
	                  = [
			'username' => 'test1',
			'password' => 'test1',
			'roles'    => ['contributor']
		];
	private   $followerId;

	public function getData()
	{
		return [
			'followerId' => $this->getFollowerId(),
			'userId'     => $this->userId
		];
	}

	public function testIsFollowerExist()
	{
		$status = FollowerModel::isFollowerExist($this->getData());
		$this->assertTrue($status);
	}

	public function getFollowerId()
	{
		$this->createUser($this->aInfoUser);
		$this->setUserLogin($this->aInfoUser['username']);
		$this->followerId = (get_user_by('login', $this->aInfoUser['username']))->ID;
		return $this->followerId;
	}

	public function testInsertFollower()
	{
		$aResponse = $this->restGET('follower', $this->getData());
		$this->assertEquals('success', $aResponse['status'], 'returns the status of success');
		$this->assertEquals('yes', $aResponse['isFollowing'], 'You have a successful follower');
	}

	/**
	 * @depends testInsertFollower
	 */
	public function testDeleteFollower()
	{
		$aResponse = $this->restGET('follower', $this->getData());
		$this->assertEquals('success', $aResponse['status'], 'returns the status of success');
		$this->assertEquals('no', $aResponse['isFollowing'], 'You have successfully unsubscribed');
	}

	public function testGetFollower()
	{
		$response = FollowerModel::getFollower($this->getData());
		$this->assertIsNumeric($response);
	}

	public function testGetFollowing()
	{
		$response = FollowerModel::getFollowing($this->getData());
		$this->assertIsNumeric($response);
	}
}