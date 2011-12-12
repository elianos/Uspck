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
class GalleryPagesPresenter extends BasePresenter
{
	
	public function renderDefault(){
		
	}
	
	protected function createComponentPageGrid($name){
        $db = $this->context->getService('database');
		$pages = new \Models\PagesModel($this->context);
        $res = $db->table('gallery_pages')->where('id', $pages->getPages());
		$model = new \Gridito\NetteDatabaseModel($res);
		$grid = new \Gridito\Grid($this, $name);
		$grid->setDefaultSorting('id', 'DESC');
		$grid->setModel($model);
		$grid->addColumn('id', 'ID')->setSortable(true);
		$grid->addColumn('name', 'JmĂ©no')->setSortable(true);
		$grid->addButton('open', 'Otevřít')->setLink(function ($row) use ($grid){
			return $grid->presenter->link('galleryPages:topics', array('id' => $row->id));
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
        $res = $db->table('gallery_topics')->where('gallery_pages_id', $param->id);
		$model = new \Gridito\NetteDatabaseModel($res);
		$grid = new \Gridito\Grid($this, $name);
		$grid->setModel($model);
		$grid->addColumn('id', 'ID')->setSortable(true);
		$grid->addColumn('name', 'JmĂ©no')->setSortable(true);
		$grid->addColumn('description', 'Popis')->setSortable(true);
		$grid->addColumn('key', 'Klíč')->setSortable(true);
		$grid->addColumn('gallery_images_id', 'Náhled')->setRenderer(function ($row) use ($grid){
			echo '<img src="'.$grid->template->baseUrl.'/../media/gallery/min/'.$row->gallery_images_id.'.jpg" />';
		});
		$grid->addButton('open', 'Otevřít')->setLink(function ($row) use ($grid){
			return $grid->presenter->link('galleryPages:detail', array('id' => $row->id));
		});
		$grid->addWindowButton('delete', 'Smazat')->setHandler(function ($row) use ($grid){
			echo $grid->presenter->createComponentDeleteTopicForm($row);
		});
		$grid->addToolbarWindowButton('create', 'Přidat topic')->setHandler(function () use ($grid) {
			echo $grid->presenter->createComponentAddTopicForm($grid);
		});

	}
	
	public function createComponentAddTopicForm($grid){
		$db = $this->context->getService('database');
		$modules = $db->table('core_modules')->fetchPairs('id');
		foreach($modules as $module){
			$m[$module->id] = $module['module_name'];
		}
		$form = new \Nette\Application\UI\Form();
		$form->setAction('?do=addTopicForm-submit');
		$form->addText('name', 'Název:')->setRequired('Zadejte název.');
		$form->addText('description', 'Popis:')->setRequired('Zadejte popis.');
		$form->addText('key', 'Klíčové slovo:')->setRequired('Zadejte klíčová slova.');
		$form->addText('date', 'Rok:');
		$form->addFile('image', 'Obrázek')->addRule(Form::IMAGE, 'Obrázek musí být JPEG, PNG nebo GIF.');
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
				'description' => $values->description,
				'key' => $values->key,
				'date' => $values->date,
				'gallery_pages_id' => $this->getParam('id')
			);
		
		$db = $this->context->getService('database');
		
		$db->exec('INSERT INTO gallery_topics', $core_pages);
		
		$topic = $db->query('SELECT MAX(id) AS id FROM gallery_topics')->fetch();
		
		$image_name = $galleryModel->uploadImage($file, $topic['id']);
		
		$db->exec('UPDATE gallery_topics SET ? WHERE id=?', array('gallery_images_id' => $image_name), $topic['id']);

		$this->redirect('galleryPages:topics', array('id' => $this->getParam('id')));
	}
	
	public function createComponentDeleteTopicForm($val){
		$param = $this->session->getNamespace('param');
		if($this->getParam('id') != null){
			$param->id = $this->getParam('id');
		}
		$form = new \Nette\Application\UI\Form();
		$url = $this->link('galleryPages:topicDelete', array('id' => $param->id));
		$form->setAction($url);
		$form->addHidden('topicId', $val->id);
		$form->addSubmit('submit', 'Smazat topic');
		return $form;
	}
	
	public function actionTopicDelete(){
		$form = $_POST;
		
		$container = $this->getContext();
		
		$galleryModel = new \Models\GalleryModel($container);
		$galleryModel->deleteTopic($form['topicId']);
		$this->redirect('galleryPages:topics', array('id' => $this->getParam('id')));
	}
	
	
	public function renderDetail(){
	}
	
	
	
	protected function createComponentDetailGrid($name){
        $param = $this->session->getNamespace('param');
		if($this->getParam('id') != null){
			$param->id = $this->getParam('id');
		}
		$db = $this->context->getService('database');
		$pages = new \Models\PagesModel($this->context);
        $res = $db->table('gallery_images')->where('gallery_topics_id', $param->id);
		$model = new \Gridito\NetteDatabaseModel($res);
		$grid = new \Gridito\Grid($this, $name);
		$grid->setModel($model);
		$grid->addColumn('id', 'ID')->setRenderer(function ($row) use ($grid){
			echo '<img src="'.$grid->template->baseUrl.'/../media/gallery/min/'.$row->id.'.jpg" />';
			echo $row->id;
		});
		$grid->addColumn('date', 'Datum')->setSortable(true);
		$grid->addWindowButton('main', 'Hlavní')->setHandler(function ($row) use ($grid){
			echo $grid->presenter->createComponentMainDetailForm($row);
		});
		$grid->addWindowButton('delete', 'Smazat')->setHandler(function ($row) use ($grid){
			echo $grid->presenter->createComponentDeleteDetailForm($row);
		});
		$grid->addToolbarWindowButton('create', 'Přidat foto')->setHandler(function () use ($grid) {
			echo $grid->presenter->createComponentAddDetailForm($grid);
		});
	}
	
	public function createComponentAddDetailForm($grid){
		$form = new \Nette\Application\UI\Form();
		$form->setAction('?do=addDetailForm-submit');
		$form->addFile('image', 'Obrázek')->addRule(Form::IMAGE, 'Obrázek musí být JPEG, PNG nebo GIF.');
		$form->addSubmit('submit', 'Vytvořit');
		$form->onSubmit[] = callback($this, 'addDetailFormSubmitted');
		return $form;
	}
	
	public function addDetailFormSubmitted($form){
		$container = $this->getContext();
		$httpRequest = $container->httpRequest;
		$file = $httpRequest->getFile('image');
		
		$galleryModel = new \Models\GalleryModel($container);
		$galleryModel->uploadImage($file, $this->getParam('id'));
		$this->redirect('galleryPages:detail', array('id' => $this->getParam('id')));
	}
	
	public function createComponentMainDetailForm($val){
		$param = $this->session->getNamespace('param');
		if($this->getParam('id') != null){
			$param->id = $this->getParam('id');
		}
		$form = new \Nette\Application\UI\Form();
		$url = $this->link('galleryPages:detailMain', array('id' => $param->id));
		$form->setAction($url);
		$form->addHidden('imageId', $val->id);
		$form->addSubmit('submit', 'Hlavní obrázek');
		return $form;
	}
	
	public function actionDetailMain($form){
		$container = $this->getContext();
		$form = $_POST;
		$galleryModel = new \Models\GalleryModel($container);
		$galleryModel->mainImage($form['imageId'], $this->getParam('id'));
		$this->redirect('galleryPages:detail', array('id' => $this->getParam('id')));
	}
	
	public function createComponentDeleteDetailForm($val){
		$param = $this->session->getNamespace('param');
		if($this->getParam('id') != null){
			$param->id = $this->getParam('id');
		}
		$form = new \Nette\Application\UI\Form();
		$url = $this->link('galleryPages:detailDelete', array('id' => $param->id));
		$form->setAction($url);
		$form->addHidden('imageId', $val->id);
		$form->addSubmit('submit', 'Smazat');
		return $form;
	}
	
	public function actionDetailDelete($form){
		$container = $this->getContext();
		$form = $_POST;
		$galleryModel = new \Models\GalleryModel($container);
		$galleryModel->deleteImage($form['imageId']);
		$this->redirect('galleryPages:detail', array('id' => $this->getParam('id')));
	}
}
?>