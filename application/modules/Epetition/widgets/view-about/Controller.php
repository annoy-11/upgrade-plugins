<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Widget_ViewAboutController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    // Check permission
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('epetition_id', null);
    $this->view->epetition_id = $epetition_id = Engine_Api::_()->getDbtable('epetitions','epetition')->getPetitionId($id);
    if (!Engine_Api::_()->core()->hasSubject())
      $epetition = Engine_Api::_()->getItem('epetition', $epetition_id);
    else
      $epetition = Engine_Api::_()->core()->getSubject();
    if(empty($epetition['petition_overview']))
    {
      if($viewer->getIdentity()==$epetition['owner_id'])
      {
        echo "For Enter <a href='".Zend_Registry::get('StaticBaseUrl')."petitions/dashboard/edit/".$epetition['custom_url']."'>click here</a>";
        return;
      }
      return $this->setNoRender();
    }
    $this->view->epetition = $epetition;

  }

}
