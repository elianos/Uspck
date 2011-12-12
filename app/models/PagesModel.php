<?php
/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace Models;

/**
 * Gallery Model.
 * 
 * Class preparing data for all others presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class PagesModel extends BaseModel {
	public function getPages() {
		$section = $this->context->session->getNamespace('web');
		return $section->pages;
    }
	
}