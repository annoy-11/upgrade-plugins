<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Albumcomposer.php 2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Plugin_Albumcomposer extends Core_Plugin_Abstract {

  public function onAttachSesbusiness_photo($data) {

    if (!is_array($data) || empty($data['photo_id']))
      return;
    $photo = Engine_Api::_()->getItem('sesbusiness_photo', $data['photo_id']);
    if (!($photo instanceof Core_Model_Item_Abstract) || !$photo->getIdentity())
      return;
    if (!empty($data['actionBody']) && empty($photo->description)) {
      $photo->description = $data['actionBody'];
      $photo->save();
    }
    return $photo;
  }
}
