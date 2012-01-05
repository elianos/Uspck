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
	
	/**
	 * Function preparing data grid with pages of Cms
	 * @param string $name
	 */
	protected function createComponentCmsGrid($name){
        $db = $this->context->getService('database');
		$pages = new \Models\PagesModel($this->context);
        $res = $db->table('cms_pages')->where('id', $pages->getPages());
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
	
	/**
	 * Function preparing form for editing page
	 * @param \Gridito\Grid $grid
	 * @return Nette\Application\UI\Form
	 */
	public function createComponentEditForm($grid){
		$_id = $this->getParam('id');
		$form = new \Nette\Application\UI\Form();
		$url = $this->link('CmsPage:edit');
		$form->setAction($url);
		if($_id != null){
			$db = $this->context->getService('database');
			$res = $db->table('cms_pages')->where('id', $_id)->fetch();
            $form->addHidden('id')->setDefaultValue($res['id']);
			$form->addTextArea('content', 'Obsah:')->setRequired('Zadejte popis.')->setDefaultValue($res['content']);
		}else{
			$form->addHidden('id')->setDefaultValue($grid->id);
			$form->addTextArea('content', 'Obsah:')->setRequired('Zadejte popis.')->setDefaultValue($grid->content);
		}
		$form->addSubmit('submit', 'Odeslat');
		return $form;
	}
	
	/**
	 * Function data processing of edit page
	 */
	public function actionEdit(){
		$form = $_POST;
		$container = $this->getContext();
		$cmsModel = new \Models\CmsModel($container);
		$cmsModel->editCms($form);
		$this->redirect('cmsPage:');
	}
}
?>