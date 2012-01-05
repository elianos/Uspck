<?php

/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace FrontendModule;

/**
 * Gallery presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class GalleryPresenter extends \FrontendModule\BasePresenter
{

	/**
	 * Function preparing data for rendering galleries 
	 */
	public function renderDefault()
	{
		$g = new \Models\GalleryModel($this->context);
		$this->template->years = $g->getGalleryYears();
		$this->template->topics = $g->getGalleryTopics($this->getParam('id'), $this->getParam('rok'));	
	}
	
	/**
	 * Function preparing data for gallery detail
	 */
	public function renderDetail()
	{
		$g = new \Models\GalleryModel($this->context);
		$this->template->images = $g->getGalleryImages($this->getParam('inid'));	
	}

}
