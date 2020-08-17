<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinessteam_Widget_ViewbusinessTeamController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $business_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('business_id', null);
    if(empty($business_id))
      return $this->setNoRender();

    $team_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('team_id');
    if (!$team_id) {
      $user_id = Engine_Api::_()->core()->getSubject()->getIdentity();
      $team_id = Engine_Api::_()->getDbtable('teams', 'sesbusinessteam')->getTeamId(array('user_id' => $user_id));
    }

    if (empty($team_id))
      return $this->setNoRender();

    $this->view->team = $team = Engine_Api::_()->getItem('sesbusinessteam_team', $team_id);
    if (!$team)
      return $this->setNoRender();

    $this->view->infoshow = $this->_getParam('infoshow', array('displayname', 'designation', 'description', 'facebook', 'twitter', 'linkdin', 'googleplus', 'detaildescription'));
    if (!$this->view->infoshow)
      return $this->setNoRender();

    $this->view->descriptionText = $this->_getParam('descriptionText', '');
    $nonloggined = $this->_getParam('nonloggined', 1);
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (empty($nonloggined) && empty($viewer_id))
      return $this->setNoRender();
  }

}
