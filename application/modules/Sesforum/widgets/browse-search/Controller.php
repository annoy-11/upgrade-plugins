<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesforum_Widget_BrowseSearchController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {

    $searchForm = $this->view->searchForm = new Sesforum_Form_Search();
    $request = Zend_Controller_Front::getInstance()->getRequest();
     if(isset($_GET['tag_name'])) {
        $_GET['query'] = $_GET['tag_name'];
        $_GET['search_type'] = $_GET['topics'];
     }
    $sesforum_widgets = Zend_Registry::isRegistered('sesforum_widgets') ? Zend_Registry::get('sesforum_widgets') : null;
    if(empty($sesforum_widgets))
      return $this->setNoRender();
    $searchForm
      ->setMethod('get')
      ->populate($_GET)
      ;

  }
}
