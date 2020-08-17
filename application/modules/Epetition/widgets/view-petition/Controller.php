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

class Epetition_Widget_ViewPetitionController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    // Check permission
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id =$viewerid= $viewer->getIdentity();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('epetition_id', null);
    $this->view->epetition_id = $epetition_id = Engine_Api::_()->getDbtable('epetitions', 'epetition')->getPetitionId($id);



    if (!Engine_Api::_()->core()->hasSubject())
      $epetition = Engine_Api::_()->getItem('epetition', $epetition_id);
    else
      $epetition = Engine_Api::_()->core()->getSubject();

    $show_criterias = $this->_getParam('show_criteria', array('title', 'description', 'photo', 'socialShare', 'ownerOptions', 'rating', 'postComment', 'likeButton', 'favouriteButton', 'view', 'like', 'comment', 'signature', 'statics', 'shareButton', 'smallShareButton'));
    if (is_array($show_criterias)) {
      foreach ($show_criterias as $show_criteria)
        $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }

    $this->view->allParams = $this->_getAllParams();


    // Prepare data
    $this->view->epetition = $epetition;
    $this->view->owner = $owner = $epetition->getOwner();
    $this->view->viewer = $viewer;

    if (!$epetition->isOwner($viewer)) {
      Engine_Api::_()->getDbtable('epetitions', 'epetition')->update(array(
        'view_count' => new Zend_Db_Expr('view_count + 1'),
      ), array(
        'epetition_id = ?' => $epetition->getIdentity(),
      ));
    }


    // Get tags
    $this->view->epetitionTags = $epetition->tags()->getTagMaps();

    // Get category
    if (!empty($epetition->category_id))
      $this->view->category = Engine_Api::_()->getDbtable('categories', 'epetition')->find($epetition->category_id)->current();

    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $style = $table->select()
      ->from($table, 'style')
      ->where('type = ?', 'user_epetition')
      ->where('id = ?', $owner->getIdentity())
      ->limit(1)
      ->query()
      ->fetchColumn();
    if (!empty($style)) {
      try {
        $this->view->headStyle()->appendStyle($style);
      } // silence any exception, exceptin in development mode
      catch (Exception $e) {
        if (APPLICATION_ENV === 'development') {
          throw $e;
        }
      }
    }

  }

}
