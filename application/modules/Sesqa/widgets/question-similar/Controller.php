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

class Sesqa_Widget_QuestionSimilarController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if(!Engine_Api::_()->core()->hasSubject('sesqa_question'))
      return $this->setNoRender();
    $this->view->title = $this->_getParam('title','Post a similar question');
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();
  }
}
