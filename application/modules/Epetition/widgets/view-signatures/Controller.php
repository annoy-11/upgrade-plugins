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

class Epetition_Widget_ViewSignaturesController extends Engine_Content_Widget_Abstract
{
  protected $_childCount;
  public function indexAction()
  {
    $this->view->slug = Zend_Controller_Front::getInstance()->getRequest()->getParam('epetition_id', null);
    $viewer = Engine_Api::_()->user()->getViewer();
    if (isset($_POST['params'])) {
      $params = json_decode($_POST['params'], true);
    }
    if (isset($_POST['searchParams']) && $_POST['searchParams']) {
      parse_str($_POST['searchParams'], $searchArray);
    }

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : $this->_getParam('page', 1);
    $this->view->limit = $limit = isset($_POST['limit']) ? $_POST['limit'] : $this->_getParam('limit_data', 10);

    if (!$is_ajax) {
      $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();
      $this->view->allow_create = true;

      if (!$is_ajax && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('epetitionpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetitionpackage.enable.package', 1)) {
        $package = $subject->getPackage();
        $viewAllowed = $package->getItemModule('signature');
        if (!$viewAllowed)
          return $this->setNoRender();
      }

      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.allow.signature', 1))
        return $this->setNoRender();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.allow.owner', 1))
        $allowedCreate = true;
      else {
        if ($subject->owner_id == $viewer->getIdentity())
          $allowedCreate = false;
        else
          $allowedCreate = true;
      }
      $this->view->allowedCreate = $allowedCreate;


      if (!Engine_Api::_()->core()->hasSubject('epetition')) {
        return $this->setNoRender();
      }
    $this->view->isSignature = Engine_Api::_()->getDbtable('signatures', 'epetition')->isSignature(array('epetition_id' => $subject->getIdentity()));
      //$this->view->cancreate = Engine_Api::_()->authorization()->getPermission($viewer, 'epetition_signature', 'create');
    }
    $this->view->stats = isset($params['stats']) ? $params['stats'] : $this->_getParam('stats', array('featured', 'likeCount', 'commentCount', 'viewCount', 'title', 'postedBy', 'pros', 'cons', 'description', 'creationDate', 'recommended', 'parameter', 'rating', 'likeButton', 'socialSharing'));

    $this->view->params = array('stats' => $this->view->stats, 'search_text' => $value['search_text'], 'order' => $value['order'], 'signature_stars' => $value['signature_stars'], 'signature_recommended' => $value['signature_recommended']);

    $params = array('search_text' => $value['search_text'], 'info' => str_replace('SP', '_', $value['order']), 'signature_stars' => $value['signature_stars'], 'signature_recommended' => $value['signature_recommended']);
    $this->view->epetition_id = $params['epetition_id'] = isset($_POST['epetition_id']) ? $_POST['epetition_id'] : $subject->getIdentity();
    $params['paginator'] = true;


    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('signatures', 'epetition')->getEpetitionSignatureSelect($params);

    //Set item count per page and current page number
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($page);
    if ($is_ajax)
      $this->getElement()->removeDecorator('Container');
    else {
      if (!($this->view->allowedCreate && $this->view->cancreate && $viewer->getIdentity()) && $paginator->getTotalItemCount() == 0)
        return $this->setNoRender();
    }

//    //Add count to title if configured
    if ($paginator->getTotalItemCount() > 0) {
      $this->_childCount = $paginator->getTotalItemCount();
    }

  }

  public function getChildCount()
  {
    return $this->_childCount;
  }
}


