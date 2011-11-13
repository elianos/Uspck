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
class GalleryModel extends BaseModel {
	
	public function getGalleryTopics($page = null, $year = null){
		$db = $this->context->getService('database');
		if($year == null){
			return $db->query('SELECT * FROM gallery_topics LEFT JOIN gallery_images ON gallery_topics.gallery_images_id = gallery_images.id WHERE gallery_topics.gallery_pages_id = ?', $page);
		}
		return $db->query('SELECT * FROM gallery_topics LEFT JOIN gallery_images ON gallery_topics.gallery_images_id = gallery_images.id WHERE gallery_topics.gallery_pages_id = ? AND gallery_topics.date = ?', $page, $year);
	}
	
	public function getGalleryImages($id){
		$db = $this->context->getService('database');
		return $db->query('SELECT * FROM gallery_images WHERE gallery_topics_id = ?', $id);
	}
	
	public function getGalleryYears(){
		$db = $this->context->getService('database');
		return $db->query('SELECT * FROM gallery_topics GROUP BY date');
	}
}