<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesthought
 * @package    Sesthought
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesthought_Widget_ThoughtsOfTheDayController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->allParams = $allParams = $this->_getAllParams();
    
    $this->view->thoughts = Engine_Api::_()->getDbTable('thoughts', 'sesthought')->getThoughtsSelect(array('limit' => $allParams['limit'], 'widget' => 'oftheday'));
    
    if(count($this->view->thoughts) == 0)
      return $this->setNoRender();
  }
}
