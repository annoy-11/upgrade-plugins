<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmusicapp
 * @package    Sesmusicapp
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-12-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmusicapp_Widget_CategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    if(!empty($_GET['category_id'])) {
            $this->view->category_id = $_GET['category_id'];
    } else {
        $this->view->category_id = 0;
    }
    $sesmusicapp_widget = Zend_Registry::isRegistered('sesmusicapp_widget') ? Zend_Registry::get('sesmusicapp_widget') : null;
    if(empty($sesmusicapp_widget))
      return $this->setNoRender();
    $this->view->contentType = $this->_getParam('contentType', 'album');
    $this->view->showType = $this->_getParam('showType', 'simple');
    $this->view->height = $this->_getParam('height', '115');
    $this->view->width = $this->_getParam('width', '200');
    $this->view->limit = $this->_getParam('limit', '6');
    $this->view->color = $this->_getParam('color', '#00f');
    $this->view->textHeight = $this->_getParam('text_height', '15');
    $this->view->image = $image = $this->_getParam('image', 1);
    $this->view->storage = Engine_Api::_()->storage();
    $this->view->can_show_tilte = $this->_getParam('can_show_tilte', true);
    $categoriesTable = Engine_Api::_()->getDbtable('categories', 'sesmusic');


    if ($this->view->showType == 'tagcloud' && $this->view->image == 0)
      $this->view->categories = $categoriesTable->getCategory(array('column_name' => '*', 'image' => 1, 'param' => $this->view->contentType));
    else
      $this->view->categories = $categoriesTable->getCategory(array('column_name' => '*', 'param' => $this->view->contentType));

    if (count($this->view->categories) <= 0)
      return $this->setNoRender();
  }

}
