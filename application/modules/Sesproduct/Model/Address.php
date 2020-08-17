<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Address.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_Address extends Core_Model_Item_Abstract {
	protected $_searchTriggers = false;

  protected $_modifiedTriggers = false;

    public function getHref($params = array()) {
    $slug = $this->getSlug();
    $params = array_merge(array(
      'route' => 'sesproduct_entry_view',
      'reset' => true,
     // 'user_id' => $this->owner_id,
      'product_id' => $this->custom_url,
      //'slug' => $slug,
    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
      ->assemble($params, $route, $reset);
  }
 public function getTitle() {
    return $this->first_name.' '.$this->last_name;
  }
}
