<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Pagereview.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagereview_Model_Pagereview extends Core_Model_Item_Abstract {

  protected $_searchTriggers = false;
  protected $_type = 'pagereview';

  public function getShortType($inflect = false) {
    if ($inflect)
      return 'Review';
    return 'review';
  }

  public function getHref($params = array()) {
    $params = array_merge(array('route' => 'sespagereview_view', 'reset' => true, 'slug' => $this->getSlug(), 'review_id' => $this->getIdentity()), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, $reset);
  }

  protected function _delete() {
    if ($this->_disableHooks)
      return;
    $db = Engine_Db_Table::getDefaultAdapter();
    $reviewParameterTable = Engine_Api::_()->getDbTable('parametervalues', 'sespagereview');
    $select = $reviewParameterTable->select()->where('content_id =?', $this->getIdentity());
    $parameters = $reviewParameterTable->fetchAll($select);
    if (count($parameters) > 0) {
      foreach ($parameters as $parameter) {
        $reviewParameterTable->delete(array('parametervalue_id =?' => $parameter->parametervalue_id));
      }
    }
    $reviewVoteTable = Engine_Api::_()->getDbTable('reviewvotes', 'sespagereview');
    $select = $reviewVoteTable->select()->where('review_id =?', $this->getIdentity());
    $votes = $reviewVoteTable->fetchAll($select);
    if (count($votes) > 0) {
      foreach ($votes as $vote) {
        $vote->delete(array('reviewvote_id =?' => $vote->reviewvote_id));
      }
    }
    $db->query("UPDATE `engine4_sespage_pages` SET `review_count` = '" . new Zend_Db_Expr('review_count - 1') . "' WHERE `page_id` = '" . $this->page_id . "'");
    parent::_delete();
  }

  /**
   * Gets a proxy object for the comment handler
   *
   * @return Engine_ProxyObject
   * */
  public function comments() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('comments', 'core'));
  }

  /**
   * Gets a proxy object for the like handler
   *
   * @return Engine_ProxyObject
   * */
  public function likes() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('likes', 'core'));
  }

  /**
   * Get a generic media type. Values:
   * page
   *
   * @return string
   */
  public function getMediaType() {
    return 'review';
  }

}
