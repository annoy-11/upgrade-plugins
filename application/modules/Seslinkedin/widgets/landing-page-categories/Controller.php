<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seslinkedin_Widget_LandingPageCategoriesController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->getElement()->removeDecorator('Title');
    $categoriesTable = Engine_Api::_()->getDbtable('categories', 'sesjob');
    $paginator = $categoriesTable->getCloudCategory(array('column_name'=>'*', 'limit' => $countItem));
    $this->view->heading = $this->_getParam('heading');
    $this->view->paginator = $paginator;
  }
}
