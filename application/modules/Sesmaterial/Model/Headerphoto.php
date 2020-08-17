<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Headerphoto.php 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmaterial_Model_Headerphoto extends Core_Model_Item_Abstract {
  protected $_searchTriggers = false;
  public function getFilePath($item = 'thumb_icon') {
    $file = Engine_Api::_()->getItem('storage_file', $this->{$item});
    if ($file)
      return $file->map();
  }
}
