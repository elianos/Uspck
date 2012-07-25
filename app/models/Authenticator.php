<?php

/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

use \Nette\Security as NS;

/**
 * Users authenticator.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */

class MyAuthenticator extends \Nette\Object implements NS\IAuthenticator
{
	/** @var Nette\Database\Table\Selection */
	public $connection;



	function __construct(Nette\Database\Connection $connection)
    {
        $this->connection = $connection;
    }



	/**
	 * Performs an authentication
	 * @param  array
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;
		$row = $this->connection->table('core_users')
            ->where('nickname', $username)->fetch();

		if (!$row) {
			throw new \Nette\Security\AuthenticationException("Uživatel '$username' neexituje.", self::IDENTITY_NOT_FOUND);
		}

		if ($row->password !== $this->calculateHash($password)) {
			throw new \Nette\Security\AuthenticationException("Nesprávné heslo.", self::INVALID_CREDENTIAL);
		}

		unset($row->password);
		$role = 'user';
		if ($row->admin == 1){
			$role = 'admin';
		}
		return new \Nette\Security\Identity($row->nickname, $role, $row->toArray());
	}



	/**
	 * Computes salted password hash.
	 * @param  string
	 * @return string
	 */
	public function calculateHash($password)
	{
		return md5($password . str_repeat('*enter any random salt here*', 10));
	}

}
