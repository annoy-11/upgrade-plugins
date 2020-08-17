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

class Epetition_Widget_ViewSignpetitionController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('epetition_id', null);
    $this->view->epetition_id = $epetition_id = Engine_Api::_()->getDbtable('epetitions', 'epetition')->getPetitionId($id);
    if (isset($epetition_id)) {
      $table = Engine_Api::_()->getDbtable('signatures', 'epetition');
      $data = $table->select()
        ->where('epetition_id = ?', $epetition_id)
        ->query()
        ->fetchAll();
      $this->view->signpet = $s = count($data); // Total completed signature for this petition
      $sign_goal = Engine_Api::_()->getItemTable('epetition', 'epetition');
      $sign_goals = $sign_goal->select()
        ->where('epetition_id =?', $epetition_id)
        ->query()
        ->fetch();
      $this->view->sign_goal = $sign_goals['signature_goal']; // Total target
      $this->view->epetition_id = $epetition_id;
      $this->view->startdate=$sign_goals['starttime'];
      $this->view->enddate=$sign_goals['endtime'];
      $this->view->victory=$sign_goals['victory'];
      $total_sign_per = 0;
      if ($s > 0 && isset($sign_goals['signature_goal']) && trim($sign_goals['signature_goal']) > 0) {
        $total_sign_per = ((count($data) * 100) / $sign_goals['signature_goal']);
      }
      $this->view->sign_per = round($total_sign_per, 2);
      $this->view->user_check = 1;
      $viewer = Engine_Api::_()->user()->getViewer();
      $viewer_id = $viewer->getIdentity();
      if (!empty($viewer_id)) {
        $table = Engine_Api::_()->getDbtable('signatures', 'epetition');
        $data = $table->select()
          ->where('epetition_id =?', $epetition_id)
          ->where('owner_id =?', $viewer_id)
          ->query()
          ->fetchAll();

        if (count($data) > 0) {
          $this->view->user_check = 0; // here we change button view
        }
      }

    }

  }

}