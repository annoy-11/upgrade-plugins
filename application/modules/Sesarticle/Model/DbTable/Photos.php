<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Photos.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Model_DbTable_Photos extends Engine_Db_Table
{
  protected $_rowClass = 'Sesarticle_Model_Photo';
  
  	public function getPhotoSelect($params = array())
  {
    $select = $this->select();
    
    if( !empty($params['album']) && $params['album'] instanceof Sesarticle_Model_Album ) {
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
	}else
			return Zend_Paginator::factory($select);
		
    return $paginator;
  }
  public function getPhotoPaginator(array $params)
  {
    return Zend_Paginator::factory($this->getPhotoSelect($params));
  }
	public function countPhotos(){
		return $this->select()->from($this->info('name'), new Zend_Db_Expr('COUNT(photo_id) as total_photos'))->limit(1)->query()->fetchColumn();;
	}
}