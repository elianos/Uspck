<?php
/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace Models;

/**
 * Base presenter.
 * 
 * Class preparing data for all others presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class ActionModel extends BaseModel{
	
	public function getActions($page = null, $year = null){
		$db = $this->context->getService('database');
		if($year == null){
			return $db->query('SELECT * FROM action_detail WHERE action_detail.action_pages_id = ?', $page);
		}
		return $db->query('SELECT * FROM action_detail WHERE action_detail.action_pages_id = ? AND YEAR(FROM_UNIXTIME(time)) = ?', $page, $year);
	}
	
	
	public function getActionYears(){
		$db = $this->context->getService('database');
		return $db->query('SELECT YEAR(FROM_UNIXTIME(time)) AS years FROM action_detail GROUP BY YEAR(FROM_UNIXTIME(time))');
	}
	
	public function getAction($id){
		$db = $this->context->getService('database');
		return $db->query('SELECT *, FROM_UNIXTIME(time) AS date FROM action_detail LEFT JOIN gallery_topics ON action_detail.key = gallery_topics.key WHERE action_detail.id = ?', $id)->fetch();
	}
}