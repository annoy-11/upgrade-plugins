<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Favourites.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Model_DbTable_Favourites extends Engine_Db_Table {

  protected $_rowClass = "Sesgroup_Model_Favourite";

  public function isFavourite($params = array()) {

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $status = $this->select()
            ->where('resource_type = ?', $params['resource_type'])
            ->where('resource_id = ?', $params['resource_id'])
            ->where('owner_id = ?', $viewer_id)
            ->query()
            ->fetchColumn();
    if ($status)
      return 1;
    else
      return 0;
  }
  

  public function getAllFavMembers($resourceId) {

    $select = $this->select()
            ->from($this->info('name'), 'owner_id')
            ->where('resource_id = ?', $resourceId);
    return $this->fetchAll($select);
  }

  public function getItemfav($resource_type, $itemId) {
    $tableFav = Engine_Api::_()->getDbTable('favourites', 'sesgroup');
    $tableMainFav = $tableFav->info('name');
    $select = $tableFav->select()->from($tableMainFav)->where('resource_type =?', $resource_type)->where('owner_id =?', Engine_Api::_()->user()->getViewer()->getIdentity())->where('resource_id =?', $itemId);
    return $tableFav->fetchRow($select);
  }

  public function getFavourites($params = array()) {
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $select = $this->select()
            ->from($this->info('name'))
            ->where('resource_type =?', $params['resource_type'])
            ->where('owner_id =?', $viewer_id);
    $albumTableName = Engine_Api::_()->getItemTable('album')->info('name');
    if ($params['resource_type'] == 'album_photo') {
      $photoTableName = Engine_Api::_()->getItemTable('album_photo')->info('name');
      $select = $select->joinLeft($photoTableName, $photoTableName . '.photo_id = ' . $this->info('name') . '.resource_id', null)
              ->where($photoTableName . '.photo_id != ?', '');
      $select = $select->joinLeft($albumTableName, $albumTableName . '.album_id = ' . $photoTableName . '.album_id', null)
              ->where($albumTableName . '.album_id !=?', '');
    } else {
      $select = $select->joinLeft($albumTableName, $albumTableName . '.album_id = ' . $this->info('name') . '.resource_id', null)
              ->where($albumTableName . '.album_id !=?', '');
    }
    return Zend_Paginator::factory($select);
  }

}
