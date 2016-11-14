<?php

namespace App\Users\DI;

class Extension extends \Adeira\CompilerExtension implements \Kdyby\Doctrine\DI\IEntityProvider
{

	public function loadConfiguration()
	{
		$this->addConfig(__DIR__ . '/config.neon');
	}

	public function getEntityMappings()
	{
		return [
			'App\Users' => __DIR__ . '/..',
		];
	}

}
