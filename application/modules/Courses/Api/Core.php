<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Api_Core extends Core_Api_Abstract {
  function orderComplete($item,$courses = array(),$isAdmin = false){ 
    //check product variations
    $orderTableName = Engine_Api::_()->getDbTable('orders', 'courses');
    $select = $orderTableName->select();
        if(!$isAdmin)
          $select->where('order_id =?', $item->getIdentity());
        else
          $select->where('order_id =?',$item->getIdentity());
    $orders = $orderTableName->fetchRow($select);
    if(!count($courses)) {
        //get all order products
        $courseTableName = Engine_Api::_()->getDbTable('ordercourses', 'courses');
        $select = $courseTableName->select()->where('order_id =?',$item->getIdentity());
        $courses = $courseTableName->fetchAll($select);

    }
    $item->onOrderComplete();
    foreach ($courses as $course) {
          $courseOwner = Engine_Api::_()->getItem('courses',$course->course_id)->getOwner();
          $orderAmount = round($course->total, 2);
          $viewer = Engine_Api::_()->user()->getViewer();
          $commissionType = Engine_Api::_()->authorization()->getPermission($courseOwner,'courses','course_admincomn');
          $commissionTypeValue = Engine_Api::_()->authorization()->getPermission($courseOwner,'courses','course_comission');
          $orderCommissionAmount = round($course->price, 2);
          $currentCurrency = Engine_Api::_()->courses()->getCurrentCurrency();
          $defaultCurrency = Engine_Api::_()->courses()->defaultCurrency();
          $settings = Engine_Api::_()->getApi('settings', 'core');
          $currencyValue = 1;
          if($currentCurrency != $defaultCurrency){
              $currencyValue = $settings->getSetting('sesmultiplecurrency.'.$currentCurrency);
          }
          if($commissionType == 1 && $commissionTypeValue > 0){
              $course->commission_amount = round(($orderCommissionAmount/$currencyValue) * ($commissionTypeValue/100),2);
          }else if($commissionType == 0 && $commissionTypeValue > 0){
              $course->commission_amount = $commissionTypeValue;
          }
          $commissionValue = round($course->commission_amount, 2);
          if (isset($commissionValue) && $orderAmount > $commissionValue) {
              $orderAmount = $orderAmount - $commissionValue;
          } else {
              $course->commission_amount = 0;
          }
          $course->save();
          //update Courses OWNER REMAINING amount
          $tableRemaining = Engine_Api::_()->getDbtable('remainingpayments', 'courses');
          $tableName = $tableRemaining->info('name');
          $select = $tableRemaining->select()->from($tableName)->where('course_id =?', $course->course_id);
          $select = $tableRemaining->fetchAll($select);
          if (count($select)) {
              $tableRemaining->update(array('remaining_payment' => new Zend_Db_Expr("remaining_payment + $orderAmount")), array('course_id =?' => $course->course_id));
          } else {
              $tableRemaining->insert(array(
                  'remaining_payment' => $orderAmount,
                  'course_id' => $course->course_id,
              ));
          }
      }
    return true;
  }
    
  public function isValidPriceValue($number){
    return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
  }
  public function defaultCurrency(){
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->defaultCurrency();
    }else{
      $settings = Engine_Api::_()->getApi('settings', 'core');
      return $settings->getSetting('payment.currency', 'USD');
    }
  }
  public function deleteClassroom($classroom = null){
		if(!$classroom)
			return false;
    $cousesTable = Engine_Api::_()->getDbtable('courses', 'courses');
    $cousesTableName = $cousesTable->info('name');
    $items = $select = $cousesTable->select()->where($cousesTableName.".classroom_id = ?", $classroom->classroom_id)->query()->fetchAll();
    foreach($items as $item){
      $this->deleteCourse($item);
    }
    //Delete Reviews
		$reviewsTable = Engine_Api::_()->getDbtable('reviews', 'eclassroom');
    $reviewsTable->delete(array(
      'classroom_id = ?' => $classroom->classroom_id,
    ));
		$classroom->delete();
	}
  public function deleteCourse($course = null){  
		if(!$course)
			return false;
			
    //Delete Favourites
		$coursesFavouritesTable = Engine_Api::_()->getDbtable('favourites', 'courses');
		$coursesFavouritesTable->delete(array(
			'resource_id = ?' => $course->course_id,
			'resource_type = ?' => $course->getType(),
		));
		
    $cartId = Engine_Api::_()->courses()->getCartId();
    $cartCourseTable = Engine_Api::_()->getDbTable('cartcourses','courses');
    $cartCourseTable->delete(array(
			'cart_id = ?' => $cartId->getIdentity(),
			'course_id = ?' => $course->course_id,
		));
    if(isset($_SESSION['courses_cart_checkout']['cart_total_price'][$course->course_id]))
      unset($_SESSION['courses_cart_checkout']['cart_total_price'][$course->course_id]);
    //deletes wishlist
		$cousesWishlistTable = Engine_Api::_()->getDbtable('wishlists', 'courses');
		$cousesWishlistTable->delete(array(
			'course_id = ?' => $course->course_id,
		));
		
    //Delete Reviews
		$coursesReviewTable = Engine_Api::_()->getDbtable('reviews', 'courses');
		$coursesReviewTable->delete(array(
			'course_id = ?' => $course->course_id,
		));
		$course->delete();
	}
  public function deleteUserTest($test = null){
		if(!$course)
			return false;
		$course->delete();
		Zend_Db_Table_Abstract::getDefaultAdapter()->delete('engine4_courses_userquestions', array('usertest_id' => $test->usertest_id));
	}
  public function getUserPurchesedCourse($courseId = null){
      $viewer = Engine_Api::_()->user()->getViewer();
      $orderCoursesTable = Engine_Api::_()->getDbTable('ordercourses', 'courses');
      $orderTable = Engine_Api::_()->getItemTable('courses_order')->info('name');
      $orderCoursesTableName = $orderCoursesTable->info('name');
      $select = $orderCoursesTable->select()->from($orderCoursesTable->info('name'), array('order_id','course_id'))
                ->setIntegrityCheck(false)->joinLeft($orderTable, "$orderTable.order_id = $orderCoursesTableName.order_id",null)
                ->where($orderCoursesTableName.'.user_id =?', $viewer->getIdentity())
                ->where($orderTable.".state = 'complete'")
                ->group($orderCoursesTableName.'.user_id');
              if(isset($courseId)){
                $select->where($orderCoursesTableName.'.course_id =?',$courseId);
                $result = $select->query()->fetchAll();
                if(count($result) > 0 || (Engine_Api::_()->getItem('courses', $courseId)->owner_id == $viewer->getIdentity()))
                  return 1;
                else 
                  return 0;
              }
      return $select->query()->fetchAll();
  }
  public function createCourse($classroom = null){
	  $viewer = Engine_Api::_()->user()->getViewer();
     if(!$classroom)
        return false;
     if( !Engine_Api::_()->authorization()->isAllowed('courses', $viewer, 'create') )
        return false;
      return true;
  }
  public function allowAddWishlist() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity())
      $level_id = 0;
    else
      $level_id = $viewer->level_id;
    if(Engine_Api::_()->authorization()->getPermission($level_id, 'courses', 'addwishlist'))
      return 1;
    else 
      return 0; 
  }
  public function privacy($item = null, $privacy = null) {
      $viewer = Engine_Api::_()->user()->getViewer();
      if (!$item->authorization()->isAllowed($viewer, $privacy))
      return 0;
      else
      return 1;
  }
  function getCurrencyPrice($price = 0, $givenSymbol = '', $change_rate = '') {
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $precisionValue = $settings->getSetting('sesmultiplecurrency.precision', 2);
      $defaultParams['precision'] = $precisionValue;
      if (!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])) {
        return Engine_Api::_()->sesmultiplecurrency()->getCurrencyPrice($price, $givenSymbol, $change_rate);
      } else {
        $givenSymbol = $settings->getSetting('payment.currency', 'USD');
        return Zend_Registry::get('Zend_View')->locale()->toCurrency($price, $givenSymbol, $defaultParams);
      }
  }
    public function classroomRolePermission($classroom,$action_name){
        if($action_name == "manage-classroomapps")
        return 1;
        $actionName =  Engine_Api::_()->getDbTable('dashboards', 'courses')->getDashboardsItems(array('action_name'=>$action_name));
        if(!$actionName)
            return 0;

        $actionName = $actionName->manage_section_name;
        $permissionName = $actionName->permission_name;
        switch($actionName){
            case "manage_classroom":
            return Engine_Api::_()->getDbTable('classroomroles','courses')->toCheckUserClassroomRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$classroom->getIdentity(),'manage_dashboard',$permissionName);
            break;
            case "manage_course":
            return Engine_Api::_()->getDbTable('classroomroles','courses')->toCheckUserClassroomRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$classroom->getIdentity(),'manage_course',$permissionName);
            break;
            case "classroom_style":
                return Engine_Api::_()->getDbTable('classroomroles','courses')->toCheckUserClassroomRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$classroom->getIdentity(),'manage_styling',$permissionName);
            break;
            case "class_promotions":
                return Engine_Api::_()->getDbTable('classroomroles','courses')->toCheckUserClassroomRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$classroom->getIdentity(),'manage_promotions',$permissionName);
            break;
            case "insights_reports":
                return Engine_Api::_()->getDbTable('classroomroles','courses')->toCheckUserClassroomRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$classroom->getIdentity(),'manage_insight',$permissionName);
            break;
            case "manage_apps";
            return Engine_Api::_()->getDbTable('classroomroles','courses')->toCheckUserClassroomRole(Engine_Api::_()->user()->getViewer()->getIdentity(),$classroom->getIdentity(),'manage_apps',$permissionName);
            break;

        }
        return 0;
    }
    public function getClassroomRolePermission($classroom_id, $role_name, $permission_name, $canEdit = true) {
        $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        return Engine_Api::_()->getDbTable('classroomroles','classroom')->toCheckUserClassroomRole($viewer_id, $classroom_id, $role_name, $permission_name,$canEdit);
    }
    public function getCurrentCurrency(){
            $settings = Engine_Api::_()->getApi('settings', 'core');
        if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
        return Engine_Api::_()->sesmultiplecurrency()->getCurrentCurrency();
        }else{
        return $settings->getSetting('payment.currency', 'USD');
        }
    }
    public function isMultiCurrencyAvailable(){
        if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
            return Engine_Api::_()->sesmultiplecurrency()->isMultiCurrencyAvailable();
        }else{
            return false;
        }
    }
    public function getFieldsCount($item) {
        if(empty($item->category_id) && empty($item->subcat_id) && empty($item->subsubcat_id))
        return 0;
        $arrayProfileIds = '';
        $categoryIds = array_filter(array('0' => $item->category_id, '1' => $item->subcat_id, '2' => $item->subsubcat_id));
        $categoryTable = Engine_Api::_()->getDbTable('categories', 'courses');
        $select = $categoryTable->select()->from($categoryTable->info('name'), 'group_concat(profile_type) as profile_type')->where('category_id IN(?)', $categoryIds);
        $arrayProfileIdsArray = $categoryTable->fetchAll($select)->toArray();
        if ($arrayProfileIdsArray[0]['profile_type'])
        $arrayProfileIds = $arrayProfileIdsArray[0]['profile_type'];
        if (!empty($arrayProfileIds)) {
        $mapsTable = Engine_Api::_()->fields()->getTable('courses', 'maps');
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

        $favouriteTable = Engine_Api::_()->getDbTable('favourites', 'courses');
        $select = $favouriteTable->select()->from($favouriteTable->info('name'), 'owner_id')
                ->where('resource_id =?', $itemId)
                ->where('resource_type =?', $resource_type);
        if ($limit)
        $select = $select->limit($limit);
        $results = $select->query()->fetchAll();
        return $results;
    }

    public function getMemberFollow($itemId,$resource_type = 'classroom' ,$limit = null) {
        $followTable = Engine_Api::_()->getDbTable('followers', 'courses');
        $select = $followTable->select()->from($followTable->info('name'), 'owner_id')
                ->where('resource_id =?', $itemId)
                ->where('resource_type =?', $resource_type);
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
        $db->update('engine4_courses_classrooms', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "classroom_id = ?" => $params['classroom_id']));
        $db->update('engine4_courses_announcements', array('user_id' => $params['newuser_id']), array("user_id = ?" => $params['olduser_id'], "classroom_id = ?" => $params['classroom_id']));
        $db->update('engine4_courses_favourites', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "resource_id = ?" => $params['classroom_id']));
        $db->update('engine4_courses_followers', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "resource_id = ?" => $params['classroom_id']));
        $db->update('engine4_courses_locationphotos', array('owner_id' => $params['newuser_id']), array("owner_id = ?" => $params['olduser_id'], "classroom_id = ?" => $params['classroom_id']));
        $db->update('engine4_courses_classroomroles', array('user_id' => $params['newuser_id']), array("user_id = ?" => $params['olduser_id'], "classroom_id = ?" => $params['classroom_id']));
    }
    public function getNextPhoto($album_id = '', $order = '') {
        $table = Engine_Api::_()->getDbTable('photos', 'courses');
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
        $table = Engine_Api::_()->getDbTable('photos', 'courses');
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
        $albums = Engine_Api::_()->getItemTable('courses_album');
        $albumTableName = $albums->info('name');
        $photos = Engine_Api::_()->getItemTable('courses_photo');
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
        $moduleName = 'courses';
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
        $slug = $this->getSlug(Engine_Api::_()->getItem('ecourses_album', $albumId)->getTitle());
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
    public function getCustomFieldMapDataCourse($course) {
      if ($course) {
        $db = Engine_Db_Table::getDefaultAdapter();
        return $db->query("SELECT GROUP_CONCAT(value) AS `valuesMeta`,IFNULL(TRIM(TRAILING ', ' FROM GROUP_CONCAT(DISTINCT(engine4_courses_fields_options.label) SEPARATOR ', ')),engine4_courses_fields_values.value) AS `value`, `engine4_courses_fields_meta`.`label`, `engine4_courses_fields_meta`.`type` FROM `engine4_courses_fields_values` LEFT JOIN `engine4_courses_fields_meta` ON engine4_courses_fields_meta.field_id = engine4_courses_fields_values.field_id LEFT JOIN `engine4_courses_fields_options` ON engine4_courses_fields_values.value = engine4_courses_fields_options.option_id AND (`engine4_courses_fields_meta`.`type` = 'multi_checkbox' || `engine4_courses_fields_meta`.`type` = 'radio') WHERE (engine4_courses_fields_values.item_id = ".$course->course_id.") AND (engine4_courses_fields_values.field_id != 1) GROUP BY `engine4_courses_fields_meta`.`field_id`,`engine4_courses_fields_options`.`field_id`")->fetchAll();
      }
      return array();
    }
    function cartTotalPrice(){
      $cartId = Engine_Api::_()->courses()->getCartId();
      $courseTable = Engine_Api::_()->getDbTable('cartcourses','courses');
      $courseTableName = $courseTable->info('name');
      $select = $courseTable->select()->from($courseTableName,'*');
      $select->where("cart_id =?",$cartId->getIdentity());
      $cartCourses = $courseTable->fetchAll($select);
      $coursesArray = array();
      $counter = 0;
      $totalPrice = 0;
      $cartCourseIds = array();
      foreach($cartCourses as $cartCourse){
          $cartCourseIds[] = $cartCourse->course_id;
          $course = Engine_Api::_()->getItem('courses',$cartCourse->course_id);
          $priceData = Engine_Api::_()->courses()->courseDiscountPrice($course);
          @$coursesArray[$course->classroom_id]['course_id'][] = $cartCourse;
          @$coursesArray[$course->classroom_id]['total_discounted_amount'] += $priceData['discountPrice'];
          @$coursesArray[$course->classroom_id]['total_discount'] += $priceData['discount'];
          @$coursesArray[$course->classroom_id]['total_actual_amount'] += $course->price;
          @$totalPrice += $priceData['discountPrice'];
      }
      return array('cartCoursesCount'=>@count($cartCourses),'totalPrice'=>$totalPrice,'cartCourses'=>$cartCourses,'cartId'=>$cartId->getIdentity(),'cartCourseIds'=>$cartCourseIds,'coursesArray'=>$coursesArray);
    }
    function courseDiscountPrice($item){
      $viewer_discount_id =  Engine_Api::_()->user()->getViewer()->getIdentity();
      $priceDiscount = 0;
      if($item->discount == 1 && (empty($item->allowed_discount_type) || ($viewer_discount_id && $item->allowed_discount_type == 2) || ($viewer_discount_id && $item->allowed_discount_type == 1))) {
          //discount_type = 0 (percentage) else fixed
          //allowed_discount_type = 0(everyone), 1 - (public) else registered
          $startDate = strtotime($item->discount_start_date);
          if($item->discount_end_type){
              $endDate = strtotime($item->discount_end_date);
          }
          if($startDate < time() && (empty($endDate) || $endDate > time() )) {
              if ($item->discount_type == 0) {
                  $priceDiscount = round($item->price - ($item->price / 100) * $item->percentage_discount_value, 2);
              } else {
                  $priceDiscount = round($item->price - $item->fixed_discount_value, 2);
              }
              return array('discountPrice'=>$priceDiscount ,'discount'=>round($item->price-$priceDiscount,2) > 0 ? round($item->price-$priceDiscount,2) : 0);
          }
      }
      return array('discountPrice'=>$item->price ,'discount'=> 0);
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
//     public function getWidgetReviewParams($widgetId) {
//         if ($pageStyle)
//         $pageName = 'courses_profile_index';
//         $db = Engine_Db_Table::getDefaultAdapter();
//         $page_id = $db->select()
//                 ->from('engine4_core_pages', 'page_id')
//                 ->where('name = ?', $pageName)
//                 ->limit(1)
//                 ->query()
//                 ->fetchColumn();
//         $params = $db->select()
//                 ->from('engine4_core_content', 'params')
//                 ->where('name = ?', 'courses.profile-review')
//                 ->where('page_id = ?', $page_id)
//                 ->limit(1)
//                 ->query()
//                 ->fetchColumn();
//         $decodedparams = json_decode($params);
//         return $stats = $decodedparams->stats;
//     }
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
    public  function getCartId(){
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $viewer->getIdentity();
        $table = Engine_Api::_()->getDbTable('carts', 'courses');
        $select = $table->select();
        if (!$viewer_id) {
            $phpSessionId = session_id();
            $select->where('phpsessionid =?', $phpSessionId);
        } else {
            $select->where('owner_id =?', $viewer_id);
        }
        $cart =  $table->fetchRow($select);
        if(!$cart){
            $cart = $table->createRow();
            $cart->owner_id = $viewer_id;
            $cart->phpsessionid = session_id();
            $cart->save();
        }
        return $cart;
    }
    public function createLecture($course = null){
	  $viewer = Engine_Api::_()->user()->getViewer();
     if(!$course)
        return false;
     if( !Engine_Api::_()->authorization()->isAllowed('courses', $viewer, 'lec_create') )
        return false;
      return true;
    }
    public function createTest($course = null){
	  $viewer = Engine_Api::_()->user()->getViewer();
     if(!$course)
        return false;
     if(!Engine_Api::_()->authorization()->isAllowed('courses', $viewer, 'test_create') )
        return false;
      return true;
    }
    public  function checkAddToCompare($course){
      $courses = !empty($_SESSION['courses_add_to_compare']) ? $_SESSION['courses_add_to_compare'] : false;
      if($courses){
        if(isset($courses[$course["category_id"]])){
            $catgeory = $courses[$course["category_id"]];
            if(!empty($courses[$course["category_id"]][$course["course_id"]])){
                return 1;
            }
        }
      }
      return 0;
    }
    function compareData($course){
        $array["course_id"] = $course["course_id"];
        $array["category_id"] = $course["category_id"];
        $category = Engine_Api::_()->getItem('courses_category',$course->category_id);
        if($category)
            $category_title = $category->category_name;
        else
            $category_title = "Untitled";

        $array["image"] = $course->getPhotoUrl();

        $array["category_title"] = $category_title;
        return json_encode($array);
    }
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
    function tagCloudItemCore($fetchtype = '', $course_id = '',$limit = null) {
        $tableTagmap = Engine_Api::_()->getDbtable('tagMaps', 'core');
        $tableTagName = $tableTagmap->info('name');
        $tableTag = Engine_Api::_()->getDbtable('tags', 'core');
        $tableMainTagName = $tableTag->info('name');
        $selecttagged_photo = $tableTagmap->select()
                ->from($tableTagName)
                ->setIntegrityCheck(false)
                ->where('resource_type =?', 'courses')
                ->where('tag_type =?', 'core_tag')
                ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id=' . $tableTagName . '.tag_id', array('text'))
                ->group($tableTagName . '.tag_id');
        if($course_id) {
          $selecttagged_photo->where($tableTagName.'.resource_id =?', $course_id);
        }
        $selecttagged_photo->columns(array('itemCount' => ("COUNT($tableTagName.tagmap_id)")));
        if(isset($limit) && $limit >0)
          $selecttagged_photo->limit($limit);
        if ($fetchtype == '')
          return Zend_Paginator::factory($selecttagged_photo);
        else
          return $tableTagmap->fetchAll($selecttagged_photo);
    }
    public function isCourseAdmin($course = null, $privacy = null) {
	  $viewer = Engine_Api::_()->user()->getViewer();
	  $viewer->getIdentity();
	  if($viewer->getIdentity()) {
      if($viewer->level_id == 1 || $viewer->level_id == 2)
      return 1;
	  } 
	  if(!isset($course->owner_id))
      return 0;
	  $level_id = Engine_Api::_()->getItem('user', $course->owner_id)->level_id; 
	  if($privacy == 'create') {
	   if($course->authorization()->isAllowed(null, 'create'))
      return 1;
	   elseif($this->checkCourseAdmin($course))
      return 1;
	   else
      return 0;
	  } else {
			if(!Engine_Api::_()->authorization()->getPermission($level_id, 'courses', $privacy))
        return 0;
			else {
				$courseAdmin = $this->checkCourseAdmin($course);
				if($courseAdmin)
          return 1;
				else
          return 0;
			}
	  }
	}
  public function checkCourseAdmin($course = null) {
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $coursesTable = Engine_Api::_()->getDbTable('courses', 'courses');
    return $coursesTable->select()->from($coursesTable->info('name'), 'course_id')
	                    ->where('course_id = ?', is_object($course) ? $course->course_id : $course)
	                    ->where('owner_id =?', $viewerId)
	                    ->query()
	                    ->fetchColumn();
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
  public function getWidgetPageId($widgetId) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $params = $db->select()
              ->from('engine4_core_content', 'page_id')
              ->where('`content_id` = ?', $widgetId)
              ->query()
              ->fetchColumn();
      return json_decode($params, true);
  }
  public function getQuestionType($question) {
      if($question->answer_type == 2 || $question->answer_type == 1):
        return Engine_Api::_()->getDbTable('testanswers', 'courses')->addMoreAnswers($question->testquestion_id);
      elseif($question->answer_type == 3):
          return 0;
      else:
          return 1;
      endif;
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
            ->where('`name` = ?', 'courses.browse-search')
            ->query()
            ->fetchColumn();
    if ($params)
        return json_decode($params, true);
    else
        return 0;
  }
  public function getUserTest() {
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $db = Engine_Db_Table::getDefaultAdapter();
    return $db->select()
            ->from('engine4_courses_usertests', array('MAX(usertest_id)','*'))
            ->where('`user_id` = ?', $viewerId)
            ->query()
            ->fetchAll();
  }
  public function getIsUserTestDetails($params = array()) {
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $db = Engine_Db_Table::getDefaultAdapter();
    if($params['is_passed'] && $params['usertest_id']){
      $settings = Engine_Api::_()->getApi('settings', 'core'); 
      $passPercentage = is_numeric($settings->getSetting('courses.ptest.pass', 1)) ? $settings->getSetting('courses.ptest.pass', 1) : 1;
      $totalquestion = $db->select()
          ->from('engine4_courses_userquestions', array('COUNT(usertest_id)'))
          ->where('`usertest_id` = ?', $params['usertest_id'])
          ->where('`is_attempt` = ?', 1)
          ->query()
          ->fetchColumn();
      $courrectAnswer =  $db->select()
          ->from('engine4_courses_userquestions', array('COUNT(usertest_id)'))
          ->where('`usertest_id` = ?', $params['usertest_id'])
          ->where('`is_true` = ?', 1)
          ->query()
          ->fetchColumn();
      return (($courrectAnswer/$totalquestion)*100) > $passPercentage ? 1 : 0 ;
    }elseif($params['currect_answer']) {
      return  $courrectAnswer =  $db->select()
          ->from('engine4_courses_userquestions', array('COUNT(usertest_id) as currectAnswer'))
          ->where('`usertest_id` = ?', $params['usertest_id'])
          ->where('`is_true` = ?', 1)
          ->query()
          ->fetchColumn();
    }elseif($params['is_attempt']) {
      return $db->select()
          ->from('engine4_courses_userquestions', array('COUNT(usertest_id) as currectAnswer'))
          ->where('`usertest_id` = ?', $params['usertest_id'])
          ->where('`is_attempt` = ?', 1)
          ->query()
          ->fetchColumn();
    }
            
  }
  public function allowReviewRating() {
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.review', 1)) {
      return 1;
    }
    return 0;
  } 
  public function allowToAddWishlist() {
    if (!$viewer->getIdentity())
      $level_id = 0;
    else
      $level_id = $viewer->level_id;
    $viewer = Engine_Api::_()->user()->getViewer();
    return Engine_Api::_()->authorization()->getPermission($level_id, 'courses', 'addwishlist');
  }
  public function getAdminnSuperAdmins() {
    $userTable = Engine_Api::_()->getDbTable('users', 'user');
    $select = $userTable->select()->from($userTable->info('name'), 'user_id')->where('level_id IN (?)', array(1,2));
    $results = $select->query()->fetchAll();
    return $results;
  }
  public function dateFormat($date = null,$changetimezone = '',$object = '',$formate = 'M d, Y h:m A') {
		if($changetimezone != '' && $date){
			$date = strtotime($date);
			$oldTz = date_default_timezone_get();
			date_default_timezone_set($object->timezone);
			if($formate == '')
				$dateChange = date('Y-m-d h:i:s',$date);
			else{
				$dateChange = date('M d, Y h:i A',$date);
			}
			date_default_timezone_set($oldTz);
			return $dateChange.' ('.$object->timezone.')';
		}
    if($date){
      return date('M d, Y h:i A', strtotime($date));
    }
  }
  function checkPaymentGatewayEnable(){
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $paymentMethods = array();
      $noPaymentGatewayEnableByAdmin = false;
      //payment to site admin
      $enbledpaymentMethods = array_flip($settings->getSetting('courses.payment.siteadmin',array('paypal','stripe')));
      $table = Engine_Api::_()->getDbTable('gateways','payment');
      $select = $table->select()->where('plugin =?','Payment_Plugin_Gateway_PayPal')->where('enabled =?',1);
      $paypal = $table->fetchRow($select);
      $select = $table->select()->where('plugin =?','Sesadvpmnt_Plugin_Gateway_Stripe')->where('enabled =?',1);
      $stripe = $table->fetchRow($select);

      $select = $table->select()->where('plugin =?','Epaytm_Plugin_Gateway_Paytm')->where('enabled =?',1);
      $paytm = $table->fetchRow($select);
      $givenSymbol = Engine_Api::_()->courses()->getCurrentCurrency();
      if($paypal && isset($enbledpaymentMethods['paypal'])){
          $paymentMethods['paypal'] = 'paypal';
      }
      if($stripe && isset($enbledpaymentMethods['stripe'])){
            $gatewayObject = $stripe->getGateway();
            $stripeSupportedCurrencies = $gatewayObject->getSupportedCurrencies();
            if(in_array($givenSymbol,$stripeSupportedCurrencies))
              $paymentMethods['stripe'] = 'stripe';
      }
      if($paytm){ 
          $gatewayObject = $paytm->getGateway();
          $paytmSupportedCurrencies = $gatewayObject->getSupportedCurrencies();
          if(in_array($givenSymbol,$paytmSupportedCurrencies))
            $paymentMethods['paytm'] = 'paytm';
      }
      if(!count($paymentMethods)){
          $noPaymentGatewayEnableByAdmin = true;
      }
      return array('methods'=>$paymentMethods,'noPaymentGatewayEnableByAdmin'=>$noPaymentGatewayEnableByAdmin,'paypal'=>$paypal);
  }
  public function getCourseRolePermission($course_id, $role_name, $permission_name, $canEdit = true) {
      $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
      return Engine_Api::_()->getDbTable('courseroles','courses')->toCheckUserCourseRole($viewer_id, $course_id, $role_name, $permission_name,$canEdit);
  }
   // create date range from 2 given dates.
  public function createDateRangeArray($strDateFrom = '', $strDateTo = '', $interval) {
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.
    $aryRange = array();
    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
    if ($iDateTo >= $iDateFrom) {
      if ($interval == 'monthly') {
        array_push($aryRange, date('Y-m', $iDateFrom));
        $iDateFrom = strtotime('+1 Months', $iDateFrom);
        while ($iDateFrom < $iDateTo) {
          array_push($aryRange, date('Y-m', $iDateFrom));
          $iDateFrom += strtotime('+1 Months', $iDateFrom);
        }
      } elseif ($interval == 'weekly') {
        array_push($aryRange, date('Y-m-d', strtotime("last Sunday", $iDateFrom)));
        $iDateFrom = strtotime('+1 Weeks', $iDateFrom);
        while ($iDateFrom < $iDateTo) {
          array_push($aryRange, date('Y-m-d', strtotime("last Sunday", $iDateFrom)));
          $iDateFrom = strtotime('+1 Weeks', $iDateFrom);
        }
      } elseif ($interval == 'daily') {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
          $iDateFrom += 86400; // add 24 hours
          array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
      } elseif ($interval == 'hourly') {
        $iDateFrom = strtotime(date('Y-m-d 00:00:00'));
        $iDateTo = strtotime('+1 Day', $iDateFrom);

        array_push($aryRange, date('Y-m-d H', $iDateFrom));
        $iDateFrom = strtotime('+1 Hours', ($iDateFrom));

        while ($iDateFrom < $iDateTo) {
          array_push($aryRange, date('Y-m-d H', $iDateFrom));
          $iDateFrom = strtotime('+1 Hours', ($iDateFrom));
        }
      }
    }
    $preserve = $aryRange;
    return $preserve;
  }
}
