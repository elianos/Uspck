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
	
	/**
	 * Function preparing data grid with pages of actions
	 * @param string $name
	 */
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
	
	/**
	 * Function preparing data grid with topic of action page
	 * @param string $name
	 */
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
	
	/**
	 * Function preparing form for adding topics
	 * @param \Gridito\Grid $grid
	 */
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
	
	/**
	 * Function data processing of new topic
	 * @param \Nette\Application\UI\Form $form
	 */
	public function addTopicFormSubmitted($form){
		$values = $form->getValues();
		$container = $this->getContext();
		$actionModel = new \Models\ActionModel($container);
		$actionModel->addTopic($values);

		$this->redirect('actionPages:topics', array('id' => $values->action_pages));
	}
	
	/**
	 * Function preparing form for delete topic
	 * @param array $val
	 */
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
	
	/**
	 * Function data processing of delete topic
	 */
	public function actionTopicDelete(){
		$form = $_POST;
		$container = $this->getContext();
		$actionModel = new \Models\ActionModel($container);
		$actionModel->deleteTopic($form['topicId']);
		$this->redirect('actionPages:topics', array('id' => $this->getParam('id')));
	}
	
	/**
	 * Function preparing form for edit topic
	 * @param array $val
	 */
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
	
	/**
	 * Function data processing of edit topic
	 */
	public function actionTopicEdit(){
		$form = $_POST;
		$container = $this->getContext();
		$actionModel = new \Models\ActionModel($container);
		$actionModel->editTopic($form);
		$this->redirect('actionPages:topics', array('id' => $this->getParam('id')));
	}
}