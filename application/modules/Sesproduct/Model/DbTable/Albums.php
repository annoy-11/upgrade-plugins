<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Albums.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Model_DbTable_Albums extends Engine_Db_Table {

  protected $_rowClass = 'Sesproduct_Model_Album';

  //Count numbers of album that made in Product

  public function getUserAlbumCount($params = array()){
    return $this->select()->from($this->info('name'), new Zend_Db_Expr('COUNT(album_id) as total_albums'))->where('product_id = ?', Engine_Api::_()->user()->getViewer()->getIdentity())->limit(1)->query()->fetchColumn();
  }

 //This function used for fetch all albums in Product

  public function getAlbumSelect($value = array()){
    // Prepare data
    $albumTableName = $this->info('name');
    $select = $this->select()
		    ->from($albumTableName)
		    ->where('search =?',1)
		    ->where($albumTableName.'.product_id =?',$value['product_id'])
		    ->group($albumTableName.'.album_id');
    return Zend_Paginator::factory($select);
  }


    public function editPhotos(){
        $albumTable = Engine_Api::_()->getItemTable('sesproduct_album');
        $myAlbums = $albumTable->select()
                ->from($albumTable, array('album_id', 'title'))
                ->where('owner_id = ?', Engine_Api::_()->user()->getViewer()->getIdentity())
                ->query()
                ->fetchAll();
        return $myAlbums;
    }
}
