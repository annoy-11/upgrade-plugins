<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Widget_ServiceController extends Engine_Content_Widget_Abstract {
  
  protected $_childCount;
  
  public function indexAction() {
  
    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('sespage_page');
    if (!$subject) {
      return $this->setNoRender();
    }
    
    $this->getElement()->removeDecorator('Title');
    $this->view->height = 200;
    $this->view->width = 200;
    
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('services', 'sespage')->getServiceMemers(array('page_id' => $subject->getIdentity(), 'widgettype' => 'widget'));
    
    //Manage Apps Check
    $isCheck = Engine_Api::_()->getDbTable('managepageapps', 'sespage')->isCheck(array('page_id' => $subject->getIdentity(), 'columnname' => 'service'));
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