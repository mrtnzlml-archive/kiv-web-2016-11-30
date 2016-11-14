<?php

namespace App\Tests\Presenters;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class HomepagePresenter extends \Tester\TestCase
{

	use \Testbench\TPresenter;

	public function testActionDefault()
	{
		$this->checkAction('Front:Homepage:default');
	}

}

(new HomepagePresenter)->run();
