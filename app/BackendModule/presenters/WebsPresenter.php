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

	/**
	 * Function preparing data grid with list of webs
	 * @param string $name
	 */
	protected function createComponentWebGrid($name){
        $db = $this->context->getService('database');
		$res = $db->table('core_webs');
		$model = new \Gridito\NetteDatabaseModel($res);
		$grid = new \Gridito\Grid($this, $name);
		$grid->setModel($model);
		$grid->addColumn('id', 'ID')->setSortable(true);
		$grid->addColumn('name', 'Název')->setSortable(true);
		$grid->addColumn('url', 'Adresa')->setSortable(true);
		$grid->addButton('select', 'Vybrat')->setHandler(function ($row) use ($grid){
			$section = $grid->presenter->session->getNamespace('web');
			$db = $grid->presenter->context->getService('database');
			$res = $db->table('core_pages')->where('core_webs_id', $row->id)->select('core_pages.id')->fetchPairs('id');
			$i = 0;
			$pages = array();
			foreach($res as $r){
				$pages[$i++] = $r['id'];	
			}
			$section->id = $row->id;
			$section->pages = $pages;
			$grid->presenter->redirect('pages:default');
		});
	}	
	
}