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
class Sescrowdfunding_Widget_CategorySidebarController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
 
    $categoriesTable = Engine_Api::_()->getDbtable('categories', 'sescrowdfunding');
		$paginator = $categoriesTable->getCategory(array('paginator'=>true,'column_name'=>'*'));
   
    $this->view->storage = Engine_Api::_()->storage();
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber(1);
    if( $paginator->getTotalItemCount() <= 0 )
    return $this->setNoRender();
  }
}
