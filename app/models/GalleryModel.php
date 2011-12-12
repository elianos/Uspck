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
	
	private $baseUrl = '/Uspck/media/gallery/';
	
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
	
	public function uploadImage($file, $topic){
		$image = \Nette\Image::fromFile($file->getTemporaryFile());
		$params = array('gallery_topics_id' => $topic, 'date' => time(), 'status' => 'a', 'for_slimbox' => 1);
		$db = $this->context->getService('database');
		$db->exec('INSERT INTO gallery_images', $params);
		$name = $db->query('SELECT MAX(id) AS id FROM gallery_images')->fetch();
		$this->createImages($image, $name['id']);
		return $name['id'];
	}
	
	public function createImages($image, $name){
		$this->saveImage($image, $name, 1200, 900, 'full');
		$this->saveImage($image, $name, 320, 240, 'med');
		$this->saveImage($image, $name, 110, 73, 'min');
	}
	
	public function saveImage($image, $name, $x, $y, $type){
		$image->resize($x, $y);
		$image->save($_SERVER['DOCUMENT_ROOT'].$this->baseUrl.$type.'/'.$name.'.jpg', 80, \Nette\Image::JPEG);
	}
	
	public function mainImage($imageId, $galleryId){
		$db = $this->context->getService('database');
		$db->exec('UPDATE gallery_topics SET ? WHERE id=?', array('gallery_images_id' => $imageId), $galleryId);
	}
	
	public function deleteImage($imageId){
		$db = $this->context->getService('database');
		$db->exec('DELETE FROM gallery_images WHERE id=?', $imageId);
		$this->deleteImages($imageId);
	}
	
	public function deleteImages($imageId){
		$this->deleteFile($imageId, 'full');
		$this->deleteFile($imageId, 'med');
		$this->deleteFile($imageId, 'min');
	}
	
	public function deleteFile($imageId, $type){
		unlink($_SERVER['DOCUMENT_ROOT'].$this->baseUrl.$type.'/'.$imageId.'.jpg');
	}
	
	public static function getImageUrl($name, $type){
		return $this->baseUrl.'/'.$type.'/'.$name.'.jpg';
	}
	
	
	public function deleteTopic($id){
		$db = $this->context->getService('database');
		$images = $db->table('gallery_images')->where('gallery_topics_id', $id)->fetchPairs('id');
		$db->exec('DELETE FROM gallery_topics WHERE id=?', $id);
		foreach($images as $image){
			$this->deleteImages($image['id']);
		}
	}
	
}