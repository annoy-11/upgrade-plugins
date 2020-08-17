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

class Epetition_Widget_ViewLetterController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('epetition_id', null);
    $epetition_id = Engine_Api::_()->getDbtable('epetitions', 'epetition')->getPetitionId($id);
    $petition=Engine_Api::_()->getItem('epetition', $epetition_id);
    $this->view->letter=$petition['letter'];
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerid= $viewer->getIdentity();
    $decisionmaker=Engine_Api::_()->getDbtable('decisionmakers', 'epetition')
      ->select()
      ->where('epetition_id = ?', $epetition_id)
      ->where('user_id = ?', $viewerid)
      ->where('enabled = ?',1)
      ->where('letter_approve = ?',1)
      ->query()
      ->fetch();
    $goal=Engine_Api::_()->getDbtable('epetitions', 'epetition')->getDetailsForAjaxUpdate($epetition_id);
    if(count($decisionmaker)>0 && isset($decisionmaker['decisionmaker_id']) &&($goal['signpet']==$goal['goal']))
    {
      $this->view->decisionmakers=$decisionmaker['decisionmaker_id'];
    }

  }

}
