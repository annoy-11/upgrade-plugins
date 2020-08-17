<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Announcement.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespage_Model_Announcement extends Core_Model_Item_Abstract {

  protected $_owner_type = 'user';
  protected $_searchTriggers = false;
  public function getHref($params = array()) {
    return Zend_Controller_Front::getInstance()->getRouter()
                    ->assemble(array(), 'default', true);
  }

}
