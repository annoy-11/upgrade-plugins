<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class sesprayer_Widget_BrowseSearchController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $this->view->viewType = $this->_getParam('viewType', 'vertical');
    $viewer = Engine_Api::_()->user()->getViewer();
    
    // Make form
    $this->view->form = $form = new Sesprayer_Form_Search();

    if( !$viewer->getIdentity() ) {
      $form->removeElement('show');
    }

    // Process form
    $p = Zend_Controller_Front::getInstance()->getRequest()->getParams();
    $form->isValid($p);
    $values = $form->getValues();
    $this->view->formValues = array_filter($values);
    $values['draft'] = "0";
    $values['visible'] = "1";
        
    $sesprayer_browsesearch = Zend_Registry::isRegistered('sesprayer_browsesearch') ? Zend_Registry::get('sesprayer_browsesearch') : null;
    if(empty($sesprayer_browsesearch)) {
      return $this->setNoRender();
    }
    
    // Populate options
    if (isset($form->category_id) && count($form->category_id->getMultiOptions()) <= 1)
      $form->removeElement('category_id');
      
    // Do the show thingy
    if( @$values['show'] == 2 ) {
      // Get an array of friend ids
      $table = Engine_Api::_()->getItemTable('user');
      $select = $viewer->membership()->getMembersSelect('user_id');
      $friends = $table->fetchAll($select);
      // Get stuff
      $ids = array();
      foreach( $friends as $friend ) {
        $ids[] = $friend->user_id;
      }
      //unset($values['show']);
      $values['users'] = $ids;
    }
    
    $this->view->assign($values);
  }
}
