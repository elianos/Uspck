<?php

/**
 * Model base class.
 */
class Model extends Nette\Object
{
	/** @var Nette\Database\Connection */
	public $database;



	public function __construct($database)
	{
		return new Authenticator($database->table('core_users'));
	}



	public function createAuthenticatorService($db)
	{
		return new Authenticator($db->table('core_users'));
	}

}