<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesfaq_Api_Core extends Core_Api_Abstract {

  public function faqpermission($faq_id) {

    $viewer = Engine_Api::_()->user()->getViewer();
    if(empty($faq_id))
      return;

    $flag = false;
    $faq = Engine_Api::_()->getItem('sesfaq_faq', $faq_id);
    $memberlevels = unserialize($faq->memberlevels);
    if($viewer->getIdentity()) {
      if(in_array($viewer->level_id, $memberlevels)) {
        $flag = true;
      }
    }
    return $flag;
  }

  public function textTruncation($text, $textLength = null) {
    $text = strip_tags($text);
    return ( Engine_String::strlen($text) > $textLength ? Engine_String::substr($text, 0, $textLength) . '...' : $text);
  }

  function tagCloudItemCore($fetchtype = '', $faq_id = '') {

    $tableTagmap = Engine_Api::_()->getDbtable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbtable('tags', 'core');
    $tableMainTagName = $tableTag->info('name');
    $selecttagged_photo = $tableTagmap->select()
            ->from($tableTagName)
            ->setIntegrityCheck(false)
            ->where('resource_type =?', 'sesfaq_faq')
            ->where('tag_type =?', 'core_tag')
            ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id=' . $tableTagName . '.tag_id', array('text'))
            ->group($tableTagName . '.tag_id');
    if($faq_id) {
      $selecttagged_photo->where($tableTagName.'.resource_id =?', $faq_id);
    }
    $selecttagged_photo->columns(array('itemCount' => ("COUNT($tableTagName.tagmap_id)")));
    if ($fetchtype == '')
      return Zend_Paginator::factory($selecttagged_photo);
    else
      return $tableTagmap->fetchAll($selecttagged_photo);
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

  public function getRating($faq_id) {

    $table  = Engine_Api::_()->getDbTable('ratings', 'sesfaq');
    $rating_sum = $table->select()
      ->from($table->info('name'), new Zend_Db_Expr('SUM(rating)'))
      ->group('faq_id')
      ->where('faq_id = ?', $faq_id)
      ->query()
      ->fetchColumn(0);

    $total = $this->ratingCount($faq_id);
    if ($total) $rating = $rating_sum/$this->ratingCount($faq_id);
    else $rating = 0;

    return $rating;
  }

  public function getRatings($faq_id) {

    $table  = Engine_Api::_()->getDbTable('ratings', 'sesfaq');
    $rName = $table->info('name');
    $select = $table->select()
                    ->from($rName)
                    ->where($rName.'.faq_id = ?', $faq_id);
    $row = $table->fetchAll($select);
    return $row;
  }

  public function checkRated($faq_id, $user_id) {

    $table  = Engine_Api::_()->getDbTable('ratings', 'sesfaq');
    $rName = $table->info('name');
    $select = $table->select()
                 ->setIntegrityCheck(false)
                    ->where('faq_id = ?', $faq_id)
                    ->where('user_id = ?', $user_id)
                    ->limit(1);
    $row = $table->fetchAll($select);

    if (count($row)>0) return true;
    return false;
  }

  public function setRating($faq_id, $user_id, $rating) {

    $table  = Engine_Api::_()->getDbTable('ratings', 'sesfaq');
    $rName = $table->info('name');
    $select = $table->select()
                    ->from($rName)
                    ->where($rName.'.faq_id = ?', $faq_id)
                    ->where($rName.'.user_id = ?', $user_id);
    $row = $table->fetchRow($select);
    if (empty($row)) {
      // create rating
      Engine_Api::_()->getDbTable('ratings', 'sesfaq')->insert(array(
        'faq_id' => $faq_id,
        'user_id' => $user_id,
        'rating' => $rating
      ));
    }
  }

  public function ratingCount($faq_id) {

    $table  = Engine_Api::_()->getDbTable('ratings', 'sesfaq');
    $rName = $table->info('name');
    $select = $table->select()
                    ->from($rName)
                    ->where($rName.'.faq_id = ?', $faq_id);
    $row = $table->fetchAll($select);
    $total = count($row);
    return $total;
  }


  public function checkPrivacySetting($faq_id) {

    $faq = Engine_Api::_()->getItem('sesfaq_faq', $faq_id);
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();

    if (empty($faq->status))
      return false;

// 		if(empty($faq->show_page) && empty($viewerId))
// 			return false;

    if ($viewerId)
      $level_id = $viewer->level_id;
    else
      $level_id = 5;

    $memberlevels = $faq->memberlevels;
    $member_level = unserialize($memberlevels);
    if (!empty($member_level)) {
      if (!in_array($level_id, $member_level))
        return false;
    } else
      return false;


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
        $networks = unserialize($faq->networks);

        if (!empty($networks)) {
          if (!array_intersect($network_id_array, $networks))
            return false;
        } else
          return false;
      }

      $profile_table = Engine_Api::_()->fields()->getTable('user', 'values');
      $profile_select = $profile_table->select('value')->where('field_id = 1 AND item_id = ?', $viewerId);
      $profile_type_query = $profile_table->fetchRow($profile_select);
      $profile_type_id = $profile_type_query['value'];
      $profile_types = unserialize($faq->profile_types);
      if (!empty($profile_types)) {
        if (is_array($profile_types)) {
          if (!in_array($profile_type_id, $profile_types))
            return false;
        }
        else {
          if ($profile_type_id != $profile_types)
            return false;
        }
      } else
        return false;
    }
    return true;
  }


  // get item like status
  public function getLikeStatus($faq_id = '', $resource_type = '') {

    if ($faq_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbtable('likes', 'core');
      $total_likes = $coreLikeTable->select()->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))->where('resource_type =?', $resource_type)->where('poster_id =?', $userId)->where('poster_type =?', 'user')->where('resource_id =?', $faq_id)->limit(1)->query()->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }
}
