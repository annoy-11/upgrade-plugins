<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: List.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Model_List extends Core_Model_List
{
  protected $_owner_type = 'sesforum';

  protected $_child_type = 'user';

  public function getListItemTable()
  {
    return Engine_Api::_()->getItemTable('sesforum_list_item');
  }
}
