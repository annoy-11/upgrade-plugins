<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Announcement.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Model_Announcement extends Core_Model_Item_Abstract {

  protected $_owner_type = 'user';

  public function getHref($params = array()) {
    return Zend_Controller_Front::getInstance()->getRouter()
                    ->assemble(array(), 'default', true);
  }

}
