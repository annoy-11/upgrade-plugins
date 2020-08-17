<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Accordion.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Model_Accordion extends Core_Model_Item_Abstract {

  protected $_searchTriggers = false;

  public function setPhoto($photo, $accordion_id) {

    if ($photo instanceof Zend_Form_Element_File)
      $accordionIcon = $photo->getFileName();
    else if (is_array($photo) && !empty($photo['tmp_name']))
      $accordionIcon = $photo['tmp_name'];
    else if (is_string($photo) && file_exists($photo))
      $accordionIcon = $photo;
    else
      return;

    if (empty($accordionIcon))
      return;

    $mainName = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary' . '/' . basename($accordionIcon);
    $photo_params = array(
        'parent_id' => $accordion_id,
        'parent_type' => "sespagebuilder_accordion",
    );

    //Resize accordion icon
    $image = Engine_Image::factory();
    $image->open($accordionIcon);
    $image->open($accordionIcon)
            ->resample(0, 0, $image->width, $image->height, $image->width, $image->height)
            ->write($mainName)
            ->destroy();
    try {
      $photoFile = Engine_Api::_()->storage()->create($mainName, $photo_params);
    } catch (Exception $e) {
      if ($e->getCode() == Storage_Api_Storage::SPACE_LIMIT_REACHED_CODE) {
        echo $e->getMessage();
        exit();
      }
    }
    //Delete temp file.
    @unlink($mainName);
    return $photoFile;
  }

}
