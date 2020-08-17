<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestestimonial_Widget_BrowseTestimonialsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);

    $this->view->viewmore = $this->_getParam('viewmore', 0);

    $this->view->paginationType = $paginationType = $this->_getParam('paginationType', 1);

    $popularity = isset($_GET['popularity']) ? $_GET['popularity'] : (isset($params['popularity']) ? $params['popularity'] : '');

    $title = isset($_GET['title']) ? $_GET['title'] : (isset($params['title']) ? $params['title'] : '');

    if ($this->view->viewmore)
      $this->getElement()->removeDecorator('Container');

    $form = new Sestestimonial_Form_Search();

    $this->view->truncationlimit = $truncationlimit = isset($params['truncationlimit']) ? $params['truncationlimit'] : $this->_getParam('truncationlimit', 100);

    $limit = isset($params['itemCount']) ? $params['itemCount'] : $this->_getParam('limit', 10);

    $this->view->viewtype = $viewtype = isset($params['viewtype']) ? $params['viewtype'] : $this->_getParam('viewtype', 'listview');

    $this->view->all_params = $values = array('truncationlimit' => $truncationlimit, 'viewtype' => $viewtype, 'title' => $title, 'itemCount' => $limit, 'limit' => $limit);

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('testimonials', 'sestestimonial')->getTestimonials(array_merge($values, $_GET));
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    $this->view->count = $paginator->getTotalItemCount();
  }
}
