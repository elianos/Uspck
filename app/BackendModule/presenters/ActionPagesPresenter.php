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
class ActionPagesPresenter extends BasePresenter
{
	
	public function renderDefault(){
		
	}
	
	protected function createComponentActionGrid($name){
        $db = $this->context->getService('database');
		$pages = new \Models\PagesModel($this->context);
        $res = $db->table('action_pages');
		$model = new \Gridito\NetteDatabaseModel($res);
		$grid = new \Gridito\Grid($this, $name);
		$grid->setDefaultSorting('id', 'DESC');
		$grid->setModel($model);
		$grid->addColumn('id', 'ID')->setSortable(true);
		$grid->addColumn('name', 'JmĂ©no')->setSortable(true);
		$grid->addButton('open', 'Otevřít')->setLink(function ($row) use ($grid){
			return $grid->presenter->link('actionPages:topics', array('id' => $row->id));
		});

	}
	
	public function renderTopics(){
		
	}
	
	protected function createComponentTopicGrid($name){
		$param = $this->session->getNamespace('param');
		if($this->getParam('id') != null){
			$param->id = $this->getParam('id');
		}
		$db = $this->context->getService('database');
		$pages = new \Models\PagesModel($this->context);
        $res = $db->table('action_detail')->where('action_pages_id', $param->id);
		$model = new \Gridito\NetteDatabaseModel($res);
		$grid = new \Gridito\Grid($this, $name);
		$grid->setModel($model);
		$grid->addColumn('id', 'ID')->setSortable(true);
		$grid->addColumn('name', 'JmĂ©no')->setSortable(true);
		$grid->addColumn('key', 'Klíč')->setSortable(true);
		$grid->addWindowButton('edit', 'Upravit')->setHandler(function ($row) use ($grid){
			echo $grid->presenter->createComponentEditTopicForm($row);
		});
		$grid->addWindowButton('delete', 'Smazat')->setHandler(function ($row) use ($grid){
			echo $grid->presenter->createComponentDeleteTopicForm($row);
		});
		$grid->addToolbarWindowButton('create', 'Přidat topic')->setHandler(function () use ($grid) {
			echo $grid->presenter->createComponentAddTopicForm($grid);
		});

	}
	
	public function createComponentAddTopicForm($grid){
		$param = $this->session->getNamespace('param');
		if($this->getParam('id') != null){
			$param->id = $this->getParam('id');
		}
		$db = $this->context->getService('database');
		$modules = $db->table('core_modules')->fetchPairs('id');
		foreach($modules as $module){
			$m[$module->id] = $module['module_name'];
		}
		$form = new \Nette\Application\UI\Form();
		$form->setAction('?do=addTopicForm-submit');
		$form->addText('name', 'Název:')->setRequired('Zadejte název.');
		$form->addText('key', 'Klíčové slovo:')->setRequired('Zadejte klíčová slova.');
		$form->addTextArea('text', 'Obsah:')->setRequired('Zadejte obsah.');
		$form->addHidden('action_pages', $param->id);
		$form->addSubmit('submit', 'Vytvořit');
		$form->onSubmit[] = callback($this, 'addTopicFormSubmitted');
		return $form;
	}
	
	public function addTopicFormSubmitted($form){
		$section = $this->session->getNamespace('web');
		$container = $this->getContext();
		$httpRequest = $container->httpRequest;
		$file = $httpRequest->getFile('image');
		$galleryModel = new \Models\GalleryModel($container);
		
		$values = $form->getValues();
		$core_pages = array(
				'name' => $values->name,
				'text' => $values->text,
				'key' => $values->key,
				'time' => time(),
				'action_pages_id' => $values->action_pages,
			);
		
		$db = $this->context->getService('database');
		
		$db->exec('INSERT INTO action_detail', $core_pages);
		
		$this->redirect('actionPages:topics', array('id' => $values->action_pages));
	}
	
	public function createComponentDeleteTopicForm($val){
		$param = $this->session->getNamespace('param');
		if($this->getParam('id') != null){
			$param->id = $this->getParam('id');
		}
		$form = new \Nette\Application\UI\Form();
		$url = $this->link('actionPages:topicDelete', array('id' => $param->id));
		$form->setAction($url);
		$form->addHidden('topicId', $val->id);
		$form->addSubmit('submit', 'Smazat topic');
		return $form;
	}
	
	public function actionTopicDelete(){
		$form = $_POST;
		
		$container = $this->getContext();
		
		$actionModel = new \Models\ActionModel($container);
		$actionModel->deleteTopic($form['topicId']);
		$this->redirect('actionPages:topics', array('id' => $this->getParam('id')));
	}
	
	public function createComponentEditTopicForm($val){
		$param = $this->session->getNamespace('param');
		if($this->getParam('id') != null){
			$param->id = $this->getParam('id');
		}
		$db = $this->context->getService('database');
		$modules = $db->table('core_modules')->fetchPairs('id');
		foreach($modules as $module){
			$m[$module->id] = $module['module_name'];
		}
		$form = new \Nette\Application\UI\Form();
		$url = $this->link('actionPages:TopicEdit', array('id' => $param->id));
		$form->setAction($url);
		$form->addText('name', 'Název:')->setDefaultValue($val->name)->setRequired('Zadejte název.');
		$form->addText('key', 'Klíčové slovo:')->setDefaultValue($val->key)->setRequired('Zadejte klíčová slova.');
		$form->addTextArea('text', 'Obsah:')->setDefaultValue($val->text)->setRequired('Zadejte obsah.');
		$form->addHidden('id', $val->id);
		$form->addSubmit('submit', 'Upravit');
		$form->onSubmit[] = callback($this, 'ropicEditFormSubmitted');
		return $form;
	}
	
	public function actionTopicEdit(){
		$form = $_POST;
		
		$container = $this->getContext();
		
		$actionModel = new \Models\ActionModel($container);
		$actionModel->editTopic($form);
		$this->redirect('actionPages:topics', array('id' => $this->getParam('id')));
	}
}