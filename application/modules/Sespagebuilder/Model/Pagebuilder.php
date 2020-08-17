<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Pagebuilder.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Model_Pagebuilder extends Core_Model_Item_Abstract {

  protected $_searchTriggers = array('title', 'body', 'search');
  /**
   * Gets an absolute URL to the page to view this item
   *
   * @return string
   */
  public function getHref($params = array()) {

    $params = array_merge(array(
      'route' => 'sespagebuilder_index_' . $this->getIdentity(),
      'reset' => true,
      'module' => 'sespagebuilder',
      'controller' => 'index',
      'action' => 'index',
      'pagebuilder_id' => $this->pagebuilder_id,
    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
      ->assemble($params, $route, $reset);
  }
}
