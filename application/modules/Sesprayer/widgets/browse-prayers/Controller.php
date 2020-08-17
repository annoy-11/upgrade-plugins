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

class Sesprayer_Widget_BrowsePrayersController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);

    if(isset($_POST['searchParams']) && $_POST['searchParams'])
        parse_str($_POST['searchParams'], $searchArray);

    $this->view->viewmore = $this->_getParam('viewmore', 0);

    if ($this->view->viewmore)
      $this->getElement()->removeDecorator('Container');

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    // Permissions
    $this->view->canCreate = 1; //$this->_helper->requireAuth()->setAuthParams('sesprayer_prayer', null, 'create')->checkRequire();

    $this->view->form = $form = new Sesprayer_Form_Search();
    $form->removeElement('draft');
    if( !$viewer->getIdentity() ) {
      $form->removeElement('show');
    }
    $sesprayer_browseprayer = Zend_Registry::isRegistered('sesprayer_browseprayer') ? Zend_Registry::get('sesprayer_browseprayer') : null;
    if(empty($sesprayer_browseprayer)) {
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

    if(isset($values['search_networks']) && !empty($values['search_networks'])) {
      $networksTable = Engine_Api::_()->getDbtable('membership', 'network');
      $select = $networksTable->select()->from($networksTable->info('name'), array('user_id'))->where('resource_id = ?', $values['search_networks']);
      $users = $networksTable->fetchAll($select);
      $usersIDSNetworks = array();
      foreach($users as $user) {
        if($viewer_id == $user->user_id) continue;
        $usersIDSNetworks[] = $user->user_id;
      }
      $values['userNetworksSearch'] = $usersIDSNetworks;
    }

    //When Search by lists
    if(isset($values['search_lists']) && !empty($values['search_lists'])) {
      $listitemsTable = Engine_Api::_()->getItemTable('user_list_item');
      $select = $listitemsTable->select()->from($listitemsTable->info('name'), array('child_id'))->where('list_id = ?', $values['search_lists'])->group('child_id');
      $users = $listitemsTable->fetchAll($select);
      $usersIDS = array();
      foreach($users as $user) {
        $usersIDS[] = $user->child_id;
      }
      $values['userlistsSearch'] = $usersIDS;
    }
    $values['actionname'] = 'browseprayer';
      if($searchArray)
          $values = array_merge($values, $searchArray);
    $paginator = Engine_Api::_()->getItemTable('sesprayer_prayer')->getPrayersPaginator($values);
    $paginator->setItemCountPerPage($this->view->allParams['limit']);
    $page = $_REQUEST['page'] ? $_REQUEST['page'] : $this->_getParam('page', 1);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $this->view->count = $paginator->getTotalItemCount();
  }
}
