<?php

/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

use Nette\Diagnostics\Debugger,
	Nette\Application\Routers\SimpleRouter,
	Nette\Application\Routers\Route;


/**
 * Route prepare.
 * 
 * Class for prepare of url rewrite
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class RouterPrepare{
	
	private $router;
		
	public function __construct($connection, $router) {
		$this->router = $router;
		foreach($connection->query('SELECT core_pages.*, core_modules.presenter, core_modules.action, core_webs.url FROM core_pages LEFT JOIN core_modules ON core_pages.core_modules_id = core_modules.id LEFT JOIN core_webs ON core_webs.id = core_pages.core_webs_id') as $r){
			if($r->home == 1){
				$this->router[] = new Route($r->url, array('module' => 'Frontend', 'presenter' => $r->presenter, 'action' => $r->action, 'id' => $r->id, 'web' => $r->core_webs_id));
				$this->router[] = new Route($r->url.'index.php', array('module' => 'Frontend', 'presenter' => $r->presenter, 'action' => $r->action, 'id' => $r->id, 'web' => $r->core_webs_id));
			}
			$this->router[] = new Route($r->url.$r->rewrite.'[/<action>][/<inid>]', array('module' => 'Frontend', 'presenter' => $r->presenter, 'action' => $r->action, 'id' => $r->id, 'web' => $r->core_webs_id));
		}
		$this->router[] = new Route('admin[/<presenter>][/<action>][/<id>]', array('module' => 'Backend', 'presenter' => 'webs', 'action' => 'default', 'id' => null));
	}

	public function getRouter(){
		return $this->router;
	}
}