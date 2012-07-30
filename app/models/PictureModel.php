<?php
/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace Models;

/**
 * Picture Model.
 * 
 * Class preparing data for all others presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
class PictureModel extends BaseModel {
	
	private $baseUrl = '/Uspck/media/pictures/';
		
	/**
	 * Function uploading image
	 * @param \Nette\Image $file
	 * @param Integer $topic
	 * @return Integer
	 */
	public function uploadImage($file, $webId){
		$image = \Nette\Image::fromFile($file->getTemporaryFile());
		$params = array('date' => time(), 'core_webs_id' => $webId);
		$db = $this->context->getService('database');
		$db->exec('INSERT INTO core_pictures', $params);
		$name = $db->query('SELECT MAX(id) AS id FROM core_pictures')->fetch();
		$this->createImages($image, $name['id']);
		return $name['id'];
	}
	
	/**
	 * Function preparing image thumbs
	 * @param \Nette\Image $image
	 * @param String $name
	 */
	public function createImages($image, $name){
		$this->saveImage($image, $name, 1280, 1024);
		$this->saveImage($image, $name.'-min', 100, 100);
	}
	
	/**
	 * Function saving image
	 * @param \Nette\Image $image
	 * @param String $name
	 * @param String $x
	 * @param String $y
	 */
	public function saveImage($image, $name, $x, $y){
		$image->resize($x, $y);
		$image->save($_SERVER['DOCUMENT_ROOT'].$this->baseUrl.'/'.$name.'.jpg', 80, \Nette\Image::JPEG);
	}
	
	
	
	/**
	 * Function deleting image
	 * @param Integer $imageId
	 */
	public function deleteImage($imageId){
		$db = $this->context->getService('database');
		$db->exec('DELETE FROM core_pictures WHERE id=?', $imageId);
		$this->deleteImages($imageId);
	}

	/**
	 * Function deleting all image variants
	 * @param Integer $imageId
	 */
	public function deleteImages($imageId){
		$this->deleteFile($imageId);
	}
	
	/**
	 * Function deleting image file
	 * @param Integer $imageId
	 * @param String $type
	 */
	public function deleteFile($imageId){
		unlink($_SERVER['DOCUMENT_ROOT'].$this->baseUrl.$imageId.'.jpg');
		unlink($_SERVER['DOCUMENT_ROOT'].$this->baseUrl.$imageId.'-min.jpg');
	}
	
	/**
	 * Function getting image Url
	 * @param String $name
	 * @param String $type
	 */
	public function getImageUrl($name){
		return $this->baseUrl.$name.'.jpg';
	}
	
	
}