<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesrecipe_Widget_TagHorizantalRecipesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $countItem = $this->_getParam('itemCountPerPage', '25');
    $this->view->viewtype =  $this->_getParam('viewtype', 1);
    
    $this->view->widgetbgcolor = $this->_getParam('widgetbgcolor', '424242');
    $this->view->buttonbgcolor = $this->_getParam('buttonbgcolor', '000000');
    $this->view->textcolor = $this->_getParam('textcolor', 'ffffff');
    
    $paginator = Engine_Api::_()->sesrecipe()->tagCloudItemCore();
    $this->view->paginator = $paginator ;
    $paginator->setItemCountPerPage($countItem);
    $paginator->setCurrentPageNumber(1);			
    if( $paginator->getTotalItemCount() <= 0 ) 
    return $this->setNoRender();
  }
}
