<?php

class Seslink_Widget_BrowseLinksController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->allParams = $this->_getAllParams();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Permissions
    $this->view->canCreate = 1; //$this->_helper->requireAuth()->setAuthParams('seslink_link', null, 'create')->checkRequire();

    $this->view->form = $form = new Seslink_Form_Search();
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
    $paginator = Engine_Api::_()->getItemTable('seslink_link')->getLinksPaginator($values);
    $paginator->setItemCountPerPage($this->view->allParams['limit']);
    $this->view->paginator = $paginator->setCurrentPageNumber( $values['page'] );
  }
}
