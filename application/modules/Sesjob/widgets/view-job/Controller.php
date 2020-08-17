<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Widget_ViewJobController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    // Check permission
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('job_id', null);
    $this->view->job_id = $job_id = Engine_Api::_()->getDbtable('jobs', 'sesjob')->getJobId($id);
    if(!Engine_Api::_()->core()->hasSubject())
    $sesjob = Engine_Api::_()->getItem('sesjob_job', $job_id);
    else
    $sesjob = Engine_Api::_()->core()->getSubject();
    $sesjob_profilejobs = Zend_Registry::isRegistered('sesjob_profilejobs') ? Zend_Registry::get('sesjob_profilejobs') : null;
    $show_criterias = $this->_getParam('show_criteria', array('title', 'description', 'photo', 'socialShare', 'ownerOptions', 'rating', 'postComment', 'likeButton', 'favouriteButton', 'view', 'like', 'comment', 'review', 'statics','shareButton','smallShareButton'));
    if(is_array($show_criterias)){
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }

    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);

    if (empty($sesjob_profilejobs))
      return $this->setNoRender();
    // Prepare data
    $this->view->sesjob = $sesjob;
    $this->view->owner = $owner = $sesjob->getOwner();
    $this->view->viewer = $viewer;
    $viewerId = $viewer->getIdentity();

    if(!empty($viewerId)) {
        $this->view->isApplied = Engine_Api::_()->getDbTable('applications', 'sesjob')->isApplied(array('job_id' => $sesjob->getIdentity(), 'owner_id' => $viewerId));
    }

    if( !$sesjob->isOwner($viewer) ) {
      Engine_Api::_()->getDbtable('jobs', 'sesjob')->update(array(
        'view_count' => new Zend_Db_Expr('view_count + 1'),
      ), array(
        'job_id = ?' => $sesjob->getIdentity(),
      ));
    }

    // Get tags
    $this->view->sesjobTags = $sesjob->tags()->getTagMaps();

    // Get category
    if( !empty($sesjob->category_id) )
    $this->view->category = Engine_Api::_()->getDbtable('categories', 'sesjob')->find($sesjob->category_id)->current();

    //Cusotm Informaiton
    $this->view->customMetaFields = Engine_Api::_()->sesjob()->getCustomFieldMapDataJob($sesjob);


    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $style = $table->select()
      ->from($table, 'style')
      ->where('type = ?', 'user_sesjob')
      ->where('id = ?', $owner->getIdentity())
      ->limit(1)
      ->query()
      ->fetchColumn();
    if( !empty($style) ) {
      try {
        $this->view->headStyle()->appendStyle($style);
      }
      // silence any exception, exceptin in development mode
      catch (Exception $e) {
        if (APPLICATION_ENV === 'development') {
          throw $e;
        }
      }
    }
  }

}
