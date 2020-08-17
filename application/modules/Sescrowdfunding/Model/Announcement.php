<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Announcement.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Model_Announcement extends Core_Model_Item_Abstract {

  protected $_owner_type = 'user';
  protected $_searchTriggers = false;
  public function getHref($params = array()) {
    return Zend_Controller_Front::getInstance()->getRouter()
                    ->assemble(array(), 'default', true);
  }

}
