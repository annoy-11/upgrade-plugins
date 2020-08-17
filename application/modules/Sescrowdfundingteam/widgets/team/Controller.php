<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingteam
 * @package    Sescrowdfundingteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescrowdfundingteam_Widget_TeamController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('crowdfunding');
    if (!$subject) {
      return $this->setNoRender();
    }
    $this->view->deslimit = $this->_getParam('deslimit', 150);
    $this->getElement()->removeDecorator('Title');
    $this->view->height = $this->_getParam('height', 200);
    $this->view->width = $this->_getParam('width', 200);

    $this->view->center_block = $this->_getParam('center_block', 1);

    $this->view->viewMoreText = $this->_getParam('viewMoreText', 'View Details');
    $this->view->content_show = $this->_getParam('sesteam_contentshow', array('displayname', 'designation', 'description', 'email', 'phone', 'website', 'location', 'facebook', 'linkdin', 'twitter', 'googleplus'));
    $this->view->template_settings = $this->_getParam('sesteam_template', 1);

    $params = array();
    $this->view->type = $params['type'] = isset($_GET['sesteam_type']) ? $_GET['sesteam_type'] : $this->_getParam('sesteam_type', 'teammember');

    $this->view->paginator = Engine_Api::_()->getDbTable('teams', 'sescrowdfundingteam')->getTeamMemers(array('crowdfunding_id' => $subject->getIdentity(), 'widgettype' => 'widget'));
  }

}
