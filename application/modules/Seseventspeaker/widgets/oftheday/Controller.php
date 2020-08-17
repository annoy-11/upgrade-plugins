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

class Seseventspeaker_Widget_OfthedayController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewMoreText = $this->_getParam('viewMoreText', 'View Details');
    $this->view->content_show = $this->_getParam('infoshow', array('displayname', 'email', 'phone', 'website', 'location', 'facebook', 'linkdin', 'twitter', 'googleplus'));

    $this->view->results = Engine_Api::_()->getDbtable('speakers', 'seseventspeaker')->getOfTheDayResults();
    if (!$this->view->results)
      return $this->setNoRender();
  }

}