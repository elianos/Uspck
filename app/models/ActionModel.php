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
	
	
	/**
	 * Function preparing actions
	 * @param Integer $page
	 * @param Integer $year
	 * @return Statement
	 */
	public function getActions($page = null, $year = null){
		$db = $this->context->getService('database');
		if($year == null){
			return $db->query('SELECT * FROM action_detail WHERE action_detail.action_pages_id = ?', $page);
		}
		return $db->query('SELECT * FROM action_detail WHERE action_detail.action_pages_id = ? AND YEAR(FROM_UNIXTIME(time)) = ?', $page, $year);
	}
	
	/**
	 * Function getting years
	 * @return Statement
	 */
	public function getActionYears(){
		$db = $this->context->getService('database');
		return $db->query('SELECT YEAR(FROM_UNIXTIME(time)) AS years FROM action_detail GROUP BY YEAR(FROM_UNIXTIME(time))');
	}
	
	/**
	 * Get action by id
	 * @param Integer $id
	 * @return mixed
	 */
	public function getAction($id){
		$db = $this->context->getService('database');
		return $db->query('SELECT *, FROM_UNIXTIME(time) AS date FROM action_detail LEFT JOIN gallery_topics ON action_detail.key = gallery_topics.key WHERE action_detail.id = ?', $id)->fetch();
	}
	
	/**
	 * Delete topic by id
	 * @param Integer $id
	 */
	public function deleteTopic($id){
		$db = $this->context->getService('database');
		return $db->exec('DELETE FROM action_detail WHERE id=?', $id);
	}
	
	/**
	 * Edit topic
	 * @param \Nette\Application\UI\Form $form
	 * @return boolean
	 */
	public function editTopic($form){
		$id = $form['id'];
		unset($form['id']);
		unset($form['submit_']);
		$db = $this->context->getService('database');
		return $db->exec('UPDATE action_detail SET ? WHERE id = ?', $form, $id);
	}
	
	/**
	 * Edit topic
	 * @param \Nette\Application\UI\Form $values
	 */
	public function addTopic($values){
		$core_pages = array(
			'name' => $values->name,
			'text' => $values->text,
			'key' => $values->key,
			'time' => time(),
			'action_pages_id' => $values->action_pages,
		);
		$db = $this->context->getService('database');
		$db->exec('INSERT INTO action_detail', $core_pages);
	}
}