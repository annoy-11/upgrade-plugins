<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seseventspeaker_Widget_ProfileSpeakerController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $speaker_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('speaker_id');
    $this->view->event_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('event_id'); 
    if (empty($speaker_id))
      return $this->setNoRender();

    $this->view->speaker = $speaker = Engine_Api::_()->getItem('seseventspeaker_speakers', $speaker_id);
    if (!$speaker)
      return $this->setNoRender();
      
    $this->view->speakerEventCount = Engine_Api::_()->getDbtable('eventspeakers', 'seseventspeaker')->getSpeakerEventCounts(array('speaker_id' => $speaker->speaker_id));

    $this->view->infoshow = $this->_getParam('infoshow', array('displayname', 'description', 'facebook', 'twitter', 'linkdin', 'googleplus', 'detaildescription', 'likeButton', 'favouriteButton'));
    $this->view->descriptionText = $this->_getParam('descriptionText', '');
  }

}