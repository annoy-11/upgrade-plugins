<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Widget_ProfileComplimentsController extends Engine_Content_Widget_Abstract {

  protected $_childCount;

  public function indexAction() {
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();


    // Prepare
    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;

    if (!$is_ajax) {
      $complements = Engine_Api::_()->getDbtable('compliments', 'sesmember')->getComplementsParameters();
      if (!Engine_Api::_()->core()->hasSubject('user') || !count($complements))
        return $this->setNoRender();
      else
        $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('user');

      $this->view->canCompliment = 1;
      if ($subject->getIdentity() == $viewer->getIdentity())
        $this->view->canCompliment = 0;
      if ($viewer->getIdentity() == 0)
        $this->view->canCompliment = 0;
    }else {
      $subject_id = $params['subject_id'];
      $this->view->subject = $subject = Engine_Api::_()->getItem('user', $subject_id);
    }
    $this->view->options = $options = isset($params['options']) ? $params['options'] : $this->_getParam('criterias', array('photo', 'username', 'location', 'friends', 'mutual', 'addfriend', 'follow', 'message', 'friendButton', 'like'));
    $limit_data = isset($params['limit_data']) ? $params['limit_data'] : $this->_getParam('limit_data', '10');
    $this->view->loadOptionData = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');
    $sesmember_profilemembers = Zend_Registry::isRegistered('sesmember_profilemembers') ? Zend_Registry::get('sesmember_profilemembers') : null;
    if (empty($sesmember_profilemembers))
      return $this->setNoRender();
    $this->view->params = array('limit_data' => $limit_data, 'options' => $options, 'subject_id' => $subject->getIdentity(), 'pagging' => $loadOptionData);
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('usercompliments', 'sesmember')->getComplementsUser(array('user_id' => $subject->getIdentity()));

    $paginator->setItemCountPerPage($limit_data);
    $this->view->page = $page;
    $paginator->setCurrentPageNumber($page);
    if ($is_ajax)
      $this->getElement()->removeDecorator('Container');

    if ($paginator->getTotalItemCount() > 0) {
      $this->_childCount = $paginator->getTotalItemCount();
    }
  }

  public function getChildCount() {
    return $this->_childCount;
  }

}