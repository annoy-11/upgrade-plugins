<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvancedheader_Widget_AdCampaignController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    // Get campaign
    if( !($id = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedheader.adcampaignid','0')) ||
        !($campaign = Engine_Api::_()->getItem('core_adcampaign', $id)) ) {
      return $this->setNoRender();
    }

    // Check limits, start, and expire
    if( !$campaign->isActive() ) {
      return $this->setNoRender();
    }
    
    // Get viewer
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$campaign->isAllowedToView($viewer) ) {
      return $this->setNoRender();
    }

    // Get ad
    $table = Engine_Api::_()->getDbtable('ads', 'core');
    $select = $table->select()->where('ad_campaign = ?', $id)->order('RAND()');
    $ad =  $table->fetchRow($select);
    if( !($ad) ) {
      return $this->setNoRender();
    }
    $this->getElement()->removeDecorator('Container');
    // Okay
    $campaign->views++;
    $campaign->save();
    
    $ad->views++;
    $ad->save();

    $this->view->campaign = $campaign;
    $this->view->ad = $ad;
  }
}