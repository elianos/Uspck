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
class DownloadModel extends BaseModel {
	
	private $baseUrl = '/Uspck/media/downloads/';
		
	/**
	 * Function uploading image
	 * @param \Nette\Image $file
	 * @param Integer $topic
	 * @return Integer
	 */
	public function uploadFile($file, $text, $webId){
		
		$params = array('time' => time(), 'name' => $file->getName(), 'text' => $text, 'size' => filesize($file), 'download_pages_id' => $webId);
		$db = $this->context->getService('database');
		$db->exec('INSERT INTO download_detail', $params);
		
		$this->saveFile($file);
		return $file->getName();
	}
	
	/**
	 * Function saving file
	 * @param $file
	 */
	public function saveFile($file){
		$file->move($_SERVER['DOCUMENT_ROOT'].$this->baseUrl.'/'.$file->getName());
	}
	
	
	
	/**
	 * Function deleting image
	 * @param Integer $imageId
	 */
	public function deleteFile($fileId){
		$db = $this->context->getService('database');
		
		$row = $db->query('SELECT name FROM download_detail WHERE id=?', $fileId)->fetch();
		$name = $row['name'];
	
		$db->exec('DELETE FROM download_detail WHERE id=?', $fileId);
		echo $_SERVER['DOCUMENT_ROOT'].$this->baseUrl.$name;
		unlink($_SERVER['DOCUMENT_ROOT'].$this->baseUrl.$name);
	}
	
	/**
	 * Function preparing downloads
	 * @param Integer $id
	 */
	public function getDownloads($id){
		$db = $this->context->getService('database');
		return $db->query('SELECT * FROM download_detail WHERE download_detail.download_pages_id = ?', $id);
	}
	
	
}