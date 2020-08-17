<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespage_Api_Core extends Core_Api_Abstract {

  public function getPageRolePermission($page_id, $role_name, $permission_name, $canEdit = true) {

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

    return Engine_Api::_()->getDbTable('pageroles','sespage')->toCheckUserPageRole($viewer_id, $page_id, $role_name, $permission_name,$canEdit);
  }

  public function pageRolePermission($page,$action_name){
    if($action_name == "manage-pageapps")
    return 1;
   $actionName =  Engine_Api::_()->getDbTable('dashboards', 'sespage')->getDashboardsItems(array('action_name'=>$action_name));
   if(!$actionName)
    return 0;

   $actionName = $actionName->manage_section_name;
   $permissionName = $actionName->permission_name;
   switch($actionName){
      case "manage_page":
       return Engine_Api::_()->getDbTable('pageroles','sespage')->toCheckUserPageRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$page->getIdentity(),'manage_dashboard',$permissionName);
      break;
      case "page_style":
        return Engine_Api::_()->getDbTable('pageroles','sespage')->toCheckUserPageRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$page->getIdentity(),'manage_styling',$permissionName);
      break;
      case "page_promotion":
        return Engine_Api::_()->getDbTable('pageroles','sespage')->toCheckUserPageRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$page->getIdentity(),'manage_promotions',$permissionName);
      break;
      case "insightreport":
        return Engine_Api::_()->getDbTable('pageroles','sespage')->toCheckUserPageRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$page->getIdentity(),'manage_insight',$permissionName);
      break;
      case "page_pageapps";
       return Engine_Api::_()->getDbTable('pageroles','sespage')->toCheckUserPageRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$page->getIdentity(),'manage_apps',$permissionName);
      break;

   }
    return 0;
  }
  public function getNextPhoto($album_id = '', $order = '') {

    $table = Engine_Api::_()->getDbTable('photos', 'sespage');
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

  public function getPreviousPhoto($album_id = '', $order = '') {

    $table = Engine_Api::_()->getDbTable('photos', 'sespage');
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

  /**
   * Gets an absolute URL to the page to view this item
   *
   * @return string
   */
  public function getHref($albumId = '', $slug = '') {

    if (is_numeric($albumId)) {
      $slug = $this->getSlug(Engine_Api::_()->getItem('sespage_album', $albumId)->getTitle());
    }

    $params = array_merge(array(
        'route' => 'sespage_specific_album',
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

  // Get album photo
  function getAlbumPhoto($albumId = '', $photoId = '', $limit = 4) {
    if ($albumId != '') {
      $albums = Engine_Api::_()->getItemTable('sespage_album');
      $albumTableName = $albums->info('name');
      $photos = Engine_Api::_()->getItemTable('sespage_photo');
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

  // Get Page like status
  public function getLikeStatusPage($page_id = '', $moduleName = '') {

    if ($moduleName == '')
      $moduleName = 'sespage_page';

    if ($page_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
      $total_likes = $coreLikeTable->select()
              ->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))
              ->where('resource_type =?', $moduleName)
              ->where('poster_id =?', $userId)
              ->where('poster_type =?', 'user')
              ->where('resource_id =?', $page_id)
              ->query()
              ->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }

  public function pagePrivacy($page = null, $privacy = null) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$page->authorization()->isAllowed($viewer, $privacy))
      return 0;
    else
      return 1;
  }

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

  public function updateNewOwnerId($params = array()) {
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->update('engine4_sespage_pages', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "page_id = ?" => $params['page_id']));
    $db->update('engine4_sespage_announcements', array('user_id' => $params['newuser_id']), array("user_id = ?" => $params['olduser_id'], "page_id = ?" => $params['page_id']));
    $db->update('engine4_sespage_favourites', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "resource_id = ?" => $params['page_id']));
    $db->update('engine4_sespage_followers', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "resource_id = ?" => $params['page_id']));
    $db->update('engine4_sespage_locationphotos', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "page_id = ?" => $params['page_id']));
    $db->update('engine4_sespage_pageroles', array('user_id' => $params['newuser_id']), array("user_id = ?" => $params['olduser_id'], "page_id = ?" => $params['page_id']));
  }

  public function getLikeStatus($page_id = '', $resource_type = '') {

    if ($page_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
      $total_likes = $coreLikeTable->select()->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))->where('resource_type =?', $resource_type)->where('poster_id =?', $userId)->where('poster_type =?', 'user')->where('resource_id =?', $page_id)->limit(1)->query()->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }

  public function getMemberByLike($pageId, $limit = null) {

    $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
    $select = $coreLikeTable->select()->from($coreLikeTable->info('name'), 'poster_id')
            ->where('resource_id =?', $pageId)
            ->where('resource_type =?', 'sespage_page');
    if ($limit) {
      $select = $select->limit($limit);
    }
    $results = $select->query()->fetchAll();
    return $results;
  }

  public function getMemberFavourite($pageId, $limit = null) {

    $favouriteTable = Engine_Api::_()->getDbTable('favourites', 'sespage');
    $select = $favouriteTable->select()->from($favouriteTable->info('name'), 'owner_id')
            ->where('resource_id =?', $pageId)
            ->where('resource_type =?', 'sespage_page');
    if ($limit)
      $select = $select->limit($limit);

    $results = $select->query()->fetchAll();
    return $results;
  }

  public function getMemberFollow($pageId, $limit = null) {

    $followTable = Engine_Api::_()->getDbTable('followers', 'sespage');
    $select = $followTable->select()->from($followTable->info('name'), 'owner_id')
            ->where('resource_id =?', $pageId)
            ->where('resource_type =?', 'sespage_page');
    if ($limit)
      $select = $select->limit($limit);

    $results = $select->query()->fetchAll();

    return $results;
  }

  function tagCloudItemCore($fetchtype = '', $page_id = '') {

    $tableTagmap = Engine_Api::_()->getDbTable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbTable('tags', 'core');
    $tableMainTagName = $tableTag->info('name');
    $selecttagged_photo = $tableTagmap->select()
            ->from($tableTagName)
            ->setIntegrityCheck(false)
            ->where('resource_type =?', 'sespage_page')
            ->where('tag_type =?', 'core_tag')
            ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id=' . $tableTagName . '.tag_id', array('text'))
            ->group($tableTagName . '.tag_id');
    if ($page_id) {
      $selecttagged_photo->where($tableTagName . '.resource_id =?', $page_id);
    }
    $selecttagged_photo->columns(array('itemCount' => ("COUNT($tableTagName.tagmap_id)")));
    if ($fetchtype == '')
      return Zend_Paginator::factory($selecttagged_photo);
    else
      return $tableTagmap->fetchAll($selecttagged_photo);
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
            ->where('`name` = ?', 'sespage.browse-search')
            ->query()
            ->fetchColumn();
    if ($params)
      return json_decode($params, true);
    else
      return 0;
  }

  public function getFieldsCount($page) {

    if(empty($page->category_id) && empty($page->subcat_id) && empty($page->subsubcat_id))
      return 0;

    $arrayProfileIds = '';
    $categoryIds = array_filter(array('0' => $page->category_id, '1' => $page->subcat_id, '2' => $page->subsubcat_id));
    $categoryTable = Engine_Api::_()->getDbTable('categories', 'sespage');
    $select = $categoryTable->select()->from($categoryTable->info('name'), 'group_concat(profile_type) as profile_type')->where('category_id IN(?)', $categoryIds);
    $arrayProfileIdsArray = $categoryTable->fetchAll($select)->toArray();
    if ($arrayProfileIdsArray[0]['profile_type'])
      $arrayProfileIds = $arrayProfileIdsArray[0]['profile_type'];
    if (!empty($arrayProfileIds)) {
      $mapsTable = Engine_Api::_()->fields()->getTable('sespage_page', 'maps');
      return $mapsTable->select()->from($mapsTable->info('name'), 'COUNT(option_id)')->where('option_id IN(?)', $arrayProfileIds)->query()->fetchColumn();
    }
    return 0;
  }

  public function getAdminnSuperAdmins() {
    $userTable = Engine_Api::_()->getDbTable('users', 'user');
    $select = $userTable->select()->from($userTable->info('name'), 'user_id')->where('level_id IN (?)', array(1,2));
    $results = $select->query()->fetchAll();
    return $results;
  }

  public function getallJoinedMembers($page) {
    $select = $page->membership()->getMembersObjectSelect();
    return Zend_Paginator::factory($select);
  }

  public function getAllPageMembers($page) {

    $userArray = array();
    //Send to all joined members
    $joinedMembers = Engine_Api::_()->sespage()->getallJoinedMembers($page);
    foreach($joinedMembers as $joinedMember) {
      if($joinedMember->user_id == $page->owner_id) continue;
      $userArray[] = $joinedMember->user_id;
    }

    //Send to all followed members
    $followerMembers = Engine_Api::_()->getDbTable('followers', 'sespage')->getFollowers($page->getIdentity());
    foreach($followerMembers as $followerMember) {
      if($followerMember->owner_id == $page->owner_id) continue;
      $userArray[] = $followerMember->owner_id;
    }

    //Send to all favourites members
    $favouritesMembers = Engine_Api::_()->getDbTable('favourites', 'sespage')->getAllFavMembers($page->getIdentity());
    foreach($favouritesMembers as $favouritesMember) {
      if($favouritesMember->owner_id == $page->owner_id) continue;
      $userArray[] = $favouritesMember->owner_id;
    }

    return array_unique($userArray);
  }

  function sendMailNotification($params = array()) {
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $viewer = Engine_Api::_()->user()->getViewer();
    $page = $params['page'];
    $usersTable = Engine_Api::_()->getDbtable('users', 'user');
    $usersSelect = $usersTable->select()
            ->where('level_id = ?', 1)
            ->where('enabled >= ?', 1);
    $superAdmins = $usersTable->fetchAll($usersSelect);
    foreach ($superAdmins as $superAdmin) {
      $adminEmails[$superAdmin->displayname] = $superAdmin->email;
    }
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($adminEmails, 'sespage_admin_approval', array('object_link' => $page->getHref(), 'host' => $_SERVER['HTTP_HOST']));
    Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($page->getOwner(), $viewer, $page, 'sespage_send_approval_page');
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($page->getOwner(), 'sespage_send_approval_page', array('page_title' => $page->getTitle(), 'object_link' => $view->url(array('action' => 'manage'), 'sespage_general', true), 'host' => $_SERVER['HTTP_HOST']));
  }

  function getPageLikeCount($pageURL = '') {
    $pageTable = Engine_Api::_()->getDbTable('pages','sespage');
    return $pageTable->select()
            ->from($pageTable->info('name'),'like_count')
            ->where('custom_url =?',$pageURL)
            ->query()
            ->fetchColumn();
  }
}
