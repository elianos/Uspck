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
 * Download presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class DownloadPagesPresenter extends BasePresenter
{
	
	/**
	 * Function preparing data grid with pages of downloads
	 * @param string $name
	 */
	protected function createComponentDownloadGrid($name){
        $db = $this->context->getService('database');
		$pages = new \Models\PagesModel($this->context);
        $res = $db->table('download_pages')->where('id', $pages->getPages());
		$model = new \Gridito\NetteDatabaseModel($res);
		$grid = new \Gridito\Grid($this, $name);
		$grid->setDefaultSorting('id', 'DESC');
		$grid->setModel($model);
		$grid->addColumn('id', 'ID')->setSortable(true);
		$grid->addColumn('name', 'Jméno')->setSortable(true);
		$grid->addButton('open', 'Otevřít')->setLink(function ($row) use ($grid){
			return $grid->presenter->link('downloadPages:detail', array('id' => $row->id));
		});

	}
	
	/**
	 * Function preparing data grid with topic of download page
	 * @param string $name
	 */
	protected function createComponentDetailGrid($name){
		$param = $this->session->getNamespace('param');
		if($this->getParam('id') != null){
			$param->id = $this->getParam('id');
		}
		$db = $this->context->getService('database');
		$pages = new \Models\PagesModel($this->context);
        $res = $db->table('download_detail')->where('download_pages_id', $param->id);
		$model = new \Gridito\NetteDatabaseModel($res);
		$grid = new \Gridito\Grid($this, $name);
		$grid->setModel($model);
		$grid->addColumn('id', 'ID')->setSortable(true);
		$grid->addColumn('time', 'Datum')->setSortable(true)->setRenderer(function ($row) use ($grid){
			echo date('d. m. Y', $row->time);
		});
		$grid->addColumn('name', 'Název')->setSortable(true);
		$grid->addColumn('text', 'Text')->setSortable(true);
		$grid->addColumn('size', 'Velikost')->setSortable(true)->setRenderer(function ($row) use ($grid){
	        if($row->size < 100000){
	        	$result = round($row->size / 1000, 2);
	        	echo "{$result} kB";
	        }else{
	        	$result = round($row->size / 1000000, 2);
	        	echo "{$result} MB";
	        }
		});
		$grid->addWindowButton('delete', 'Smazat')->setHandler(function ($row) use ($grid){
			echo $grid->presenter->createComponentDeleteDetailForm($row);
			echo '<script type="text/javascript" src="'.$grid->presenter->template->baseUrl.'/js/live-form-validation.js"></script>';
		});
		$grid->addToolbarWindowButton('create', 'Přidat soubor')->setHandler(function () use ($grid) {
			echo $grid->presenter->createComponentAddFileForm($grid);
			echo '<script type="text/javascript" src="'.$grid->presenter->template->baseUrl.'/js/live-form-validation.js"></script>';
		});
	}
	
	/**
	 * Function preparing form for adding topics
	 * @param \Gridito\Grid $grid
	 */
	public function createComponentAddFileForm($grid){
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
		$form->setAction('?do=addFileForm-submit');
		$form->addText('text', 'Popisek:')->setRequired('Je nutno zadat popisek.');
		$form->addFile('file', 'Obrázek')->setRequired('Je nutno nahrát soubor.');
		$form->addHidden('download_pages', $param->id);
		$form->addSubmit('submit', 'Vytvořit');
		$form->onSubmit[] = callback($this, 'addFileFormSubmitted');
		return $form;
	}
	
	/**
	 * Function data processing of new topic
	 * @param \Nette\Application\UI\Form $form
	 */
	public function addFileFormSubmitted($form){
		$container = $this->getContext();
		$httpRequest = $container->httpRequest;
		$file = $httpRequest->getFile('file');
		$form = $_POST;
		
		$downloadModel = new \Models\DownloadModel($container, $this->session->getNamespace('web')->id);
		$downloadModel->uploadFile($file, $form['text'], $form['download_pages']);
		$this->redirect('downloadPages:detail', array('id' => $form['download_pages']));
	}
	
	/**
	 * Function preparing form for delete topic
	 * @param array $val
	 */
	public function createComponentDeleteDetailForm($val){
		$param = $this->session->getNamespace('param');
		if($this->getParam('id') != null){
			$param->id = $this->getParam('id');
		}
		$form = new \Nette\Application\UI\Form();
		$url = $this->link('downloadPages:detailDelete', array('id' => $param->id));
		$form->setAction($url);
		$form->addHidden('detailId', $val->id);
		$form->addSubmit('submit', 'Smazat topic');
		return $form;
	}
	
	/**
	 * Function data processing of delete topic
	 */
	public function actionDetailDelete(){
		$form = $_POST;
		$container = $this->getContext();
		$downloadModel = new \Models\DownloadModel($container, $this->session->getNamespace('web')->id);
		$downloadModel->deleteFile($form['detailId']);
		$this->redirect('downloadPages:detail', array('id' => $this->getParam('id')));
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