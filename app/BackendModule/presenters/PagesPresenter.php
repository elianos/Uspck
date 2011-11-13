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
 * Action presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class PagesPresenter extends BasePresenter
{
	
	public function renderDefault(){

	}
	
	protected function createComponentPageGrid($name){
		$section = $this->session->getNamespace('web');
        $db = $this->context->getService('database');
		$res = $db->table('core_pages')->where('core_pages.core_webs_id', $section->id)->select('core_pages.*, core_modules.module_name as module_name');
		$model = new \Gridito\NetteDatabaseModel($res);
		$grid = new \Gridito\Grid($this, $name);
		$grid->setModel($model);
		$grid->addColumn('id', 'ID')->setSortable(true);
		$grid->addColumn('name', 'Jméno')->setSortable(true);
		$grid->addColumn('title', 'Popis')->setSortable(true);
		$grid->addColumn('rewrite', 'Adresa')->setSortable(true);
		$grid->addColumn('module_name', 'Name')->setSortable(true);
		$grid->addColumn('active', 'Aktivní')->setSortable(true);
		$grid->addColumn('home', 'Domovská stránka')->setSortable(true);
		$grid->addToolbarWindowButton('create', 'Přidat záznam')->setHandler(function () use ($grid) {
			echo $grid->presenter->createComponentAddForm($grid);
		});
		$grid->addWindowButton('edit', 'Upravit')->setHandler(function ($row) use ($grid){
			echo $grid->presenter->createComponentEditForm($row);
		});
		$grid->addWindowButton('delete', 'Smazat')->setHandler(function ($row) use ($grid){
			echo $grid->presenter->createComponentDeleteForm($row);
		});
	}
	
	
	public function createComponentAddForm($grid){
		$db = $this->context->getService('database');
		$modules = $db->table('core_modules')->fetchPairs('id');
		foreach($modules as $module){
			$m[$module->id] = $module['module_name'];
		}
		$form = new \Nette\Application\UI\Form();
		$form->setAction('?do=addForm-submit');
		$form->addText('name', 'Název:')->setRequired('Zadejte název.');
		$form->addText('title', 'Popis:')->setRequired('Zadejte popis.');
		$form->addText('metadata', 'Klíčová slova:')->setRequired('Zadejte klíčová slova.');
		$form->addText('rewrite', 'Adresa:');
		$form->addSelect('module', 'Modul', $m);
		$form->addCheckbox('active', 'Aktivní')->setDefaultValue(1);
		$form->addText('order', 'Pořadí:');
		$form->addSubmit('submit', 'Vytvořit');
		$form->onSubmit[] = callback($this, 'addFormSubmitted');
		return $form;
	}
	
	public function addFormSubmitted($form){
		$section = $this->session->getNamespace('web');
		
		$values = $form->getValues();
		$core_pages = array(
				'name' => $values->name,
				'title' => $values->title,
				'metadata' => $values->metadata,
				'rewrite' => $values->rewrite,
				'core_modules_id' => $values->module,
				'home' => 0,
				'active' => $values->active,
				'order' => $values->order,
				'core_webs_id' => $section->id
			);
		$db = $this->context->getService('database');
		$db->exec('INSERT INTO core_pages', $core_pages);
		$id = $db->query('SELECT MAX(id) AS id FROM core_pages')->fetch();
		$module = $db->table('core_modules')->where('id', $values->module)->fetch();
		$cms_page = array(
				'id' => $id[0],
				'name' => $values->name
			);
		$db->exec('INSERT INTO '.$module['module_name'], $cms_page);
		$_url = $module['presenter'].':detail';
		$this->redirect($_url, array('id' => $id[0]));
	}
	

	public function createComponentEditForm($val){
		$form = new \Nette\Application\UI\Form();
		$form->setAction('?do=editForm-submit');
		if($this->getParam('do')!= "editForm-submit"){
			$form->addText('name', 'Název:')->setRequired('Zadejte název.')->setDefaultValue($val->name);
			$form->addText('title', 'Popis:')->setRequired('Zadejte popis.')->setDefaultValue($val->title);
			$form->addText('metadata', 'Klíčová slova:')->setRequired('Zadejte klíčová slova.')->setDefaultValue($val->metadata);
			$form->addText('rewrite', 'Adresa:')->setDefaultValue($val->rewrite);
			$form->addCheckbox('active', 'Aktivní')->setDefaultValue($val->active);
		}
		$form->addSubmit('submit', 'Vytvořit');
		$form->onSubmit[] = callback($this, 'editFormSubmitted');
		return $form;
	}
	
	public function editFormSubmitted($form){
		$values = $form->getValues();
		echo $values->name.'<br />';
		echo $values->title.'<br />';
		echo $values->metadata.'<br />';
		echo $values->rewrite.'<br />';
		echo $values->active.'<br />';
	}

	
	public function createComponentDeleteForm($val){
		$form = new \Nette\Application\UI\Form();
		$form->setAction('?do=deleteForm-submit');
		if($this->getParam('do')!= "deleteForm-submit"){
			$form->addHidden('idp')->setDefaultValue($val->id);
		}
		$form->addSubmit('submit', 'Smazat');
		$form->onSubmit[] = callback($this, 'deleteFormSubmitted');
		return $form;
	}
	
	public function deleteFormSubmitted($form){
		//echo 'csdf';
	}
	
}