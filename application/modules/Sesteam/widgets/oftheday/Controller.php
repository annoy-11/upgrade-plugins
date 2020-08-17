<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_Widget_OfthedayController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->type = $this->_getParam('sesteamType', 'teammember');
    $this->view->viewMoreText = $this->_getParam('viewMoreText', 'View Details');
    $this->view->content_show = $this->_getParam('infoshow', array('displayname', 'designation', 'description', 'email', 'phone', 'website', 'location', 'facebook', 'linkdin', 'twitter', 'googleplus'));

    $this->view->results = Engine_Api::_()->getDbtable('teams', 'sesteam')->getOfTheDayResults(array('type' => $this->view->type));
    if (!$this->view->results)
      return $this->setNoRender();
  }

}