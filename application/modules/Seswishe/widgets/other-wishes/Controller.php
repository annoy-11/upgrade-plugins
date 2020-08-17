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

class Seswishe_Widget_OtherWishesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    if (Engine_Api::_()->core()->hasSubject('seswishe_wishe'))
      $item = Engine_Api::_()->core()->getSubject('seswishe_wishe');
    if (!$item)
      return $this->setNoRender();
    $this->view->allParams = $allParams = $this->_getAllParams();
    $this->view->wishes = Engine_Api::_()->getDbTable('wishes', 'seswishe')->getWishesSelect(array('orderby' => $allParams['popularity'], 'limit' => $allParams['limit'], 'widget' => 1, 'wishe_id' => $item->wishe_id, 'owner_id' => $item->owner_id));
    if(count($this->view->wishes) == 0)
      return $this->setNoRender();
  }
}
