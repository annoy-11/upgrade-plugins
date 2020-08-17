<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Widget_ServiceController extends Engine_Content_Widget_Abstract {

  protected $_childCount;

  public function indexAction() {

    // Get subject and check auth
    $subject = Engine_Api::_()->core()->getSubject('stores');
    if (!$subject) {
      return $this->setNoRender();
    }
     $limit_data = $this->_getParam('limit_data',5);
    $show_criterias = $this->_getParam('show_criteria', array('title','creationDate','photo','description'));

    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;


    $this->getElement()->removeDecorator('Title');
    $this->view->height = 200;
    $this->view->width = 200;

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('services', 'estore')->getServiceMemers(array('store_id' => $subject->getIdentity(), 'widgettype' => 'widget','limit' => $limit_data));

    //Manage Apps Check
    $isCheck = Engine_Api::_()->getDbTable('managestoreapps', 'estore')->isCheck(array('store_id' => $subject->getIdentity(), 'columnname' => 'service'));
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
