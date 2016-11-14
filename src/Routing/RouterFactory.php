<?php

namespace App\Routing;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;

class RouterFactory
{

	use Nette\StaticClass;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter($idMap = [])
	{
		$router = new RouteList;
		if ($idMap) {
			$router[] = new IdRouter($idMap);
		} else {
			$router[] = new Route('<action>[/<id>]', 'Front:Single:');
			$router[] = new Route('<presenter>/<action>[/<id>]', 'Front:Homepage:default');
		}
		return $router;
	}

}
