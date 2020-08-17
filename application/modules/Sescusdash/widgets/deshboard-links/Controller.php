<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescusdash
 * @package    Sescusdash
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sescusdash_Widget_DeshboardLinksController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $dashboard_id = $this->_getParam('dashboard_id', null);
    if(empty($dashboard_id))
        return $this->setNoRender();
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();
//     if(empty($viewerId))
//       return $this->setNoRender();

    $this->view->dashboardlinks = Engine_Api::_()->getDbTable('dashboardlinks', 'sescusdash')->getInfo(array('sublink' => 0, 'enabled' => 1, 'dashboard_id' => $dashboard_id));

    $finalArray = array();
    foreach( $this->view->dashboardlinks as $item ) {
      $results = Engine_Api::_()->getDbTable('dashboardlinks', 'sescusdash')->getInfo(array('sublink' => $item->dashboardlink_id, 'enabled' => 1));
      foreach($results as $result) {
        $finalArray[] = $result->getIdentity();
      }
    }

    if(count($finalArray) == 0)
      return $this->setNoRender();
  }
}
