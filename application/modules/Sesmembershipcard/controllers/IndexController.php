<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershipcard
 * @package    Sesmembershipcard
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2019-02-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmembershipcard_IndexController extends Core_Controller_Action_Standard
{
  public function printAction()
  {
     $this->_helper->layout->setLayout('default-simple');
     $this->view->id = $this->_getParam('id');
     $this->view->subject_id = $subject_id = $this->_getParam('subject_id');
     $subject = Engine_Api::_()->getItem('user',$subject_id);
     Engine_Api::_()->core()->setSubject($subject);

  }
  
}
