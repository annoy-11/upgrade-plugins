<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessreview_Plugin_Menus {

  public function reviewEnable() {
    if (!Engine_Api::_()->getApi('core', 'sesbusinessreview')->allowReviewRating() || !Engine_Api::_()->sesbasic()->getViewerPrivacy('businessreview', 'view')) {
      return false;
    }
    return true;
  }
  public function onMenuInitialize_SesbusinessreviewReviewProfileEdit() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    if (!Engine_Api::_()->getApi('core', 'sesbusinessreview')->allowReviewRating())
      return false;
    if (!$viewer->getIdentity())
      return false;
    if (!$review->authorization()->isAllowed($viewer, 'edit'))
      return false;
    return array(
        'label' => $view->translate('SESBUSINESS Edit Review'),
        'class' => 'sessmoothbox sesbasic_icon_edit',
        'route' => 'sesbusinessreview_view',
        'params' => array(
            'action' => 'edit-review',
            'review_id' => $review->getIdentity(),
            'slug' => $review->getSlug(),
        )
    );
  }

  public function onMenuInitialize_SesbusinessreviewReviewProfileReport() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

    if (!(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.show.report', 1)))
      return false;

    if (!$viewer->getIdentity())
      return false;

    return array(
        'label' => $view->translate('Report'),
        'class' => 'smoothbox sesbasic_icon_report',
        'route' => 'default',
        'params' => array(
            'module' => 'core',
            'controller' => 'report',
            'action' => 'create',
            'subject' => $review->getGuid(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SesbusinessreviewReviewProfileShare() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

    if (!(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.allow.share', 1)))
      return false;

    if (!$viewer->getIdentity())
      return false;

    if (!$viewer->getIdentity())
      return false;

    return array(
        'label' => $view->translate('Share'),
        'class' => 'smoothbox sesbasic_icon_share',
        'route' => 'default',
        'params' => array(
            'module' => 'activity',
            'controller' => 'index',
            'action' => 'share',
            'type' => $review->getType(),
            'id' => $review->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

  public function onMenuInitialize_SesbusinessreviewReviewProfileDelete() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $review = Engine_Api::_()->core()->getSubject();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    if (!$viewer->getIdentity())
      return false;
    if (!$review->authorization()->isAllowed($viewer, 'delete'))
      return false;
    return array(
        'label' => $view->translate('SESBUSINESS Delete Review'),
        'class' => 'smoothbox sesbasic_icon_delete',
        'route' => 'sesbusinessreview_view',
        'params' => array(
            'action' => 'delete',
            'review_id' => $review->getIdentity(),
            'format' => 'smoothbox',
        ),
    );
  }

}
