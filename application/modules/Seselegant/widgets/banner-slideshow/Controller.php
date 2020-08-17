<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seselegant_Widget_BannerSlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->full_width = $this->_getParam('full_width', 1);
    $this->view->height = $this->_getParam('height', '583');
    $this->view->banner_id = $banner_id = $this->_getParam('banner_id', 0);

    if (!$banner_id)
      return $this->setNoRender();

    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('slides', 'seselegant')->getSlides($banner_id,'',true,$params);
    if (count($paginator) == 0)
      return $this->setNoRender();

	}
}
