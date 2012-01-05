<?php
/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace Models;

/**
 * Cms Model
 * 
 * Class operating with CmsPages data
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class CmsModel extends BaseModel{
	
	/**
	 * Edit cms
	 * @param \Nette\Application\UI\Form $values
	 */
	public function editCms($values){
		$id = $values['id'];
		unset($values['id']);
		unset($values['submit_']);
		$db = $this->context->getService('database');
		$db->exec('UPDATE cms_pages SET ? WHERE id = ?', $values, $id);
	}
	
}