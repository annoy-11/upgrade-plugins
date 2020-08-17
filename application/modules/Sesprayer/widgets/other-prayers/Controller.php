<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprayer_Widget_OtherPrayersController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    if (Engine_Api::_()->core()->hasSubject('sesprayer_prayer'))
      $item = Engine_Api::_()->core()->getSubject('sesprayer_prayer');
    if (!$item)
      return $this->setNoRender();
    $this->view->allParams = $allParams = $this->_getAllParams();
    $this->view->prayers = Engine_Api::_()->getDbTable('prayers', 'sesprayer')->getPrayersSelect(array('orderby' => $allParams['popularity'], 'limit' => $allParams['limit'], 'widget' => 1, 'prayer_id' => $item->prayer_id, 'owner_id' => $item->owner_id));
    if(count($this->view->prayers) == 0)
      return $this->setNoRender();
  }
}
