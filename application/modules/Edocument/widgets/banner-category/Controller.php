<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Edocument_Widget_BannerCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->bannerImage = $this->_getParam('edocument_categorycover_photo');
    $this->view->description = $this->_getParam('description', '');
    $this->view->title = $this->_getParam('title', '');
  }
}
