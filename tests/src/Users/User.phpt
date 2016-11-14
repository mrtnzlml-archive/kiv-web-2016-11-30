<?php

namespace App\Tests\Users;

use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class User extends \Tester\TestCase
{

	/**
	 * Entity must work without databse!
	 */
	public function testEntity()
	{
		$user = new \App\Users\User('Johny');
		Assert::true(\Ramsey\Uuid\Uuid::isValid($uuid1 = $user->getId()), 'UUID is not valid');
		Assert::same([], $user->getRoles());
		Assert::same('Johny', $user->toNickname());

		$cloned = clone $user;
		Assert::true(\Ramsey\Uuid\Uuid::isValid($uuid2 = $cloned->getId()), 'UUID is not valid');
		Assert::notSame($uuid1, $uuid2);
	}

}

(new User)->run();
