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
class Sesmember_Widget_BrowseReviewSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Create form
    $isWidget = $this->_getParam('isWidget', 0);
    $viewOptionsArray = array('likeSPcount' => 'Most Liked', 'viewSPcount' => 'Most Viewed', 'commentSPcount' => 'Most Commented', 'mostSPrated' => 'Most Rated', 'leastSPrated' => 'Least Rated', Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.review.first111', 'useful') . 'SPcount' => 'Most ' . Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.review.first', 'Useful'), Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.review.second111', 'funny') . 'SPcount' => 'Most ' . Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.review.second', 'Funny'), Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.review.third111', 'cool') . 'SPcount' => 'Most ' . Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.review.third', 'Cool'), 'verified' => 'Verified Only', 'featured' => 'Featured Only',);
    $this->view->view_type = $view_type = isset($_POST['view_type']) ? $_POST['view_type'] : $this->_getParam('view_type', 'vertical');
    $viewOptions = $this->_getParam('view', $viewOptionsArray);
    if (count($viewOptions))
      $view = true;
    else
      $view = false;
    $this->view->subject_id = $this->_getParam('user_id', 0);
    $this->view->widgetIdentity = $this->_getParam('widgetIdentity', 0);

    $this->view->form = $formFilter = new Sesmember_Form_Review_Browse(array('reviewTitle' => $this->_getParam('review_title', 1), 'reviewSearch' => $this->_getParam('review_search', 1), 'reviewStars' => $this->_getParam('review_stars', 1), 'reviewRecommended' => $view));
    if ($formFilter) {
      if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.review.votes', '1')) {
        unset($viewOptionsArray[Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.review.first11', 'useful') . 'SPcount']);
        unset($viewOptionsArray[Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.review.second11', 'funny') . 'SPcount']);
        unset($viewOptionsArray[Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.review.third11', 'cool') . 'SPcount']);
      }
      $viewOptionsArray = array_merge(array('' => ''), $viewOptionsArray);
      $formFilter->order->setMultiOptions($viewOptionsArray);
    }
    $sesmember_reviews = Zend_Registry::isRegistered('sesmember_reviews') ? Zend_Registry::get('sesmember_reviews') : null;
    if (empty($sesmember_reviews))
      return $this->setNoRender();
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