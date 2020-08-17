<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesqa_IndexController extends Core_Controller_Action_Standard
{
  public function init()
  {
    // only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('sesqa_question', null, 'view')->isValid() ) return;
    // Get subject
    $question = null;
    if( null !== ($questionIdentity = $this->_getParam('question_id')) ) {
      $question = Engine_Api::_()->getItem('sesqa_question', $questionIdentity);
      if( null !== $question ) {
        Engine_Api::_()->core()->setSubject($question);
      }
    }
  }
  public function featuredAction(){
    if( !$this->_helper->requireAuth()->setAuthParams('sesqa_question', null, 'view')->isValid() ) return;
     // Render
    $this->_helper->content->setEnabled();
  }
  public function sponsoredAction(){
    if( !$this->_helper->requireAuth()->setAuthParams('sesqa_question', null, 'view')->isValid() ) return;
     // Render
    $this->_helper->content->setEnabled();
  }
  public function hotAction(){
    if( !$this->_helper->requireAuth()->setAuthParams('sesqa_question', null, 'view')->isValid() ) return;
     // Render
    $this->_helper->content->setEnabled();
  }
  public function tagsAction(){

    if( !$this->_helper->requireAuth()->setAuthParams('sesqa_question', null, 'view')->isValid() ) return;
     // Render
    $this->_helper->content->setEnabled();
  }
  public function browseAction(){
    if( !$this->_helper->requireAuth()->setAuthParams('sesqa_question', null, 'view')->isValid() ) return;
     // Render
    $this->_helper->content->setEnabled();
  }
  public function manageAction(){
    if( !$this->_helper->requireAuth()->setAuthParams('sesqa_question', null, 'view')->isValid() ) return;
    $sesqa_manage = Zend_Registry::isRegistered('sesqa_manage') ? Zend_Registry::get('sesqa_manage') : null;
    if(!empty($sesqa_manage)) {
      $this->_helper->content->setEnabled();
    }
  }
  public function unansweredAction(){
    if( !$this->_helper->requireAuth()->setAuthParams('sesqa_question', null, 'view')->isValid() ) return;
     // Render
    $this->_helper->content->setEnabled();
  }

  //get categories ajax based.
  public function subcategoryAction() {
    $category_id = $this->_getParam('category_id', null);
    if ($category_id) {
			$subcategory = Engine_Api::_()->getDbtable('categories', 'sesqa')->getModuleSubcategory(array('category_id'=>$category_id,'column_name'=>'*'));
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
        $data .= '<option value=""></option>';
        foreach ($subcategory as $category) {
          $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '" >' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
        }
      }
    }
    else
      $data = '';
    echo $data;
    die;
  }

    public function getIframelyInformationAction() {

    $url = trim(strip_tags($this->_getParam('uri')));
    $ajax = $this->_getParam('ajax', false);
    $information = $this->handleIframelyInformation($url);
    $this->view->ajax = $ajax;
    $this->view->valid = !empty($information['code']);
    $this->view->iframely = $information;
  }
   // HELPER FUNCTIONS
  public function handleIframelyInformation($uri) {

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
	// get subsubcategory ajax based
  public function subsubcategoryAction() {
    $category_id = $this->_getParam('subcategory_id', null);
    if ($category_id) {
      $subcategory = Engine_Api::_()->getDbtable('categories', 'sesqa')->getModuleSubsubcategory(array('category_id'=>$category_id,'column_name'=>'*'));
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
        $data .= '<option value=""></option>';
        foreach ($subcategory as $category) {
          $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '">' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
        }
      }
    }
    else
      $data = '';
    echo $data;die;
  }
  //get search question
  public function getQuestionsAction() {
    $sesdata = array();
    $value['searchText'] = $this->_getParam('text', '');
    $value['search'] = 1;
    $value['fetchAll'] = true;
    $value['limit'] = 5;
    $value['locationEnable'] = $this->_getParam('locationEnable',0);
    $questions = Engine_Api::_()->getDbtable('questions', 'sesqa')->getQuestions($value);
    foreach ($questions as $question) {
      $question_icon = $this->view->itemPhoto($question, 'thumb.icon');
      $sesdata[] = array(
          'id' => $question->getIdentity(),
          'video_id' => $question->getIdentity(),
          'url' => $question->getHref(),
          'label' => $question->title,
          'photo' => $question_icon
      );
    }
    return $this->_helper->json($sesdata);
  }
  public function createAction(){
    if( !$this->_helper->requireAuth()->setAuthParams('sesqa_question', null, 'view')->isValid() ) return;
     // Render
    $sesqa_create = Zend_Registry::isRegistered('sesqa_create') ? Zend_Registry::get('sesqa_create') : null;
    if(!empty($sesqa_create)) {
      $this->_helper->content->setEnabled();
    }
    if (!$this->_helper->requireAuth()->setAuthParams('sesqa_question', null, 'create')->isValid())
      return;


    $viewer = Engine_Api::_()->user()->getViewer();
    $values['user_id'] = $viewer->getIdentity();
    $values['fetchAll'] = true;
    $this->view->current_count = $current_count = count(Engine_Api::_()->getDbtable('questions', 'sesqa')->getQuestions($values));
    $this->view->quota = $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesqa_question', 'max');
    $this->view->options = array();
    $this->view->maxOptions = $max_options = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.maxoptions', 15);

    $this->view->form = $form = new Sesqa_Form_Create();
    // Check options
    $options = (array) $this->_getParam('optionsArray');
    $options = array_filter(array_map('trim', $options));
    $options = array_slice($options, 0, $max_options);
    $this->view->options = $options;

    $this->view->multi = !empty($_POST['multi']) ? $_POST['multi'] : "";
    if(Engine_Api::_()->core()->hasSubject('sesqa_question')){
      $subject = Engine_Api::_()->core()->getSubject();
      $arrayQuestion = $subject->toArray();
      if($subject->location){
        $latLng = Engine_Api::_()->getDbTable('locations', 'sesbasic')->getLocationData($subject->getType(),$subject->getIdentity());
        if($latLng){
          $arrayQuestion['lat'] = $latLng["lat"];
          $arrayQuestion['lng'] = $latLng["lng"];
        }
      }
      $form->populate($arrayQuestion);
      $form->title->setValue('');
      $options = (array) $this->_getParam('optionsArray');
      $pollOptions = $subject->getOptions();
      if(!count($options)){
        foreach($pollOptions as $optn){
           $options[] = $optn->poll_option;
        }
      }
     $this->view->isPollDisable = $question->vote_count && count($pollOptions);

    $options = array_filter(array_map('trim', $options));
    $options = array_slice($options, 0, $max_options);
    $this->view->options = $options;
    if($form->video)
      $form->video->setValue($subject->video_url);
      // authorization
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
      foreach ($roles as $role) {
        if (1 === $auth->isAllowed($subject, $role, 'view')) {
          $form->auth_view->setValue($role);
        }
        if (1 === $auth->isAllowed($subject, $role, 'comment')) {
          $form->auth_comment->setValue($role);
        }
        if (1 === $auth->isAllowed($subject, $role, 'answer')) {
          $form->auth_answer->setValue($role);
        }
      }
      // prepare tags
      $questionTags = $subject->tags()->getTagMaps();
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


      if($subject->draft == 1)
        $form->removeElement('draft');

    }
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
      $question = Engine_Api::_()->getItemTable('sesqa_question')->createRow();
      // Add tags
      $values = $form->getValues();
      if( empty($values['auth_view']) )
       $values['auth_view'] = 'everyone';

      if( empty($values['auth_comment']) )
       $values['auth_comment'] = 'everyone';

      if( empty($values['auth_answer']) )
       $values['auth_answer'] = 'everyone';
      $values['owner_id'] = $viewer->getIdentity();
      $values['view_privacy'] = $values['auth_view'];
      $question->setFromArray($values);

      if(!empty($_FILES['photo']['name']) && $values['mediatype'] == 1)
       $question->setPhoto($form->photo);

      if(@$values['video'] && @$values['mediatype'] == 2) {
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
      $question->tags()->addTagMaps($viewer, $tags);

      if(!empty($_POST['is_poll'])){
        // poll data insert
        $censor = new Engine_Filter_Censor();
        $html = new Engine_Filter_Html(array('AllowedTags'=> array('a')));
        foreach( $options as $option ) {
          $option = $censor->filter($html->filter($option));
          $sesqaOptionsTable->insert(array(
            'question_id' => $question->getIdentity(),
            'poll_option' => $option,
          ));
        }
        $question->multi = !empty($_POST['multi']) ? $_POST['multi'] : 0;
        $question->save();
      }

        //Auto Approve Work
        if(Engine_Api::_()->authorization()->isAllowed('sesqa_question', null, 'sesqa_autoapp')) {
            $question->approved = 1;
            $question->save();
        } else if(empty($question->approved)) {
            $getSuperAdmins = Engine_Api::_()->user()->getSuperAdmins();
            foreach($getSuperAdmins as $getSuperAdmin) {
                $admin = Engine_Api::_()->getItem('user', $getSuperAdmin->user_id);
                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($admin, $admin, $question, 'sesqa_qaaprvwaiting');

                Engine_Api::_()->getApi('mail', 'core')->sendSystem($getSuperAdmin->email, 'sesqa_qaaprvwaiting', array('host' => $_SERVER['HTTP_HOST'], 'queue' => false, 'title' => $question->title, 'question_link' => $question->getHref()));
            }
        }

      //update location data in sesbasic location table
//       if ($_POST['lat'] != '' && $_POST['lng'] != '') {
//         $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
//         $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $question->getIdentity() . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","'.$question->getType().'")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
//       }
      
      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '') {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $question->getIdentity() . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","'.$question->getType().'")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      } else {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type, country, state, city, zip) VALUES ("' . $question->getIdentity() . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","'.$question->getType().'", "' . $_POST['country'] . '", "' . $_POST['state'] . '", "' . $_POST['city'] . '", "' . $_POST['zip'] . '")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      }
      
      if($question->draft == 1){
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

      return $this->_helper->redirector->gotoUrl($question->getHref(), array('prependBase' => false));
    }catch(Exception $e){
      throw $e;
    }

  }
  function voteupAction(){
    $itemguid = $this->_getParam('itemguid',0);
    $userguid = $this->_getParam('userguid',0);
    $type = $this->_getParam('type','upvote');
    $item = Engine_Api::_()->getItemByGuid($itemguid);
    $user = Engine_Api::_()->getItemByGuid($userguid);
    $isVote = Engine_Api::_()->getDbTable('voteupdowns','sesqa')->isVote(array('resource_id'=>$item->getIdentity(),'resource_type'=>$item->getType(),'user_id'=>$user->getIdentity(),'user_type'=>$user->getType()));
    $checkType = "";
    if($isVote)
      $checkType = $isVote->type;
    if($checkType != "upvote" && $type == "upvote"){
      //up vote
      $table = Engine_Api::_()->getDbTable('voteupdowns','sesqa');
      $vote = $table->createRow();
      $vote->type = "upvote";
      $vote->resource_type = $item->getType();
      $vote->resource_id = $item->getIdentity();
      $vote->user_type = $user->getType();
      $vote->user_id = $user->getIdentity();
      $vote->save();
      $item->upvote_count = new Zend_Db_Expr('upvote_count + 1');
      if($isVote){
         $isVote->delete();
         $item->downvote_count = new Zend_Db_Expr('downvote_count - 1');
      }
      $item->save();

    }else{
      //down vote
      $table = Engine_Api::_()->getDbTable('voteupdowns','sesqa');
      $vote = $table->createRow();
      $vote->type = "downvote";
      $vote->resource_type = $item->getType();
      $vote->resource_id = $item->getIdentity();
      $vote->user_type = $user->getType();
      $vote->user_id = $user->getIdentity();
      $vote->save();
      $item->downvote_count = new Zend_Db_Expr('downvote_count + 1');
      if($isVote){
         $isVote->delete();
         $item->upvote_count = new Zend_Db_Expr('upvote_count - 1');
      }
      $item->save();
    }
    $markasBest = false;
    if($item->getType() == "sesqa_answer")
      $markasBest = true;

    echo $this->view->partial('_updownvote.tpl', 'sesqa', array('question' => $item,'user'=>$user,'markasBest'=>$markasBest));die;

  }
   public function viewAction(){
     $question = Engine_Api::_()->core()->getSubject('sesqa_question');
     if (!$this->_helper->requireSubject()->isValid())
      return;
     if(!$this->_helper->requireAuth()->setAuthParams($question, null, 'view')->isValid() ) return;

     $viewer = Engine_Api::_()->user()->getViewer();
     /* Insert data for recently viewed widget */
     if ($viewer->getIdentity() != 0 && ($question->getIdentity())) {
       $dbObject = Engine_Db_Table::getDefaultAdapter();
       $dbObject->query('INSERT INTO engine4_sesqa_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $question->getIdentity() . '", "'.$question->getType().'","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
     }

     if( !$viewer || !$viewer->getIdentity() || !$question->isOwner($viewer) ) {
        $question->view_count = new Zend_Db_Expr('view_count + 1');
        $question->save();
      }
     // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;
   }
   public function voteAction()
  {
    // Check auth
    if( !$this->_helper->requireUser()->isValid() ) {
      return;
    }
    if( !$this->_helper->requireSubject()->isValid() ) {
      return;
    }

    //if( !$this->_helper->requireAuth()->setAuthParams(null, null, 'vote')->isValid() ) {
      //return;
    //}

    // Check method
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    $option_id = $this->_getParam('option_id');
    $canChangeVote = Engine_Api::_()->getApi('settings', 'core')->getSetting('question.canchangevote', true);

    $question = Engine_Api::_()->core()->getSubject('sesqa_question');
    $viewer = Engine_Api::_()->user()->getViewer();

    if( !$question ) {
      $this->view->success = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('This question does not seem to exist anymore.');
      return;
    }

   // $hashElement = $this->view->voteHashSesqa($question)->getElement();
    //if (!$hashElement->isValid($this->_getParam('token'))) {
      //$this->view->success = false;
      //$this->view->error = join(';', $hashElement->getMessages());
      //return;
    //}

    if( $question->open_close ) {
      $this->view->success = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('This question is closed.');
      return;
    }

    if( $question->hasVoted($viewer) && !$canChangeVote && !$question->multi ) {
      $this->view->success = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('You have already voted on this question, and are not permitted to change your vote.');
      return;
    }

    $db = Engine_Api::_()->getDbtable('questions', 'sesqa')->getAdapter();
    $db->beginTransaction();
    try {
      $question->vote($viewer, $option_id);
      $db->commit();
    } catch( Exception $e ) {
      $db->rollback();
      $this->view->success = false;
      throw $e;
    }

    $this->view->token = $this->view->voteHashSesqa($question)->generateHash();
    $this->view->success = true;
    $pollOptions = array();
    foreach( $question->getOptions()->toArray() as $option ) {
      $option['votesTranslated'] = $this->view->translate(array('%s vote', '%s votes', $option['votes']), $this->view->locale()->toNumber($option['votes']));
      $pollOptions[] = $option;
    }
    $this->view->questionOptions = $pollOptions;
    $this->view->votes_total = $question->vote_count;
  }


  //item liked as per item tye given
  function likeAction() {
    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }

    $type = 'sesqa_question';
    $dbTable = 'questions';
    $resorces_id = 'question_id';
    $notificationType = 'liked';
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $tableLike = Engine_Api::_()->getDbtable('likes', 'core');
    $tableMainLike = $tableLike->info('name');
    $itemTable = Engine_Api::_()->getDbtable($dbTable, 'sesqa');
    $select = $tableLike->select()->from($tableMainLike)->where('resource_type =?', $type)->where('poster_id =?', Engine_Api::_()->user()->getViewer()->getIdentity())->where('poster_type =?', 'user')->where('resource_id =?', $item_id);
    $Like = $tableLike->fetchRow($select);
    if (count($Like) > 0) {
      //delete
      $db = $Like->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $Like->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $item = Engine_Api::_()->getItem($type, $item_id);
      $item->like_count = $item->like_count--;
      $item->save();
      $item = Engine_Api::_()->getItem($type, $item_id);
      Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->getDbtable('actions', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->getDbtable('actions', 'activity')->detachFromActivity($item);
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $this->view->translate(array('%s Like', '%s Likes', $item->like_count), $this->view->locale()->toNumber($item->like_count))));
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('likes', 'core')->getAdapter();
      $db->beginTransaction();
      try {
        $like = $tableLike->createRow();
        $like->poster_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $like->resource_type = $type;
        $like->resource_id = $item_id;
        $like->poster_type = 'user';
        $like->save();
        $itemTable->update(array(
            'like_count' => new Zend_Db_Expr('like_count + 1'),
                ), array(
            $resorces_id . '= ?' => $item_id,
        ));
        // Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //send notification and activity feed work.
      $item = Engine_Api::_()->getItem($type, $item_id);
      $subject = $item;
      $owner = $subject->getOwner();
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
        $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
        $result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $subject, $notificationType);
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $this->view->translate(array('%s Like', '%s Likes', $item->like_count), $this->view->locale()->toNumber($item->like_count))));
      die;
    }
  }
  //item favourite as per item tye given
  function favouriteAction() {
    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login')); die;
    }

    $type = 'sesqa_question';
    $dbTable = 'questions';
    $resorces_id = 'question_id';
    $notificationType = 'sesqa_question_favourite';
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));die;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $Fav = Engine_Api::_()->getDbTable('favourites', 'sesqa')->getItemfav($type, $item_id);
    $favItem = Engine_Api::_()->getDbtable($dbTable, 'sesqa');
    if (count($Fav) > 0) {
      //delete
      $db = $Fav->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $Fav->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $favItem->update(array('favourite_count' => new Zend_Db_Expr('favourite_count - 1')), array($resorces_id . ' = ?' => $item_id));
      $item = Engine_Api::_()->getItem($type, $item_id);
      Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->getDbtable('actions', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->getDbtable('actions', 'activity')->detachFromActivity($item);
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $this->view->translate(array('%s Favourite', '%s Favourites', $item->favourite_count), $this->view->locale()->toNumber($item->favourite_count))));
      $this->view->favourite_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('favourites', 'sesqa')->getAdapter();
      $db->beginTransaction();
      try {
        $fav = Engine_Api::_()->getDbTable('favourites', 'sesqa')->createRow();
        $fav->user_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $fav->resource_type = $type;
        $fav->resource_id = $item_id;
        $fav->save();
        $favItem->update(array('favourite_count' => new Zend_Db_Expr('favourite_count + 1'),
                ), array(
            $resorces_id . '= ?' => $item_id,
        ));
        // Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //send notification and activity feed work.
      $item = Engine_Api::_()->getItem(@$type, @$item_id);
        $subject = $item;
        $owner = $subject->getOwner();
        if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
          $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
          Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
          $result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
          if (!$result) {
            $action = $activityTable->addActivity($viewer, $subject, $notificationType);
            if ($action)
              $activityTable->attachActivity($action, $subject);
          }
        }
      $this->view->favourite_id = 1;
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $this->view->translate(array('%s Favourite', '%s Favourites', $item->favourite_count), $this->view->locale()->toNumber($item->favourite_count)), 'favourite_id' => 1));
      die;
    }
  }
   function followAction() {

    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $itemObj = Engine_Api::_()->getItem('sesqa_question',$item_id);
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    $itemTable = Engine_Api::_()->getItemTable('sesqa_question');
    $tableFollow = Engine_Api::_()->getDbtable('follows', 'sesqa');
    $tableMainFollow = $tableFollow->info('name');

    $select = $tableFollow->select()
            ->from($tableMainFollow)
            ->where('resource_id = ?', $item_id)
            ->where('user_id = ?', $viewer_id);
    $result = $tableFollow->fetchRow($select);

    if (count($result) > 0) {
      //delete
      $db = $result->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $result->delete();
        //$itemObj->follow_count = $itemObj->follow_count--;
        //$itemObj->save();
        $itemTable->update(array('follow_count' => new Zend_Db_Expr('follow_count - 1')), array('question_id = ?' => $item_id));
        $db->commit();

        $user = Engine_Api::_()->getItem('user', $item_id);
        //Unfollow notification Work: Delete follow notification and feed
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => "sesqa_qafollow", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $user->getType(), "object_id = ?" => $user->getIdentity()));
        Engine_Api::_()->getDbtable('actions', 'activity')->delete(array('type =?' => "sesqa_follow", "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $user->getType(), "object_id = ?" => $user->getIdentity()));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $selectUser = $itemTable->select()->where('question_id =?', $item_id);
      $user = $itemTable->fetchRow($selectUser);
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $user->follow_count));
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('follows', 'sesqa')->getAdapter();
      $db->beginTransaction();
      try {
        $follow = $tableFollow->createRow();
        $follow->user_id = $viewer_id;
        $follow->resource_id = $item_id;
        $follow->save();
       // $itemObj->follow_count = $itemObj->follow_count++;
        //$itemObj->save();
        $itemTable->update(array('follow_count' => new Zend_Db_Expr('follow_count + 1')), array('question_id = ?' => $item_id));
        //Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //Send notification and activity feed work.
      $selectUser = $itemTable->select()->where('question_id =?', $item_id);
      $item = $itemTable->fetchRow($selectUser);
      $subject = $item;
      $owner = $subject->getOwner();
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer_id) {
        $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => 'sesqa_qafollow', "subject_id =?" => $viewer_id, "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, 'sesqa_qafollow');
        $result = $activityTable->fetchRow(array('type =?' => 'sesqa_follow', "subject_id =?" => $viewer_id, "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $subject, 'sesqa_follow');
        }

        //follow mail to another user
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner->email, 'sesqa_qafollow', array('sender_title' => $viewer->getTitle(), 'object_link' => $viewer->getHref(), 'host' => $_SERVER['HTTP_HOST'], 'title' => $subject->getTitle(), 'member_name' => $viewer->getTitle()));
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->follow_count));
      die;
    }
  }

  function deleteAction(){
    $viewer = Engine_Api::_()->user()->getViewer();
    $question = Engine_Api::_()->core()->getSubject('sesqa_question');
    if (!$this->_helper->requireAuth()->setAuthParams($question, null, 'delete')->isValid())
      return;
    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    $this->view->form = $form = new Sesbasic_Form_Delete();
    $form->setTitle('Delete Question?');
    $form->setDescription('Are you sure that you want to delete this question? It will not be recoverable after being deleted. ');
    $form->submit->setLabel('Delete');
    if (!$question) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Question doesn't exists or not authorized to delete");
      return;
    }
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sesqa_general', true);

    $db = $question->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      Engine_Api::_()->getApi('core', 'sesqa')->deleteQuestion($question);
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Question has been deleted.');
    return $this->_forward('success', 'utility', 'core', array(
                'parentRedirect' => $redirectUrl,
                'messages' => array($this->view->message)
    ));
  }
	
	function closeAction(){
    $viewer = Engine_Api::_()->user()->getViewer();
    $question = Engine_Api::_()->core()->getSubject('sesqa_question');
    if (!$this->_helper->requireAuth()->setAuthParams($question, null, 'edit')->isValid())
      return;
    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    $this->view->form = $form = new Sesbasic_Form_Delete();
		if($question->open_close == 1){
			$form->setTitle('Open Question?');
			$form->setDescription('Are you sure that you want to open this question?');
			$form->submit->setLabel('Open');
			$message = $this->view->translate('Question has been opened');
		}
		else{
			$form->setTitle('Close Question?');
			$form->setDescription('Are you sure that you want to close this question?');
			$form->submit->setLabel('Close');
			$message = $this->view->translate('Question has been closed');
		}
   
    if (!$question) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Question doesn't exists or not authorized to delete");
      return;
    }
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sesqa_general', true);

		$question->open_close = $question->open_close ? 0 : 1;
		$question->save();
    
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_($message);
    return $this->_forward('success', 'utility', 'core', array(
                'parentRedirect' => $redirectUrl,
                'messages' => array($this->view->message)
    ));
  }
  public function createAnswerAction(){
    $question_id = $this->_getParam('question_id',0);
    $question = Engine_Api::_()->getItem('sesqa_question',$question_id);
    if(!$question_id || !$question){
      echo 0;die;
    }

    $answerTable = Engine_Api::_()->getItemTable('sesqa_answer');
    $answer = $answerTable->createRow();
    $answer->description = $this->_getParam('data','');
    $answer->owner_id = $this->view->viewer()->getIdentity();
    $answer->creation_date = date('Y-m-d H:i:s',time());
    $answer->question_id = $question_id;
    $answer->save();

    $question->answer_count = new Zend_Db_Expr('answer_count + 1');
    $question->save();

    $auth = Engine_Api::_()->authorization()->context;
    $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
    $commentMax = array_search('everyone', $roles);
    foreach( $roles as $i => $role ) {
      $auth->setAllowed($answer, $role, 'comment', ($i <= $commentMax));
    }
    $viewer = $this->view->viewer();

    //notification
    if($question->owner_id != $viewer->getIdentity()) {
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($question->getOwner(), $question->getOwner(), $question, 'sesqa_qaanswered');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($question->getOwner()->email, 'sesqa_qaanswered', array('host' => $_SERVER['HTTP_HOST'], 'queue' => false, 'title' => $question->title, 'question_link' => $question->getHref(), 'member_name' => $this->view->viewer()->getTitle()));
    }

    $getQuesitonFollowers = Engine_Api::_()->getDbTable('follows', 'sesqa')->getQuesitonFollowers($question->getIdentity());
    foreach($getQuesitonFollowers as $getQuesitonFollower) {
        $user = Engine_Api::_()->getItem('user', $getQuesitonFollower->user_id);
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($user, $user, $question, 'sesqa_qanewanswer');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($user->email, 'sesqa_qanewanswer', array('host' => $_SERVER['HTTP_HOST'], 'queue' => false, 'title' => $question->title, 'question_link' => $question->getHref(), 'member_name' => $this->view->viewer()->getTitle()));
    }

    echo $this->view->content()->renderWidget("sesqa.view-page",array('answer_id'=>$answer->getIdentity(),'is_answer_ajax'=>1,'question'=>$question,'tinymce'=>$this->_getParam('tinymce',0),'answer_show_criteria'=>($this->_getParam('answer_show_criteria'))));die;
  }
  function deleteAnswerAction(){
    $answer_id = $this->_getParam('answer_id',0);
    $answer = Engine_Api::_()->getItem('sesqa_answer',$answer_id);
    if(!$answer_id || !$answer || $answer->owner_id != $this->view->viewer()->getIdentity()){
      return $this->_forward('requireauth', 'error', 'core');
    }
    $this->_helper->layout->setLayout('default-simple');
    $this->view->form = $form = new Sesbasic_Form_Delete();
    $form->setTitle('Delete Answer?');
    $form->setDescription('Are you sure that you want to delete this answer? It will not be recoverable after being deleted. ');
    $form->submit->setLabel('Delete');
    if (!$answer) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Answer doesn't exists or not authorized to delete");
      return;
    }
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $answer->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $question = Engine_Api::_()->getItem('sesqa_question',$answer->question_id);
      if($answer->best_answer){
        $question->best_answer  = 0;
        $question->save();
      }
      $answer->delete();
      $question->answer_count = new Zend_Db_Expr('answer_count - 1');
      $question->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->answer_id = $answer_id;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Answer has been deleted.');
  }
  function markBestAction(){
    $answer_id = $this->_getParam('id',0);
    $answer = Engine_Api::_()->getItem('sesqa_answer',$answer_id);
    $question = Engine_Api::_()->getItem('sesqa_question',$answer->question_id);
    if(!$answer_id || !$answer || $question->owner_id != $this->view->viewer()->getIdentity()){
      echo json_encode(array('error'=>1));die;
    }
    $question = Engine_Api::_()->getItem('sesqa_question',$answer->question_id);
    $isMark = $answer->best_answer;
    $mark=true;
    $olsQuestionBest = $question->best_answer;
    $question->best_answer = $answer->getIdentity();
    if($isMark){
      $question->best_answer = 0;
      $question->save();
      $mark=false;
    }
    if($olsQuestionBest){
      $answerOld = Engine_Api::_()->getItem('sesqa_answer',$olsQuestionBest);
      if($answerOld){
        $answerOld->best_answer = 0;
      }
      $answerOld->save();
    }
    $question->save();

    //notification
    if($answer->owner_id != $this->view->viewer()->getIdentity()) {
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($answer->getOwner(), $answer->getOwner(), $question, 'sesqa_qabestanswer');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($answer->getOwner()->email, 'sesqa_qabestanswer', array('host' => $_SERVER['HTTP_HOST'], 'queue' => false, 'title' => $question->title, 'question_link' => $question->getHref(), 'member_name' => $this->view->viewer()->getTitle()));
    }

    $getQuesitonFollowers = Engine_Api::_()->getDbTable('follows', 'sesqa')->getQuesitonFollowers($answer->question_id);
    foreach($getQuesitonFollowers as $getQuesitonFollower) {
        $user = Engine_Api::_()->getItem('user', $getQuesitonFollower->user_id);
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($user, $user, $question, 'sesqa_bestmarkfollwd');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($user->email, 'sesqa_bestmarkfollwd', array('host' => $_SERVER['HTTP_HOST'], 'queue' => false, 'title' => $question->title, 'question_link' => $question->getHref(), 'member_name' => $this->view->viewer()->getTitle()));
    }

    $answer->best_answer = !$answer->best_answer;
    $answer->save();
    echo json_encode(array('mark'=>$this->view->translate('Mark as Best'),'unmark'=>$this->view->translate('Unmark as Best'),'ismark'=>$mark));die;
  }
  public function editAnswerAction(){
    $answer_id = $this->_getParam('id',0);
    $answer = Engine_Api::_()->getItem('sesqa_answer',$answer_id);
    if(!$answer_id || !$answer || $answer->owner_id != $this->view->viewer()->getIdentity()){
      echo json_encode(array('error'=>1));die;
    }
    $data = $this->_getParam('data','');
    $answer->description = $data;
    $answer->save();
    echo 1;die;
  }
  public function likeQuestionAction(){
      $question_id = $this->_getParam('question_id', '0');
    if ($question_id == 0)
      return;
		$this->view->title = $this->_getParam('title', 'People Who Like This');
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
		$question = Engine_Api::_()->getItem('sesqa_question', $question_id);
		$param['type'] = 'sesqa_question';
		$param['id'] = $question->question_id;
   	$paginator = Engine_Api::_()->sesqa()->likeItemCore($param);
    $this->view->question_id = $question->question_id;
    $this->view->paginator = $paginator ;
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($page);
  }
	//fetch user favourite question as per given question id .
	public function favQuestionAction() {
    $question_id = $this->_getParam('question_id', '0');
    if ($question_id == 0)
      return;
		$this->view->title = $this->_getParam('title', 'User\'s Favourite This Question');
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
		$question = Engine_Api::_()->getItem('sesqa_question', $question_id);
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';

    $tableFav = Engine_Api::_()->getDbtable('favourites', 'sesqa');
		$tableFav = $tableFav->info('name');
    $table = Engine_Api::_()->getDbtable('questions', 'sesqa');
		$select = $table->select()
							->from($table->info('name'))
              ->where('draft =?',1)
							->where('question_id = ?',$question->getIdentity())
							->setIntegrityCheck(false)
							->where($tableFav.'.resource_type =?','sesqa_question')
							->joinLeft($tableFav, $tableFav . '.resource_id=' . $table->info('name') . '.question_id',array('user_id'));
		$paginator =  Zend_Paginator::factory($select);
    $this->view->question_id = $question->question_id;
    $this->view->paginator = $paginator;
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($page);
  }
  //fetch user favourite question as per given question id .
	public function followQuestionAction() {
    $question_id = $this->_getParam('question_id', '0');
    if ($question_id == 0)
      return;
		$this->view->title = $this->_getParam('title', 'User\'s Favourite This Question');
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
		$question = Engine_Api::_()->getItem('sesqa_question', $question_id);
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
   	$tableFav = Engine_Api::_()->getDbtable('follows', 'sesqa');
		$tableFav = $tableFav->info('name');
    $table = Engine_Api::_()->getDbtable('questions', 'sesqa');
		$select = $table->select()
							->from($table->info('name'))
              ->where('draft =?',1)
							->where('question_id = ?',$question->getIdentity())
							->setIntegrityCheck(false)
							->joinLeft($tableFav, $tableFav . '.resource_id=' . $table->info('name') . '.question_id',array('user_id'));
		$this->view->paginator = $paginator =  Zend_Paginator::factory($select);
    $this->view->question_id = $question->question_id;
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($page);
  }
}
