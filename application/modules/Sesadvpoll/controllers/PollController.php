<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: PollController.php  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesadvpoll_PollController extends Core_Controller_Action_Standard {

    public function init() {

        // Get subject
        $poll = null;
        $option = null;

        if( null !== ($pollIdentity = $this->_getParam('poll_id')) ) {
            $poll = Engine_Api::_()->getItem('sesadvpoll_poll', $pollIdentity);
            if( null !== $poll ) {
                Engine_Api::_()->core()->setSubject($poll);
            }
        }

        // Get viewer
        $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
        $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

        // only show polls if authorized
        $resource = ( $poll ? $poll : 'sesadvpoll_poll' );
        $viewer = ( $viewer && $viewer->getIdentity() ? $viewer : null );

        if( !$this->_helper->requireAuth()->setAuthParams($resource, $viewer, 'view')->isValid())
            return;

    }

    public function closeAction() {

        if( !$this->_helper->requireUser()->isValid() ) return;

        $viewer = Engine_Api::_()->user()->getViewer();
        $poll = Engine_Api::_()->getItem('sesadvpoll_poll', $this->_getParam('poll_id'));

        if( !Engine_Api::_()->core()->hasSubject('sesadvpoll_poll'))
            Engine_Api::_()->core()->setSubject($poll);

        $this->view->poll = $poll;

        if( !$this->_helper->requireSubject()->isValid())
            return;

        if( !$this->_helper->requireAuth()->setAuthParams($poll, $viewer, 'edit')->isValid())
            return;

        if( !$this->_helper->requireAuth()->setAuthParams('sesadvpoll_poll', $viewer, 'edit')->isValid())
            return;

        $table = $poll->getTable();
        $db = $table->getAdapter();
        $db->beginTransaction();
        try {
            $poll->closed = (bool) $this->_getParam('closed');
            $poll->save();
            $db->commit();
        } catch( Exception $e ) {
            $db->rollBack();
            throw $e;
        }

        if( !($returnUrl = $this->_getParam('return_url')) ) {
            return $this->_helper->redirector->gotoRoute(array('action' => 'view','poll_id'=>$poll->poll_id), 'sesadvpoll_view', true);
        } else {
            return $this->_helper->redirector->gotoRoute(array('action' => 'view','poll_id'=>$poll->poll_id), 'sesadvpoll_view', true);
        }
    }

    public function favouriteAction() {

        if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
            echo json_encode(array('status' => 'false', 'error' => 'Login')); die;
        }

        $item_id = $this->_getParam('id',null);
        if (intval($item_id) == 0) {
            echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));die;
        }

        $viewer = Engine_Api::_()->user()->getViewer();

        $favTable = Engine_Api::_()->getDbTable('favourites', 'sesadvpoll');
        $Fav = $favTable->getItemfav('sesadvpoll_poll', $item_id);

        $favItem = Engine_Api::_()->getDbTable('polls', 'sesadvpoll');
        $item = Engine_Api::_()->getItem('sesadvpoll_poll', $item_id);

        if (count($Fav) > 0) {
            $db = $Fav->getTable()->getAdapter();
            $db->beginTransaction();
            try {
                $Fav->delete();
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }

            $favItem->update(array('favourite_count' => new Zend_Db_Expr('favourite_count - 1')), array('poll_id = ?' => $item_id));
            $item = Engine_Api::_()->getItem('sesadvpoll_poll', $item_id);
            Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'sesadvpoll_favourite_poll', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));

            Engine_Api::_()->getDbTable('actions', 'activity')->delete(array('type =?' => 'favourite_sesadvpoll_poll', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));

            Engine_Api::_()->getDbTable('actions', 'activity')->detachFromActivity($item);

            echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->favourite_count));
            $this->view->favourite_id = 0;
            die;
        } else {

            $db = $favTable->getAdapter();
            $db->beginTransaction();
            try {
                $fav = $favTable->createRow();
                $fav->user_id = $viewer->getIdentity();
                $fav->resource_type = 'sesadvpoll_poll';
                $fav->resource_id = $item_id;
                $fav->save();
                $favItem->update(array('favourite_count' => new Zend_Db_Expr('favourite_count + 1')), array('poll_id = ?' => $item_id));
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            $item = Engine_Api::_()->getItem('sesadvpoll_poll', $item_id);
            $owner = $item->getOwner();
            if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
              $activityTable = Engine_Api::_()->getDbTable('actions', 'activity');
              Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'sesadvpoll_favourite_poll', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $item, 'sesadvpoll_favourite_poll');
                $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $item, 'favourite_sesadvpoll_poll');
                if( $action != null ) {
                    Engine_Api::_()->getDbTable('actions', 'activity')->attachActivity($action, $item);
                }
            }
            $this->view->favourite_id = 1;
            echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->favourite_count, 'favourite_id' => 1));
            die;
        }
    }

    public function likeAction() {

        if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
            echo json_encode(array('status' => 'false', 'error' => 'Login'));
            die;
        }

        $item_id = $this->_getParam('id');
        if (intval($item_id) == 0) {
            echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
            die;
        }

        $viewer = Engine_Api::_()->user()->getViewer();

        $tableLike = Engine_Api::_()->getDbTable('likes', 'core');
        $tableMainLike = $tableLike->info('name');

        $itemTable = Engine_Api::_()->getDbTable('polls', 'sesadvpoll');

        $select = $tableLike->select()->from($tableMainLike)->where('resource_type =?', 'sesadvpoll_poll')->where('poster_id =?', Engine_Api::_()->user()->getViewer()->getIdentity())->where('poster_type =?', 'user')->where('resource_id =?', $item_id);
        $Like = $tableLike->fetchRow($select);

        $item = Engine_Api::_()->getItem('sesadvpoll_poll', $item_id);

        if (count($Like) > 0) {
            $db = $Like->getTable()->getAdapter();
            $db->beginTransaction();
            try{
                $Like->delete();
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            $item = Engine_Api::_()->getItem('sesadvpoll_poll', $item_id);
            Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'sesadvpoll_like_poll', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
            Engine_Api::_()->getDbTable('actions', 'activity')->delete(array('type =?' => 'like_sesadvpoll_poll', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
            Engine_Api::_()->getDbTable('actions', 'activity')->detachFromActivity($item);
            echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->like_count));
            die;
        } else {
            $db = Engine_Api::_()->getDbTable('likes', 'core')->getAdapter();
            $db->beginTransaction();
            try {
                $like = $tableLike->createRow();
                $like->poster_id = $viewer->getIdentity();
                $like->resource_type = 'sesadvpoll_poll';
                $like->resource_id = $item_id;
                $like->poster_type = 'user';
                $like->save();
                $itemTable->update(array('like_count' => new Zend_Db_Expr('like_count + 1')), array('poll_id = ?' => $item_id));
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            $item = Engine_Api::_()->getItem('sesadvpoll_poll', $item_id);
            $owner = $item->getOwner();
            if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
                Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'sesadvpoll_like_poll', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
                Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $item, 'sesadvpoll_like_poll');
                $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $item, 'like_sesadvpoll_poll');
                if( $action != null ) {
                    Engine_Api::_()->getDbTable('actions', 'activity')->attachActivity($action, $item);
                }
            }
            echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->like_count));
            die;
        }
    }

    public function deleteAction(){

        $viewer = Engine_Api::_()->user()->getViewer();
        $poll = Engine_Api::_()->getItem('sesadvpoll_poll', $this->getRequest()->getParam('poll_id'));

        if( !$this->_helper->requireAuth()->setAuthParams('sesadvpoll_poll', $viewer, 'delete')->isValid())
            return;

        $this->_helper->layout->setLayout('default-simple');
        $this->view->form = $form = new Sesadvpoll_Form_Delete();
        if( !$poll ) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_("Poll doesn't exist or not authorized to delete");
            return;
        }

        if( !$this->getRequest()->isPost() ) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
            return;
        }

        $db = $poll->getTable()->getAdapter();
        $db->beginTransaction();
        try {
            $poll->delete();
            $db->commit();
        } catch( Exception $e ) {
            $db->rollBack();
            throw $e;
        }

        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your poll has been deleted.');
        return $this->_forward('success' ,'utility', 'core', array(
            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'home'), 'sesadvpoll_general', true),
            'messages' => Array($this->view->message)
        ));
    }

    public function editAction() {

        $this->_helper->content->setEnabled();

        if( !$this->_helper->requireUser()->isValid())
            return;

        if( !$this->_helper->requireSubject()->isValid())
            return;

        if( !$this->_helper->requireAuth()->setAuthParams('sesadvpoll_poll', null, 'edit')->isValid())
            return;

        // Setup
        $viewer = Engine_Api::_()->user()->getViewer();
        $this->view->poll = $poll = Engine_Api::_()->core()->getSubject('sesadvpoll_poll');
        $this->view->poll_options = $poll_options = $poll->optionsFetchAll();
        $this->view->maxOptions = $max_options = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvpoll.maxoptions', 15);

        // Get form
        $this->view->form = $form = new Sesadvpoll_Form_Edit();
        $form->getElement('title')->setValue($poll->title);
        $form->getElement('description')->setValue($poll->description);

        // Prepare privacy
        $auth = Engine_Api::_()->authorization()->context;
        $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

        // Populate form with current settings
        $form->search->setValue($poll->search);

        foreach( $roles as $role ) {
            if( 1 === $auth->isAllowed($poll, $role, 'view') ) {
                $form->auth_view->setValue($role);
            }

            if( 1 === $auth->isAllowed($poll, $role, 'comment') ) {
                $form->auth_comment->setValue($role);
            }
        }

        // Check method/valid
        if( !$this->getRequest()->isPost())
            return ;

        if( !$form->isValid($this->getRequest()->getPost()) ) {
            return ;
            echo json_encode(array('status' => 'false', 'error' => '1', 'message' => 'Form Validation Error.'));
            die;
        }

        // options process
        $options = (array) $this->_getParam('optionsArray');
        $optionsCount = count($options);
        $ids = (array) $this->_getParam('optionIds');
        $isOptionImage = 0;
        $options = array_filter(array_map('trim', $options));
        $options = array_slice($options, 0, $max_options);

        if( empty($options) || !is_array($options) || count($options) < 2 ) {
            echo json_encode(array('status' => 'false', 'error' => '1', 'message' => 'You must provide at least two possible answers.'));
            die;
        }

        foreach( $options as $index => $option ) {
            if( strlen($option) > 300 ) {
                $options[$index] = Engine_String::substr($option, 0, 300);
            }
        }

        $pollTable = Engine_Api::_()->getItemTable('sesadvpoll_poll');
        $pollOptionsTable = Engine_Api::_()->getDbTable('options', 'sesadvpoll');
        $getoptionIds = $pollOptionsTable->select()
                                        ->from($pollOptionsTable, '*')
                                        ->where('poll_id = ?', $poll->getIdentity())
                                        ->query()
                                        ->fetchAll();

        $getoptionIdsCounter = 0;
        foreach($getoptionIds as $index=>$value){
            $getoptionIdsArray[$getoptionIdsCounter] = $value['poll_option_id'];
            $getoptionTextArray[$getoptionIdsCounter] = $value['poll_option'];
            $getoptionIdsCounter ++;
        }

        $IdsDiffrence=array_diff($getoptionIdsArray,$ids);
        if(!empty($IdsDiffrence)) {
            foreach($IdsDiffrence as $index=>$value){
                $diffItem = $optionItem = Engine_Api::_()->getItem('sesadvpoll_option', $value);
                if(!empty($diffItem)) {
                    $option_file_id = $diffItem->file_id;
                    if($option_file_id && $diffItem->image_type != 2){
                        $fileobj = Engine_Api::_()->getItem('storage_file', $option_file_id);
                        $fileobj->remove();
                    }
                    $diffItem->delete();
                }
            }
        }

        if($this->getParam('is_image_delete',0)==1) {
            foreach($ids as $k=>$value) {
                $Item = Engine_Api::_()->getItem('sesadvpoll_option', $value);
                if($Item){
                    $fileobj = Engine_Api::_()->getItem('storage_file', $Item->file_id);
                    if ($fileobj) {
                        if($Item->image_type == 1)
                            $fileobj->remove();
                        $pollOptionsTable->update(
                            array('poll_option' => $options[$k], 'file_id' => 0, 'image_type' => 0),
                            array('`poll_option_id` = ?' => $value));
                        $fileobj = null;
                    }
                }
            }
        }

        $dbOptn = $pollTable->getAdapter();
        $dbOptn->beginTransaction();
        $storage = Engine_Api::_()->getItemTable('storage_file');
        $censor = new Engine_Filter_Censor();
        $html = new Engine_Filter_Html(array('AllowedTags'=> array('a')));
        $counter = 0;
        try {
            foreach($options as $optionKey=>$optionValue) {
                $optionItem = Engine_Api::_()->getItem('sesadvpoll_option', $ids[$optionKey]);
                $pollOptn = $censor->filter($html->filter($optionValue));
                if(!empty($optionItem)){
                $optionItemArray = $optionItem->toArray();
                $fileobj = Engine_Api::_()->getItem('storage_file', $optionItemArray['file_id']);
                $image_type = 0;
                if (!empty($_FILES['optionsImage']['name'][$optionKey])) {
                    if($optionItemArray['file_id'] && $optionItemArray['image_type'] != 2 ){
                    if ($fileobj) {
                        $fileobj->remove();
                    }
                    }
                    $file['tmp_name'] = $_FILES['optionsImage']['tmp_name'][$optionKey];
                                $file['name'] = $_FILES['optionsImage']['name'][$optionKey];
                                $file['size'] = $_FILES['optionsImage']['size'][$optionKey];
                                $file['error'] = $_FILES['optionsImage']['error'][$optionKey];
                                $file['type'] = $_FILES['optionsImage']['type'][$optionKey];
                    $image_type = 1;
                } elseif(!empty($_POST['optionsGif'][$optionKey])){
                    $file =$_POST['optionsGif'][$optionKey];
                    $image_type = 2;
                }
                if (@$file && $image_type == 1) {
                    $thumbname = $storage->createFile($file, array(
                                    'parent_id' => $poll->getIdentity(),
                                    'parent_type' => 'sesadvpoll_poll',
                                    'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
                    ));
                    $file_id = $thumbname->file_id;
                    $pollOptionsTable->update(
                    array('poll_option' => $pollOptn, 'file_id' => $file_id, 'image_type' => $image_type),
                    array('`poll_option_id` = ?' => $ids[$optionKey]));
                                    $file = null;
                }else if ($file && $image_type ==2) {
                                $file_id = count($file)>0 ? $file :0;
                    $pollOptionsTable->update(
                                array('poll_option' => $pollOptn, 'file_id' => $file_id, 'image_type' => $image_type),
                                array('`poll_option_id` = ?' => $ids[$optionKey]));
                    $file = null;
                } else {
                    $pollOptionsTable->update(
                                array('poll_option' => $optionValue),
                                array('`poll_option_id` = ?' => $ids[$optionKey]));
                    $file = null;
                }
                }else{
                $file_id = 0;
                $image_type= 0;
                if(!empty($_FILES['optionsImage']['name'][$optionKey])){
                    $file['tmp_name'] = $_FILES['optionsImage']['tmp_name'][$optionKey];
                    $file['name'] = $_FILES['optionsImage']['name'][$optionKey];
                    $file['size'] = $_FILES['optionsImage']['size'][$optionKey];
                    $file['error'] = $_FILES['optionsImage']['error'][$optionKey];
                    $file['type'] = $_FILES['optionsImage']['type'][$optionKey];
                    $image_type = 1;
                }elseif(!empty($_POST['optionsGif'][$optionKey])){
                $file = $_POST['optionsGif'][$optionKey];
                    $image_type = 2;
                }
                if($file && $image_type == 1 ){
                    $thumbname = $storage->createFile($file, array(
                    'parent_id' => $poll->getIdentity(),
                    'parent_type' => 'sesadvpoll_poll',
                    'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
                    ));
                    $file_id = $thumbname->file_id;
                }
                if($image_type == 2){
                    $file_id = count($file)>0 ?  $file : 0;
                }
                $pollOptionsTable->insert(array(
                    'poll_id' => $poll->getIdentity(),
                    'poll_option' => $pollOptn,
                    'file_id'=>$file_id,
                    'image_type'=>$image_type
                ));
                $file = null;
                }
            }
            $dbOptn->commit();
        } catch( Exception $e ) {
            $dbOptn->rollback();
            throw $e;
        }

        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            $values = $form->getValues();
            // CREATE AUTH STUFF HERE
            if( empty($values['auth_view']) ) {
                $values['auth_view'] = 'everyone';
            }
            if( empty($values['auth_comment']) ) {
                $values['auth_comment'] = 'everyone';
            }
            $viewMax = array_search($values['auth_view'], $roles);
            $commentMax = array_search($values['auth_comment'], $roles);
            foreach( $roles as $i => $role ) {
                $auth->setAllowed($poll, $role, 'view', ($i <= $viewMax));
                $auth->setAllowed($poll, $role, 'comment', ($i <= $commentMax));
            }
            $poll->title = $values['title'];
            $poll->description = $values['description'];
            $poll->search = (bool) $values['search'];
            $poll->view_privacy = $values['auth_view'];
            $poll->save();
            $db->commit();
        } catch( Exception $e ) {
            $dbOptn->rollBack();
            $db->rollBack();
            throw $e;
        }

        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            // Rebuild privacy
            $actionTable = Engine_Api::_()->getDbTable('actions', 'activity');
            foreach( $actionTable->getActionsByObject($poll) as $action ) {
                $actionTable->resetActivityBindings($action);
            }
            $db->commit();
        } catch( Exception $e ) {
            $db->rollBack();
            throw $e;
        }
        $pollid = $poll->getIdentity();
        echo json_encode(array('status' => 'true', 'error' => '','id'=>$pollid, 'condition' => 'increment'));
        die;
    }

    public function viewAction() {

        // Check auth
        if( !$this->_helper->requireSubject('sesadvpoll_poll')->isValid())
            return;

        if( !$this->_helper->requireAuth()->setAuthParams(null, null, 'view')->isValid())
            return;

        $this->_helper->content->setEnabled();
    }

    public function voteAction() {

        if( !$this->_helper->requireUser()->isValid())
            return;

        if( !$this->_helper->requireSubject()->isValid())
            return;

        if( !$this->_helper->requireAuth()->setAuthParams(null, null, 'view')->isValid())
            return;

        // Check method
        if( !$this->getRequest()->isPost())
            return;

        $option_id = $this->_getParam('option_id');
        $canChangeVote = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvpoll.canchangevote', false);

        $poll = Engine_Api::_()->core()->getSubject('sesadvpoll_poll');
        $viewer = Engine_Api::_()->user()->getViewer();
        if( !$poll ) {
            $this->view->success = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('This poll does not seem to exist anymore.');
            return;
        }

        $hashElement = $this->view->sesadvpollVoteHash($poll)->getElement();
        if( $poll->closed ) {
            $this->view->success = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('This poll is closed.');
            return;
        }

        if( $poll->hasVoted($viewer) && !$canChangeVote ) {
            $this->view->success = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('You have already voted on this poll, and are not permitted to change your vote.');
            return;
        }

        $owner = $poll->getOwner();
        $db = Engine_Api::_()->getDbTable('polls', 'sesadvpoll')->getAdapter();
        $db->beginTransaction();
        try {
            $poll->vote($viewer,$option_id,$owner,$poll);
            $db->commit();
        } catch( Exception $e ) {
            $db->rollback();
            $this->view->success = false;
            throw $e;
        }

        $this->view->token = $this->view->sesadvpollVoteHash($poll)->generateHash();
        $this->view->success = true;
        $pollOptions = array();
        $counter = 0;
        $htmlData = array();

        foreach( $poll->getOptions()->toArray() as $option ) {

            $option['votesTranslated'] = $this->view->translate(array('%s vote', '%s votes', $option['votes']), $this->view->locale()->toNumber($option['votes']));
            $pollOptions[] = $option;

            // user image
            $tables = Engine_Api::_()->getDbTable('votes', 'sesadvpoll')->getVotesPaginator($option['poll_option_id'])->setItemCountPerPage(5)->setCurrentPageNumber(1);
            $pagecount = $tables->getPages()->pageCount;
            $htmlData[$counter] = "";
            foreach($tables as $table) {
                $user = Engine_Api::_()->getItem('user', $table->user_id);
                if($user->getPhotoUrl('thumb.normal')){
                    $htmlData[$counter] .=	"<div><a href='".$user->getHref()."'><span class='bg_item_photo' style='background-image:url(".$user->getPhotoUrl('thumb.normal')."'></span></a></div>";
                }
            }
            if($pagecount >1 ){
                $htmlData[$counter] .= "<div><a class='more_user' id='".$option['poll_option_id']."'><i class='fa fa-ellipsis-h'></i></a></div>";
            }
            $counter++;
        }

        $this->view->users = ($htmlData);
        $this->view->pollOptions = $pollOptions;
        $this->view->votes_total = $poll->vote_count;
    }

    public function moreAction() {

        if($optionId = $this->_getParam('option_id'))
            $option = Engine_Api::_()->getItem('sesadvpoll_option', $this->_getParam('option_id'));

        if(!$option)
            return;

        $this->view->moreuser = $optionUserObj = Engine_Api::_()->getDbTable('votes', 'sesadvpoll')->getVotesPaginator
        ($option->poll_option_id);
    }
}
