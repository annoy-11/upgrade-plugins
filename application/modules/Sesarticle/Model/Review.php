<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Review.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesarticle_Model_Review extends Core_Model_Item_Abstract {

  protected $_parent_type = 'sesarticle';
  protected $_searchTriggers = false;
  protected $_type = 'sesarticlereview';

  public function getParent() {
    return Engine_Api::_()->getItem('sesarticle',$this->article_id);
  }

  public function getHref($params = array()) {
    $params = array_merge(array('route' => 'sesarticlereview_view', 'reset' => true, 'slug' => $this->getSlug(), 'review_id' => $this->getIdentity()), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, $reset);
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

}
