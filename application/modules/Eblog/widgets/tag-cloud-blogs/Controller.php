<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Eblog_Widget_tagCloudBlogsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->height =  $this->_getParam('height', '300');
    $this->view->color =  $this->_getParam('color', '#00f');
    $this->view->textHeight =  $this->_getParam('text_height', '15');
    $this->view->type =  $this->_getParam('type', 'tab');
    
    $this->view->paginator = $paginator = Engine_Api::_()->eblog()->tagCloudItemCore();
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', '25'));
    if($paginator->getTotalItemCount() <= 0) 
      return $this->setNoRender();
  }
}
