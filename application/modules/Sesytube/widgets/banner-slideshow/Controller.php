<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Widget_BannerSlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->full_width = $this->_getParam('full_width', 1);
    $this->view->height = $this->_getParam('height', '583');
    $this->view->banner_id = $banner_id = $this->_getParam('banner_id', 0);
    $sesytube_bannerwidget = Zend_Registry::isRegistered('sesytube_bannerwidget') ? Zend_Registry::get('sesytube_bannerwidget') : null;
    if(empty($sesytube_bannerwidget)) {
      return $this->setNoRender();
    }
    if (!$banner_id)
      return $this->setNoRender();

    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('slides', 'sesytube')->getSlides($banner_id,'',true);
    if (count($paginator) == 0)
      return $this->setNoRender();

	}
}
