<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgrouppoll_IndexController extends Core_Controller_Action_Standard{
  public function init(){
   // Get subject
    $poll = null;
    if( null !== ($pollIdentity = $this->_getParam('poll_id')) ) {
      $poll = Engine_Api::_()->getItem('sesgrouppoll_poll', $pollIdentity);
      if( null !== $poll ) {
        Engine_Api::_()->core()->setSubject($poll);
      }
    }
    // Get viewer
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    // only show polls if authorized
    $resource = ( $poll ? $poll : 'sesgrouppoll_poll' );
    $viewer = ( $viewer && $viewer->getIdentity() ? $viewer : null );
    if( !$this->_helper->requireAuth()->setAuthParams($resource, $viewer, 'view')->isValid() ) {
      return;
    }
  }
    public function gifAction() {
    $this->view->edit = $this->_getParam('edit',false);
    $this->renderScript('_gif.tpl');
  }
  public function getPollAction() {
    $sesdata = array();
    $value['text'] = $this->_getParam('text', '');
    $value['search'] = 1;
    $polls = Engine_Api::_()->getDbtable('polls', 'sesgrouppoll')->getPollsPaginator($value);
    foreach ($polls as $poll) {
      $sesdata = $poll->toArray();
    }
    return $this->_helper->json($sesdata);
  }
   public function getGroupAction() {
    $sesdata = array();
    $groupTable = Engine_Api::_()->getDbtable('groups', 'sesgroup');
    $selectGroupTable = $groupTable->select()->where('title LIKE "%' . $this->_getParam('text', '') . '%"');
    $groups = $groupTable->fetchAll($selectGroupTable);
    foreach ($groups as $group) {
      $group_icon = $this->view->itemPhoto($group, 'thumb.icon');
      $sesdata[] = array(
          'id' => $group->group_id,
          'group_id' => $group->group_id,
          'url'=>$group->getHref(),
          'label' => $group->title,
          'photo' => $group_icon
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function searchGifAction() {
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $text = $this->_getParam('text','ha');
    $this->view->is_ajax = $this->_getParam('is_ajax', 1);
    $this->view->searchvalue = $this->_getParam('searchvalue', 0);
    $paginator = $this->view->paginator = Engine_Api::_()->getDbTable('images', 'sesfeedgif')->searchGif($text);
		$paginator->setItemCountPerPage(10);
		$this->view->page = $page ;
		$paginator->setCurrentPageNumber($page);
  }
  public function browseAction(){
    // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;
  }
  public function homeAction(){
	
    // Render
    $this->_helper->content
      //->setNoRender()
      ->setEnabled()
    ;
			
  }
  public function createAction(){
      // check login
    if( !$this->_helper->requireUser()->isValid() ) {
      return;
    }
    // check member level  authentication
    if( !$this->_helper->requireAuth()->setAuthParams('sesgrouppoll_poll', null, 'create')->isValid() ) {
      return;
    }
    // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;
    $this->view->options = array();
    $this->view->maxOptions = $max_options = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppoll.maxoptions', 15);
    $this->view->form = $form = new Sesgrouppoll_Form_Create();
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }
    // Check options
    $group_id = $this->_getParam('group_id',null);
    if($group_id == null)
      return;
    $optionImages = $_FILES['optionsImage'];
    $optionGifs = $_FILES['optionsGif'];
    $options = (array) $this->_getParam('optionsArray');
    $options = array_filter(array_map('trim', $options));
    $options = array_slice($options, 0, $max_options);
    $this->view->options = $options;
    if( empty($options) || !is_array($options) || count($options) < 2 ) {
      echo json_encode(array('status' => 'false', 'error' => '1', 'message' =>'You must provide at least two possible answers.'));
      die;
    }
    foreach( $options as $index => $option ) {
      if( strlen($option) > 300 ) {
        $options[$index] = Engine_String::substr($option, 0, 300);
      }
    }
    // Process
    $pollTable = Engine_Api::_()->getItemTable('sesgrouppoll_poll');
    $pollOptionsTable = Engine_Api::_()->getDbtable('options', 'sesgrouppoll');
    $db = $pollTable->getAdapter();
    $db->beginTransaction();
    try {
      $values = $form->getValues();
      $values['group_id'] =$group_id;
      $values['user_id'] = $viewer->getIdentity();
      if( empty($values['auth_view']) ) {
        $values['auth_view'] = 'everyone';
      }
      if( empty($values['auth_comment']) ) {
        $values['auth_comment'] = 'everyone';
      }
      $values['view_privacy'] = $values['auth_view'];
      // Create poll
      $poll = $pollTable->createRow();
      $poll->setFromArray($values);
      $poll->save();
      // Create options
      $censor = new Engine_Filter_Censor();
      $html = new Engine_Filter_Html(array('AllowedTags'=> array('a')));
      $counter = 0;
      $storage = Engine_Api::_()->getItemTable('storage_file');
      foreach( $options as $option ) {
        $option = $censor->filter($html->filter($option));
        $file_id = 0;
        $image_type= 0;
        if(!empty($_FILES['optionsImage']['name'][$counter])){
		  $file['tmp_name'] = $_FILES['optionsImage']['tmp_name'][$counter];
		  $file['name'] = $_FILES['optionsImage']['name'][$counter];
		  $file['size'] = $_FILES['optionsImage']['size'][$counter];
		  $file['error'] = $_FILES['optionsImage']['error'][$counter];
		  $file['type'] = $_FILES['optionsImage']['type'][$counter];
          $image_type = 1;
        }elseif(!empty($_POST['optionsGif'][$counter])){
          $file_id  = $_POST['optionsGif'][$counter];
          $image_type = 2;
        }
    if($file && $image_type == 1){
        $thumbname = $storage->createFile($file, array(
          'parent_id' => $poll->getIdentity(),
          'parent_type' => 'sesgrouppoll_poll',
          'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        ));
        $file_id = $thumbname->file_id;
      }
        $pollOptionsTable->insert(array(
          'poll_id' => $poll->getIdentity(),
          'poll_option' => $option,
          'file_id'=>$file_id,
          'image_type'=>$image_type
        ));
		 $image_type = 0;
        $counter ++;
      }
      // Privacy
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner','member', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
      foreach( $roles as $i => $role ) {
        $auth->setAllowed($poll, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($poll, $role, 'comment', ($i <= $commentMax));
      }
      $auth->setAllowed($poll, 'registered', 'vote', true);
      $db->commit();
    } catch( Exception $e ) {
      $db->rollback();
      throw $e;
    }
    // Process activity
    $db = Engine_Api::_()->getDbTable('polls', 'sesgrouppoll')->getAdapter();
    $db->beginTransaction();
    try {
        $group = Engine_Api::_()->getItem('sesgroup_group',$group_id);
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity(Engine_Api::_()->user()->getViewer(), $group, 'sesgroup_group_createpoll');
      if( $action != null ) {
        Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $poll);
      }
      $db->commit();
    } catch( Exception $e ) {
      $db->rollback();
      throw $e;
    }
	 // Redirect
    echo json_encode(array('status' => 'true', 'error' => '', 'id' => $poll->poll_id));
    die;
  }
}
