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

class Sesdiscussion_Widget_OtherDiscussionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (Engine_Api::_()->core()->hasSubject('discussion'))
      $item = Engine_Api::_()->core()->getSubject('discussion');
    if (!$item)
      return $this->setNoRender();
    $this->view->allParams = $allParams = $this->_getAllParams();
    $this->view->discussions = Engine_Api::_()->getDbTable('discussions', 'sesdiscussion')->getDiscussionsSelect(array('orderby' => $allParams['popularity'], 'limit' => @$allParams['limit'], 'widget' => 1, 'discussion_id' => $item->discussion_id, 'owner_id' => $item->owner_id));
    if(count($this->view->discussions) == 0)
      return $this->setNoRender();
  }
}
