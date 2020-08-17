<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Widget_BannerCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->bannerImage = $this->_getParam('sescrowdfunding_categorycover_photo');
    $this->view->description = $this->_getParam('description', '');
    $this->view->title = $this->_getParam('title', '');
  }

}
