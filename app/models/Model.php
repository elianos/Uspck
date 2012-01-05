<?php
/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

/**
 * Model
 * 
 * Class preparing database connection for autentication
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
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