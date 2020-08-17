<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_Widget_BannerSlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->full_width = $this->_getParam('full_width', 1);
    $this->view->height = $this->_getParam('height', '583');
    $this->view->banner_id = $banner_id = $this->_getParam('banner_id', 0);
    $sesariana_bannerwidget = Zend_Registry::isRegistered('sesariana_bannerwidget') ? Zend_Registry::get('sesariana_bannerwidget') : null;
    if(empty($sesariana_bannerwidget)) {
      return $this->setNoRender();
    }
    if (!$banner_id)
      return $this->setNoRender();

    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('slides', 'sesariana')->getSlides($banner_id,'',true);
    if (count($paginator) == 0)
      return $this->setNoRender();

	}
}
