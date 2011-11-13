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
 * Webs presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class WebsPresenter extends BasePresenter
{
	
	public function renderDefault(){

	}
	
	protected function createComponentWebGrid($name){
        $db = $this->context->getService('database');
		$res = $db->table('core_webs');
		$model = new \Gridito\NetteDatabaseModel($res);
		$grid = new \Gridito\Grid($this, $name);
		$grid->setModel($model);
		$grid->addColumn('id', 'ID')->setSortable(true);
		$grid->addColumn('name', 'Název')->setSortable(true);
		$grid->addColumn('url', 'Adresa')->setSortable(true);
		$grid->addButton('select', 'Vybrat')->setLink(function ($row) use ($grid){
			$section = $grid->presenter->session->getNamespace('web');
			$section->id = $row->id;
			return $grid->presenter->link('pages:default');
		});
	}	
	
}