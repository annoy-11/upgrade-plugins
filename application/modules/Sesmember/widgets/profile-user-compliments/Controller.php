<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Widget_ProfileUserComplimentsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('user'))
      return $this->setNoRender();

    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->core()->getSubject();
    $sesmember_compliments = Zend_Registry::isRegistered('sesmember_compliments') ? Zend_Registry::get('sesmember_compliments') : null;
    if (empty($sesmember_compliments))
      return $this->setNoRender();
    $this->view->getStatusCompliments = Engine_Api::_()->getDbTable('usercompliments', 'sesmember')->getCountUserCompliments(array('user_id' => $subject->getIdentity()));
    $count = count($this->view->getStatusCompliments->toArray());
    if (!$count)
      return $this->setNoRender();
  }

}
