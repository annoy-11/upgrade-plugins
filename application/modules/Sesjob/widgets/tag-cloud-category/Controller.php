<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesjob_Widget_tagCloudCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $countItem = $this->_getParam('itemCountPerPage', '25');
    $this->view->showType = $this->_getParam('showType', 'simple');
    $this->view->height =  $this->_getParam('height', '300');
    $this->view->color =  $this->_getParam('color', '#00f');
    $this->view->textHeight =  $this->_getParam('text_height', '15');
    $categoriesTable = Engine_Api::_()->getDbtable('categories', 'sesjob');
    $paginator = $categoriesTable->getCloudCategory(array('column_name'=>'*', 'limit' => $countItem));

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->paginator = $paginator;
    //$paginator->setItemCountPerPage($countItem);
    //$paginator->setCurrentPageNumber(1);
    if( count($paginator) == 0 )
    return $this->setNoRender();
  }
}
