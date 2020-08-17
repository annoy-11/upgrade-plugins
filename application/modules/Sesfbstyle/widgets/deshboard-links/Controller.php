<?php



/**

 * SocialEngineSolutions

 *

 * @category   Application_Sesfbstyle

 * @package    Sesfbstyle

 * @copyright  Copyright 2017-2018 SocialEngineSolutions

 * @license    http://www.socialenginesolutions.com/license/

 * @version    $Id: Controller.php  2017-09-23 00:00:00 SocialEngineSolutions $

 * @author     SocialEngineSolutions

 */





class Sesfbstyle_Widget_DeshboardLinksController extends Engine_Content_Widget_Abstract {



  public function indexAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    $this->view->viewer_id = $viewerId = $viewer->getIdentity();

    if(empty($viewerId))

      return $this->setNoRender();

    

    $this->view->shortCount = $this->_getParam('limitdata', 2);

    

    $this->view->homelinksnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('user_home');

    $sesfbstyle_landingpage = Zend_Registry::isRegistered('sesfbstyle_landingpage') ? Zend_Registry::get('sesfbstyle_landingpage') : null;

    if(empty($sesfbstyle_landingpage)) {

      return $this->setNoRender();

    }

    $this->view->dashboardlinks = Engine_Api::_()->getDbTable('dashboardlinks', 'sesfbstyle')->getInfo(array('sublink' => 0, 'enabled' => 1));

  }



}

