<?php

$container = require __DIR__ . '/../app/bootstrap.php';

if (PHP_SAPI === 'cli') {
	die("\e[37;41m To run application in CLI mode use 'bin/console' instead. \e[0m\n");
}

$container
	->getByType(Nette\Application\Application::class)
	->run();
