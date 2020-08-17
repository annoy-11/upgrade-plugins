<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_Widget_ComingsoonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.comingsoonenable', 0))
      return $this->setNoRender();
    
    $this->view->showcontactbutton = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.comingsooncontactenable', 1);
    
    $this->view->showsocialshare = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.comingsoonenablesocial', 1);
    
    $this->view->comingsoonphotoID = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.comingsoonphotoID', 0);
    
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->default_activate = $settings->getSetting('seserror.comingsoonactivate', 1);
    $this->view->text1 = $settings->getSetting('seserror.comingsoontext1', "Coming Soon !");
    $this->view->text2 = $settings->getSetting('seserror.comingsoontext2', "This Page Going Overthrow Your Mind");
    $this->view->seserror_comingsoondate = $settings->getSetting('seserror.comingsoondate', "");
    $this->view->text3 = $settings->getSetting('seserror.comingsoontext3', "We Have Been Spending Long Hours In Order To Launch Our New Website. We Will Offer Freebies, A Brand New Blog And Featured Content Of Our Latest Work. Join Our Mailing List Or Follow Us On Facebook Or Twitter To Stay Up To Date.");
    
    $facebook = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.facebook', '');
    $this->view->facebook  = (preg_match("#https?://#", $facebook) === 0) ? 'http://'.$facebook : $facebook;
    $googleplus = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.googleplus','');
    $this->view->googleplus  = (preg_match("#https?://#", $googleplus) === 0) ? 'http://'.$googleplus : $googleplus;
    $twitter = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.twitter', '');
    $this->view->twitter  = (preg_match("#https?://#", $twitter) === 0) ? 'http://'.$twitter : $twitter;
    $youtube = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.youtube', '');
    $this->view->youtube  = (preg_match("#https?://#", $youtube) === 0) ? 'http://'.$youtube : $youtube;
    $linkedin = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.linkedin', '');
    $this->view->linkedin  = (preg_match("#https?://#", $linkedin) === 0) ? 'http://'.$linkedin : $linkedin;
    
//     $seserror_table = Engine_Api::_()->getDbtable('errors', 'seserror');
//     $select = $seserror_table->select()
//             ->where('`default` = ?', 1)
//             ->where('error_type = ?', 'comingsoon');
//     $this->view->ses_error_results = $seserror_table->fetchRow($select);
//     if (!$this->view->ses_error_results->default) {
//       return $this->setNoRender();
//     }
  }

}
