<?php

class Sesgroupalbum_Api_Core extends Core_Api_Abstract {

  public function getNextPhoto($album_id = '', $order = '') {
    $table = Engine_Api::_()->getDbTable('photos', 'sesgroupalbum');
    $select = $table->select()
            ->where('album_id = ?', $album_id)
            ->where('`order` > ?', $order)
            ->order('order ASC')
            ->limit(1);
    $photo = $table->fetchRow($select);

    if (!$photo) {
      // Get first photo instead
      $select = $table->select()
              ->where('album_id = ?', $album_id)
              ->order('order ASC')
              ->limit(1);
      $photo = $table->fetchRow($select);
    }

    return $photo;
  }
    /**
   * Get Flush Photo Count
   *
   * @return photocount
   */
  public function getFlushPhotoData() {
    $GetTableNamePhoto = Engine_Api::_()->getItemTable('sesgroupalbum_photo');
    $tableNamePhoto = $GetTableNamePhoto->info('name');
    $select = $GetTableNamePhoto->select()->from($tableNamePhoto, new Zend_Db_Expr('COUNT(photo_id) as total'))->where('album_id =?', 0)->where('DATE(NOW()) != DATE(creation_date)');
    $data = $GetTableNamePhoto->fetchRow($select);
    return (int) $data->total;
  }
    //get next photo
  public function nextPhoto($photo = '', $params = array()) {
    return Engine_Api::_()->getDbTable('photos', 'sesgroupalbum')->getPhotoCustom($photo, $params, '>');
  }

  //get previous photo
  public function previousPhoto($photo = '', $params = array()) {
    return Engine_Api::_()->getDbTable('photos', 'sesgroupalbum')->getPhotoCustom($photo, $params, '<');
  }
  /**
   * Get Widget Identity
   *
   * @return $identity
   */
  public function getIdentityWidget($name, $type, $corePages) {
    $widgetTable = Engine_Api::_()->getDbTable('content', 'core');
    $widgetPages = Engine_Api::_()->getDbTable('pages', 'core')->info('name');
    $identity = $widgetTable->select()
            ->setIntegrityCheck(false)
            ->from($widgetTable, 'content_id')
            ->where($widgetTable->info('name') . '.type = ?', $type)
            ->where($widgetTable->info('name') . '.name = ?', $name)
            ->where($widgetPages . '.name = ?', $corePages)
            ->joinLeft($widgetPages, $widgetPages . '.page_id = ' . $widgetTable->info('name') . '.page_id')
            ->query()
            ->fetchColumn();
    return $identity;
  }
  /* tag cloud widget paginator */

  function tagCloudItemCore($fetchtype = '') {
    $tableTagmap = Engine_Api::_()->getDbtable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbtable('tags', 'core');
    $tableMainTagName = $tableTag->info('name');
    $selecttagged_photo = $tableTagmap->select()
            ->from($tableTagName)
            ->setIntegrityCheck(false)
            ->where('resource_type =?', 'sesgroupalbum_album')
            ->where('tag_type =?', 'core_tag')
            ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id=' . $tableTagName . '.tag_id', array('text'))
            ->group($tableTagName . '.tag_id');
    $selecttagged_photo->columns(array('itemCount' => ("COUNT($tableTagName.tagmap_id)")));
    if ($fetchtype == '')
      return Zend_Paginator::factory($selecttagged_photo);
    else
      return $tableTagmap->fetchAll($selecttagged_photo);
  }
  //get photo URL
  public function photoUrlGet($photo_id, $type = null) {
		    
				$viewer = Engine_Api::_()->user()->getViewer();
				if ($viewer->getIdentity() == 0)
					$level = Engine_Api::_()->getDbtable('levels', 'authorization')->getPublicLevel()->level_id;
				else
					$level = $viewer;
					
				$sesprofilelock_enable_module = (array)Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.enable.modules');
				
// 				if (Engine_Api::_()->getItem('sesgroupalbum_photo', $photo_id)->getParent()->is_locked && Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesprofilelock'))  && in_array('sesgroupalbum',$sesprofilelock_enable_module) && !Engine_Api::_()->authorization()->getPermission($level, 'album', 'locked'))
// 					return 'application/modules/Sesgroupalbum/externals/images/locked-album.jpg';
	    if( !$photo_id ) {
			 return 'application/modules/Sesgroupalbum/externals/images/nophoto_album_thumb_normal.pngc=direct';
			}
    if (empty($photo_id)) {
      $photoTable = Engine_Api::_()->getItemTable('sesgroupalbum_photo');
      $photoInfo = $photoTable->select()
              ->from($photoTable, array('photo_id', 'file_id'))
              ->where('album_id = ?', $this->album_id)
              ->order('order ASC')
              ->limit(1)
              ->query()
              ->fetch();
      if (!empty($photoInfo)) {
        $this->photo_id = $photo_id = $photoInfo['photo_id'];
        $this->save();
        $file_id = $photoInfo['file_id'];
      } else {
        return;
      }
    } else {
      $photoTable = Engine_Api::_()->getItemTable('sesgroupalbum_photo');
      $file_id = $photoTable->select()
              ->from($photoTable, 'file_id')
              ->where('photo_id = ?', $photo_id)
              ->query()
              ->fetchColumn();
    }
    if (!$file_id) {
      return;
    }
    $file = Engine_Api::_()->getItemTable('storage_file')->getFile($file_id, $type);
    if (!$file) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($file_id, '');
    }
    return $file->map();
  }
  
  public function getPreviousPhoto($album_id = '', $order = '') {
    $table = Engine_Api::_()->getDbTable('photos', 'sesgroupalbum');
    $select = $table->select()
            ->where('album_id = ?', $album_id)
            ->where('`order` < ?', $order)
            ->order('order DESC')
            ->limit(1);
    $photo = $table->fetchRow($select);

    if (!$photo) {
      // Get last photo instead
      $select = $table->select()
              ->where('album_id = ?', $album_id)
              ->order('order DESC')
              ->limit(1);
      $photo = $table->fetchRow($select);
    }

    return $photo;
  }

  //get photo href
  function getHrefPhoto($photoId = '', $albumId = '') {
    $params = array_merge(array(
        'route' => 'sesgroupalbum_extended',
        'reset' => true,
        'controller' => 'photo',
        'action' => 'view',
        'album_id' => $albumId,
        'photo_id' => $photoId,
    ));
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
                    ->assemble($params, $route, $reset);
  }
    /* people like item widget paginator */

  public function likeItemCore($params = array()) {
    $parentTable = Engine_Api::_()->getItemTable('core_like');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', $params['type'])
            ->order('like_id DESC');
    if (isset($params['id']))
      $select = $select->where('resource_id = ?', $params['id']);
    if (isset($params['poster_id']))
      $select = $select->where('poster_id =?', $params['poster_id']);
    return Zend_Paginator::factory($select);
  }
    // get lightbox image URL
  function getImageViewerHref($getImageViewerData, $paramsExtra = array()) {
    if (is_object($getImageViewerData)) {
      if (isset($getImageViewerData->album_id))
        $album_id = $getImageViewerData->album_id;
      else if (isset($getImageViewerData['album_id']))
        $album_id = $getImageViewerData['album_id'];

      if (isset($getImageViewerData->photo_id))
        $photo_id = $getImageViewerData->photo_id;
      else if (isset($getImageViewerData['photo_id']))
        $photo_id = $getImageViewerData['photo_id'];

      $params = array_merge(array(
          'route' => 'sesgroupalbum_extended',
          'controller' => 'photo',
          'action' => 'image-viewer-detail',
          'reset' => true,
          'album_id' => $album_id,
          'photo_id' => $photo_id,
              ), $paramsExtra);
      $route = $params['route'];
      $reset = $params['reset'];
      unset($params['route']);
      unset($params['reset']);
      return Zend_Controller_Front::getInstance()->getRouter()
                      ->assemble($params, $route, $reset);
    }
    return '';
  }

  
  /**
   * Get Photo Count
   *
   * @return $photoCount
   */
  function getPhotoCount($album_id = '') {
    if ($album_id != '') {
      $photoTable = Engine_Api::_()->getItemTable('group_photo');
      return $photoCount = $photoTable->select()->from($photoTable->info('name'), new Zend_Db_Expr('COUNT(photo_id) as total'))->where('album_id =?', $album_id)->query()
              ->fetchColumn();
    }
  }
   
     /**
   * Gets an absolute URL to the page to view this item
   *
   * @return string
  */
  public function getHref($albumId = '', $slug = '') {
    if (is_numeric($albumId)) {
      $slug = $this->getSlug(Engine_Api::_()->getItem('sesgroupalbum_album', $albumId)->getTitle());
    }
    $params = array_merge(array(
        'route' => 'sesgroupalbum_specific_album',
        'reset' => true,
        'album_id' => $albumId,
        'slug' => $slug,
    ));
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
                    ->assemble($params, $route, $reset);
  }
  
  
  /**
   * Gets a url slug for this item, based on it's title
   *
   * @return string The slug
   */
  public function getSlug($str = null, $maxstrlen = 245) {
    if (null === $str) {
      $str = $this->getTitle();
    }
    if (strlen($str) > $maxstrlen) {
      $str = Engine_String::substr($str, 0, $maxstrlen);
    }

    $search = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
    $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
    $str = str_replace($search, $replace, $str);

    $str = preg_replace('/([a-z])([A-Z])/', '$1 $2', $str);
    $str = strtolower($str);
    $str = preg_replace('/[^a-z0-9-]+/i', '-', $str);
    $str = preg_replace('/-+/', '-', $str);
    $str = trim($str, '-');
    if (!$str) {
      $str = '-';
    }
    return $str;
  }
    //get album photo
  function getAlbumPhoto($albumId = '', $photoId = '', $limit = 4) {
    if ($albumId != '') {
      $albums = Engine_Api::_()->getItemTable('group_album');
      $albumTableName = $albums->info('name');
      $photos = Engine_Api::_()->getItemTable('group_photo');
      $photoTableName = $photos->info('name');
      $select = $photos->select()
              ->from($photoTableName)
              ->limit($limit)
              ->where($albumTableName . '.album_id = ?', $albumId)
              ->where($photoTableName . '.photo_id != ?', $photoId)
              ->setIntegrityCheck(false)
              ->joinLeft($albumTableName, $albumTableName . '.album_id = ' . $photoTableName . '.album_id', null);
      if ($limit == 3)
        $select = $select->order('rand()');

      return $photos->fetchAll($select);
    }
  }
  
  function getPhotoUrl($photo_id = '', $type = 'group_photo') {
    $viewer = Engine_Api::_()->user()->getViewer();
			if ($viewer->getIdentity() == 0)
				$level = Engine_Api::_()->getDbtable('levels', 'authorization')->getPublicLevel()->level_id;
			else
				$level = $viewer;
/*				
			$sesprofilelock_enable_module = (array)Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.enable.modules');
			if (Engine_Api::_()->getItem('group_photo', $photo_id)->getParent()->is_locked && Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesprofilelock'))  && in_array('sesgroupalbum',$sesprofilelock_enable_module) && !Engine_Api::_()->authorization()->getPermission($level, 'group_album', 'locked'))
				return 'application/modules/Sesgroupalbum/externals/images/locked-album.jpg';*/
				
		if( !$photo_id ) {
		 return 'application/modules/Sesgroupalbum/externals/images/nophoto_album_thumb_normal.pngc=direct';
		}
		
    $file = Engine_Api::_()->getItemTable('storage_file')->getFile($photo_id, $type);
    if (!$file) {
      return null;
    }
    return $file->map();
  }
    // get photo like status
  public function getLikeStatusPhoto($photo_id = '', $moduleName = '') {
    if ($moduleName == '')
      $moduleName = 'sesgroupalbum_photo';
    if ($photo_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbtable('likes', 'core');
      $total_likes = $coreLikeTable->select()->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))->where('resource_type =?', $moduleName)->where('poster_id =?', $userId)->where('poster_type =?', 'user')->where('	resource_id =?', $photo_id)->limit(1)->query()->fetchColumn();
      if ($total_likes > 0) {
        return true;
      } else {
        return false;
      }
    }
    return false;
  }
    // get item like status
  public function getLikeStatus($album_id = '') {
    if ($album_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbtable('likes', 'core');
      $total_likes = $coreLikeTable->select()->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))->where('resource_type =?', 'sesgroupalbum_album')->where('poster_id =?', $userId)->where('poster_type =?', 'user')->where('resource_id =?', $album_id)->limit(1)->query()->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }
      //Get Event like status
  public function getLikeStatusGroup($blog_id = '', $moduleName = '') {
    if ($moduleName == '')
      $moduleName = 'group';
    if ($blog_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbtable('likes', 'core');
      $total_likes = $coreLikeTable->select()
              ->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))
              ->where('resource_type =?', $moduleName)
              ->where('poster_id =?', $userId)
              ->where('poster_type =?', 'user')
              ->where('	resource_id =?', $blog_id)
              ->query()
              ->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }
}