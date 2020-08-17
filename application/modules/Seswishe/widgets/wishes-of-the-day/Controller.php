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

class Seswishe_Widget_WishesOfTheDayController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->allParams = $allParams = $this->_getAllParams();
    
    $this->view->wishes = Engine_Api::_()->getDbTable('wishes', 'seswishe')->getWishesSelect(array('limit' => $allParams['limit'], 'widget' => 'oftheday'));
    
    if(count($this->view->wishes) == 0)
      return $this->setNoRender();
  }
}
