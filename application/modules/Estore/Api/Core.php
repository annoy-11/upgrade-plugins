<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Api_Core extends Core_Api_Abstract {
  public function isValidPriceValue($number)
    {
      return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
    }
    function isValidFloatAndIntegerValue($number){
      //reference https://stackoverflow.com/questions/3941052/php-regex-valid-float-number
      return preg_match("/^(\d+|\d*\.\d+)$/",$number);
    }
    function checkIntegerValue($number){
      //reference https://stackoverflow.com/questions/3941052/php-regex-valid-float-number
      //remove decimal value
      return preg_match("/^(\d+|\d*)$/",$number);
    }
   //get supported currencies
  public function getSupportedCurrency(){
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->getSupportedCurrency();
    }else{
      return array();
    }
  }
	public function isMultiCurrencyAvailable(){
		if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->isMultiCurrencyAvailable();
    }else{
      return false;
    }
	}
  public function getCurrencySymbolValue($price, $currency = '', $change_rate = '') {
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->getCurrencySymbolValue($price,$currency,$change_rate);
    }else{
      return false;
    }
  }

  //return price with symbol and change rate param for payment history.
  public function getCurrencyPrice($price = 0, $givenSymbol = '', $change_rate = '') {
		$settings = Engine_Api::_()->getApi('settings', 'core');
    $precisionValue = $settings->getSetting('sesmultiplecurrency.precision', 2);
    $defaultParams['precision'] = $precisionValue;
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->getCurrencyPrice($price, $givenSymbol, $change_rate);
    }else{
      return Zend_Registry::get('Zend_View')->locale()->toCurrency($price, $this->getCurrentCurrency(), $defaultParams);
    }
	}
  public function getCurrentCurrency(){
		$settings = Engine_Api::_()->getApi('settings', 'core');
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->getCurrentCurrency();
    }else{
      return $settings->getSetting('payment.currency', 'USD');
    }
  }
  public function defaultCurrency(){
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->defaultCurrency();
    }else{
      $settings = Engine_Api::_()->getApi('settings', 'core');
      return $settings->getSetting('payment.currency', 'USD');
    }
  }

  public function getStoreRolePermission($store_id, $role_name, $permission_name, $canEdit = true) {

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

    return Engine_Api::_()->getDbTable('storeroles','estore')->toCheckUserStoreRole($viewer_id, $store_id, $role_name, $permission_name,$canEdit);
  }

  public function storeRolePermission($store,$action_name){
    if($action_name == "manage-storeapps")
    return 1;
   $actionName =  Engine_Api::_()->getDbTable('dashboards', 'estore')->getDashboardsItems(array('action_name'=>$action_name));
   if(!$actionName)
    return 0;

   $actionName = $actionName->manage_section_name;
   $permissionName = $actionName->permission_name;
   switch($actionName){
      case "manage_store":
       return Engine_Api::_()->getDbTable('storeroles','estore')->toCheckUserStoreRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$store->getIdentity(),'manage_dashboard',$permissionName);
      break;
      case "manage_product":
      return Engine_Api::_()->getDbTable('storeroles','estore')->toCheckUserStoreRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$store->getIdentity(),'manage_product',$permissionName);
      break;
      case "store_style":
        return Engine_Api::_()->getDbTable('storeroles','estore')->toCheckUserStoreRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$store->getIdentity(),'manage_styling',$permissionName);
      break;
      case "store_promotion":
        return Engine_Api::_()->getDbTable('storeroles','estore')->toCheckUserStoreRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$store->getIdentity(),'manage_promotions',$permissionName);
      break;
      case "insightreport":
        return Engine_Api::_()->getDbTable('storeroles','estore')->toCheckUserStoreRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$store->getIdentity(),'manage_insight',$permissionName);
      break;
      case "store_storeapps";
       return Engine_Api::_()->getDbTable('storeroles','estore')->toCheckUserStoreRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$store->getIdentity(),'manage_apps',$permissionName);
      break;

   }
    return 0;
  }
  public function getNextPhoto($album_id = '', $order = '') {

    $table = Engine_Api::_()->getDbTable('photos', 'estore');
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

    $table = Engine_Api::_()->getDbTable('photos', 'estore');
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
   * Gets an absolute URL to the store to view this item
   *
   * @return string
   */
  public function getHref($albumId = '', $slug = '') {

    if (is_numeric($albumId)) {
      $slug = $this->getSlug(Engine_Api::_()->getItem('estore_album', $albumId)->getTitle());
    }

    $params = array_merge(array(
        'route' => 'estore_specific_album',
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
      $albums = Engine_Api::_()->getItemTable('estore_album');
      $albumTableName = $albums->info('name');
      $photos = Engine_Api::_()->getItemTable('estore_photo');
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

  // Get Store like status
  public function getLikeStatusStore($store_id = '', $moduleName = '') {

    if ($moduleName == '')
      $moduleName = 'stores';

    if ($store_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
      $total_likes = $coreLikeTable->select()
              ->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))
              ->where('resource_type =?', $moduleName)
              ->where('poster_id =?', $userId)
              ->where('poster_type =?', 'user')
              ->where('resource_id =?', $store_id)
              ->query()
              ->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }

  public function storePrivacy($store = null, $privacy = null) {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$store->authorization()->isAllowed($viewer, $privacy))
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
    $db->update('engine4_estore_stores', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "store_id = ?" => $params['store_id']));
    $db->update('engine4_estore_announcements', array('user_id' => $params['newuser_id']), array("user_id = ?" => $params['olduser_id'], "store_id = ?" => $params['store_id']));
    $db->update('engine4_estore_favourites', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "resource_id = ?" => $params['store_id']));
    $db->update('engine4_estore_followers', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "resource_id = ?" => $params['store_id']));
    $db->update('engine4_estore_locationphotos', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "store_id = ?" => $params['store_id']));
    $db->update('engine4_estore_storeroles', array('user_id' => $params['newuser_id']), array("user_id = ?" => $params['olduser_id'], "store_id = ?" => $params['store_id']));
  }

  public function getLikeStatus($store_id = '', $resource_type = '') {

    if ($store_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
      $total_likes = $coreLikeTable->select()->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))->where('resource_type =?', $resource_type)->where('poster_id =?', $userId)->where('poster_type =?', 'user')->where('resource_id =?', $store_id)->limit(1)->query()->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }

  public function getMemberByLike($storeId, $limit = null) {

    $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
    $select = $coreLikeTable->select()->from($coreLikeTable->info('name'), 'poster_id')
            ->where('resource_id =?', $storeId)
            ->where('resource_type =?', 'stores');
    if ($limit) {
      $select = $select->limit($limit);
    }
    $results = $select->query()->fetchAll();
    return $results;
  }
  public function getMemberFavourite($storeId, $limit = null) {

    $favouriteTable = Engine_Api::_()->getDbTable('favourites', 'estore');
    $select = $favouriteTable->select()->from($favouriteTable->info('name'), 'owner_id')
            ->where('resource_id =?', $storeId)
            ->where('resource_type =?', 'stores');
    if ($limit)
      $select = $select->limit($limit);

    $results = $select->query()->fetchAll();
    return $results;
  }

  public function getMemberFollow($storeId, $limit = null) {

    $followTable = Engine_Api::_()->getDbTable('followers', 'estore');
    $select = $followTable->select()->from($followTable->info('name'), 'owner_id')
            ->where('resource_id =?', $storeId)
            ->where('resource_type =?', 'stores');
    if ($limit)
      $select = $select->limit($limit);

    $results = $select->query()->fetchAll();

    return $results;
  }

 public function getMemberReview($storeId, $limit = null) {

    $reviewTable = Engine_Api::_()->getDbTable('reviews', 'estore');
    $select = $reviewTable->select()->from($reviewTable->info('name'), 'owner_id')
            ->where('store_id =?', $storeId);
    if ($limit)
      $select = $select->limit($limit);

    $results = $select->query()->fetchAll();

    return $results;
  }
  function tagCloudItemCore($fetchtype = '', $store_id = '') {

    $tableTagmap = Engine_Api::_()->getDbTable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbTable('tags', 'core');
    $tableMainTagName = $tableTag->info('name');
    $selecttagged_photo = $tableTagmap->select()
            ->from($tableTagName)
            ->setIntegrityCheck(false)
            ->where('resource_type =?', 'stores')
            ->where('tag_type =?', 'core_tag')
            ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id=' . $tableTagName . '.tag_id', array('text'))
            ->group($tableTagName . '.tag_id');
    if ($store_id) {
      $selecttagged_photo->where($tableTagName . '.resource_id =?', $store_id);
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
            ->where('`name` = ?', 'estore.browse-search')
            ->query()
            ->fetchColumn();
    if ($params)
      return json_decode($params, true);
    else
      return 0;
  }

  public function getFieldsCount($store) {
    if(empty($store->category_id) && empty($store->subcat_id) && empty($store->subsubcat_id))
      return 0;
    $arrayProfileIds = '';
    $categoryIds = array_filter(array('0' => $store->category_id, '1' => $store->subcat_id, '2' => $store->subsubcat_id));
    $categoryTable = Engine_Api::_()->getDbTable('categories', 'estore');
    $select = $categoryTable->select()->from($categoryTable->info('name'), 'group_concat(profile_type) as profile_type')->where('category_id IN(?)', $categoryIds);
    $arrayProfileIdsArray = $categoryTable->fetchAll($select)->toArray();
    if ($arrayProfileIdsArray[0]['profile_type'])
      $arrayProfileIds = $arrayProfileIdsArray[0]['profile_type'];
    if (!empty($arrayProfileIds)) {
      $mapsTable = Engine_Api::_()->fields()->getTable('stores', 'maps');
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

  public function getallJoinedMembers($store) {
    $select = $store->membership()->getMembersObjectSelect();
    return Zend_Paginator::factory($select);
  }

  public function getAllStoreMembers($store) {
    $userArray = array();
    //Send to all joined members
    $joinedMembers = Engine_Api::_()->estore()->getallJoinedMembers($store);
    foreach($joinedMembers as $joinedMember) {
      if($joinedMember->user_id == $store->owner_id) continue;
      $userArray[] = $joinedMember->user_id;
    }
    //Send to all followed members
    $followerMembers = Engine_Api::_()->getDbTable('followers', 'estore')->getFollowers($store->getIdentity());
    foreach($followerMembers as $followerMember) {
      if($followerMember->owner_id == $store->owner_id) continue;
      $userArray[] = $followerMember->owner_id;
    }
    //Send to all favourites members
    $favouritesMembers = Engine_Api::_()->getDbTable('favourites', 'estore')->getAllFavMembers($store->getIdentity());
    foreach($favouritesMembers as $favouritesMember) {
      if($favouritesMember->owner_id == $store->owner_id) continue;
      $userArray[] = $favouritesMember->owner_id;
    }
    return array_unique($userArray);
  }

  function sendMailNotification($params = array()) {
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $viewer = Engine_Api::_()->user()->getViewer();
    $store = $params['store'];
    $usersTable = Engine_Api::_()->getDbtable('users', 'user');
    $usersSelect = $usersTable->select()
            ->where('level_id = ?', 1)
            ->where('enabled >= ?', 1);
    $superAdmins = $usersTable->fetchAll($usersSelect);
    foreach ($superAdmins as $superAdmin) {
      $adminEmails[$superAdmin->displayname] = $superAdmin->email;
    }
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($adminEmails, 'estore_admin_approval', array('object_link' => $store->getHref(), 'host' => $_SERVER['HTTP_HOST']));
    Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($store->getOwner(), $viewer, $store, 'estore_send_approval_store');
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($store->getOwner(), 'estore_send_approval_store', array('store_title' => $store->getTitle(), 'object_link' => $view->url(array('action' => 'manage'), 'estore_general', true), 'host' => $_SERVER['HTTP_HOST']));
  }
  public function deleteStore($store = null){
		if(!$store)
			return false;

		$owner_id = $store->owner_id;
		$store_id = $store->store_id;
		//Delete Product
		$productTable = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct');
        $productTableName = $productTable->info('name');
        $items = $select = $productTable->select()->where($productTableName.".store_id = ?", $store_id)->query()->fetchAll();
        foreach($items as $item){
            $product_id = $item->product_id;
            $sesproductAlbumTable = Engine_Api::_()->getDbtable('albums', 'sesproduct');
            $sesproductAlbumTable->delete(array(
                'product_id = ?' => $product_id,
            ));
            //Delete Photos
            $sesproductPhotosTable = Engine_Api::_()->getDbtable('photos', 'sesproduct');
            $sesproductPhotosTable->delete(array(
                'product_id = ?' => $product_id,
            ));
            //Delete Reviews
            $sesproductReviewsTable = Engine_Api::_()->getDbtable('sesproductreviews', 'sesproduct');
            $sesproductReviewsTable->delete(array(
                'product_id = ?' => $product_id,
            ));
            //Delete Roles
            $sesproductRolesTable = Engine_Api::_()->getDbtable('roles', 'sesproduct');
            $sesproductRolesTable->delete(array(
                'product_id = ?' => $product_id,
            ));
        }
		$productTable->delete(array(
			'store_id = ?' => $store_id,
		));

        //Delete Shipping Methods
		$shippingMethdodTable = Engine_Api::_()->getDbtable('shippingmethods', 'estore');
        $shippingMethdodTable->delete(array(
			'store_id = ?' => $store_id,
		));

        //Delete Reviews
		$reviewsTable = Engine_Api::_()->getDbtable('reviews', 'estore');
        $reviewsTable->delete(array(
			'store_id = ?' => $store_id,
		));

		//Delete Orders
        $productOrdersTable = Engine_Api::_()->getDbtable('orders', 'sesproduct');
        $productOrdersTableName = $productOrdersTable->info('name');
        $orders = $select = $productOrdersTable->select()->where($productOrdersTableName.".store_id = ?", $store_id)->query()->fetchAll();
        foreach($orders as $order){
            $order_id = $order->order_id;
            $orderProductTable = Engine_Api::_()->getDbtable('orderproducts', 'sesproduct');
            $orderProductTable->delete(array(
                'order_id = ?' => $order_id,
            ));
            $orderAddressTable = Engine_Api::_()->getDbtable('orderaddresses', 'sesproduct');
            $orderAddressTable->delete(array(
                'order_id = ?' => $order_id,
            ));
        }
		$productOrdersTable->delete(array(
			'store_id = ?' => $store_id,
		));
		$store->delete();
	}

}
