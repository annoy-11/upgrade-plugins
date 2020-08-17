<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Announcement.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Model_Announcement extends Core_Model_Item_Abstract {
  protected $_owner_type = 'user';
  public function getHref($params = array()) {
    return Zend_Controller_Front::getInstance()->getRouter()
                    ->assemble(array(), 'default', true);
  }

}
