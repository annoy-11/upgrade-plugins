<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Api_Core extends Core_Api_Abstract {

  public function getWidgetParams($widgetId) {
      if(!$widgetId)
          return array();
    $db = Engine_Db_Table::getDefaultAdapter();
    $params = $db->select()
            ->from('engine4_core_content', 'params')
            ->where('`content_id` = ?', $widgetId)
            ->query()
            ->fetchColumn();
    return json_decode($params, true);
  }

  public function checkPrivacySetting($listing_id) {

    $listing = Engine_Api::_()->getItem('seslisting', $listing_id);
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();

    if ($viewerId)
      $level_id = $viewer->level_id;
    else
      $level_id = 5;

    $levels = $listing->levels;
    $member_level = explode(",",$listing->levels); //json_decode($levels);

    if (!empty($member_level)  && !empty($item->levels)) {
      if (!in_array($level_id, $member_level))
        return false;
    } else
      return true;


    if ($viewerId) {
      $network_table = Engine_Api::_()->getDbtable('membership', 'network');
      $network_select = $network_table->select('resource_id')->where('user_id = ?', $viewerId);
      $network_id_query = $network_table->fetchAll($network_select);
      $network_id_query_count = count($network_id_query);
      $network_id_array = array();
      for ($i = 0; $i < $network_id_query_count; $i++) {
        $network_id_array[$i] = $network_id_query[$i]['resource_id'];
      }

      if (!empty($network_id_array)) {
        $networks = explode(",",$listing->networks); //json_decode($listing->networks);

        if (!empty($networks)) {
          if (!array_intersect($network_id_array, $networks))
            return false;
        } else
          return true;
      }
    }
    return true;
  }

  /* get other module compatibility code as per module name given */
  public function getPluginItem($moduleName) {
		//initialize module item array
    $moduleType = array();
    $filePath =  APPLICATION_PATH . "/application/modules/" . ucfirst($moduleName) . "/settings/manifest.php";
		//check file exists or not
    if (is_file($filePath)) {
			//now include the file
      $manafestFile = include $filePath;
			$resultsArray =  Engine_Api::_()->getDbtable('integrateothermodules', 'seslisting')->getResults(array('module_name'=>$moduleName));
      if (is_array($manafestFile) && isset($manafestFile['items'])) {
        foreach ($manafestFile['items'] as $item)
          if (!in_array($item, $resultsArray))
            $moduleType[$item] = $item.' ';
      }
    }
    return $moduleType;
  }

  public function getWidgetPageId($widgetId) {

    $db = Engine_Db_Table::getDefaultAdapter();
    $params = $db->select()
            ->from('engine4_core_content', 'page_id')
            ->where('`content_id` = ?', $widgetId)
            ->query()
            ->fetchColumn();
    return json_decode($params, true);
  }

  function multiCurrencyActive(){
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->multiCurrencyActive();
    }else{
      return false;
    }
  }
  function isMultiCurrencyAvailable(){
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->isMultiCurrencyAvailable();
    }else{
      return false;
    }
  }

  function getCurrencyPrice($price = 0, $givenSymbol = '', $change_rate = '',$returnValue = false){
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $precisionValue = $settings->getSetting('sesmultiplecurrency.precision', 2);
    $defaultParams['precision'] = $precisionValue;
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->getCurrencyPrice($price, $givenSymbol, $change_rate,$returnValue);
    }else{
      return Zend_Registry::get('Zend_View')->locale()->toCurrency($price, $givenSymbol, $defaultParams);
    }
  }
  function getCurrentCurrency(){
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->getCurrentCurrency();
    }else{
      return $settings->getSetting('payment.currency', 'USD');
    }
  }
  function defaultCurrency(){
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->defaultCurrency();
    }else{
      $settings = Engine_Api::_()->getApi('settings', 'core');
      return $settings->getSetting('payment.currency', 'USD');
    }
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

  function truncate($text, $length = 100, $options = array()) {
    $default = array(
        'ending' => '...', 'exact' => true, 'html' => false
    );
    $options = array_merge($default, $options);
    extract($options);

    if ($html) {
        if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        $totalLength = mb_strlen(strip_tags($ending));
        $openTags = array();
        $truncate = '';

        preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
        foreach ($tags as $tag) {
            if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                    array_unshift($openTags, $tag[2]);
                } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                    $pos = array_search($closeTag[1], $openTags);
                    if ($pos !== false) {
                        array_splice($openTags, $pos, 1);
                    }
                }
            }
            $truncate .= $tag[1];

            $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
            if ($contentLength + $totalLength > $length) {
                $left = $length - $totalLength;
                $entitiesLength = 0;
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                    foreach ($entities[0] as $entity) {
                        if ($entity[1] + 1 - $entitiesLength <= $left) {
                            $left--;
                            $entitiesLength += mb_strlen($entity[0]);
                        } else {
                            break;
                        }
                    }
                }

                $truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
                break;
            } else {
                $truncate .= $tag[3];
                $totalLength += $contentLength;
            }
            if ($totalLength >= $length) {
                break;
            }
        }
    } else {
        if (mb_strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = mb_substr($text, 0, $length - mb_strlen($ending));
        }
    }
    if (!$exact) {
        $spacepos = mb_strrpos($truncate, ' ');
        if (isset($spacepos)) {
            if ($html) {
                $bits = mb_substr($truncate, $spacepos);
                preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                if (!empty($droppedTags)) {
                    foreach ($droppedTags as $closingTag) {
                        if (!in_array($closingTag[1], $openTags)) {
                            array_unshift($openTags, $closingTag[1]);
                        }
                    }
                }
            }
            $truncate = mb_substr($truncate, 0, $spacepos);
        }
    }
    $truncate .= $ending;

    if ($html) {
        foreach ($openTags as $tag) {
            $truncate .= '</'.$tag.'>';
        }
    }

    return $truncate;
}
   public function getCustomFieldMapDataListing($listing) {
    if ($listing) {
      $db = Engine_Db_Table::getDefaultAdapter();
      return $db->query("SELECT GROUP_CONCAT(value) AS `valuesMeta`,IFNULL(TRIM(TRAILING ', ' FROM GROUP_CONCAT(DISTINCT(engine4_seslisting_fields_options.label) SEPARATOR ', ')),engine4_seslisting_fields_values.value) AS `value`, `engine4_seslisting_fields_meta`.`label`, `engine4_seslisting_fields_meta`.`type` FROM `engine4_seslisting_fields_values` LEFT JOIN `engine4_seslisting_fields_meta` ON engine4_seslisting_fields_meta.field_id = engine4_seslisting_fields_values.field_id LEFT JOIN `engine4_seslisting_fields_options` ON engine4_seslisting_fields_values.value = engine4_seslisting_fields_options.option_id AND (`engine4_seslisting_fields_meta`.`type` = 'multi_checkbox' || `engine4_seslisting_fields_meta`.`type` = 'radio') WHERE (engine4_seslisting_fields_values.item_id = ".$listing->listing_id.") AND (engine4_seslisting_fields_values.field_id != 1) GROUP BY `engine4_seslisting_fields_meta`.`field_id`,`engine4_seslisting_fields_options`.`field_id`")->fetchAll();
    }
    return array();
  }

  public function getwidgetizePage($params = array()) {

    $corePages = Engine_Api::_()->getDbtable('pages', 'core');
    $corePagesName = $corePages->info('name');
    $select = $corePages->select()
            ->from($corePagesName, array('*'))
            ->where('name = ?', $params['name'])
            ->limit(1);
    return $corePages->fetchRow($select);
  }

     /**
   * Gets an absolute URL to the page to view this item
   *
   * @return string
  */
  public function getHref($albumId = '', $slug = '') {
//     if (is_numeric($albumId)) {
//       $slug = $this->getSlug(Engine_Api::_()->getItem('seslisting_album', $albumId)->getTitle());
//     }
    $params = array_merge(array(
        'route' => 'seslisting_specific_album',
        'reset' => true,
        'album_id' => $albumId,
       // 'slug' => $slug,
    ));
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
                    ->assemble($params, $route, $reset);
  }
      //get album photo
  function getAlbumPhoto($albumId = '', $photoId = '', $limit = 4) {
    if ($albumId != '') {
      $albums = Engine_Api::_()->getItemTable('seslisting_album');
      $albumTableName = $albums->info('name');
      $photos = Engine_Api::_()->getItemTable('seslisting_photo');
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
       //get photo URL
  public function photoUrlGet($photo_id, $type = null) {
    if (empty($photo_id)) {
      $photoTable = Engine_Api::_()->getItemTable('seslisting_photo');
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
      $photoTable = Engine_Api::_()->getItemTable('seslisting_photo');
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
    $table = Engine_Api::_()->getDbTable('photos', 'seslisting');
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

  	public function getNextPhoto($album_id = '', $order = '') {
    $table = Engine_Api::_()->getDbTable('photos', 'seslisting');
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

    //Get Event like status
  public function getLikeStatusListing($listing_id = '', $moduleName = '') {
    if ($moduleName == '')
      $moduleName = 'seslisting';
    if ($listing_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbtable('likes', 'core');
      $total_likes = $coreLikeTable->select()
              ->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))
              ->where('resource_type =?', $moduleName)
              ->where('poster_id =?', $userId)
              ->where('poster_type =?', 'user')
              ->where('	resource_id =?', $listing_id)
              ->query()
              ->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
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

  function tagCloudItemCore($fetchtype = '', $listing_id = '') {

    $tableTagmap = Engine_Api::_()->getDbtable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbtable('tags', 'core');
    $tableMainTagName = $tableTag->info('name');
    $selecttagged_photo = $tableTagmap->select()
            ->from($tableTagName)
            ->setIntegrityCheck(false)
            ->where('resource_type =?', 'seslisting')
            ->where('tag_type =?', 'core_tag')
            ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id=' . $tableTagName . '.tag_id', array('text'))
            ->group($tableTagName . '.tag_id');
    if($listing_id) {
      $selecttagged_photo->where($tableTagName.'.resource_id =?', $listing_id);
    }
    $selecttagged_photo->columns(array('itemCount' => ("COUNT($tableTagName.tagmap_id)")));
    if ($fetchtype == '')
      return Zend_Paginator::factory($selecttagged_photo);
    else
      return $tableTagmap->fetchAll($selecttagged_photo);
  }

  function getListinggers() {
    $userTable = Engine_Api::_()->getItemTable('user');
    $userTableName = $userTable->info('name');
    $listingTable = Engine_Api::_()->getDbTable('seslistings', 'seslisting');
    $listingTableName = $listingTable->info('name');
    $select = $userTable->select()
			->from($userTable, array('COUNT(*) AS listing_count', 'user_id', 'displayname'))
			->setIntegrityCheck(false)
			->join($listingTableName, $listingTableName . '.owner_id=' . $userTableName . '.user_id')
			->group($userTableName . '.user_id')->order('listing_count DESC');
    return Zend_Paginator::factory($select);
  }

    // get item like status
  public function getLikeStatus($listing_id = '', $resource_type = '') {

    if ($listing_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbtable('likes', 'core');
      $total_likes = $coreLikeTable->select()->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))->where('resource_type =?', $resource_type)->where('poster_id =?', $userId)->where('poster_type =?', 'user')->where('resource_id =?', $listing_id)->limit(1)->query()->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }

  public function getCustomFieldMapData($item) {
    if ($item) {
      $db = Engine_Db_Table::getDefaultAdapter();
      return $db->query("SELECT GROUP_CONCAT(value) AS `valuesMeta`,IFNULL(TRIM(TRAILING ', ' FROM GROUP_CONCAT(DISTINCT(engine4_seslistingreview_fields_options.label) SEPARATOR ', ')),engine4_seslistingreview_fields_values.value) AS `value`, `engine4_seslistingreview_fields_meta`.`label`, `engine4_seslistingreview_fields_meta`.`type` FROM `engine4_seslistingreview_fields_values` LEFT JOIN `engine4_seslistingreview_fields_meta` ON engine4_seslistingreview_fields_meta.field_id = engine4_seslistingreview_fields_values.field_id LEFT JOIN `engine4_seslistingreview_fields_options` ON engine4_seslistingreview_fields_values.value = engine4_seslistingreview_fields_options.option_id AND `engine4_seslistingreview_fields_meta`.`type` = 'multi_checkbox' WHERE (engine4_seslistingreview_fields_values.item_id = ".$item->getIdentity().") AND (engine4_seslistingreview_fields_values.field_id != 1) GROUP BY `engine4_seslistingreview_fields_meta`.`field_id`,`engine4_seslistingreview_fields_options`.`field_id`")->fetchAll();
    }
    return array();
  }

  public function getSpecialAlbum(User_Model_User $user, $type = 'seslisting') {
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

	public function allowReviewRating() {
		if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.allow.review', 1))
		return true;

		return false;
	}

	public function isListingAdmin($listing = null, $privacy = null) {
	  $viewer = Engine_Api::_()->user()->getViewer();
	  if($viewer->getIdentity()) {
      if($viewer->level_id == 1 || $viewer->level_id == 2)
      return 1;
	  }
	  if(!isset($listing->owner_id))
	  return 0;
	  $level_id = Engine_Api::_()->getItem('user', $listing->owner_id)->level_id;
	  if($privacy == 'create') {
	   if($listing->authorization()->isAllowed(null, 'video'))
	   return 1;
	   elseif($this->checkListingAdmin($listing))
	   return 1;
	   else
	   return 0;
	  }
	  elseif($privacy == 'music_create') {
	   if(Engine_Api::_()->authorization()->isAllowed('sesmusic_album', 'create'))
	   return 1;
	   elseif($this->checkListingAdmin($listing))
	   return 1;
	   else
	   return 0;
	  }
	  else {
			if(!Engine_Api::_()->authorization()->getPermission($level_id, 'seslisting', $privacy))
			return 0;
			else {
				$listingAdmin = $this->checkListingAdmin($listing);
				if($listingAdmin)
				return 1;
				else
				return 0;
			}
	  }
	}

	public function checkListingAdmin($listing = null) {
	   $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
	   $roleTable = Engine_Api::_()->getDbTable('roles', 'seslisting');
	   return $roleTable->select()->from($roleTable->info('name'), 'role_id')
	                    ->where('listing_id = ?', $listing->listing_id)
	                    ->where('user_id =?', $viewerId)
	                    ->query()
	                    ->fetchColumn();

	}

      public function deleteListing($seslisting = null){
		if(!$seslisting)
			return false;
        $listingId = $seslisting->listing_id;
		$isPackageEnable = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('seslistingpackage');
		if($isPackageEnable){
			$seslisting->cancel();
		}
		$owner_id = $seslisting->owner_id;
		//Delete album
		$seslistingAlbumTable = Engine_Api::_()->getDbtable('albums', 'seslisting');
		$seslistingAlbumTable->delete(array(
			'owner_id = ?' => $owner_id,
            'listing_id = ?' =>  $listingId,
		));

		//Delete Photos
		$seslistingPhotosTable = Engine_Api::_()->getDbtable('photos', 'seslisting');
		$seslistingPhotosTable->delete(array(
			'user_id = ?' => $owner_id,
            'listing_id = ?' =>  $listingId,
		));
			//Delete Claims
		$seslistingClaimsTable = Engine_Api::_()->getDbtable('claims', 'seslisting');
		$seslistingClaimsTable->delete(array(
			'user_id = ?' => $owner_id,
            'listing_id = ?' =>  $listingId,
		));
		//Delete Favourites
		$seslistingFavouritesTable = Engine_Api::_()->getDbtable('favourites', 'seslisting');
		$seslistingFavouritesTable->delete(array(
			'user_id = ?' => $owner_id,
            'resource_id = ?' =>  $listingId,
		));
		//Delete Reviews
		$seslistingReviewsTable = Engine_Api::_()->getDbtable('seslistingreviews', 'seslisting');
		$seslistingReviewsTable->delete(array(
			'owner_id = ?' => $owner_id,
            'listing_id = ?' =>  $listingId,
		));
		//Delete Reviews Parameters
		$seslistingReviewsParametersTable = Engine_Api::_()->getDbtable('parametervalues', 'seslisting');
		$seslistingReviewsParametersTable->delete(array(
			'user_id = ?' => $owner_id,
            'resources_id = ?' =>  $listingId,
		));
		//Delete Roles
		$seslistingRolesTable = Engine_Api::_()->getDbtable('roles', 'seslisting');
		$seslistingRolesTable->delete(array(
			'user_id = ?' => $owner_id,
            'listing_id = ?' =>  $listingId,
		));

		$seslisting->delete();
	}

	public function checkListingStatus() {
		$table = Engine_Api::_()->getDbTable('seslistings', 'seslisting');
		$select = $table->select()
		->where('publish_date is NOT NULL AND publish_date <= "'.date('Y-m-d H:i:s').'"')
		->where('draft =?', 0)
        ->where('is_approved =?', 1)
		->where('is_publish =?', 0);
		$listings = $table->fetchAll($select);
		if(count($listings) > 0) {
			foreach($listings as $listing) {
			  $seslisting = Engine_Api::_()->getItem('seslisting', $listing->listing_id);
				$action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($seslisting);
				if(count($action->toArray()) <= 0) {
					$viewer = Engine_Api::_()->getItem('user', $listing->owner_id);
					$action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $seslisting, 'seslisting_new');
					// make sure action exists before attaching the seslisting to the activity
					if( $action ) {
						Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $seslisting);
					}
					Engine_Api::_()->getItemTable('seslisting')->update(array('is_publish' => 1,'publish_date'=>date('Y-m-d H:i:s')), array('listing_id = ?' => $listing->listing_id));
				}
			}
		}
	}

	public function getTotalReviews($listingId = null) {
	  $reviewTable = Engine_Api::_()->getDbTable('seslistingreviews', 'seslisting');
	  return $reviewTable->select()
	  ->from($reviewTable->info('name'), new Zend_Db_Expr('COUNT(review_id)'))
	  ->where('listing_id =?', $listingId)
	  ->query()
	  ->fetchColumn();
	}
}
