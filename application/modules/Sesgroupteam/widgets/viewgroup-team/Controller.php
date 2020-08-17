<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupteam
 * @package    Sesgroupteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroupteam_Widget_ViewgroupTeamController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $group_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('group_id', null);
    if(empty($group_id))
      return $this->setNoRender();

    $team_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('team_id');
    if (!$team_id) {
      $user_id = Engine_Api::_()->core()->getSubject()->getIdentity();
      $team_id = Engine_Api::_()->getDbtable('teams', 'sesgroupteam')->getTeamId(array('user_id' => $user_id));
    }

    if (empty($team_id))
      return $this->setNoRender();

    $this->view->team = $team = Engine_Api::_()->getItem('sesgroupteam_team', $team_id);
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
