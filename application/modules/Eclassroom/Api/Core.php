<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Api_Core extends Core_Api_Abstract {

    public function deleteClassroom($classroom = null){
		if(!$classroom)
			return false;
		$classroom->delete();
	}
    public function privacy($item = null, $privacy = null) {
        $viewer = Engine_Api::_()->user()->getViewer();
        if (!$item->authorization()->isAllowed($viewer, $privacy))
        return 0;
        else
        return 1;
    }
    public function getallJoinedMembers($classroom) {
      $select = $classroom->membership()->getMembersObjectSelect();
      return Zend_Paginator::factory($select);
    }
    public function classroomRolePermission($classroom,$action_name){
      if($action_name == "manage-classroomapps")
      return 1;
      $actionName =  Engine_Api::_()->getDbTable('dashboards', 'eclassroom')->getDashboardsItems(array('action_name'=>$action_name));
      if(!$actionName)
      return 0;
      $actionName = $actionName->manage_section_name;
      $permissionName = $actionName->permission_name;
      switch($actionName){
        case "manage_classroom":
        return Engine_Api::_()->getDbTable('classroomroles','eclassroom')->toCheckUserClassroomRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$classroom->getIdentity(),'manage_dashboard',$permissionName);
        break;
        case "manage_product":
        return Engine_Api::_()->getDbTable('classroomroles','eclassroom')->toCheckUserClassroomRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$classroom->getIdentity(),'manage_product',$permissionName);
        break;
        case "classroom_style":
            return Engine_Api::_()->getDbTable('classroomroles','eclassroom')->toCheckUserClassroomRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$classroom->getIdentity(),'manage_styling',$permissionName);
        break;
        case "class_promotions":
            return Engine_Api::_()->getDbTable('classroomroles','eclassroom')->toCheckUserClassroomRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$classroom->getIdentity(),'manage_promotions',$permissionName);
        break;
        case "crs_insights_reports":
            return Engine_Api::_()->getDbTable('classroomroles','eclassroom')->toCheckUserClassroomRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$classroom->getIdentity(),'manage_insight',$permissionName);
        break;
        case "manage_apps";
        return Engine_Api::_()->getDbTable('classroomroles','eclassroom')->toCheckUserClassroomRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$classroom->getIdentity(),'manage_apps',$permissionName);
        break;
      }
      return 0;
    }
    public function getClassroomRolePermission($classroom_id, $role_name, $permission_name, $canEdit = true) {
        $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        return Engine_Api::_()->getDbTable('classroomroles','eclassroom')->toCheckUserClassroomRole($viewer_id, $classroom_id, $role_name, $permission_name,$canEdit);
    }
    public function getFieldsCount($item) {
        if(empty($item->category_id) && empty($item->subcat_id) && empty($item->subsubcat_id))
        return 0;
        $arrayProfileIds = '';
        $categoryIds = array_filter(array('0' => $item->category_id, '1' => $item->subcat_id, '2' => $item->subsubcat_id));
        $categoryTable = Engine_Api::_()->getDbTable('categories', 'eclassroom');
        $select = $categoryTable->select()->from($categoryTable->info('name'), 'group_concat(profile_type) as profile_type')->where('category_id IN(?)', $categoryIds);
        $arrayProfileIdsArray = $categoryTable->fetchAll($select)->toArray();
        if ($arrayProfileIdsArray[0]['profile_type'])
        $arrayProfileIds = $arrayProfileIdsArray[0]['profile_type'];
        if (!empty($arrayProfileIds)) {
        $mapsTable = Engine_Api::_()->fields()->getTable('classroom', 'maps');
        return $mapsTable->select()->from($mapsTable->info('name'), 'COUNT(option_id)')->where('option_id IN(?)', $arrayProfileIds)->query()->fetchColumn();
        }
        return 0;
    }
    public function getMemberByLike($itemId, $resource_type ='classroom',$limit = null) {
        $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
        $select = $coreLikeTable->select()->from($coreLikeTable->info('name'), 'poster_id')
                ->where('resource_id =?', $itemId)
                ->where('resource_type =?', $resource_type);
        if ($limit) {
        $select = $select->limit($limit);
        }
        $results = $select->query()->fetchAll();
        return $results;
    }
    public function getMemberFavourite($itemId, $resource_type ='classroom', $limit = null) {

        $favouriteTable = Engine_Api::_()->getDbTable('favourites', 'eclassroom');
        $select = $favouriteTable->select()->from($favouriteTable->info('name'), 'owner_id')
                ->where('resource_id =?', $itemId)
                ->where('resource_type =?', $resource_type);
        if ($limit)
        $select = $select->limit($limit);
        $results = $select->query()->fetchAll();
        return $results;
    }
    public function getMemberFollow($itemId,$resource_type = 'classroom' ,$limit = null) {
        $followTable = Engine_Api::_()->getDbTable('followers', 'eclassroom');
        $select = $followTable->select()->from($followTable->info('name'), 'owner_id')
                ->where('resource_id =?', $itemId)
                ->where('resource_type =?', $resource_type);
        if ($limit)
        $select = $select->limit($limit);
        $results = $select->query()->fetchAll();
        return $results;
    }
    public function getMemberReview($classroomId, $limit = null) {
        $reviewTable = Engine_Api::_()->getDbTable('reviews', 'eclassroom');
        $select = $reviewTable->select()->from($reviewTable->info('name'), 'owner_id')
                ->where('classroom_id =?', $classroomId);
        if ($limit)
        $select = $select->limit($limit);
        $results = $select->query()->fetchAll();
        return $results;
    }
  public function getLikeStatus($item_id = '', $resource_type = '') {
    if ($item_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
      $total_likes = $coreLikeTable->select()->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))->where('resource_type =?', $resource_type)->where('poster_id =?', $userId)->where('poster_type =?', 'user')->where('resource_id =?', $item_id)->limit(1)->query()->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }
  public function updateNewOwnerId($params = array()) {
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->update('engine4_eclassroom_classrooms', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "classroom_id = ?" => $params['classroom_id']));
    $db->update('engine4_eclassroom_announcements', array('user_id' => $params['newuser_id']), array("user_id = ?" => $params['olduser_id'], "classroom_id = ?" => $params['classroom_id']));
    $db->update('engine4_eclassroom_favourites', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "resource_id = ?" => $params['classroom_id']));
    $db->update('engine4_eclassroom_followers', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "resource_id = ?" => $params['classroom_id']));
    $db->update('engine4_eclassroom_locationphotos', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "classroom_id = ?" => $params['classroom_id']));
    $db->update('engine4_eclassroom_classroomroles', array('user_id' => $params['newuser_id']), array("user_id = ?" => $params['olduser_id'], "classroom_id = ?" => $params['classroom_id']));
  }
  public function getCustomFieldMapDataCourse($classroom) {
      if ($classroom) {
        $db = Engine_Db_Table::getDefaultAdapter();
        return $db->query("SELECT GROUP_CONCAT(value) AS `valuesMeta`,IFNULL(TRIM(TRAILING ', ' FROM GROUP_CONCAT(DISTINCT(engine4_classroom_fields_options.label) SEPARATOR ', ')),engine4_classroom_fields_values.value) AS `value`, `engine4_classroom_fields_meta`.`label`, `engine4_classroom_fields_meta`.`type` FROM `engine4_classroom_fields_values` LEFT JOIN `engine4_classroom_fields_meta` ON engine4_classroom_fields_meta.field_id = engine4_classroom_fields_values.field_id LEFT JOIN `engine4_classroom_fields_options` ON engine4_classroom_fields_values.value = engine4_classroom_fields_options.option_id AND (`engine4_classroom_fields_meta`.`type` = 'multi_checkbox' || `engine4_classroom_fields_meta`.`type` = 'radio') WHERE (engine4_classroom_fields_values.item_id = ".$classroom->classroom_id.") AND (engine4_classroom_fields_values.field_id != 1) GROUP BY `engine4_classroom_fields_meta`.`field_id`,`engine4_classroom_fields_options`.`field_id`")->fetchAll();
      }
      return array();
  }
  public function getNextPhoto($album_id = '', $order = '') {
    $table = Engine_Api::_()->getDbTable('photos', 'eclassroom');
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
  public function checkClassroomAdmin($clasroom_id) {
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $classroomTable = Engine_Api::_()->getDbTable('classrooms', 'eclassroom');
    return $classroomTable->select()->from($classroomTable->info('name'), 'classroom_id')
	                    ->where('classroom_id = ?', $clasroom_id)
	                    ->where('owner_id =?', $viewerId)
	                    ->query()
	                    ->fetchColumn();
	}
  public function getPreviousPhoto($album_id = '', $order = '') {
    $table = Engine_Api::_()->getDbTable('photos', 'eclassroom');
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
    // Get album photo
  function getAlbumPhoto($albumId = '', $photoId = '', $limit = 4) {
    if ($albumId != '') {
      $albums = Engine_Api::_()->getItemTable('eclassroom_album');
      $albumTableName = $albums->info('name');
      $photos = Engine_Api::_()->getItemTable('eclassroom_photo');
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
      $paginator = Zend_Paginator::factory($select);
    return  $paginator->setItemCountPerPage($limit);
    }
  }
  // Get Classroom like status
  public function getLikeStatusClassroom($classroom_id = '', $moduleName = '') {

    if ($moduleName == '')
      $moduleName = 'eclassroom';

    if ($classroom_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
      $total_likes = $coreLikeTable->select()
              ->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))
              ->where('resource_type =?', $moduleName)
              ->where('poster_id =?', $userId)
              ->where('poster_type =?', 'user')
              ->where('resource_id =?', $classroom_id)
              ->query()
              ->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }
  public function getHref($albumId = '', $slug = '') {
    if (is_numeric($albumId)) {
      $slug = $this->getSlug(Engine_Api::_()->getItem('eclassroom_album', $albumId)->getTitle());
    }
    $params = array_merge(array(
        'route' => 'eclassroom_specific_album',
        'reset' => true,
        'album_id' => $albumId,
        'slug' => $slug,
    ));
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, $reset);
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
  public function getWidgetParams($widgetId) {
    $db = Engine_Db_Table::getDefaultAdapter();
    $params = $db->select()
            ->from('engine4_core_content', 'params')
            ->where('`content_id` = ?', $widgetId)
            ->query()
            ->fetchColumn();
    return json_decode($params, true);
  }
  //Total likes according to viewer_id
    public function likeIds($params = array()) {

        $likeTable = Engine_Api::_()->getItemTable('core_like');
        return $likeTable->select()
                        ->from($likeTable->info('name'), array('resource_id'))
                        ->where('resource_type = ?', $params['type'])
                        ->where('poster_id = ?', $params['id'])
                        ->query()
                        ->fetchColumn();
    }
    function tagCloudItemCore($fetchtype = '', $classroom_id = '',$limit = null) {
        $tableTagmap = Engine_Api::_()->getDbtable('tagMaps', 'core');
        $tableTagName = $tableTagmap->info('name');
        $tableTag = Engine_Api::_()->getDbtable('tags', 'core');
        $tableMainTagName = $tableTag->info('name');
        $selecttagged_photo = $tableTagmap->select()
                ->from($tableTagName)
                ->setIntegrityCheck(false)
                ->where('resource_type =?', 'classroom')
                ->where('tag_type =?', 'core_tag')
                ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id=' . $tableTagName . '.tag_id', array('text'))
                ->group($tableTagName . '.tag_id');
        if($classroom_id) {
        $selecttagged_photo->where($tableTagName.'.resource_id =?', $classroom_id);
        }
        $selecttagged_photo->columns(array('itemCount' => ("COUNT($tableTagName.tagmap_id)")));
        if(isset($limit) && $limit >0)
          $selecttagged_photo->limit($limit);
        if ($fetchtype == '')
        return Zend_Paginator::factory($selecttagged_photo);
        else
        return $tableTagmap->fetchAll($selecttagged_photo);
    }
    public function getSearchWidgetParams($widgetId) {
        $db = Engine_Db_Table::getDefaultAdapter();
        $pageId = $db->select()
                ->from('engine4_core_content', 'page_id')
                ->where('`content_id` = ?', $widgetId)
                ->query()
                ->fetchColumn();
        $params = $db->select()
                ->from('engine4_core_content', 'params')
                ->where('`page_id` = ?', $pageId)
                ->where('`name` = ?', 'eclassroom.browse-search')
                ->query()
                ->fetchColumn();
        if ($params)
            return json_decode($params, true);
        else
            return 0;
    }
}
