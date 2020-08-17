<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Widget_BannerCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->bannerImage = $this->_getParam('epetition_categorycover_photo');
    $this->view->description = $this->_getParam('description', '');
    $this->view->title = $this->_getParam('title', '');
  }

}
