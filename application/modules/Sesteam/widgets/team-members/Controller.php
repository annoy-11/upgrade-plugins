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
class Sesteam_Widget_TeamMembersController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->blockposition = $this->_getParam('blockposition', 1);
    $this->view->viewType = $this->_getParam('viewType', 1);
    $this->view->height = $this->_getParam('height', 200);
    $this->view->width = $this->_getParam('width', 200);
    $this->view->viewMoreText = $this->_getParam('viewMoreText', 'View Details');
    $this->view->type = $type = $this->_getParam('sesteam_type', 'teammember');
    $this->view->infoshow = $this->_getParam('infoshow', array('featured', 'sponsored', 'displayname', 'designation', 'description', 'facebook', 'twitter', 'linkdin', 'googleplus', 'viewMore'));

    $nonloggined = $this->_getParam('nonloggined', 1);
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (empty($nonloggined) && empty($viewer_id))
      return $this->setNoRender();

    $this->view->paginator = Engine_Api::_()->getDbtable('teams', 'sesteam')->getTeamMemers(array('widgettype' => 'widget', 'type' => $type, 'allTeam' => $this->view->allTeam, 'designation_id' => $this->_getParam('designation_id', 0), 'limit' => $this->_getParam('limit', 3), 'popularity' => $this->_getParam('popularity', '')));

    $count = count($this->view->paginator);
    if (empty($count))
      return $this->setNoRender();
  }

}
