<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinesspoll_Widget_BrowseSearchController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $p = Zend_Controller_Front::getInstance()->getRequest()->getParams();
    // Get form
    $this->view->form = $form = new Sesbusinesspoll_Form_Search(array('searchTitle'=>$this->_getParam('search_title')));
    if( !$viewer->getIdentity() ) {
      $form->removeElement('show');
    }
    $sesbusinesspoll_widget = Zend_Registry::isRegistered('sesbusinesspoll_widget') ? Zend_Registry::get('sesbusinesspoll_widget') : null;
    if(empty($sesbusinesspoll_widget))
      return $this->setNoRender();
    // Process form
    $values = array('browse' => 1);
    if( $form->isValid($p) ) {
      $values = $form->getValues();
    }
    $this->view->formValues = array_filter($values);
    if( @$values['show'] == 2 && $viewer->getIdentity() ) {
      // Get an array of friend ids
      $values['users'] = $viewer->membership()->getMembershipsOfIds();
    }
    unset($values['show']);
  }
}
