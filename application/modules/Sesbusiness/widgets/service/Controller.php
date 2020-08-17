<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Widget_ServiceController extends Engine_Content_Widget_Abstract {

  protected $_childCount;

  public function indexAction() {

    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('businesses');
    if (!$subject) {
      return $this->setNoRender();
    }

    $this->getElement()->removeDecorator('Title');
    $this->view->height = 200;
    $this->view->width = 200;

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('services', 'sesbusiness')->getServiceMemers(array('business_id' => $subject->getIdentity(), 'widgettype' => 'widget'));

    //Manage Apps Check
    $isCheck = Engine_Api::_()->getDbTable('managebusinessapps', 'sesbusiness')->isCheck(array('business_id' => $subject->getIdentity(), 'columnname' => 'service'));
    if(empty($isCheck))
      return $this->setNoRender();

    // Add count to title if configured
    if (count($paginator) > 0) {
      $this->_childCount = count($paginator);
    }
  }

  public function getChildCount() {
    return $this->_childCount;
  }
}
