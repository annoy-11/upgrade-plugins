<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Address.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_Address extends Core_Model_Item_Abstract {
	protected $_searchTriggers = false;
  protected $_modifiedTriggers = false;
//   public function getHref($params = array()) {
//     $slug = $this->getSlug();
//     $params = array_merge(array(
//       'route' => 'courses_entry_view',
//       'reset' => true,
//      // 'user_id' => $this->owner_id,
//       'courses_id' => $this->custom_url,
//       //'slug' => $slug,
//     ), $params);
//     $route = $params['route'];
//     $reset = $params['reset'];
//     unset($params['route']);
//     unset($params['reset']);
//     return Zend_Controller_Front::getInstance()->getRouter()
//       ->assemble($params, $route, $reset);
//   }
 public function getTitle() {
    return $this->first_name.' '.$this->last_name;
  }
}
