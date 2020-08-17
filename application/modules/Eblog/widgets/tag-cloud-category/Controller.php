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
class Eblog_Widget_tagCloudCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
 
    $countItem = $this->_getParam('itemCountPerPage', '25');
    $this->view->showType = $this->_getParam('showType', 'simple');
    $this->view->height =  $this->_getParam('height', '300');
    $this->view->color =  $this->_getParam('color', '#00f');
    $this->view->textHeight =  $this->_getParam('text_height', '15');
    $categoriesTable = Engine_Api::_()->getDbtable('categories', 'eblog');
		$paginator = $categoriesTable->getCloudCategory(array('paginator'=>true,'column_name'=>'*'));
   
    $this->view->storage = Engine_Api::_()->storage();
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage($countItem);
    $paginator->setCurrentPageNumber(1);
    if( $paginator->getTotalItemCount() <= 0 )
    return $this->setNoRender();
  }
}
