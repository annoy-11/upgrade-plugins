<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Usertest.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Model_Usertest extends Core_Model_Item_Abstract
{
  // Properties
	protected $_searchTriggers = true;
  public function getHref($params = array()) {
    $slug = $this->getSlug();
    $params = array_merge(array(
      'route' => 'tests_general',
      'reset' => true,
      'action'=>'result',
      'usertest_id' => $this->usertest_id,
      'test_id' => $this->test_id,
    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
      ->assemble($params, $route, $reset);
  }
}
