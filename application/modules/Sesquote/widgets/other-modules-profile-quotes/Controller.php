<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesquote_Widget_OtherModulesProfileQuotesController extends Engine_Content_Widget_Abstract {

  protected $_childCount;

  public function indexAction() {

    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);

    if(isset($_POST['searchParams']) && $_POST['searchParams'])
        parse_str($_POST['searchParams'], $searchArray);

    $this->view->viewmore = $this->_getParam('viewmore', 0);
    $this->view->descriplimit = $this->_getParam('descriplimit', 150);

    if ($this->view->viewmore)
      $this->getElement()->removeDecorator('Container');

    $viewer = Engine_Api::_()->user()->getViewer();
    // Permissions
    $this->view->canCreate = 1; //$this->_helper->requireAuth()->setAuthParams('sesquote_quote', null, 'create')->checkRequire();
    $this->view->can_create = Engine_Api::_()->authorization()->isAllowed('sesquote_quote', $viewer, 'create');

    $this->view->form = $form = new Sesquote_Form_Search();
    if(!empty($_POST['search'])){
        $form->search->setValue($_POST['search']);
    }
    $form->removeElement('draft');
    if( !$viewer->getIdentity() ) {
      $form->removeElement('show');
    }

    $sesquote_browsequote = Zend_Registry::isRegistered('sesquote_browsequote') ? Zend_Registry::get('sesquote_browsequote') : null;
    if(empty($sesquote_browsequote)) {
      return $this->setNoRender();
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
    if($searchArray)
    $values = array_merge($values, $searchArray);

    $this->view->resource_id = $values['resource_id'] = $resource_id = isset($_GET['resource_id']) ? $_GET['resource_id'] : (isset($params['resource_id']) ?  $params['resource_id'] : Engine_Api::_()->core()->getSubject()->getIdentity());

    $this->view->resource_type = $values['resource_type'] = $resource_type = isset($_GET['resource_type']) ? $_GET['resource_type'] : (isset($params['resource_type']) ?  $params['resource_type'] : Engine_Api::_()->core()->getSubject()->getType());


    $paginator = Engine_Api::_()->getItemTable('sesquote_quote')->getQuotesPaginator($values);
    $paginator->setItemCountPerPage($this->view->allParams['limit']);
    $this->view->paginator = $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    $this->view->count = $paginator->getTotalItemCount();

    // Add count to title if configured
    if( $paginator->getTotalItemCount() > 0 ) {
      $this->_childCount = $paginator->getTotalItemCount();
    }
  }


  public function getChildCount()
  {
    return $this->_childCount;
  }
}
