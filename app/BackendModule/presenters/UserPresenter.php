<?php

/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace BackendModule;

use \Nette\Application\UI\Form,
	\Nette\Http\Session;

/**
 * User presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class UserPresenter extends BasePresenter
{

	/**
	 * Function preparing data grid with users
	 * @param string $name
	 */
	protected function createComponentUserGrid($name){
        $db = $this->context->getService('database');
		$res = $db->table('core_users');
		$model = new \Gridito\NetteDatabaseModel($res);
		$grid = new \Gridito\Grid($this, $name);
		$grid->setModel($model);
		$grid->addColumn('nickname', 'Nickname')->setSortable(true);
		$grid->addToolbarWindowButton('create', 'Přidat uživatele')->setHandler(function () use ($grid) {
			echo $grid->presenter->createComponentAddForm($grid);
			echo '<script type="text/javascript" src="'.$grid->presenter->template->baseUrl.'/js/live-form-validation.js"></script>';
		});
		$grid->addWindowButton('edit', 'Upravit')->setHandler(function ($row) use ($grid) {
			echo $grid->presenter->createComponentEditForm($row);
			echo '<script type="text/javascript" src="'.$grid->presenter->template->baseUrl.'/js/live-form-validation.js"></script>';
		});
	}	
	
	/**
	 * Function preparing form for addign user
	 * @param \Gridito\Grid $grid
	 * @return Nette\Application\UI\Form
	 */
	public function createComponentAddForm($grid){
		$form = new \Nette\Application\UI\Form();
		$form->setAction('?do=addForm-submit');
		$form->addText('nickname', 'Jméno:')->setRequired('Zadejte Jméno.');
		$form->addPassword('password', 'Heslo:')->setRequired('Zadejte popis.');
		$form->addPassword('password_confirmation', 'Ověření hesla:')->setRequired('Zadejte ověření.');
		$form->addSubmit('submit', 'Vytvořit');
		$form->onSubmit[] = callback($this, 'addFormSubmitted');
		return $form;
	}
	
	/**
	 * Function data processing of add page
	 * @param Nette\Application\UI\Form $form
	 */
	public function addFormSubmitted($form){
		$values = $form->getValues();
		if(strlen($values->password) < 6){
			$this->flashMessage('Heslo musí mít alespoň 6 znaků');
			$this->redirect('user:');
		}elseif($values->password == $values->password_confirmation){
			$inser['nickname'] = $values->nickname;
			$inser['password'] = md5($values->password . str_repeat('*enter any random salt here*', 10));
			$db = $this->context->getService('database');
			$db->exec('INSERT INTO core_users', $inser);
			$this->redirect('user:');
		}else{
			$this->flashMessage('Hesla se neschodují!');
			$this->redirect('user:');
		}
	}
	
	/**
	 * Function preparing form for change user password
	 * @param \Gridito\Grid $grid
	 * @return Nette\Application\UI\Form
	 */
	public function createComponentEditForm($row){
		if($row->nickname == $this->getUser()->id){
			$form = new \Nette\Application\UI\Form();
			$form->setAction('?do=addForm-submit');
			$form->addPassword('current', 'Současné heslo:')->setRequired('Zadejte současné heslo.');
			$form->addPassword('password', 'Heslo:')->setRequired('Zadejte nové heslo.')->addRule(Form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků', 6);
			$form->addPassword('password_confirmation', 'Ověření hesla:')->setRequired('Zadejte ověření.')->addRule(Form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků', 6);
			$form->addHidden('id', $row->id);
			$form->addSubmit('submit', 'Vytvořit');
			$url = $this->link('user:edit');
			$form->setAction($url);
			return $form;
		}else{
			return 'Nejste majitelem tohoto Účtu';
		}
	}
	
	/**
	 * Function data processing of edit password
	 */
	public function actionEdit(){
		$form = $_POST;
		$db = $this->context->getService('database');
		$res = $db->table('core_users')->find($form['id'])->fetch();
		if($res->password != md5($form['current'] . str_repeat('*enter any random salt here*', 10))){
			$this->flashMessage('Původní heslo není správné!');
			$this->redirect('user:');
		}elseif( strlen($form['password']) < 6){
			$this->flashMessage('Heslo musí mít alespoň 6 znaků');
			$this->redirect('user:');
		}else{
			if($form['password'] == $form['password_confirmation']){
				$update['password'] = md5($form['password'] . str_repeat('*enter any random salt here*', 10));
				$db->exec('UPDATE core_users SET ? WHERE id = ?', $update, $form['id']);
				$this->redirect('user:');
			}
			else{
				$this->flashMessage('Hesla se neschodují!');
				$this->redirect('user:');
			}
		}
	}
	
	
	
}