<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagereview_Widget_BrowseReviewSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Create form
    $isWidget = $this->_getParam('isWidget', 0);
    $viewOptionsArray = array('likeSPcount' => 'Most Liked', 'viewSPcount' => 'Most Viewed', 'commentSPcount' => 'Most Commented', 'mostSPrated' => 'Most Rated', 'leastSPrated' => 'Least Rated', Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.first111', 'useful') . 'SPcount' => 'Most ' . Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.first', 'Useful'), Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.second111', 'funny') . 'SPcount' => 'Most ' . Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.second', 'Funny'), Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.third111', 'cool') . 'SPcount' => 'Most ' . Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.third', 'Cool'), 'verified' => 'Verified Only', 'featured' => 'Featured Only',);
    $this->view->view_type = $view_type = isset($_POST['view_type']) ? $_POST['view_type'] : $this->_getParam('view_type', 'vertical');
    $viewOptions = $this->_getParam('view', $viewOptionsArray);
    if (count($viewOptions))
      $view = true;
    else
      $view = false;
    $this->view->subject_id = $this->_getParam('page_id', 0);
    $this->view->widgetIdentity = $this->_getParam('widgetIdentity', 0);

    $this->view->form = $formFilter = new Sespagereview_Form_Review_Browse(array('reviewTitle' => $this->_getParam('review_title', 1), 'reviewSearch' => $this->_getParam('review_search', 1), 'reviewStars' => $this->_getParam('review_stars', 1), 'reviewRecommended' => $view));
    if ($formFilter) {
      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.votes', '1')) {
        unset($viewOptionsArray[Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.first11', 'useful') . 'SPcount']);
        unset($viewOptionsArray[Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.second11', 'funny') . 'SPcount']);
        unset($viewOptionsArray[Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.review.third11', 'cool') . 'SPcount']);
      }
      $viewOptionsArray = array_merge(array('' => ''), $viewOptionsArray);
      if(isset($formFilter->order))
      $formFilter->order->setMultiOptions($viewOptionsArray);
    }
    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey => $urlParamsVal) {
      if ($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
        continue;
      $urlParams[$urlParamsKey] = $urlParamsVal;
    }
    $formFilter->populate($urlParams);
    if ($isWidget) {
      $this->getElement()->removeDecorator('Container');
      $formFilter->setAttrib('class', '');
    }
  }

}