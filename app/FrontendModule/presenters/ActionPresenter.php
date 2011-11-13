<?php

/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace FrontendModule;

/**
 * Action presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class ActionPresenter extends BasePresenter
{

	public function renderDefault()
	{
		$a = new \Models\ActionModel($this->context);
		$this->template->years = $a->getActionYears();
		$this->template->actions = $a->getActions($this->getParam('id'), $this->getParam('rok'));	
	}
	
	public function renderDetail()
	{
		$g = new \Models\ActionModel($this->context);
		$this->template->action = $g->getAction($this->getParam('inid'));	
	}

}
