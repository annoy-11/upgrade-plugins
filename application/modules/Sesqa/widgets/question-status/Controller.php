<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Widget_QuestionStatusController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    if( !Engine_Api::_()->core()->hasSubject() ) {
        return $this->setNoRender();
      }
      // Get subject and check auth
      $subject = Engine_Api::_()->core()->getSubject();
      $this->view->question = $subject;
      $this->view->fontSize = $this->_getParam('fontSize',15);
      if($subject->open_close == 0){
        $this->view->color = $this->_getParam('colorOpen','#ffdfa1');
        $this->view->text = $this->_getParam('textColorOpen','#000');
      }else{
        $this->view->color = $this->_getParam('colorClose','#ffdfa1');
        $this->view->text = $this->_getParam('textColorClose','#000');
      }
  }
}