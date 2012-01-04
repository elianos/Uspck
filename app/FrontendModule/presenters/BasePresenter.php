<?php

/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace FrontendModule;

/**
 * Fronted Base presenter.
 * 
 * Class preparing data for all others presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
abstract class BasePresenter extends \FrontendModule\Presenter
{
	protected function startup() {
    	parent::startup();
    	$db = $this->context->getService('database');
    	$page = $db->table('core_pages')->where('id', $this->getParam('id'))->select('title')->fetch();
    	if(isset($page->title)){
    		$this->template->title = $page->title;
    	}else{
    		$this->template->title = null;
    	}
      	$this->template->param = $this->getParam();
      	$this->template->navigation_list = $db->query('SELECT core_pages.*, core_modules.presenter, core_modules.action FROM core_pages LEFT JOIN core_modules ON core_pages.core_modules_id = core_modules.id WHERE active = ? AND core_pages.core_webs_id = ? ORDER BY core_pages.order',1, $this->getParam('web'));
	}
}
