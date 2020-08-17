<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Widget_tagCloudBusinessesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $countItem = $this->_getParam('itemCountPerPage', '25');
    $this->view->height =  $this->_getParam('height', '300');
    $this->view->color =  $this->_getParam('color', '#00f');
    $this->view->textHeight =  $this->_getParam('text_height', '15');
    $this->view->type =  $this->_getParam('type', 'tab');
    $paginator = Engine_Api::_()->sesbusiness()->tagCloudItemCore();
    $this->view->paginator = $paginator ;
    $paginator->setItemCountPerPage($countItem);
    $paginator->setCurrentPageNumber (1);
    if( $paginator->getTotalItemCount() <= 0 )
    return $this->setNoRender();
  }
}
