<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursesalbum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Photos.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Coursesalbum_Model_DbTable_Photos extends Engine_Db_Table {
  protected $_rowClass = 'Coursesalbum_Model_Photo';
  protected $_name = 'courses_photos';
  public function getPhotoSelect($params = array()) {
      $select = $this->select();
      if(!empty($params['course_id'])){
          $select->where('course_id = ?', $params['course_id']);
      }
      if( !empty($params['album']) && $params['album'] instanceof Coursesalbum_Model_Album ) {
          $select->where('album_id = ?', $params['album']->getIdentity());
      } else if( !empty($params['album_id']) && is_numeric($params['album_id']) ) {
          $select->where('album_id = ?', $params['album_id']);
      }
      if(empty($params['pagNator'])){
          if(isset($params['limit_data'])){
              $select->limit($params['limit_data']);
              $paginator = $this->fetchAll($select);
              return $paginator;
          }else
              $paginator = $this->fetchAll($select);
      } else
          return Zend_Paginator::factory($select);
      return $paginator;
  }
  public function getPhotoPaginator(array $params)
  {
      return Zend_Paginator::factory($this->getPhotoSelect($params));
  }
  public function countPhotos(){
		return $this->select()->from($this->info('name'), new Zend_Db_Expr('COUNT(photo_id) as total_photos'))->limit(1)->query()->fetchColumn();
	}
  public function countAlbumPhotos($album_id){
		return $this->select()->from($this->info('name'), new Zend_Db_Expr('COUNT(photo_id) as total_photos'))->where('album_id =?', $album_id)->limit(1)->query()->fetchColumn();
	}
	public function getPhotoId($file_id) {
		return $this->select()->from($this->info('name'), 'photo_id')->where('file_id = ?', $file_id)->limit(1)->query()->fetchColumn();
	}


}
