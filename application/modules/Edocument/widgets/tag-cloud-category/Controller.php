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
class Edocument_Widget_tagCloudCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->showType = $this->_getParam('showType', 'simple');
    $this->view->height =  $this->_getParam('height', '300');
    $this->view->color =  $this->_getParam('color', '#00f');
    $this->view->textHeight =  $this->_getParam('text_height', '15');
    $this->view->storage = Engine_Api::_()->storage();

    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('categories', 'edocument')->getCloudCategory(array('paginator'=>true, 'column_name'=>'*'));
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', '25'));
    $paginator->setCurrentPageNumber(1);

    if( $paginator->getTotalItemCount() <= 0 )
      return $this->setNoRender();
  }
}
