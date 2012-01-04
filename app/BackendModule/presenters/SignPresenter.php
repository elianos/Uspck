<?php

/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace BackendModule;

use Nette\Application\UI,
	Nette\Security as NS;


/**
 * User presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class SignPresenter extends \FrontendModule\BasePresenter
{

	public function actionIn(){
		
	}

	/**
	 * Sign in form component factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new UI\Form;
		$form->getElementPrototype()->class('ajax');
		$form->addText('username', 'Uživatelské jméno:')
			->setRequired('Zadejte uživatelské jméno.');

		$form->addPassword('password', 'Heslo:')
			->setRequired('Zadejte heslo.');

		$form->addCheckbox('remember', 'Zapamatovat si mě zde.');

		$form->addSubmit('send', 'Přihlásit');

		$form->onSubmit[] = callback($this, 'signInFormSubmitted');
		return $form;
	}



	public function signInFormSubmitted($form)
	{
		try {
			$values = $form->getValues();
			if ($values->remember) {
				$this->getUser()->setExpiration('+ 14 days', FALSE);
			} else {
				$this->getUser()->setExpiration('+ 20 minutes', TRUE);
			}
			$this->getUser()->login($values->username, $values->password);
			if($this->isAjax()){
				$this->redirect('Webs:');
				$this->invalidateControl();
			}
			$this->redirect('Webs:');
		} catch (\Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
			if($this->isAjax()){
				//$form->setValues(array(), TRUE);
				$this->invalidateControl('flashMessages');
		        $this->invalidateControl('form');
			}
		}
	}



	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Byl jste odhlášen.');
		$this->redirect('in');
	}

}
