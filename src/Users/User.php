<?php

namespace App\Users;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements \Nette\Security\IIdentity
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid_binary")
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @var \Ramsey\Uuid\Uuid
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", unique=true)
	 */
	private $username;

	/**
	 * @ORM\Column(type="string")
	 */
	private $passwordHash;

	public function toNickname()
	{
		return $this->username;
	}

	public function authenticate($pass, callable $checkHash)
	{
		return $checkHash($pass, $this->passwordHash);
	}

	public function needRehash(callable $checkRehash)
	{
		return $checkRehash($this->passwordHash);
	}

	public function changePass($pass, callable $hash)
	{
		$this->passwordHash = $hash($pass);
	}

	public function __construct($username)
	{
		$this->id = \Ramsey\Uuid\Uuid::uuid4();
		$this->username = $username;
	}

	/**
	 * Implementation of Nette\Security\IIdentity
	 */
	final public function getId()
	{
		return $this->id;
	}

	/**
	 * Implementation of Nette\Security\IIdentity
	 */
	public function getRoles()
	{
		return [];
	}

	public function __clone()
	{
		$this->id = \Ramsey\Uuid\Uuid::uuid4();
	}

}
