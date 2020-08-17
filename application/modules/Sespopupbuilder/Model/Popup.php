<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespopupbuilder
 * @package    Sespopupbuilder
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Popup.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sespopupbuilder_Model_Popup extends Core_Model_Item_Abstract {
	protected $_parent_type = 'user';
  protected $_parent_is_owner = true;
  protected $_owner_type = 'user';
	
	
	protected function _delete() {
    if ($this->_disableHooks)
      return;
		$popup = $this;
		if ($popup->image) {
						$item = Engine_Api::_()->getItem('storage_file', $popup->image);
						if ($item->storage_path) {
								@unlink($item->storage_path);
								$item->remove();
						}
				}
				if ($popup->pdf_file) {
						$item = Engine_Api::_()->getItem('storage_file', $popup->pdf_file);
						if ($item->storage_path) {
								@unlink($item->storage_path);
								$item->remove();
						}
				}
				if ($popup->christmas_image1_upload) {
						$item = Engine_Api::_()->getItem('storage_file', $popup->christmas_image1_upload);
						if ($item->storage_path) {
								@unlink($item->storage_path);
								$item->remove();
						}
				}
				if ($popup->christmas_image2_upload) {
						$item = Engine_Api::_()->getItem('storage_file', $popup->christmas_image2_upload);
						if ($item->storage_path) {
								@unlink($item->storage_path);
								$item->remove();
						}
				}
				if ($popup->background_photo) {
						$item = Engine_Api::_()->getItem('storage_file', $popup->background_photo);
						if ($item->storage_path) {
								@unlink($item->storage_path);
								$item->remove();
						}
				}
				if ($popup->popup_sound_file) {
						$item = Engine_Api::_()->getItem('storage_file', $popup->popup_sound_file);
						if ($item->storage_path) {
								@unlink($item->storage_path);
								$item->remove();
						}
				}
    parent::_delete();
  }
  
}
