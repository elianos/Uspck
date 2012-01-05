<?php
/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace Models;

/**
 * Pages Model.
 * 
 * Class preparing data for pages
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class PagesModel extends BaseModel {
	
	/**
	 * Function prepparing pages
	 * @return array
	 */
	public function getPages() {
		$section = $this->context->session->getNamespace('web');
		return $section->pages;
    }
	
}