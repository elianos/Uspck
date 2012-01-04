<?php

/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace BackendModule;

use \Nette\Application\UI\Presenter,
	\Nette\Security\SimpleAuthenticator,
	\Nette\Http\User,
	\Nette\Http\Session;
	
/**
 * Backend Base presenter.
 * 
 * Class preparing data for all others presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
abstract class BasePresenter extends \BackendModule\Presenter
{	
	
	/**
	 * Function checking if you are logged in
	 */
	protected function startup() {
    	parent::startup();
		if($this->getPresenter()->getName() != 'Backend:Sign'){
	      	if(!$this->getUser()->isLoggedIn()){		
	      		$this->redirect('Sign:in');
	      	}
      	}
	}
}
