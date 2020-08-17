<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesdiscussion_Widget_CategoryIconsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->allParams = $allParams = $this->_getAllParams();
    
    $this->getElement()->removeDecorator('Title');
    
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'sesdiscussion')->getCategory(array('criteria' => $allParams['criteria'], 'countDiscussions' => true, 'limit' => $allParams['limit_data']));
    if (count($paginator) == 0)
      return $this->setNoRender();
  }
}