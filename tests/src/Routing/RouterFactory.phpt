<?php

namespace App\Tests\Routing;

use App\Routing\RouterFactory as RF;
use Nette\Application\Routers;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class RouterFactory extends \Tester\TestCase
{

	public function testCreateRouter()
	{
		/** @var Routers\RouteList $routeList */
		Assert::type(Routers\RouteList::class, $routeList = RF::createRouter());
		Assert::same('', $routeList->getModule());
		Assert::same([
			'<action>[/<id>]',
			'<presenter>/<action>[/<id>]',
		], array_map(function (Routers\Route $route) {
			return $route->getMask();
		}, (array)$routeList->getIterator()));
	}

}

(new RouterFactory)->run();
