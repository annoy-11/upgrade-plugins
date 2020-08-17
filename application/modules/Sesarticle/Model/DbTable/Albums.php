<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Albums.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Model_DbTable_Albums extends Engine_Db_Table {

  protected $_rowClass = 'Sesarticle_Model_Album';
  
  public function getUserAlbumCount($params = array()){
    return $this->select()->from($this->info('name'), new Zend_Db_Expr('COUNT(album_id) as total_albums'))->where('article_id = ?', Engine_Api::_()->user()->getViewer()->getIdentity())->limit(1)->query()->fetchColumn();
  }
  
  public function getAlbumSelect($value = array()){
    // Prepare data
    $albumTableName = $this->info('name');
    $select = $this->select()
		    ->from($albumTableName)
		    ->where('search =?',1)
		    ->where($albumTableName.'.article_id =?',$value['article_id'])
		    ->group($albumTableName.'.album_id');
    return Zend_Paginator::factory($select);
  }
  
	public function editPhotos(){
		$albumTable = Engine_Api::_()->getItemTable('sesarticle_album');
		$myAlbums = $albumTable->select()
				->from($albumTable, array('album_id', 'title'))
				->where('owner_id = ?', Engine_Api::_()->user()->getViewer()->getIdentity())
				->query()
				->fetchAll();	
		return $myAlbums;
	}
}