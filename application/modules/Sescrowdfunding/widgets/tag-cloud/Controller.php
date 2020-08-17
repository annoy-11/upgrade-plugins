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

class Sescrowdfunding_Widget_tagCloudController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $countItem = $this->_getParam('itemCountPerPage', '25');
    $this->view->height =  $this->_getParam('height', '300');
    $this->view->color =  $this->_getParam('color', '#00f');
    $this->view->textHeight =  $this->_getParam('text_height', '15');
    $this->view->type =  $this->_getParam('type', 'tab');
    $this->view->paginator = $paginator = Engine_Api::_()->sescrowdfunding()->tagCloudItemCore();
   
    if($paginator->getTotalItemCount() <= 0 ) 
      return $this->setNoRender();
  }
}
