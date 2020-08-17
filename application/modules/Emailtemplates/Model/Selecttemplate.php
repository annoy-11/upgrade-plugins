<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Selecttemplate.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Emailtemplates_Model_Selecttemplate extends Core_Model_Item_Abstract {
	protected $_parent_type = 'user';
  protected $_parent_is_owner = true;
  protected $_owner_type = 'user';
    protected $_searchTriggers = false;
}
