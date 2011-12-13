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
	protected function startup() {
    	parent::startup();
		if($this->getPresenter()->getName() != 'Backend:Sign'){
	      	if(!$this->getUser()->isLoggedIn()){		
	      		//$section = $this->session->getSection('redirect');
	      		//list($_dum , $section->presenter) = explode(":", $this->getPresenter()->getName());
				//$section->action = $this->getAction();
				//$section->id = $this->getParam('id');
	      		$this->redirect('Sign:in');
	      	}
      	}
	}
}
