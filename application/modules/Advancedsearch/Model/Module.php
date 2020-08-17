<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Module.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Advancedsearch_Model_Module extends Core_Model_Item_Abstract
{
  protected $_searchTriggers = false;
  protected $_modifiedTriggers = false;

  function getPhotoUrl($type = null)
  {
    if(!$this->file_id)
        return "application/modules/Advancedsearch/externals/images/search.png";
    $storage = Engine_Api::_()->getItem('storage_file',$this->file_id);
    if($storage)
        return $storage->map();
    return "application/modules/Advancedsearch/externals/images/search.png";
  }
}