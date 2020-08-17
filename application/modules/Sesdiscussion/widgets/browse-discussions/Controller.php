<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Widget_BrowseDiscussionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);

    $this->view->viewmore = $this->_getParam('viewmore', 0);

    if ($this->view->viewmore)
      $this->getElement()->removeDecorator('Container');

    $viewer = Engine_Api::_()->user()->getViewer();
    // Permissions
    $this->view->canCreate = 1; //$this->_helper->requireAuth()->setAuthParams('discussion', null, 'create')->checkRequire();

    $this->view->form = $form = new Sesdiscussion_Form_Search();
    $form->removeElement('draft');
    if( !$viewer->getIdentity() ) {
      $form->removeElement('show');
    }

    // Process form
    $defaultValues = $form->getValues();
    if( $form->isValid($this->_getAllParams()) ) {
      $values = $form->getValues();
    } else {
      $values = $defaultValues;
    }
    $this->view->formValues = array_filter($values);
    $values['draft'] = "0";
    $values['visible'] = "1";
    $values = array_merge($values, $_GET);
    if(isset($values['tag_id']))
      $values['tag'] = $values['tag_id'];
    // Do the show thingy
    if( @$values['show'] == 2 ) {
      // Get an array of friend ids
      $table = Engine_Api::_()->getItemTable('user');
      $select = $viewer->membership()->getMembersSelect('user_id');
      $friends = $table->fetchAll($select);
      // Get stuff
      $ids = array();
      foreach( $friends as $friend )
      {
        $ids[] = $friend->user_id;
      }
      $values['users'] = $ids;
    }
    $this->view->assign($values);

    if(@$params) {
      $this->view->allParams = $values = @$params;
    } else {
      $this->view->allParams = $values = array_merge($this->_getAllParams(), $values);
    }

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $getModuleName = $request->getModuleName();
    $getControllerName = $request->getControllerName();
    $getActionName = $request->getActionName();
    if($getActionName == 'top-voted') {
      $values['orderby'] = 'total_votecount';
    }
    $page = !empty($values['page']) ? $values['page'] : $this->_getParam('page', 1);
    $paginator = Engine_Api::_()->getItemTable('discussion')->getDiscussionsPaginator($values);
    $paginator->setItemCountPerPage($this->view->allParams['limit']);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $this->view->count = $paginator->getTotalItemCount();
  }
}
