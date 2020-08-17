<?php

/**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Sesqa
 * @copyright  Copyright 2014-2020 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: DashboardController.php 2016-07-23 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Sesqa_DashboardController extends Core_Controller_Action_Standard {
  public function init() {
    // only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('sesqa_question', null, 'view')->isValid() ) return;
    // Get subject
    $question = null;
    if( null !== ($questionIdentity = $this->_getParam('question_id')) ) {
      $question = Engine_Api::_()->getItem('sesqa_question', $questionIdentity);
      if( null !== $question ) {
        Engine_Api::_()->core()->setSubject($question);
        $this->view->question = $question = Engine_Api::_()->core()->getSubject('sesqa_question');
        $this->view->question_id = $question_id = $question->getIdentity();
      }
    }
    
  } 
  public function editAction(){ 
    $question = Engine_Api::_()->core()->getSubject('sesqa_question');
     if (!$this->_helper->requireSubject()->isValid())
      return;
     if(!$this->_helper->requireAuth()->setAuthParams($question, null, 'view')->isValid() ) return;

     $viewer = Engine_Api::_()->user()->getViewer();
    $sesqa_create = Zend_Registry::isRegistered('sesqa_create') ? Zend_Registry::get('sesqa_create') : null;
    if(!empty($sesqa_create)) {
      $this->view->form = $form = new Sesqa_Form_Edit();
    }
    $form->setTitle('Edit Question');
    $form->populate($question->toArray());
    $this->view->options = array();
    $this->view->maxOptions = $max_options = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.maxoptions', 15);
    $this->view->multi = !empty($_POST['multi']) ? $_POST['multi'] : ($question->multi) ? $question->multi : "";
    $draftOldValue = $question->draft;
    // Check options
    $options = (array) $this->_getParam('optionsArray');
    $pollOptions = $question->getOptions();
    if(!count($options)){
      foreach($pollOptions as $optn){
         $options[] = $optn->poll_option;
      }
    }
    
    $this->view->isPollDisable = $question->vote_count && count($pollOptions);

    $options = array_filter(array_map('trim', $options));
    $options = array_slice($options, 0, $max_options);
    $this->view->options = $options;
    // authorization
    $auth = Engine_Api::_()->authorization()->context;
    $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
    foreach ($roles as $role) {
      if (1 === $auth->isAllowed($question, $role, 'view')) {
        $form->auth_view->setValue($role);
      }
      if (1 === $auth->isAllowed($question, $role, 'comment')) {
        $form->auth_comment->setValue($role);
      }
      if (1 === $auth->isAllowed($question, $role, 'answer')) {
        $form->auth_answer->setValue($role);
      }
    }
    // prepare tags
    $questionTags = $question->tags()->getTagMaps();
    $tagString = '';
    foreach ($questionTags as $tagmap) {
      $tag = $tagmap->getTag();
      if(isset($tag)) {
      if ($tagString !== '')
        $tagString .= ', ';
      $tagString .= $tag->getTitle();
      }
    }
    if($form->tags)
    $form->tags->setValue($tagString);


    if($question->draft == 1)
      $form->removeElement('draft');

    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    if(!empty($_POST['is_poll']) &&  (empty($options) || !is_array($options) || count($options) < 2 )) {
      return $form->addError('You must provide at least two possible answers.');
    }
    foreach( $options as $index => $option ) {
      if( strlen($option) > 255 ) {
        $options[$index] = Engine_String::substr($option, 0, 255);
      }
    }


    $db = Engine_Api::_()->getItemTable('sesqa_question')->getAdapter();
    $sesqaOptionsTable = Engine_Api::_()->getDbtable('options', 'sesqa');
    $db->beginTransaction();
    try {
      // Add tags
      $values = $form->getValues();
      if( empty($values['auth_view']) )
        $values['auth_view'] = 'everyone';

      if( empty($values['auth_comment']) )
       $values['auth_comment'] = 'everyone';

      if( empty($values['auth_answer']) )
       $values['auth_answer'] = 'everyone';
      $values['view_privacy'] = $values['auth_view'];
      $question->setFromArray($values);

      $question->save();
      // Auth
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
      $answerMax = array_search($values['auth_answer'], $roles);
      foreach( $roles as $i => $role ) {
        $auth->setAllowed($question, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($question, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($question, $role, 'answer', ($i <= $answerMax));
      }
      $auth->setAllowed($question, 'registered', 'vote', true);
      // Add tags
      $tags = preg_split('/[,]+/', trim($values['tags'],', '));
      $question->tags()->setTagMaps($viewer, $tags);

      $isPollOptionUpdate = $this->pollOptionUpdate($pollOptions,$_POST['optionsArray']);

      if(!empty($_POST['is_poll'])){
         if(($isPollOptionUpdate && !$question->vote_count) || !count($pollOptions)){
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          $dbGetInsert->query("DELETE FROM engine4_sesqa_options WHERE question_id = ".$question->getIdentity());
          // poll data insert
          $censor = new Engine_Filter_Censor();
          $html = new Engine_Filter_Html(array('AllowedTags'=> array('a')));
          foreach( $options as $option ){
            $option = $censor->filter($html->filter($option));
            $sesqaOptionsTable->insert(array(
              'question_id' => $question->getIdentity(),
              'poll_option' => $option,
            ));
          }
          $question->multi = !empty($_POST['multi']) ? $_POST['multi'] : 0;
          $question->save();
         }
      }else{
        //remove poll options
        $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
        $dbGetInsert->query("DELETE FROM engine4_sesqa_options WHERE question_id = ".$question->getIdentity());
        $question->vote_count = 0;
        $question->save();
      }
      
      if($draftOldValue == 0 && $question->draft == 1){
        // Add activity only if question is published
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $question, 'sesqa_question_new');
        // make sure action exists before attaching the question to the activity
        if( $action )
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $question);
        if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags) {
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          foreach($tags as $tag)
            $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$action->getIdentity().'", "'.$tag.'")');
        }
      }
      $db->commit();
      // return $this->_helper->redirector->gotoUrl($question->getHref(), array('prependBase' => false));
      $this->_redirectCustom(array('route' => 'sesqa_dashboard', 'action' => 'edit', 'question_id' => $question->getIdentity()));
    }catch(Exception $e){
      throw $e;
    }
  }
  function pollOptionUpdate($questionPolls,$postOptions){
    foreach($questionPolls->toArray() as $key => $qpoll){
        if(empty($postOptions[$key]) || $qpoll['poll_option'] != $postOptions[$key]){
          return true;
        }
    }
    return false;
  }
  public function editLocationAction() { 

    $sesqa = Engine_Api::_()->core()->getSubject();
    $userLocation = $sesqa->location;
    if (!$userLocation)
      return $this->_forward('notfound', 'error', 'core');

    $this->view->locationLatLng = $locationLatLng = Engine_Api::_()->getDbtable('locations', 'sesbasic')->getLocationData($sesqa->getType(), $sesqa->getIdentity());
    if (!$locationLatLng) {
     return $this->_forward('notfound', 'error', 'core');
    }

    $this->view->form = $form = new Sesqa_Form_Locationedit();
    $form->populate(array(
        'location' => $userLocation,
        'lat' => $locationLatLng['lat'],
        'lng' => $locationLatLng['lng'],
        'zip' => $locationLatLng['zip'],
        'city' => $locationLatLng['city'],
        'state' => $locationLatLng['state'],
        'country' => $locationLatLng['country'],
    ));
    if ($this->getRequest()->getPost()) {
      Engine_Api::_()->getItemTable('sesqa_question')->update(array(
          'location' => $_POST['location'],
              ), array(
          'question_id = ?' => $sesqa->getIdentity(),
      ));
      if (!empty($_POST['location'])) {
         $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
      $dbGetInsert->query('DELETE FROM `engine4_sesbasic_locations` WHERE `engine4_sesbasic_locations`.`resource_type` = "'.$sesqa->getType().'" AND `engine4_sesbasic_locations`.`resource_id` = "'.$sesqa->getIdentity().'";');
      $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type, country, state, city, zip) VALUES ("' . $sesqa->getIdentity() . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","'.$sesqa->getType().'", "' . $_POST['country'] . '", "' . $_POST['state'] . '", "' . $_POST['city'] . '", "' . $_POST['zip'] . '") ON DUPLICATE KEY UPDATE lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      }
      $this->_redirectCustom(array('route' => 'sesqa_dashboard', 'action' => 'edit-location', 'question_id' => $sesqa->getIdentity()));
    }
    
  }
   public function editMediaAction(){ 

    $question = Engine_Api::_()->core()->getSubject('sesqa_question');
     if (!$this->_helper->requireSubject()->isValid())
      return;
     if(!$this->_helper->requireAuth()->setAuthParams($question, null, 'view')->isValid() ) return;

     $viewer = Engine_Api::_()->user()->getViewer();
    $sesqa_create = Zend_Registry::isRegistered('sesqa_create') ? Zend_Registry::get('sesqa_create') : null;
    if(!empty($sesqa_create)) {
      $this->view->form = $form = new Sesqa_Form_Mediaedit();
    }
    $form->populate($question->toArray());
 
    if($form->video)
      $form->video->setValue($question->video_url);
   
    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    $db = Engine_Api::_()->getItemTable('sesqa_question')->getAdapter();
    $sesqaOptionsTable = Engine_Api::_()->getDbtable('options', 'sesqa');
    $db->beginTransaction();
    try {

      $values = $form->getValues();
      $question->setFromArray($values);

      if(!empty($_FILES['photo']['name']) && $values['mediatype'] == 1)
          $question->setPhoto($form->photo);

      if(!empty($values['video']) && $values['video'] && $values['mediatype'] == 2 && $question->video_url != $values['video']) {
        $information = $this->handleIframelyInformation($values['video']);
        try{
          $question->setPhoto($information['thumbnail']);
        }catch(Exception $e){
          //silence
        }
        $question->video_url = $values['video'];
        $question->code = $information['code'];
      }
      $question->save();
   
      $db->commit();
       $this->_redirectCustom(array('route' => 'sesqa_dashboard', 'action' => 'edit-media', 'question_id' => $question->getIdentity()));
    }catch(Exception $e){
      throw $e;
    }
}

 public  function handleIframelyInformation($uri) {

    $iframelyDisallowHost = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote_iframely_disallow');
    if (parse_url($uri, PHP_URL_SCHEME) === null) {
        $uri = "http://" . $uri;
    }
    $uriHost = Zend_Uri::factory($uri)->getHost();
    if ($iframelyDisallowHost && in_array($uriHost, $iframelyDisallowHost)) {
        return;
    }
    $config = Engine_Api::_()->getApi('settings', 'core')->core_iframely;
    $iframely = Engine_Iframely::factory($config)->get($uri);
    if (!in_array('player', array_keys($iframely['links']))) {
        return;
    }
    $information = array('thumbnail' => '', 'title' => '', 'description' => '', 'duration' => '');
    if (!empty($iframely['links']['thumbnail'])) {
        $information['thumbnail'] = $iframely['links']['thumbnail'][0]['href'];
        if (parse_url($information['thumbnail'], PHP_URL_SCHEME) === null) {
            $information['thumbnail'] = str_replace(array('://', '//'), '', $information['thumbnail']);
            $information['thumbnail'] = "http://" . $information['thumbnail'];
        }
    }
    if (!empty($iframely['meta']['title'])) {
        $information['title'] = $iframely['meta']['title'];
    }
    if (!empty($iframely['meta']['description'])) {
        $information['description'] = $iframely['meta']['description'];
    }
    if (!empty($iframely['meta']['duration'])) {
        $information['duration'] = $iframely['meta']['duration'];
    }
    $information['code'] = $iframely['html'];
    return $information;
  }

}
