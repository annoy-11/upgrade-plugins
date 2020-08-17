<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Composer.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventmusic_Plugin_Composer extends Core_Plugin_Abstract {

  public function onAttachSeseventmusic($data) {

    if (!is_array($data) || empty($data['albumsong_id']))
      return;

    $song = Engine_Api::_()->getItem('seseventmusic_albumsong', $data['albumsong_id']);
    if (!($song instanceof Core_Model_Item_Abstract) || !$song->getIdentity())
      return;

    return $song;
  }

}