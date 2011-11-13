<?php

/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace FrontendModule;

/**
 * CmsPage presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class CmsPagePresenter extends \FrontendModule\BasePresenter
{

	public function renderDefault()
	{
		$db = $this->context->getService('database');
		$this->template->content = $db->table('cms_pages')->where('id', $this->getParam('id'))->fetch();
	}

}
