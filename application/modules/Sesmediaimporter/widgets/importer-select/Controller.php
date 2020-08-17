<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmediaimporter_Widget_ImporterSelectController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $allowService = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesmediaimporter',Engine_Api::_()->user()->getViewer(), 'allow_service');
    $disableCounter = 0;
    $settings = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.facebook');
    $enable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.facebook.enable','');
    if( (empty($settings['secret']) ||
        empty($settings['appid']) ||
        empty($enable)) || !in_array('facebook',$allowService)) {
      $disableCounter++;
    }else{
      $_SESSION['sesmediaimporter_fb_enable'] = true;  
    }
    $settings['instagram_client'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.instagram.clientid','');
    $settings['instagram_secret'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.instagram.clientsecret','');
    $enable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.instagram.enable','');
    if( (empty($settings['instagram_client']) ||
        empty($settings['instagram_secret']) || !$enable) || !in_array('instagram',$allowService) ) {
      $disableCounter++;
    }else{
      $_SESSION['sesmediaimporter_int_enable'] = true;  
    }
    $settings['flickr_client'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.flickr.clientid','');
    $settings['flickr_secret'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.flickr.clientsecret','');
    $enable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.flickr.enable','');
    if( (empty($settings['flickr_client']) ||
        empty($settings['flickr_secret']) || !$enable ) || !in_array('flickr',$allowService)) {
      $disableCounter++;
    }else{
      $_SESSION['sesmediaimporter_flr_enable'] = true;  
    }
    $settings['google_client'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.google.clientid','');
    $settings['google_secret'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.google.clientsecret','');
    $enable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.google.enable','');
    if( empty($settings['google_client']) || 
        empty($settings['google_secret']) || !$enable || !in_array('google',$allowService)) {
      $disableCounter++;
    }else{
      $_SESSION['sesmediaimporter_gll_enable'] = true;  
    }
    $settings['500px_client'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.500px.consumerkey','');
    $settings['500px_secret'] = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.500px.consumersecret','');
    $enable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.500px.enable','');
    if( empty($settings['500px_client']) || 
        empty($settings['500px_secret']) || !$enable || !in_array('px500',$allowService)) {
      $disableCounter++;
    }else{
      $_SESSION['sesmediaimporter_px_enable'] = true;  
    }
    
    $enable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.zip.enable','');
    if(!$enable || !in_array('zip',$allowService)) {
      $disableCounter++;
    }else{
      $_SESSION['sesmediaimporter_zip_enable'] = true;  
    }
  }

}
