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
 * Cms presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class CmsPagePresenter extends BasePresenter
{
	
	
	
	protected function createComponentCmsGrid($name){
		$section = $this->session->getNamespace('web');
        $db = $this->context->getService('database');
		$res = $db->table('cms_pages');
		$model = new \Gridito\NetteDatabaseModel($res);
		$grid = new \Gridito\Grid($this, $name);
		$grid->setModel($model);
		$grid->addColumn('id', 'ID')->setSortable(true);
		$grid->addColumn('name', 'Jméno')->setSortable(true);
		$grid->addColumn('content', 'Obsah')->setSortable(true);
		$grid->addWindowButton('edit', 'Upravit')->setHandler(function ($row) use ($grid){
			echo $grid->presenter->createComponentEditForm($row);
		});

	}
	
	public function renderDetail(){
		
	}
	
	public function createComponentEditForm($grid){
		$_id = $this->getParam('id');
		if($_id != null){
			
			$db = $this->context->getService('database');
			$res = $db->table('cms_pages')->where('id', $_id)->fetch();
			
			$form = new \Nette\Application\UI\Form();
			$form->addHidden('id')->setDefaultValue($res['id']);
			$form->addTextArea('content', 'Obsah:')->setRequired('Zadejte popis.')->setDefaultValue($res['content']);
			$form->onSubmit[] = callback($this, 'addFormSubmitted');
			$form->addSubmit('submit', 'Upravit');
		}else{
			$form = new \Nette\Application\UI\Form();
			$form->addHidden('id')->setDefaultValue($grid->id);
			$form->addTextArea('content', 'Obsah:')->setRequired('Zadejte popis.')->setDefaultValue($grid->content);
			$form->onSubmit[] = callback($this, 'addFormSubmitted');
			$form->addSubmit('submit', 'Upravit');
		}
		return $form;
	}
}
?>