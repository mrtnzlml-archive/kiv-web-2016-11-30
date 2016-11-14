<?php

namespace App\Tests\Routing;

use App\Routing\IdRouter as Router;
use Nette;
use Nette\Application\Request as AppRequest;
use Nette\Http\Url;
use Testbench\Mocks\HttpRequestMock;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class IdRouter extends \Tester\TestCase
{

	/** @var Router */
	private $router;

	public function setUp()
	{
		$this->router = new Router([
			0 => 'Homepage:default', // 0 = default
			1 => 'Single:about',
		]);
	}

	public function testMatch()
	{
		// Home page
		$appRequest = $this->router->match(new HttpRequestMock);
		Assert::same('Homepage', $appRequest->getPresenterName());
		Assert::same([
			'id' => 0,
			'action' => 'default',
		], $appRequest->getParameters());

		// Single page
		$appRequest = $this->router->match(new HttpRequestMock(
			new Nette\Http\UrlScript('http://test.bench/?id=1')
		));
		Assert::same('Single', $appRequest->getPresenterName());
		Assert::same([
			'id' => 1,
			'action' => 'about',
		], $appRequest->getParameters());

		// 404
		Assert::null($this->router->match(new HttpRequestMock(
			new Nette\Http\UrlScript('http://test.bench/?id=2')
		)));
	}

	public function testConstructUrl()
	{
		// Home page
		Assert::same('http://test.bench/', $this->router->constructUrl(
			new AppRequest('Homepage', NULL, ['action' => 'default']),
			new Url('http://test.bench/')
		));

		// Single page
		Assert::same('http://test.bench/?id=1', $this->router->constructUrl(
			new AppRequest('Single', NULL, ['action' => 'about']),
			new Url('http://test.bench/')
		));

		// 404
		Assert::null($this->router->constructUrl(
			new AppRequest('Single', NULL, ['action' => 'whatever']),
			new Url('http://test.bench/')
		));
	}

}

(new IdRouter)->run();
