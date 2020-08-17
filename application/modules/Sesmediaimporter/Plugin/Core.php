<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmediaimporter_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function onUserLogoutAfter($event, $mode = null) {
    //empty facebook session
    if(!empty($_SESSION['sesmediaimporter_facebook']['fb_name'] )){
      unset($_SESSION['sesmediaimporter_facebook']['fb_name'] );
      unset($_SESSION['sesmediaimporter_facebook']['fb_id'] );
      unset($_SESSION['sesmediaimporter_facebook']['fbphoto_url']);
    }
    if(!empty($_SESSION['sesmediaimporter_px500']['inphoto_url'] )){
      unset($_SESSION['sesmediaimporter_px500']['inphoto_url'] );
      unset($_SESSION['sesmediaimporter_px500']['in_id'] );
      unset($_SESSION['sesmediaimporter_px500']['in_name'] );
      unset($_SESSION['sesmediaimporter_px500']['in_username'] );
      unset($_SESSION['px500_lock']);
      unset($_SESSION['px500_auth_token']);
      unset($_SESSION['px500_access_token']);
    }
    if(!empty($_SESSION['sesmediaimporter_instagram']['inphoto_url'] )){
      unset($_SESSION['sesmediaimporter_instagram']['in_id'] );
       unset($_SESSION['sesmediaimporter_instagram']['inphoto_url'] );
      unset($_SESSION['sesmediaimporter_instagram']['in_name'] );
      unset($_SESSION['sesmediaimporter_instagram']['in_username']);
    }
    if(!empty($_SESSION['sesmediaimporter_flickr']['inphoto_url'] )){
      unset($_SESSION['sesmediaimporter_flickr']['inphoto_url'] );
      unset($_SESSION['sesmediaimporter_flickr']['in_id'] );
      unset($_SESSION['sesmediaimporter_flickr']['in_name'] );
      unset($_SESSION['sesmediaimporter_flickr']['in_username'] );
      unset($_SESSION['flickr_lock']);
      unset($_SESSION['flickr_uid']);
      unset($_SESSION['phpFlickr_auth_token']);
    }
  }
}