<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Template.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Emailtemplates_Model_Template extends Core_Model_Item_Abstract {
	protected $_parent_type = 'user';
  protected $_parent_is_owner = true;
  protected $_owner_type = 'user';
	protected $_searchTriggers = false;

	protected function _delete() {
    if ($this->_disableHooks)
      return;
		$template = $this;
		if ($template->header_logo) {
			$item = Engine_Api::_()->getItem('storage_file', $template->header_logo);
			if ($item->storage_path) {
					@unlink($item->storage_path);
					$item->remove();
			}
		}
    parent::_delete();
  }

}
