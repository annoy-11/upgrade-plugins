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
class Eblog_Widget_TagHorizantalBlogsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewtype = $this->_getParam('viewtype', 1);
    $this->view->widgetbgcolor = $this->_getParam('widgetbgcolor', '424242');
    $this->view->buttonbgcolor = $this->_getParam('buttonbgcolor', '000000');
    $this->view->textcolor = $this->_getParam('textcolor', 'ffffff');
    
    $this->view->paginator = $paginator = Engine_Api::_()->eblog()->tagCloudItemCore();
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', '25'));
    if( $paginator->getTotalItemCount() <= 0 ) 
      return $this->setNoRender();
  }
}
