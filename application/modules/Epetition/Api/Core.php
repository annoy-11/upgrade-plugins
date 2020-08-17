<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Epetition_Api_Core extends Core_Api_Abstract
{

  function getPetitions() {
    $userTable = Engine_Api::_()->getItemTable('user');
    $userTableName = $userTable->info('name');
    $petitionTable = Engine_Api::_()->getDbTable('epetitions', 'epetition');
    $petitionTableName = $petitionTable->info('name');
    $select = $userTable->select()
      ->from($userTable, array('COUNT(*) AS petition_count', 'user_id', 'displayname'))
      ->setIntegrityCheck(false)
      ->join($petitionTableName, $petitionTableName . '.owner_id=' . $userTableName . '.user_id')
      ->group($userTableName . '.user_id')->order('petition_count DESC');
    return Zend_Paginator::factory($select);
  }


  public function pageRolePermission($page,$action_name)
  {

    $actionName =  Engine_Api::_()->getDbTable('dashboards', 'epetition')->getDashboardsItems(array('action_name'=>$action_name));
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



  public function checkPrivacySetting($epetiton_id)
  {

    $epetition = Engine_Api::_()->getItem('epetition', $epetiton_id);
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();

    if ($viewerId)
      $level_id = $viewer->level_id;
    else
      $level_id = 5;

    $levels = $epetition->levels;
    $member_level = explode(",", $epetition->levels); //json_decode($levels);

    if (!empty($member_level) && !empty($item->levels)) {
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
        $networks = explode(",", $epetition->networks);

        if (!empty($networks)) {
          if (!array_intersect($network_id_array, $networks))
            return false;
        } else
          return true;
      }
    }
    return true;
  }

  function tagCloudItemCore($fetchtype = '', $epetition_id = '')
  {

    $tableTagmap = Engine_Api::_()->getDbtable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbtable('tags', 'core');
    $tableMainTagName = $tableTag->info('name');
    $selecttagged_photo = $tableTagmap->select()
      ->from($tableTagName)
      ->setIntegrityCheck(false)
      ->where('resource_type =?', 'epetition')
      ->where('tag_type =?', 'core_tag')
      ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id=' . $tableTagName . '.tag_id', array('text'))
      ->group($tableTagName . '.tag_id');
    if ($epetition_id) {
      $selecttagged_photo->where($tableTagName . '.resource_id =?', $epetition_id);
    }
    $selecttagged_photo->columns(array('itemCount' => ("COUNT($tableTagName.tagmap_id)")));
    if ($fetchtype == '')
      return Zend_Paginator::factory($selecttagged_photo);
    else
      return $tableTagmap->fetchAll($selecttagged_photo);
  }

  //Get Event like status
  public function getLikeStatusPetition($epetition_id = '', $moduleName = '')
  {
    if ($moduleName == '')
      $moduleName = 'epetition';
    if ($epetition_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbtable('likes', 'core');
      $total_likes = $coreLikeTable->select()
        ->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))
        ->where('resource_type =?', $moduleName)
        ->where('poster_id =?', $userId)
        ->where('poster_type =?', 'user')
        ->where('resource_id =?', $epetition_id)
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
  public function getIdentityWidget($name, $type, $corePages)
  {
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

  public function allowSignatureRating()
  {
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.allow.signature', 1))
      return true;

    return false;
  }

  public function getwidgetizePage($params = array())
  {

    $corePages = Engine_Api::_()->getDbtable('pages', 'core');
    $corePagesName = $corePages->info('name');
    $select = $corePages->select()
      ->from($corePagesName, array('*'))
      ->where('name = ?', $params['name'])
      ->limit(1);
    return $corePages->fetchRow($select);
  }

  // get item like status
  public function getLikeStatus($epetition_id = '', $resource_type = '')
  {

    if ($epetition_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbtable('likes', 'core');
      $total_likes = $coreLikeTable->select()->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))->where('resource_type =?', $resource_type)->where('poster_id =?', $userId)->where('poster_type =?', 'user')->where('resource_id =?', $epetition_id)->limit(1)->query()->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }

  public function getWidgetPageId($widgetId)
  {

    $db = Engine_Db_Table::getDefaultAdapter();
    $params = $db->select()
      ->from('engine4_core_content', 'page_id')
      ->where('`content_id` = ?', $widgetId)
      ->query()
      ->fetchColumn();
    return json_decode($params, true);
  }

  public function deletePetition($epetition = null)
  {
    if (!$epetition)
      return false;
    $epetitionId = $epetition->epetition_id;

    $owner_id = $epetition->owner_id;
    //Delete album
    $epetitionAlbumTable = Engine_Api::_()->getDbtable('albums', 'epetition');
    $epetitionAlbumTable->delete(array(
      'owner_id = ?' => $owner_id,
      'epetition_id = ?' => $epetitionId,
    ));

    //Delete Photos
    $epetitionPhotosTable = Engine_Api::_()->getDbtable('photos', 'epetition');
    $epetitionPhotosTable->delete(array(
      'user_id = ?' => $owner_id,
      'epetition_id = ?' => $epetitionId,
    ));

    //Delete Favourites
    $epetitionFavouritesTable = Engine_Api::_()->getDbtable('favourites', 'epetition');
    $epetitionFavouritesTable->delete(array(
      'user_id = ?' => $owner_id,
      'resource_id = ?' => $epetitionId,
    ));


    //Delete Roles
    $epetitionRolesTable = Engine_Api::_()->getDbtable('roles', 'epetition');
    $epetitionRolesTable->delete(array(
      'user_id = ?' => $owner_id,
      'epetition_id = ?' => $epetitionId,
    ));

    $epetition->delete();
  }

  public function getCustomFieldMapDataPetition($petition)
  {

    if ($petition) {
      return Engine_Db_Table::getDefaultAdapter()->query("SELECT GROUP_CONCAT(value) AS `valuesMeta`,IFNULL(TRIM(TRAILING ', ' FROM GROUP_CONCAT(DISTINCT(engine4_epetition_fields_options.label) SEPARATOR ', ')),engine4_epetition_fields_values.value) AS `value`, `engine4_epetition_fields_meta`.`label`, `engine4_epetition_fields_meta`.`type` FROM `engine4_epetition_fields_values` LEFT JOIN `engine4_epetition_fields_meta` ON engine4_epetition_fields_meta.field_id = engine4_epetition_fields_values.field_id LEFT JOIN `engine4_epetition_fields_options` ON engine4_epetition_fields_values.value = engine4_epetition_fields_options.option_id AND (`engine4_epetition_fields_meta`.`type` = 'multi_checkbox' || `engine4_epetition_fields_meta`.`type` = 'radio') WHERE (engine4_epetition_fields_values.item_id = " . $petition->epetition_id . ") AND (engine4_epetition_fields_values.field_id != 1) GROUP BY `engine4_epetition_fields_meta`.`field_id`,`engine4_epetition_fields_options`.`field_id`")->fetchAll();
    }
    return array();
  }

  public function isPetitionAdmin($petition = null, $privacy = null)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if ($viewer->getIdentity()) {
      if ($viewer->level_id == 1 || $viewer->level_id == 2)
        return 1;
    }
    if (!isset($petition->owner_id))
      return 0;
    $level_id = Engine_Api::_()->getItem('user', $petition->owner_id)->level_id;
    if ($privacy == 'create') {
      if ($petition->authorization()->isAllowed(null, 'video'))
        return 1;
      elseif ($this->checkPetitionAdmin($petition))
        return 1;
      else
        return 0;
    } elseif ($privacy == 'music_create') {
      if (Engine_Api::_()->authorization()->isAllowed('sesmusic_album', 'create'))
        return 1;
      elseif ($this->checkPetitionAdmin($petition))
        return 1;
      else
        return 0;
    } else {
      if (!Engine_Api::_()->authorization()->getPermission($level_id, 'epetition', $privacy))
        return 0;
      else {
        $petitionAdmin = $this->checkPetitionAdmin($petition);
        if ($petitionAdmin)
          return 1;
        else
          return 0;
      }
    }
  }

  public function getTotalSignatures($petitionId = null)
  {
    $signatureTable = Engine_Api::_()->getDbTable('signatures', 'epetition');
    return $signatureTable->select()
      ->from($signatureTable->info('name'), new Zend_Db_Expr('COUNT(signature_id)'))
      ->where('epetition_id =?', $petitionId)
      ->query()
      ->fetchColumn();
  }

  public function getTimeDifference($time)
  {
    //Let's set the current time
    $currentTime = date('Y-m-d H:i:s');
    $toTime = strtotime($currentTime);

    //And the time the notification was set
    $fromTime = strtotime($time);

    //Now calc the difference between the two
    $timeDiff = floor(abs($toTime - $fromTime) / 60);

    //Now we need find out whether or not the time difference needs to be in
    //minutes, hours, or days
    if ($timeDiff < 2) {
      $timeDiff = "Just now";
    } elseif ($timeDiff > 2 && $timeDiff < 60) {
      $timeDiff = floor(abs($timeDiff)) . " minutes ago";
    } elseif ($timeDiff > 60 && $timeDiff < 120) {
      $timeDiff = floor(abs($timeDiff / 60)) . " hour ago";
    } elseif ($timeDiff < 1440) {
      $timeDiff = floor(abs($timeDiff / 60)) . " hours ago";
    } elseif ($timeDiff > 1440 && $timeDiff < 2880) {
      $timeDiff = floor(abs($timeDiff / 1440)) . " day ago";
    } elseif ($timeDiff > 2880) {
      $timeDiff = floor(abs($timeDiff / 1440)) . " days ago";
    }

    return $timeDiff;
  }


  public function SendEmailallSignatureUser($eptition_id, $subject, $message)
  {
    $Petition = Engine_Api::_()->getItem('epetition', $eptition_id);
    $table = Engine_Api::_()->getDbtable('signatures', 'epetition');
    $data = $table->select()
      ->where('epetition_id =?', $eptition_id)
      ->query()
      ->fetchAll();
    $sender = Engine_Api::_()->getItem('user', $Petition['owner_id']);
    foreach ($data as $owner) {
      $viewer = Engine_Api::_()->getItem('user', $owner['owner_id']);
      Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer->email, 'epetition_email', array(
        'host' => $_SERVER['HTTP_HOST'],
        'subject' => $subject,
        'message' => $message,
      ));
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer, $sender, $Petition, 'epetition_signreach');
    }
  }

  public function SendEmailallSignatureDecisionmaker($eptition_id, $subject, $message)
  {
    $itemPetition = Engine_Api::_()->getItem('epetition', $this->petition_id);
    $table = Engine_Api::_()->getDbtable('decisionmakers', 'epetition');
    $data = $table->select()
      ->where('epetition_id =?', $eptition_id)
      ->query()
      ->fetchAll();
    $sender = Engine_Api::_()->getItem('user',$itemPetition['owner_id']);
    foreach ($data as $de) {
      $viewer = Engine_Api::_()->getItem('user', $de['user_id']);
      Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer->email, 'epetition_email', array(
        'host' => $_SERVER['HTTP_HOST'],
        'subject' => $subject,
        'message' => $message,
      ));
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer, $sender, $itemPetition, 'epetition_signreach');
    }
  }

  public function getAdminnSuperAdmins()
  {
    $userTable = Engine_Api::_()->getDbTable('users', 'user');
    $select = $userTable->select()->from($userTable->info('name'), 'user_id')->where('level_id IN (?)', array(1, 2));
    $results = $select->query()->fetchAll();
    return $results;
  }
}
