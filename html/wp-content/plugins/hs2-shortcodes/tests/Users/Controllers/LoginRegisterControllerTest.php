<?php


namespace HSSCTEST\Controllers;


use HSSCTEST\CommonController;

class LoginRegisterControllerTest extends CommonController
{
	public function testRegister()
	{
		$aResponse = $this->restPOST('sign-up', [
			'username' => 'vuonga7k8lnc11',
			'password' => '12345',
			'email'    => 'vuong21@ahaha.com'
		]);
		$this->assertEquals('success', $aResponse['status'], 'Sign Up Success');
		$this->assertIsNumeric($aResponse['userId'], 'userId is Numberric');
		return $aResponse['userId'];
	}

	/**
	 * @depends testRegister
	 */
	public function testLogin($userId)
	{
		$aResponse = $this->restPOST('sign-in', [
			'username' => 'vuonga7k8lnc',
			'password' => '12345'
		]);
		$this->assertEquals('success', $aResponse['status'], 'Sign Up Success');
		$this->assertIsArray($aResponse['userData'], 'userData is Array');
		$this->assertEquals($userId,$aResponse['userData']['ID']);
	}
}