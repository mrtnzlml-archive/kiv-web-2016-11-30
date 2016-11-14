<?php

namespace App\Routing\DI;

class Extension extends \Adeira\CompilerExtension
{

	public function loadConfiguration()
	{
		$this->addConfig(__DIR__ . '/config.neon');
	}

}
