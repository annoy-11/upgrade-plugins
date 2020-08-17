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

class Epetition_Widget_PetitionStatisticsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $this->view->allParams =$param= $this->_getAllParams();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('epetition_id', null);
    $epetition_id = Engine_Api::_()->getDbtable('epetitions', 'epetition')->getPetitionId($id);
    $petition=Engine_Api::_()->getItem('epetition', $epetition_id);
    $user = Engine_Api::_()->getItem('user', $petition['owner_id']);

    $totalsign=Engine_Api::_()->getDbtable('epetitions', 'epetition')->getDetailsForAjaxUpdate($epetition_id);
    if($totalsign['signpet']>=$totalsign['goal'])
    {
      $table = Engine_Api::_()->getDbtable('signatures', 'epetition');
      $data = $table->select()
        ->where('epetition_id =?', $epetition_id)
        ->order('signature_id DESC')
        ->query()
        ->fetch();
      $this->view->goalreach=$data['creation_date'];
    }
    $this->view->createdby="<a href=" . $user->getHref() . ">" . $user->getTitle() . "</a>";
    $this->view->creationdate=$petition['creation_date'];
    if($petition['victory']==1) {
      $allapproveby='';
      $table=Engine_Api::_()->getDbTable('decisionmakers', 'epetition');
       $data=$table->select()->from($table->info('name'), 'user_id')
        ->where('epetition_id=?', $epetition_id)
        ->where('letter_approve=?',1)
        ->query()
        ->fetchAll();
       foreach ($data as $userid)
       {
         $user = Engine_Api::_()->getItem('user', $userid['user_id']);
         $allapproveby.="<a href=" . $user->getHref() . ">" . $this->translate($user->getTitle()) . "</a>, ";
       }
      $this->view->approvedby = $allapproveby;
      $this->view->markedvictory = $petition['vicotry_time'];
    }
    $this->view->countpresentsign=$totalsign['signpet'];

  }

}
