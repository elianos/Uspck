<?php

/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace FrontendModule;

/**
 * Download Pages presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class DownloadPagesPresenter extends BasePresenter
{
	
	/**
	 * Function preparing data for rendering actions 
	 */
	public function renderDefault()
	{
		$a = new \Models\DownloadModel($this->context);
		$this->template->downloads = $a->getDownloads($this->getParam('id'));	
	}


}
