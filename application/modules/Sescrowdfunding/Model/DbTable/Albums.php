<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Albums.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Model_DbTable_Albums extends Engine_Db_Table {

  protected $_rowClass = 'Sescrowdfunding_Model_Album';
  
  public function getUserAlbumCount($params = array()){
    return $this->select()->from($this->info('name'), new Zend_Db_Expr('COUNT(album_id) as total_albums'))->where('crowdfunding_id = ?', Engine_Api::_()->user()->getViewer()->getIdentity())->limit(1)->query()->fetchColumn();
  }
  
  public function getAlbumId($crowdfunding_id) {
  
    return $this->select()
	      ->from($this->info('name'), array('album_id'))
	      ->where('crowdfunding_id =?', $crowdfunding_id)
	      ->query()
	      ->fetchColumn();
  }
  
  public function getAlbumSelect($value = array()){
    // Prepare data
    $albumTableName = $this->info('name');
    $select = $this->select()
		    ->from($albumTableName)
		    ->where('search =?',1)
		    ->where($albumTableName.'.crowdfunding_id =?',$value['crowdfunding_id'])
		    ->group($albumTableName.'.album_id');
    return Zend_Paginator::factory($select);
  }
  
	public function editPhotos(){
		$albumTable = Engine_Api::_()->getItemTable('sescrowdfunding_album');
		$myAlbums = $albumTable->select()
				->from($albumTable, array('album_id', 'title'))
				->where('owner_id = ?', Engine_Api::_()->user()->getViewer()->getIdentity())
				->query()
				->fetchAll();	
		return $myAlbums;
	}
}