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
 * Gallery presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class PicturesPresenter extends BasePresenter
{
	/**
	 * Function preparing data grid with picture pages
	 * @param string $name
	 */
	protected function createComponentPictureGrid($name){
        $db = $this->context->getService('database');
        $res = $db->table('core_pictures')->where('core_webs_id', $this->session->getNamespace('web')->id);
		$model = new \Gridito\NetteDatabaseModel($res);
		$grid = new \Gridito\Grid($this, $name);
		//$grid->setDefaultSorting('id', 'DESC');
		$grid->setModel($model);
		$grid->addColumn('id', 'ID')->setSortable(true)->setRenderer(function ($row) use ($grid){
			echo '<img src="'.$grid->template->baseUrl.'/../media/pictures/'.$row->id.'-min.jpg" />';
			
			//$galleryModel = new \Models\PictureModel($grid->presenter->getContext(), $grid->presenter->session->getNamespace('web')->id);
			echo '<span class="link">'.$grid->template->baseUrl.'/../media/pictures/'.$row->id.'.jpg</span>';
		});
		$grid->addColumn('date', 'Datum')->setSortable(true)->setRenderer(function ($row) use ($grid){
			echo date('d. m. Y', $row->date);
		});
		
		$grid->addWindowButton('delete', 'Smazat')->setHandler(function ($row) use ($grid){
			echo $grid->presenter->createComponentDeletePictureForm($row);
			echo '<script type="text/javascript" src="'.$grid->presenter->template->baseUrl.'/js/live-form-validation.js"></script>';
		});
		$grid->addToolbarWindowButton('create', 'Přidat foto')->setHandler(function () use ($grid) {
			echo $grid->presenter->createComponentAddPictureForm($grid);
			echo '<script type="text/javascript" src="'.$grid->presenter->template->baseUrl.'/js/live-form-validation.js"></script>';
		});
	}
	
	/**
	 * Function preparing form for addign photos
	 * @param \Gridito\Grid $grid
	 * @return Nette\Application\UI\Form
	 */
	public function createComponentAddPictureForm($grid){
		$form = new \Nette\Application\UI\Form();
		$form->setAction('?do=addPictureForm-submit');
		$form->addFile('image', 'Obrázek')->addRule(Form::IMAGE, 'Obrázek musí být JPEG, PNG nebo GIF.');
		$form->addSubmit('submit', 'Vytvořit');
		$form->onSubmit[] = callback($this, 'addPictureFormSubmitted');
		return $form;
	}
	
	/**
	 * Function data processing of adding photo
	 * @param Nette\Application\UI\Form $form
	 */
	public function addPictureFormSubmitted($form){
		$container = $this->getContext();
		$httpRequest = $container->httpRequest;
		$file = $httpRequest->getFile('image');
		
		$galleryModel = new \Models\PictureModel($container, $this->session->getNamespace('web')->id);
		$galleryModel->uploadImage($file, $this->session->getNamespace('web')->id);
		$this->redirect('pictures:default');
	}
	
	/**
	 * Function preparing form for deleting picture
	 * @param \Gridito\Grid $grid
	 * @return Nette\Application\UI\Form
	 */
	public function createComponentDeletePictureForm($val){
		$param = $this->session->getNamespace('param');
		if($this->getParam('id') != null){
			$param->id = $this->getParam('id');
		}
		$form = new \Nette\Application\UI\Form();
		$url = $this->link('pictures:pictureDelete');
		$form->setAction($url);
		$form->addHidden('imageId', $val->id);
		$form->addSubmit('submit', 'Smazat');
		return $form;
	}
	
	/**
	 * Function data processing of deleting photo
	 * @param \Nette\Application\UI\Form $form
	 */
	public function actionPictureDelete($form){
		$container = $this->getContext();
		$form = $_POST;
		$galleryModel = new \Models\PictureModel($container, $this->session->getNamespace('web')->id);
		$galleryModel->deleteImage($form['imageId']);
		$this->redirect('pictures:default');
	}
	
}
?>