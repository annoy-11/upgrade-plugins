<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Albums.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Albums extends Engine_Db_Table {

  protected $_rowClass = "Estore_Model_Album";

  public function getUserAlbumCount($params = array()){
    return $this->select()->from($this->info('name'), new Zend_Db_Expr('COUNT(album_id) as total_albums'))->where('owner_id = ?', $params['user_id'])->limit(1)->query()->fetchColumn();
  }

    public function getUserStoreAlbumCount($params = array()){
        $count = $this->select()->from($this->info('name'), array("COUNT(album_id)"));
        if ($params['user_id'])
            $count->where('owner_id =?', $params['user_id']);
        if ($params['store_id'])
            $count->where('store_id =?', $params['store_id']);
        return $count->query()->fetchColumn();
    }
	public function getAlbumPaginator()
  {
    return $this->getAlbumSelect();
  }

  public function editPhotos(){
		$albumTable = Engine_Api::_()->getItemTable('estore_album');
    $myAlbums = $albumTable->select()
            ->from($albumTable, array('album_id', 'title'))
            ->where('owner_id = ?', Engine_Api::_()->user()->getViewer()->getIdentity())
            ->query()
            ->fetchAll();
	 return $myAlbums;
	}

	public function getAlbumSelect($value = array()) {


		 // Prepare data
		$albumTableName = $this->info('name');

		$tableTagmap = Engine_Api::_()->getDbTable('tagMaps', 'core');
		$tableTagName = $tableTagmap->info('name');

		$tableTag = Engine_Api::_()->getDbTable('tags', 'core');
		$tableMainTagName = $tableTag->info('name');

		$tablestore = Engine_Api::_()->getDbTable('stores', 'estore');
		$tablestoreName = $tablestore->info('name');

        $select = $this->select()
            ->from($albumTableName)
            ->setIntegrityCheck(false)
            ->where($albumTableName.'.search =?',true)
            ->where($albumTableName.'.photo_id !=?','')
            ->group($albumTableName.'.album_id')
            ->join($tablestoreName, $tablestoreName . '.store_id = ' . $albumTableName . '.store_id',null);

    if(!isset($value['order']))
      $value['order'] = '';

//     if( !in_array($value['order'], $this->info('cols')) )
//       $value['order'] = 'modified_date';


		$select->order($albumTableName .'.'.$value['order'] . ' DESC');

		if($value['order'] == 'featured') {
      $select->where($albumTableName.'.featured =?', 1);
		} else if($value['order'] == 'sponsored') {
      $select->where($albumTableName.'.sponsored =?', 1);
		}

    if(isset($value['store_id']) && intval($value['store_id']))
      $select->where($albumTableName.'.store_id = ?',$value['store_id']);

    if(isset($value['fixedDataAlbum']) && $value['fixedDataAlbum'] != '')
      $select->where($value['fixedDataAlbum']);

    if(isset($value['user_id']) && intval($value['user_id'])) $select->where('owner_id = ?',$value['user_id']);

//     if(empty($value['user_id']) || (isset($value['user_id']) && $value['user_id'] != Engine_Api::_()->user()->getViewer()->getIdentity()) && empty($value['allowSpecialAlbums'])){
//       if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesalbum.wall.profile', 1))
//         $select->where($albumTableName.'.type IS NULL');
//     }

		$viewer = Engine_Api::_()->user()->getViewer();
		if (isset($value['show']) && $value['show'] == 2 && $viewer->getIdentity()) {
      $users = $viewer->membership()->getMembershipsOfIds();
      if($users) {
        $select->where($albumTableName.'.owner_id IN (?)',$users);
			} else {
        $select->where($albumTableName . '.owner_id IN (?)', 0);
			}
    }
    if(empty($search)) {
      if (isset($value['search']) && $value['search'] != '') {
        $select->where($albumTableName.".title  LIKE ? ", '%' . $value['search'] . '%');
      }
    }

    if(isset($value['showdefaultalbum']) && empty($value['showdefaultalbum'])) {
      $select->where($albumTableName.'.type IS NULL');
    }
		if( !empty($value['owner']) && $value['owner'] instanceof Core_Model_Item_Abstract ) {
      $select->where($albumTableName.".owner_type = ?", $value['owner']->getType())
            ->where($albumTableName.".owner_id = ?", $value['owner']->getIdentity());
			return $select;
    }


    if(isset($value['limit_data']) && !empty($value['limit_data'])) {
      $select->limit($value['limit_data']);
    }

    if(isset($value['widget']) && !empty($value['widget'])) {
      //fecth all
      return $this->fetchAll($select);
    }

		return Zend_Paginator::factory($select);
	}








//   public function getAlbumSelect($value = array()){
//     // Prepare data
//     $albumTableName = $this->info('name');
//     $select = $this->select()
// 		    ->from($albumTableName)
// 		    ->where('search =?',1)
// 		    ->where($albumTableName.'.store_id =?',$value['store_id'])
// 		    ->store($albumTableName.'.album_id');
//     return Zend_Paginator::factory($select);
//   }
		public function getSpecialAlbum(User_Model_User $user, $type,$store_id)
  {
    if( !in_array($type, array('wall')) ) {
      //throw new Estore_Model_Exception('Unknown special album type');
    }
    $select = $this->select()
        ->where('owner_id = ?', $user->getIdentity())
        ->where('type = ?', $type)
				->where('store_id =?',$store_id)
        ->order('album_id ASC')
        ->limit(1);
    $album = $this->fetchRow($select);
    // Create wall photos album if it doesn't exist yet
    if( null === $album ) {
      $translate = Zend_Registry::get('Zend_Translate');
      $album = $this->createRow();
      $album->owner_id = $user->getIdentity();
      $album->title = $translate->_(ucfirst($type) . ' Photos');
      $album->type = $type;
			$album->store_id = $store_id;
      $album->search = 1;
      $album->save();
    }
    return $album;
  }
}
