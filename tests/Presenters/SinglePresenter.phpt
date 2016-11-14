<?php

namespace App\Tests\Presenters;

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class SinglePresenter extends \Tester\TestCase
{

	use \Testbench\TPresenter;

	public function testActionDefault()
	{
		Assert::exception(function () {
			$this->checkAction('Front:Single:default');
		}, \Nette\Application\BadRequestException::class, 'Page not found. Missing template%A%.');
	}

	public function testActionAbout()
	{
		$this->checkAction('Front:Single:about');
	}

	public function testActionLogin()
	{
		$this->checkAction('Front:Single:login');
	}

	public function testLoginForm()
	{
		\Tester\Environment::skip('DIY - database needed... :)');
//		$this->checkForm('Front:Single:login', 'loginForm', [
//			'username' => 'test',
//			'password' => 'test',
//		]);
	}

}

(new SinglePresenter)->run();
