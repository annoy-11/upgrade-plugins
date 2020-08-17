<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Slide.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_Model_Slide extends Core_Model_Item_Abstract {
  protected $_searchTriggers = false;
  public function getFilePath($item = 'thumb_icon') {
    $file = Engine_Api::_()->getItem('storage_file', $this->{$item});
    if ($file)
      return $file->map();
  }
}
