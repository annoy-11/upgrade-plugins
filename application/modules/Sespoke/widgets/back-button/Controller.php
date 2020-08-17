<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespoke_Widget_BackButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewMore = $this->_getParam('viewMore', 1);

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_level_id = $viewer->level_id;
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();
    if (empty($this->view->viewer_id))
      return $this->setNoRender();

    $this->view->viewmore = $this->_getParam('viewmore', 0);
    if ($this->view->viewmore)
      $this->getElement()->removeDecorator('Container');

    if (Engine_Api::_()->core()->hasSubject()) {
      $this->view->item = $item = Engine_Api::_()->core()->getSubject();
      $this->view->type = $item->getType();
      $this->view->id = $id = $item->getIdentity();
    }

    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);
    $itemCount = isset($params['itemCount']) ? $params['itemCount'] : $this->_getParam('itemCount', 5);
    $this->view->showType = isset($params['showType']) ? $params['showType'] : $this->_getParam('showType', 0);
    $this->view->identity = isset($params['identity']) ? $params['identity'] : $this->view->identity;
    $this->view->all_params = array('identity' => $this->view->identity, 'showType' => $this->view->showType, 'itemCount' => $itemCount);

    $select = Engine_Api::_()->getDbtable('pokes', 'sespoke')->getResults(array('viewer_id' => $viewer_id, 'limit' => $itemCount, 'action' => 'backwidget'));
    $this->view->results = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage($itemCount);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    $this->view->count = $count = $paginator->getTotalItemCount();
    if (empty($count))
      return $this->setNoRender();
  }

}
