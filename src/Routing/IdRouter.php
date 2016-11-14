<?php

namespace App\Routing;

use Nette;
use Nette\Application;

class IdRouter implements Application\IRouter
{

	use Nette\SmartObject;

	const ACTION_KEY = 'action';
	const ID_KEY = 'id';
	const PRESENTER_KEY = 'presenter';

	private $idMap;

	private $idMapFlip;

	public function __construct(array $idMap)
	{
		$idMap = array_unique($idMap);
		$this->idMapFlip = array_flip($idMap);

		$idMap = array_map(function ($destination) {
			list($presenter, $action) = Nette\Application\Helpers::splitName($destination);
			return [
				self::PRESENTER_KEY => $presenter,
				self::ACTION_KEY => $action,
			];
		}, $idMap);
		$this->idMap = $idMap;
	}

	/**
	 * Maps HTTP request to a Request object.
	 * @return Nette\Application\Request|NULL
	 */
	public function match(Nette\Http\IRequest $httpRequest)
	{
		if ($httpRequest->getUrl()->getPathInfo() !== '') {
			return NULL;
		}

		$params = $httpRequest->getQuery();
		if (!isset($params[self::ID_KEY])) {
			$params[self::ID_KEY] = 0; // default
		} else {
			$params[self::ID_KEY] = (int)$params[self::ID_KEY];
		}

		if (!isset($this->idMap[$params[self::ID_KEY]])) {
			return NULL;
		}

		$params[self::ACTION_KEY] = $this->idMap[$params[self::ID_KEY]][self::ACTION_KEY];
		$presenter = $this->idMap[$params[self::ID_KEY]][self::PRESENTER_KEY];

		return new Application\Request(
			$presenter,
			$httpRequest->getMethod(),
			$params,
			$httpRequest->getPost(),
			$httpRequest->getFiles(),
			[Application\Request::SECURED => $httpRequest->isSecured()]
		);
	}

	/**
	 * Constructs absolute URL from Request object.
	 * @return string|NULL
	 */
	public function constructUrl(Application\Request $appRequest, Nette\Http\Url $refUrl)
	{
		$params = $appRequest->getParameters();
		$presenter = $appRequest->getPresenterName();

		$destination = $presenter . ':' . $params[self::ACTION_KEY];
		if (!array_key_exists($destination, $this->idMapFlip)) {
			return NULL;
		}

		if ($this->idMapFlip[$destination] === 0) {
			unset($params[self::ID_KEY]);
		} else {
			$params[self::ID_KEY] = $this->idMapFlip[$destination];
		}
		unset($params[self::ACTION_KEY]);

		$url = $refUrl->getScheme() . '://' . $refUrl->getAuthority() . $refUrl->getPath();
		$sep = ini_get('arg_separator.input');
		$query = http_build_query($params, '', $sep ? $sep[0] : '&');
		if ($query != '') { // intentionally ==
			$url .= '?' . $query;
		}
		return $url;
	}

}
