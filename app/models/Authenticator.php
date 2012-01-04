<?php

use \Nette\Security as NS;

/**
 * Users authenticator.
 *
 * @author     John Doe
 * @package    MyApplication
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
		return new \Nette\Security\Identity($row->nickname, 'admin', $row->toArray());
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
