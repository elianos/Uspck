<?php

/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace BackendModule;

use \Nette\Application\UI\Form,
	Nette\Application\UI,
	Nette\Security as NS;


/**
 * User presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class SignPresenter extends \FrontendModule\BasePresenter
{

	/**
	 * Sign in form component factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new UI\Form;
		$form->getElementPrototype()->class('ajax');
		$form->addText('username', 'Uživatelské jméno:')
			->setRequired('Zadejte uživatelské jméno.')->getControlPrototype()->tabindex(1);

		$form->addPassword('password', 'Heslo:')->addRule(Form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků', 6)
			->setRequired('Zadejte heslo.')->getControlPrototype()->tabindex(2);

		$form->addCheckbox('remember', 'Zapamatovat si mě zde.')->getControlPrototype()->tabindex(3);

		$form->addSubmit('send', 'Přihlásit')->getControlPrototype()->tabindex(4);

		$form->onSubmit[] = callback($this, 'signInFormSubmitted');
		return $form;
	}


	/**
	 * Function data processing of sing in form
	 * @param \Nette\Application\UI\Form $form
	 */
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
				$this->invalidateControl('flashMessages');
		        $this->invalidateControl('form');
			}
		}
	}


	/**
	 * Function signing out user
	 */
	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Byl jste odhlášen.');
		$this->redirect('in');
	}

}
