<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinessreview_Api_Core extends Core_Api_Abstract {

  public function getWidgetParams($businessStyle = null) {
    if ($businessStyle)
      $businessName = 'sesbusiness_profile_index_' . $businessStyle;
    $db = Engine_Db_Table::getDefaultAdapter();
    $page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', $businessName)
            ->limit(1)
            ->query()
            ->fetchColumn();
    $params = $db->select()
            ->from('engine4_core_content', 'params')
            ->where('name = ?', 'sesbusinessreview.business-reviews')
            ->where('page_id = ?', $page_id)
            ->limit(1)
            ->query()
            ->fetchColumn();
    $decodedparams = json_decode($params);
    return $stats = $decodedparams->stats;
  }

  public function allowReviewRating() {
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.allow.review', 1)) {
      return 1;
    }
    return 0;
  }

  public function getLikeStatus($reviewId = '', $resource_type = '') {

    if ($reviewId != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
      $total_likes = $coreLikeTable->select()->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))->where('resource_type =?', $resource_type)->where('poster_id =?', $userId)->where('poster_type =?', 'user')->where('resource_id =?', $reviewId)->limit(1)->query()->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }

  function updateTabOnViewBusiness($businessName = '') {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();

    $page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', $businessName)
            ->limit(1)
            ->query()
            ->fetchColumn();
    $widget_id = $db->select()->where('type = ?', 'widget')
            ->from('engine4_core_content', 'content_id')
            ->where('name = ?', 'sesbusinessreview.profile-reviews')
            ->where('page_id = ?', $page_id)
            ->limit(1)
            ->query()
            ->fetchColumn();
    if ($page_id && !$widget_id) {
      $tab_id = $db->select()->where('type = ?', 'widget')
              ->from('engine4_core_content', 'content_id')
              ->where('name = ?', 'core.container-tabs')
              ->where('page_id = ?', $page_id)
              ->limit(1)
              ->query()
              ->fetchColumn();
      $order = $db->select()->where('type = ?', 'widget')
              ->from('engine4_core_content', 'order')
              ->where('parent_content_id = ?', $tab_id)
              ->limit(1)
              ->order('order DESC')
              ->query()
              ->fetchColumn();
      if ($businessName == 'sesbusiness_profile_index_1') {
        $params = '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating"],"title":"Reviews","nomobile":"0","name":"sesbusinessreview.business-reviews"}';
      } else if ($businessName == 'sesbusiness_profile_index_2') {
        $params = '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating"],"title":"Reviews","nomobile":"0","name":"sesbusinessreview.business-reviews"}';
      } else if ($businessName == 'sesbusiness_profile_index_3') {
        $params = '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating"],"title":"Reviews","nomobile":"0","name":"sesbusinessreview.business-reviews"}';
      } else if ($businessName == 'sesbusiness_profile_index_4') {
        $params = '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating"],"title":"Reviews","nomobile":"0","name":"sesbusinessreview.business-reviews"}';
      }
      $db->insert('engine4_core_content', array(
          'type' => 'widget',
          'name' => 'sesbusinessreview.business-reviews',
          'page_id' => $page_id,
          'parent_content_id' => $tab_id,
          'order' => $order++,
          'params' => $params,
      ));
    }
  }

}
