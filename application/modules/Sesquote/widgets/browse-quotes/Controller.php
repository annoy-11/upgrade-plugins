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

class Sesquote_Widget_BrowseQuotesController extends Engine_Content_Widget_Abstract {

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

    $this->view->form = $form = new Sesquote_Form_Search();
    if(!empty($_POST['search'])){
        $form->search->setValue($_POST['search']);
    }
    $form->removeElement('draft');
    if( !$viewer->getIdentity() ) {
      $form->removeElement('show');
    }

    $this->view->identityForWidget = $identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : $this->view->identity;


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

    // Quote browse page work
    $type = '';
    $page_id = Engine_Api::_()->sesquote()->getWidgetPageId($identityForWidget);
    if($page_id) {
      $pageName = Engine_Db_Table::getDefaultAdapter()->select()
              ->from('engine4_core_pages', 'name')
              ->where('page_id = ?', $page_id)
              ->limit(1)
              ->query()
              ->fetchColumn();
      if($pageName) {
        $explode = explode('sesquote_index_', $pageName);

        if(is_numeric($explode[1])) {
          $type = Engine_Db_Table::getDefaultAdapter()->select()
                ->from('engine4_sesquote_integrateothermodules', 'content_type')
                ->where('integrateothermodule_id = ?', $explode[1])
                ->limit(1)
                ->query()
                ->fetchColumn();
          if($type) {
            $values['resource_type'] = $type;
          }
        }
      }
    }
    $this->view->type = $type;
    // Quote browse page work

    if(@$params) {
      $this->view->allParams = $values = @$params;
    } else {
      $this->view->allParams = $values = array_merge($this->_getAllParams(), $values);

    }
    if($searchArray)
    $values = array_merge($values, $searchArray);

    $paginator = Engine_Api::_()->getItemTable('sesquote_quote')->getQuotesPaginator($values);
    $paginator->setItemCountPerPage($this->view->allParams['limit']);
    $page = $_REQUEST['page'] ? $_REQUEST['page'] : $this->_getParam('page', 1);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $this->view->count = $paginator->getTotalItemCount();
  }
}
