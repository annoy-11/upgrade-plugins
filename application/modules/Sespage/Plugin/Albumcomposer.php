<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Albumcomposer.php 2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Plugin_Albumcomposer extends Core_Plugin_Abstract {

  public function onAttachSespage_photo($data) {
  
    if (!is_array($data) || empty($data['photo_id']))
      return;
    $photo = Engine_Api::_()->getItem('sespage_photo', $data['photo_id']);
    if (!($photo instanceof Core_Model_Item_Abstract) || !$photo->getIdentity())
      return;
    if (!empty($data['actionBody']) && empty($photo->description)) {
      $photo->description = $data['actionBody'];
      $photo->save();
    }
    return $photo;
  }
}