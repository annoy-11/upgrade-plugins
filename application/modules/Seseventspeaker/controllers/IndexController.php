<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seseventspeaker_IndexController extends Core_Controller_Action_Standard {

  public function init() {

    if (!$this->_helper->requireAuth()->setAuthParams('sesevent_event', null, 'view')->isValid())
      return;

    if (!$this->_helper->requireUser->isValid())
      return;

    $speaker_id = $this->_getParam('speaker_id', null);
		
    if ($speaker_id) {
      $speakers = Engine_Api::_()->getItem('seseventspeaker_speakers', $speaker_id);
      if ($speakers)
        Engine_Api::_()->core()->setSubject($speakers);
     /* else
        return $this->_forward('requireauth', 'error', 'core');*/
    } 
		
    //else
	    //return $this->_forward('requireauth', 'error', 'core');
  }
  
  public function browseAction() {
    //Render
    $this->_helper->content->setEnabled();
  }
  
  public function viewAction() {
  
    $subject_id = Engine_Api::_()->core()->getSubject()->getIdentity();
    Engine_Api::_()->getDbtable('speakers', 'seseventspeaker')->update(array(
        'view_count' => new Zend_Db_Expr('view_count + 1'),
      ), array(
        'speaker_id = ?' => $subject_id,
      ));
    //Render
    $this->_helper->content->setEnabled();
  }
  
  public function speakersAction() {
  
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $id = $this->_getParam('event_id', null);
    $event_id = Engine_Api::_()->getDbtable('events', 'sesevent')->getEventId($id);
    $this->view->event = $event = Engine_Api::_()->getItem('event', $event_id); 
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('eventspeakers', 'seseventspeaker')->getSpeakerMemers(array('event_id' => $event->event_id));
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

  }
  
  public function addAdminSpeakerAction() {
  
    $id = $this->_getParam('event_id', null);
    $event_id = Engine_Api::_()->getDbtable('events', 'sesevent')->getEventId($id);
    $this->view->event = $event = Engine_Api::_()->getItem('event', $event_id); 
    $this->view->event_id = $event_id = $event->getIdentity();
    
    $this->view->type = $type = $this->_getParam('type', null);

    //Render Form
    $this->view->form = $form = new Seseventspeaker_Form_AddEventAdminSpeaker();
    if($type == 'admin')
	    $form->setTitle('Add Admin Created Speaker');
    else if($type == 'sitemember')
	    $form->setTitle('Add Site Member as Speaker');
	  else if($type == 'eventspeaker')
	    $form->setTitle('Add Speaker');

    $form->button->setLabel('Add');

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
    
      $values = $form->getValues();
      if(empty($values['speaker_id'])) {
        $error = Zend_Registry::get('Zend_Translate')->_("Please select value from autosuggest.");
        $form->getDecorator('errors')->setOption('escape', false);
        $form->addError($error);
        return;
      }

      $eventspeakers_table = Engine_Api::_()->getDbtable('eventspeakers', 'seseventspeaker');
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $values = $form->getValues();
	      if($type == 'sitemember') {
		      $speaker_id = Engine_Api::_()->getDbtable('speakers', 'seseventspeaker')->getSpeakerId(array('user_id' => $values['speaker_id']));
	        if(empty($speaker_id)) {
	        
		        $user = Engine_Api::_()->getItem('user', $values['speaker_id']);
	          $speakerTable = Engine_Api::_()->getDbtable('speakers', 'seseventspeaker');
						$rowe = $speakerTable->createRow();
						$valuese['type'] = $type;
						$valuese['enabled'] = 1;
						$valuese['user_id'] = $values['speaker_id'];
						$valuese['name'] = $user->displayname;
						$valuese['email'] = $user->email;
						$rowe->setFromArray($valuese);
						$rowe->save();
						
						$speaker_id = $rowe->speaker_id;
	        }
	      }
        
        $row = $eventspeakers_table->createRow();
        $values['event_id'] = $event_id;
        if($type == 'admin')
	        $values['type'] = 'admin';
        elseif($type == 'sitemember')
	        $values['type'] = 'sitemember';
	      elseif($type == 'eventspeaker')
	        $values['type'] = 'eventspeaker';
	      if($speaker_id)
	      $values['speaker_id'] = $speaker_id; 
	      $row->setFromArray($values);
	      $row->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully add admin speakers.'))
      ));
    }
  
  }
  
  //Add new team member using auto suggest
  public function getadminspeakersAction() {

    $sesdata = array();
    $type = $this->_getParam('type', null);
    $event_id = $this->_getParam('event_id', null);

    if($type == 'admin') {
	    $table = Engine_Api::_()->getDbtable('speakers', 'seseventspeaker');
	    $id = 'speaker_id';
	    $name = 'name';
	    $addedSpeakerIds = Engine_Api::_()->getDbtable('eventspeakers', 'seseventspeaker')->getEventAddedAdminSpeakers(array('event_id' => $event_id, 'type' => 'admin')); 
	    
    } elseif($type == 'sitemember') {
	    $table = Engine_Api::_()->getDbtable('users', 'user');
	    $id = 'user_id';
	    $name = 'displayname';
	    $addedSpeakerIds = Engine_Api::_()->getDbtable('eventspeakers', 'seseventspeaker')->getEventAddedAdminSpeakers(array('event_id' => $event_id, 'type' => 'sitemember'));
	    if($addedSpeakerIds)
	    $addedSiteSpeakerIds = Engine_Api::_()->getDbtable('speakers', 'seseventspeaker')->getEventAddedSiteMemberSpeakers(array('speaker_id' => $addedSpeakerIds, 'type' => 'sitemember'));
    } elseif($type == 'eventspeaker') {
	    $table = Engine_Api::_()->getDbtable('speakers', 'seseventspeaker');
	    $id = 'speaker_id';
	    $name = 'name';
	    $addedSpeakerIds = Engine_Api::_()->getDbtable('eventspeakers', 'seseventspeaker')->getEventAddedAdminSpeakers(array('event_id' => $event_id, 'type' => 'eventspeaker'));
	    $speakerIds = Engine_Api::_()->getDbtable('eventspeakers', 'seseventspeaker')->getEventCreatedSpeakers();
	    $speakerIdsarray = array();
	    foreach($speakerIds as $speakerId) {
		    $speakerIdsarray[] = $speakerId->speaker_id;
	    }
    }

    $select = $table->select()
                    ->where("$name  LIKE ? ", '%' . $this->_getParam('text') . '%')
                    ->order("$name ASC")
                    ->limit('40');
    if(@$speakerIdsarray) {
	    $select = $select->where('speaker_id IN(?)', $speakerIdsarray);
    }
    
    if($type == 'admin') {
	    $select = $select->where('enabled =?', 1)
										  ->where('type =?', 'admin');
			if($addedSpeakerIds) 
				$select = $select->where('speaker_id NOT IN (?)', $addedSpeakerIds);
    }
    if($type == 'eventspeaker') {
	    $select = $select->where('type =?', 'eventspeaker');
	    if($addedSpeakerIds)
		    $select = $select->where('speaker_id NOT IN(?)', $addedSpeakerIds);
    }
    
    if($type == 'sitemember' && count($addedSiteSpeakerIds)) {
	    $select = $select->where('user_id NOT IN(?)', $addedSiteSpeakerIds);
    }

   
    $users = $table->fetchAll($select);

    foreach ($users as $user) {
      $user_icon_photo = $this->view->itemPhoto($user, 'thumb.icon');
      $sesdata[] = array(
          'id' => $user->$id,
          'label' => $user->$name,
          'photo' => $user_icon_photo
      );
    }
    return $this->_helper->json($sesdata);
  }
  
  //Enable Action
  public function enabledAction() {
    
    $event_id = Engine_Api::_()->getDbtable('events', 'sesevent')->getEventId($this->_getParam('event_id', null));
    $this->view->event = $event = Engine_Api::_()->getItem('event', $event_id); 
    $id = $this->_getParam('eventspeaker_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('seseventspeaker_eventspeakers', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('events/dashboard/speakers/' . $event->getSlug());
  }
  
  public function deleteSpeakerAction() {
		
		$type = $this->_getParam('type');
    if ($this->getRequest()->isPost()) {

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        Engine_Api::_()->getDbtable('eventspeakers', 'seseventspeaker')->delete(array('eventspeaker_id =?' => $this->_getParam('eventspeaker_id')));
        if($type == 'eventspeaker')
	        Engine_Api::_()->getDbtable('speakers', 'seseventspeaker')->delete(array('speaker_id =?' => $this->_getParam('speaker_id')));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully removed speaker entry.'))
      ));
    }
    $this->renderScript('index/delete-speaker.tpl');
  }
  
  public function addEventsSpeakerAction() {

    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    $event_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('event_id');
		$viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    //Render Form
    $this->view->form = $form = new Seseventspeaker_Form_AddEventSpeaker();
    $form->setDescription("Here, you can add details for the new speaker to be added to your event and enter various information about the speaker like Photo, Description, Email, Social URLs, etc.");

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $speakerTable = Engine_Api::_()->getDbtable('speakers', 'seseventspeaker');
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $values = $form->getValues();
        if (!$values['photo_id'])
          $values['photo_id'] = 0;
        $row = $speakerTable->createRow();
        $values['type'] = $type;
        $values['enabled'] = 1;
       // $values['owner_id'] = $viewer_id; 
        $row->setFromArray($values);
        $row->save();
        if (isset($_FILES['photo_id']) && $values['photo_id']) {
          $photo = $this->setEventSpeakerPhoto($form->photo_id, array('speaker_id' => $row->speaker_id));
          if (!empty($photo))
            $row->photo_id = $photo;
          $row->save();
        }
        $db->commit();

        $db->query('INSERT INTO `engine4_seseventspeaker_eventspeakers` (`speaker_id`, `event_id`, `type`, `enabled`, `owner_id`) VALUES ("'.$row->speaker_id.'", "'.$event_id.'", "'.$type.'", 1, "'.$viewer_id.'");');

	      $this->_forward('success', 'utility', 'core', array(
	          'smoothboxClose' => 10,
	          'parentRefresh' => 10,
	          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully create speaker in your event.'))
	      ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }

  public function editEventsSpeakerAction() {

    $speaker = Engine_Api::_()->getItem('seseventspeaker_speakers', $this->_getParam('speaker_id'));

    $form = $this->view->form = new Seseventspeaker_Form_EditEventSpeaker();
    
    $form->setDescription("Here, you can add details for the speaker to be added to your website and enter various information about the speaker member like Photo, Description, Email, Social URLs, etc.");
    $form->button->setLabel('Save Changes');
    $form->populate($speaker->toArray());

    //Check post
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      if (empty($values['photo_id']))
        unset($values['photo_id']);
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {

        $speaker->setFromArray($values);
        $speaker->save();

        if (isset($_FILES['photo_id']) && !empty($_FILES['photo_id']['name'])) {
          $previousCatIcon = $speaker->photo_id;
          $photo = $this->setEventSpeakerPhoto($form->photo_id, array('speaker_id' => $speaker->speaker_id));
          if (!empty($photo)) {
            if ($previousCatIcon) {
              $catIcon = Engine_Api::_()->getItem('storage_file', $previousCatIcon);
              if ($catIcon)
                $catIcon->delete();
            }
            $speaker->photo_id = $photo;
            $speaker->save();
          }
        }
        if (isset($values['remove_profilecover']) && !empty($values['remove_profilecover'])) {
          $storage = Engine_Api::_()->getItem('storage_file', $speaker->photo_id);
          $speaker->photo_id = 0;
          $speaker->save();
          if ($storage)
            $storage->delete();
        }
        $db->commit();
        $this->_forward('success', 'utility', 'core', array(
	          'smoothboxClose' => 10,
	          'parentRefresh' => 10,
	          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully create speaker in your event.'))
	      ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }
  public function setEventSpeakerPhoto($photo, $param = null) {

    if ($photo instanceof Zend_Form_Element_File)
      $file = $photo->getFileName();
    else if (is_array($photo) && !empty($photo['tmp_name']))
      $file = $photo['tmp_name'];
    else if (is_string($photo) && file_exists($photo))
      $file = $photo;
    else
      throw new Core_Model_Exception('Invalid argument passed to setPhoto: ' . print_r($photo, 1));

    $name = basename($file);
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => 'seseventspeaker_speaker',
        'parent_id' => $param['speaker_id']
    );

    //Save
    $storage = Engine_Api::_()->storage();
    if ($param == 'mainPhoto') {
      $image = Engine_Image::factory();
      $image->open($file)
              ->resize(500, 500)
              ->write($path . '/m_' . $name)
              ->destroy();
    } else {
      $image = Engine_Image::factory();
      $image->open($file)
              ->resize(1600, 1600)
              ->write($path . '/m_' . $name)
              ->destroy();
    }
    //Resize image (icon)
    $image = Engine_Image::factory();
    $image->open($file);
    $size = min($image->height, $image->width);
    $x = ($image->width - $size) / 2;
    $y = ($image->height - $size) / 2;
    $image->resample($x, $y, $size, $size, 48, 48)
            ->write($path . '/is_' . $name)
            ->destroy();

    //Store
    $iMain = $storage->create($path . '/m_' . $name, $params);
    $iSquare = $storage->create($path . '/is_' . $name, $params);

    $iMain->bridge($iMain, 'thumb.profile');
    $iMain->bridge($iSquare, 'thumb.icon');

    //Remove temp files
    @unlink($path . '/m_' . $name);
    @unlink($path . '/is_' . $name);

    $photo_id = $iMain->getIdentity();
    return $photo_id;
  }
}
