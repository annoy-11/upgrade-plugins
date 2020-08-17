<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seswishe_Widget_CategoryIconsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->allParams = $allParams = $this->_getAllParams();
    
    $this->getElement()->removeDecorator('Title');
    
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'seswishe')->getCategory(array('criteria' => $allParams['criteria'], 'countWishes' => true, 'limit' => $allParams['limit_data']));
    if (count($paginator) == 0)
      return $this->setNoRender();
  }
}