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

class Epetition_Widget_tagPetitionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->tagCloudData  = Engine_Api::_()->epetition()->tagCloudItemCore('fetchAll');
    if( count($this->view->tagCloudData) <= 0 )
    return $this->setNoRender();
  }
}
