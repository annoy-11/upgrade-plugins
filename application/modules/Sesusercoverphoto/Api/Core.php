<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercoverphoto
 * @package    Sesusercoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-05-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesusercoverphoto_Api_Core extends Core_Api_Abstract {
	
	function getModuleRecordsOfUser($item,$user_id){
		$rName = Engine_Api::_()->getItemTable($item);
		
		if( !in_array('owner_id', $rName->info('cols')) )
			$field = 'user_id';
		else
			$field = 'owner_id';

    $rating_sum = $rName->select()
            ->from($rName->info('name'), new Zend_Db_Expr('COUNT(*)'))
            ->where($field.' = ?', $user_id)
            ->group($field)
            ->query()
            ->fetchColumn();
    if (!$rating_sum)
      return 0;
    return $rating_sum;	
	}
	public function getSpecialAlbum(User_Model_User $user, $type = 'cover')
  {
    $table = Engine_Api::_()->getItemTable('album');
    $select = $table->select()
        ->where('owner_type = ?', $user->getType())
        ->where('owner_id = ?', $user->getIdentity())
        ->where('type = ?', $type)
        ->order('album_id ASC')
        ->limit(1);
    $album = $table->fetchRow($select);
    // Create wall photos album if it doesn't exist yet
    if( null === $album ) {
      $translate = Zend_Registry::get('Zend_Translate');
      $album = $table->createRow();
      $album->owner_type = 'user';
      $album->owner_id = $user->getIdentity();
      $album->title = $translate->_(ucfirst($type) . ' Photos');
      $album->type = $type;
      $album->search = 1;
      $album->save();
      // Authorizations
			$auth = Engine_Api::_()->authorization()->context;
			$auth->setAllowed($album, 'everyone', 'view',    true);
			$auth->setAllowed($album, 'everyone', 'comment', true);
    }
    return $album;
  }
  
  public function getUserAlbum(){
			$viewer = Engine_Api::_()->user()->getViewer();
			$table = Engine_Api::_()->getItemTable('album');
			$select = $table->select()
				->from($table->info('name'))
				->where('owner_id =?',$viewer->getIdentity())
				->order('type DESC');
		
			return Zend_Paginator::factory($select);	
	}
	
  public function getPhotoSelect($params = array())
  {
    $table = Engine_Api::_()->getItemTable('photo');
    $select = $table->select();
    
    if( !empty($params['album']) && $params['album'] instanceof Sesalbum_Model_Album ) {
      $select->where('album_id = ?', $params['album']->getIdentity());
    } else if( !empty($params['album_id']) && is_numeric($params['album_id']) ) {
      $select->where('album_id = ?', $params['album_id']);
    }
    
    if( !isset($params['order']) ) {
      $select->order('order ASC');
    } else if( is_string($params['order']) ) {
      $select->order($params['order']);
    }

    if(empty($params['pagNator'])){
      if(isset($params['limit_data'])){
        $select->limit($params['limit_data']);
        return $table->fetchAll($select);
      } else
        return $table->fetchAll($select);
    } else
        return Zend_Paginator::factory($select);		
    }
}