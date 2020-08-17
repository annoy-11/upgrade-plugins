<?php

class Sesgroupalbum_IndexController extends Core_Controller_Action_Standard
{

  public function homeAction() {
    if (!$this->_helper->requireAuth()->setAuthParams('sesgroupalbum_album', null, 'view')->isValid())
      return;
    //Render
    $this->_helper->content->setEnabled();
  }
	// album browse action.
  public function browseAction() {
    if (!$this->_helper->requireAuth()->setAuthParams('sesgroupalbum_album', null, 'view')->isValid()) {
      return;
    }
    // Render
    $this->_helper->content->setEnabled();
  }
  	//make Album/Photo as off the day
	public function offthedayAction(){
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('album_id');
    if(empty($id))
    $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $param = $this->_getParam('param');
    $this->view->form = $form = new Sesgroupalbum_Form_Admin_Oftheday();
    if ($type == 'sesgroupalbum_album') {
      $item = Engine_Api::_()->getItem('sesgroupalbum_album', $id);
      $form->setTitle("Album of the Day");
      $form->setDescription('Here, choose the start date and end date for this  album to be displayed as "Album of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as  Album of the Day");
      $table = 'engine4_group_albums';
      $item_id = 'album_id';
    } elseif ($type == 'sesgroupalbum_photo') {
      $item = Engine_Api::_()->getItem('sesgroupalbum_photo', $id);
      $form->setTitle("Photo of the Day");
      if (!$param)
        $form->remove->setLabel("Remove as Photo of the Day");
      $form->setDescription('Here, choose the start date and end date for this photo to be displayed as "Photo of the Day".');
      $table = 'engine4_group_photos';
      $item_id = 'photo_id';
    }

    if (!empty($id))
      $form->populate($item->toArray());
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost())) 
        return;
      $values = $form->getValues();
      $values['starttime'] = date('Y-m-d',  strtotime($values['starttime']));
      $values['endtime'] = date('Y-m-d', strtotime($values['endtime']));
      $db->update($table, array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array("$item_id = ?" => $id));
      if (isset($values['remove']) && $values['remove']) {
        $db->update($table, array('offtheday' => 0), array("$item_id = ?" => $id));
      } else {
        $db->update($table, array('offtheday' => 1), array("$item_id = ?" => $id));
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Successfully updated the item.')
      ));
    }
	}
		//make Album/Photo as sponsored.
	public function sponsoredAction(){
		$this->view->params = $params = $this->_getParam('type');
		if($params == 'photos'){
			$this->view->id = $id = $this->_getParam('photo_id');
			$item = Engine_Api::_()->getItem('sesgroupalbum_photo', $id);
		}else{
			$this->view->id = $id = $this->_getParam('album_id');
			$item = Engine_Api::_()->getItem('sesgroupalbum_album', $id);
		}
		if($item->is_sponsored == 1)
			$status = 0;
		else
			$status = 1;
		 // Check post
    if( $this->getRequest()->isPost())
    {
			$item->is_sponsored = $status;
			$item->save();
			echo $status;die;
		}
		echo "error";die;
	}
	//make Album/Photo as featured.
	public function featuredAction(){
		$this->view->params = $params = $this->_getParam('type');
		if($params == 'photos'){
			$this->view->id = $id = $this->_getParam('photo_id');
			$item = Engine_Api::_()->getItem('sesgroupalbum_photo', $id);
		}else{
			$this->view->id = $id = $this->_getParam('album_id');
			$item = Engine_Api::_()->getItem('sesgroupalbum_album', $id);
		}
		if($item->is_featured == 1)
			$status = 0;
		else
			$status = 1;
		 // Check post
    if( $this->getRequest()->isPost())
    {
			$item->is_featured = $status;
			$item->save();
			echo $status;die;
		}
		echo "error";die;
	}
  	 //ACTION FOR PHOTO DELETE
  public function removeAction() {
			if(empty($_POST['photo_id']))
				die('error');
      //GET PHOTO ID AND ITEM
			$photo_id = (int) $this->_getParam('photo_id');
	    $photo = Engine_Api::_()->getItem('sesgroupalbum_photo', $photo_id);
      $db = Engine_Api::_()->getDbTable('photos', 'sesgroupalbum')->getAdapter();
      $db->beginTransaction();
      try {
        $photo->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
  }
	//get images as per album id (advance lightbox)
	public function correspondingImageAction(){
		$album_id = $this->_getParam('album_id', false);
		$this->view->paginator = $paginator = Engine_Api::_()->getDbtable('photos', 'sesgroupalbum')->getPhotoSelect(array('album_id'=>$album_id,'limit_data'=>100));
	}
		 public function editPhotoAction() {
    $this->view->photo_id = $photo_id = $this->_getParam('photo_id');
		$this->view->photo = Engine_Api::_()->getItem('sesgroupalbum_photo', $photo_id);
  }
  	//edit photo details from light function.
	 public function saveInformationAction() {
    $photo_id = $this->_getParam('photo_id');
    $title = $this->_getParam('title', null);
    $description = $this->_getParam('description', null);
		$location = $this->_getParam('location',null);
		if (($this->_getParam('lat')) && ($this->_getParam('lng')) && $this->_getParam('lat','') != '' && $this->_getParam('lng','')!= '') {
        $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $photo_id . '", "' . $this->_getParam('lat') . '","' . $this->_getParam('lng') . '","sesgroupalbum_album")	ON DUPLICATE KEY UPDATE	lat = "' . $this->_getParam('lat') . '" , lng = "' . $this->_getParam('lng') . '"');
      }
    Engine_Api::_()->getDbTable('photos', 'segroupsalbum')->update(array('title' => $title, 'description' => $description,'location'=>$location), array('photo_id = ?' => $photo_id));
  }
  	//download album/photo function.
	public function downloadAction(){
		$photo =  $this->_getParam('type',false);
		if(!$photo){
			$album_id = $this->_getParam('album_id',false);
			if(!$album_id)
				return;
		}else if($photo == 'sesvideo_chanelphoto'){
			$chanelphoto_id = $this->_getParam('photo_id',false);
			if(!$chanelphoto_id)
				return;		
		}else{
			$photo_id = $this->_getParam('photo_id',false);
			if(!$photo_id)
				return;	
			
		}
		$viewer = Engine_Api::_()->user()->getViewer();
		$canDownload = Engine_Api::_()->authorization()->isAllowed('sesgroupalbum_album',$viewer, 'download');
		if(!$canDownload)
			return $this->_forward('requireauth', 'error', 'core');
    $user_id = $viewer->getIdentity();
		# create new zip opbject
			$zip = new ZipArchive();			
			# create a temp file & open it
			$tmp_file = tempnam('.','');
			$zip->open($tmp_file, ZipArchive::CREATE);
			# loop through each file
		if(isset($album_id)){
			$album = Engine_Api::_()->getItem('sesgroupalbum_album', $album_id);
			$album->download_count = new Zend_Db_Expr('download_count + 1');
      $album->save();
			$paginator = Engine_Api::_()->getDbTable('photos', 'sesgroupalbum')->getPhotoSelect(array('album_id' =>$album_id));
			$counter = 0;
			foreach($paginator as $file)
			{ 
				$counter++;
				$name = Engine_Api::_()->getItem('storage_file', $file->file_id)->name;
				if(strpos($file->getPhotoUrl('thumb.main'),'http') === FALSE){
					$file = (!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on' ? "https://" : "http://").$_SERVER['HTTP_HOST'].'/'.$file->getPhotoUrl();
				}else{
					$file = $file->getPhotoUrl();
				}
				$download_file = file_get_contents($file);
				$zip->addFromString($name,$download_file);
				//$zip->addFile($url,$new_filename); 
			}
			$downloadfilename = substr($album->title,0,10);
		}else{
			if(!isset($chanelphoto_id)){
				$photo = Engine_Api::_()->getItem('sesgroupalbum_photo', $photo_id);	
				$photo->download_count = new Zend_Db_Expr('download_count + 1');
				$photo->save();
			}else{
				$photo = Engine_Api::_()->getItem($photo, $chanelphoto_id);	
			}
				if(strpos($photo->getPhotoUrl('thumb.main'),'http') === FALSE){
					$file = (!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on' ? "https://" : "http://").$_SERVER['HTTP_HOST'].'/'.$photo->getPhotoUrl();
				}else{
					$file = $photo->getPhotoUrl();
				}
				$download_file = file_get_contents($file);
				$name = explode('?',basename($file));
				$zip->addFromString($name[0],$download_file);
				$downloadfilename = Engine_Api::_()->getItem('storage_file', $photo->file_id)->name;
				$downloadfilename = explode('.',$downloadfilename);
				$downloadfilename = $downloadfilename[0];
				//$zip->addFile($url,$new_filename); 
		}
			# close zip
			$zip->close();
			# send the file to the browser as a download
			header('Content-disposition: attachment; filename='.urlencode(basename($downloadfilename)).'.zip');
			header('Content-type: application/zip');
			readfile($tmp_file);
			@unlink($tmp_file);
			die;
	}
	//rate album/photo function.
  public function rateAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $user_id = $viewer->getIdentity();

    $rating = $this->_getParam('rating');
    $resource_id = $this->_getParam('resource_id');
    $resource_type = $this->_getParam('resource_type');


    $table = Engine_Api::_()->getDbtable('ratings', 'sesgroupalbum');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try {
      Engine_Api::_()->getDbtable('ratings', 'sesgroupalbum')->setRating($resource_id, $user_id, $rating, $resource_type);
      if ($this->_getParam('resource_type') && $this->_getParam('resource_type') == 'sesgroupalbum_album'){
        $item = Engine_Api::_()->getItem('sesgroupalbum_album', $resource_id);
				$addachActivityType = 'sesgroupalbum_albumrated';
			}else{
        $item = Engine_Api::_()->getItem('sesgroupalbum_photo', $resource_id);
				$addachActivityType = 'sesgroupalbum_photorated';
			}

      $item->rating = Engine_Api::_()->getDbtable('ratings', 'sesgroupalbum')->getRating($item->getIdentity(), $resource_type);
      $item->save();
			//send notification to owner and user activity feed work.
			$viewer = Engine_Api::_()->user()->getViewer();
			$subject =$item;
			 $owner = $subject->getOwner();
			 if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
       
			$activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
			 Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $addachActivityType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $addachActivityType);
        $result = $activityTable->fetchRow(array('type =?' => $addachActivityType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $subject, $addachActivityType);
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }
		  }
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    $total = Engine_Api::_()->getDbtable('ratings', 'sesgroupalbum')->ratingCount($item->getIdentity(), $resource_type);
    $rating_sum = Engine_Api::_()->getDbtable('ratings', 'sesgroupalbum')->getSumRating($item->getIdentity(), $resource_type);

    $data = array();
		$totalTxt = $this->view->translate(array('%s rating', '%s ratings', $total), $total);
    $data[] = array(
        'total' => $total,
        'rating' => $rating,
				'totalTxt'=>str_replace($total,'',$totalTxt),
        'rating_sum' => $rating_sum
    );
    return $this->_helper->json($data);
  }
  
  //send message to site user function.
	public function messageAction(){
    // Make form
    $this->view->form = $form = new Sesgroupalbum_Form_Compose();
    // Get params
    $multi = $this->_getParam('multi');
    $to = $this->_getParam('to');
    $viewer = Engine_Api::_()->user()->getViewer();
    $toObject = null;
    // Build
    $isPopulated = false;
    if( !empty($to) && (empty($multi) || $multi == 'user') ) {
      $multi = null;
      // Prepopulate user
      $toUser = Engine_Api::_()->getItem('user', $to);
      $isMsgable = ( 'friends' != Engine_Api::_()->authorization()->getPermission($viewer, 'messages', 'auth') ||
          $viewer->membership()->isMember($toUser) );
      if( $toUser instanceof User_Model_User &&
          (!$viewer->isBlockedBy($toUser) && !$toUser->isBlockedBy($viewer)) &&
          isset($toUser->user_id) &&
          $isMsgable ) {
        $this->view->toObject = $toObject = $toUser;
        $form->toValues->setValue($toUser->getGuid());
        $isPopulated = true;
      } else {
        $multi = null;
        $to = null;
      }
    }
    $this->view->isPopulated = $isPopulated;
    // Assign the composing stuff
    $composePartials = array();
    // Get config
    $this->view->maxRecipients = $maxRecipients = 10;
    // Check method/data
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }
    // Process
    $db = Engine_Api::_()->getDbtable('messages', 'messages')->getAdapter();
    $db->beginTransaction();
    try {
      // Try attachment getting stuff
      $attachment = null;
			$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('album_id');
			if($id){
					$attachment = Engine_Api::_()->getItem('album', $id);
					$type = 'sesgroupalbum_album';
			}
			if(!$id){
				$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('photo_id');
				if($id){
					$type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type','sesgroupalbum_photo');
					$attachment = Engine_Api::_()->getItem($type, $id);
					$type = 'sesgroupalbum_photo';
				}
			}      
      $viewer = Engine_Api::_()->user()->getViewer();
      $values = $form->getValues();
			
      // Prepopulated
      if( $toObject instanceof User_Model_User ) {
        $recipientsUsers = array($toObject);
        $recipients = $toObject;
        // Validate friends
        if( 'friends' == Engine_Api::_()->authorization()->getPermission($viewer, 'messages', 'auth') ) {
          if( !$viewer->membership()->isMember($recipients) ) {
            return $form->addError('One of the members specified is not in your friends list.');
          }
        }
      } else if( $toObject instanceof Core_Model_Item_Abstract &&
          method_exists($toObject, 'membership') ) {
        $recipientsUsers = $toObject->membership()->getMembers();
        $recipients = $toObject;
      }
      // Normal
      else {
        $recipients = preg_split('/[,. ]+/', $values['toValues']);
        // clean the recipients for repeating ids
        // this can happen if recipient is selected and then a friend list is selected
        $recipients = array_unique($recipients);
        // Slice down to 10
        $recipients = array_slice($recipients, 0, $maxRecipients);
        // Get user objects
        $recipientsUsers = Engine_Api::_()->getItemMulti('user', $recipients);
        // Validate friends
        if( 'friends' == Engine_Api::_()->authorization()->getPermission($viewer, 'messages', 'auth') ) {
          foreach( $recipientsUsers as &$recipientUser ) {
            if( !$viewer->membership()->isMember($recipientUser) ) {
              return $form->addError('One of the members specified is not in your friends list.');
            }
          }
        }
      }

      // Create conversation
      $conversation = Engine_Api::_()->getItemTable('messages_conversation')->send(
        $viewer,
        $recipients,
        $values['title'],
        $values['body'],
        $attachment
      );

      // Send notifications
      foreach( $recipientsUsers as $user ) {
        if( $user->getIdentity() == $viewer->getIdentity() ) {
          continue;
        }
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification(
          $user,
          $viewer,
          $conversation,
          'message_new'
        );
      }

      // Increment messages counter
      Engine_Api::_()->getDbtable('statistics', 'core')->increment('messages.creations');

      // Commit
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    
    if( $this->getRequest()->getParam('format') == 'smoothbox' ) {
      return $this->_forward('success', 'utility', 'core', array(
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your message has been sent successfully.')),
        'smoothboxClose' => true,
      ));
    }
  	
	}
  	//share Album/photo function.
	public function shareAction(){
	
    if( !$this->_helper->requireUser()->isValid() ) return;
    
    $type = $this->_getParam('type');
    $id = $this->_getParam('photo_id');    

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->attachment = $attachment = Engine_Api::_()->getItem($type, $id);
    $this->view->form = $form = new Sesgroupalbum_Form_Share();

    if( !$attachment ) {
      // tell smoothbox to close
      $this->view->status  = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('You cannot share this item because it has been removed.');
      $this->view->smoothboxClose = true;
      //return $this->render('deletedItem');
    }
    // hide facebook and twitter option if not logged in
    $facebookTable = Engine_Api::_()->getDbtable('facebook', 'user');
    if( !$facebookTable->isConnected() ) {
      $form->removeElement('post_to_facebook');
    }
    $twitterTable = Engine_Api::_()->getDbtable('twitter', 'user');
    if( !$twitterTable->isConnected() ) {
      $form->removeElement('post_to_twitter');
    }
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }
    // Process
    $db = Engine_Api::_()->getDbtable('actions', 'activity')->getAdapter();
    $db->beginTransaction();
    try {
      // Get body
      $body = $form->getValue('body');
      // Set Params for Attachment
      $params = array(
          'type' => '<a href="'.$attachment->getHref().'">'.$attachment->getMediaType().'</a>',          
      );
      // Add activity
      $api = Engine_Api::_()->getDbtable('actions', 'activity');
      //$action = $api->addActivity($viewer, $viewer, 'post_self', $body);
      $action = $api->addActivity($viewer, $attachment->getOwner(), 'share', $body, $params);      
      if( $action ) { 
        $api->attachActivity($action, $attachment);
      }
      $db->commit();
      // Notifications
      $notifyApi = Engine_Api::_()->getDbtable('notifications', 'activity');
      // Add notification for owner of activity (if user and not viewer)
      if( $action->subject_type == 'user' && $attachment->getOwner()->getIdentity() != $viewer->getIdentity() )
      {
        $notifyApi->addNotification($attachment->getOwner(), $viewer, $action, 'shared', array(
          'label' => $attachment->getMediaType(),
        ));
      }
      // Preprocess attachment parameters
      $publishMessage = html_entity_decode($form->getValue('body'));
      $publishUrl = null;
      $publishName = null;
      $publishDesc = null;
      $publishPicUrl = null;
      // Add attachment
      if( $attachment ) {        
        $publishUrl = $attachment->getHref();
        $publishName = $attachment->getTitle();
        $publishDesc = $attachment->getDescription();
        if( empty($publishName) ) {
          $publishName = ucwords($attachment->getShortType());
        }
        if( ($tmpPicUrl = $attachment->getPhotoUrl()) ) {
          $publishPicUrl = $tmpPicUrl;
        }
        // prevents OAuthException: (#100) FBCDN image is not allowed in stream
        if( $publishPicUrl &&
            preg_match('/fbcdn.net$/i', parse_url($publishPicUrl, PHP_URL_HOST)) ) {
          $publishPicUrl = null;
        }
      } else {
        $publishUrl = $action->getHref();
      }
      // Check to ensure proto/host
      if( $publishUrl &&
          false === stripos($publishUrl, 'http://') &&
          false === stripos($publishUrl, 'https://') ) {
        $publishUrl = 'http://' . $_SERVER['HTTP_HOST'] . $publishUrl;
      }
      if( $publishPicUrl &&
          false === stripos($publishPicUrl, 'http://') &&
          false === stripos($publishPicUrl, 'https://') ) {
        $publishPicUrl = 'http://' . $_SERVER['HTTP_HOST'] . $publishPicUrl;
      }
      // Add site title
      if( $publishName ) {
        $publishName = Engine_Api::_()->getApi('settings', 'core')->core_general_site_title
            . ": " . $publishName;
      } else {
        $publishName = Engine_Api::_()->getApi('settings', 'core')->core_general_site_title;
      }
      // Publish to facebook, if checked & enabled
      if( $this->_getParam('post_to_facebook', false) &&
          'publish' == Engine_Api::_()->getApi('settings', 'core')->core_facebook_enable ) {
        try {
          $facebookTable = Engine_Api::_()->getDbtable('facebook', 'user');
          $facebookApi = $facebook = $facebookTable->getApi();
          $fb_uid = $facebookTable->find($viewer->getIdentity())->current();
          if( $fb_uid &&
              $fb_uid->facebook_uid &&
              $facebookApi &&
              $facebookApi->getUser() &&
              $facebookApi->getUser() == $fb_uid->facebook_uid ) {
            $fb_data = array(
              'message' => $publishMessage,
            );
            if( $publishUrl ) {
              $fb_data['link'] = $publishUrl;
            }
            if( $publishName ) {
              $fb_data['name'] = $publishName;
            }
            if( $publishDesc ) {
              $fb_data['description'] = $publishDesc;
            }
            if( $publishPicUrl ) {
              $fb_data['picture'] = $publishPicUrl;
            }
            $res = $facebookApi->api('/me/feed', 'POST', $fb_data);
          }
        } catch( Exception $e ) {
          // Silence
        }
      } // end Facebook
      // Publish to twitter, if checked & enabled
      if( $this->_getParam('post_to_twitter', false) &&
          'publish' == Engine_Api::_()->getApi('settings', 'core')->core_twitter_enable ) {
        try {
          $twitterTable = Engine_Api::_()->getDbtable('twitter', 'user');
          if( $twitterTable->isConnected() ) {
            // Get attachment info
            $title = $attachment->getTitle();
            $url = $attachment->getHref();
            $picUrl = $attachment->getPhotoUrl();
            // Check stuff
            if( $url && false === stripos($url, 'http://') ) {
              $url = 'http://' . $_SERVER['HTTP_HOST'] . $url;
            }
            if( $picUrl && false === stripos($picUrl, 'http://') ) {
              $picUrl = 'http://' . $_SERVER['HTTP_HOST'] . $picUrl;
            }
            // Try to keep full message
            // @todo url shortener?
            $message = html_entity_decode($form->getValue('body'));
            if( strlen($message) + strlen($title) + strlen($url) + strlen($picUrl) + 9 <= 140 ) {
              if( $title ) {
                $message .= ' - ' . $title;
              }
              if( $url ) {
                $message .= ' - ' . $url;
              }
              if( $picUrl ) {
                $message .= ' - ' . $picUrl;
              }
            } else if( strlen($message) + strlen($title) + strlen($url) + 6 <= 140 ) {
              if( $title ) {
                $message .= ' - ' . $title;
              }
              if( $url ) {
                $message .= ' - ' . $url;
              }
            } else {
              if( strlen($title) > 24 ) {
                $title = Engine_String::substr($title, 0, 21) . '...';
              }
              // Sigh truncate I guess
              if( strlen($message) + strlen($title) + strlen($url) + 9 > 140 ) {
                $message = Engine_String::substr($message, 0, 140 - (strlen($title) + strlen($url) + 9)) - 3 . '...';
              }
              if( $title ) {
                $message .= ' - ' . $title;
              }
              if( $url ) {
                $message .= ' - ' . $url;
              }
            }
            $twitter = $twitterTable->getApi();
            $twitter->statuses->update($message);
          }
        } catch( Exception $e ) {
          // Silence
        }
      }
      // Publish to janrain
      if( //$this->_getParam('post_to_janrain', false) &&
          'publish' == Engine_Api::_()->getApi('settings', 'core')->core_janrain_enable ) {
        try {
          $session = new Zend_Session_Namespace('JanrainActivity');
          $session->unsetAll();
          
          $session->message = $publishMessage;
          $session->url = $publishUrl ? $publishUrl : 'http://' . $_SERVER['HTTP_HOST'] . _ENGINE_R_BASE;
          $session->name = $publishName;
          $session->desc = $publishDesc;
          $session->picture = $publishPicUrl;
          
        } catch( Exception $e ) {
          // Silence
        }
      }
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e; // This should be caught by error handler
    }
    // If we're here, we're done
    $this->view->status = true;
    $this->view->message =  Zend_Registry::get('Zend_Translate')->_('Success!');

    // Redirect if in normal context
      $this->_forward('success', 'utility', 'core', array(
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('Photo share successfully.')),
        'smoothboxClose' => true,
        'parentRefresh'=> false,
      ));
	}
	public function editProfilephotoAction(){
		if( !Engine_Api::_()->core()->hasSubject() ) {
      // Can specifiy custom id
			$user_id = $this->_getParam('user_id', null);
      $subject = null;
      if( null === $user_id ) {
         echo json_encode(array('status'=>"error"));die;
      } else {
        $subject = Engine_Api::_()->getItem('user', $user_id);
        Engine_Api::_()->core()->setSubject($subject);
      }
    }

    $user = Engine_Api::_()->core()->getSubject();

    if( !$this->getRequest()->isPost() ) {
      echo json_encode(array('status'=>"error"));die;
    }
    // Uploading a new photo
    if(isset($_FILES['webcam']['tmp_name']) && $_FILES['webcam']['tmp_name'] != '') {
      $db = $user->getTable()->getAdapter();
      $db->beginTransaction();
      
      try {
        $userUp = $user->setPhoto($_FILES['webcam']);
        
        $iMain = Engine_Api::_()->getItem('storage_file', $user->photo_id);
        
        // Insert activity
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($user, $user, 'profile_photo_update',
          '{item:$subject} added a new profile photo.');

        // Hooks to enable albums to work
        if( $action ) {
          $event = Engine_Hooks_Dispatcher::_()
            ->callEvent('onUserProfilePhotoUpload', array(
                'user' => $user,
                'file' => $iMain,
              ));

          $attachment = $event->getResponse();
          if( !$attachment ) $attachment = $iMain;

          // We have to attach the user himself w/o album plugin
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $attachment);
        }
        
        $db->commit();
				 echo json_encode(array('status'=>"true",'src'=>Engine_Api::_()->storage()->get($userUp->photo_id)->getPhotoUrl('')));die;
      }
      // If an exception occurred within the image adapter, it's probably an invalid image
      catch( Engine_Image_Adapter_Exception $e )
      {
        $db->rollBack();
        echo json_encode(array('status'=>"error"));die;
      }
    }
  	 echo json_encode(array('status'=>"false"));die;
		
	}
	//upload existing photo
	public function uploadExistingphotoAction(){
		 $id = $this->_getParam('id', null);
     if(!$id){
		 	echo json_encode(array('status'=>"error"));die;
		 }
     $photo = Engine_Api::_()->getItem('sesgroupalbum_photo', $id);
		 $user_id = $this->_getParam('user_id', null);
		 if(null == $user_id){
				echo json_encode(array('status'=>"error"));die; 
			}
		 $user  = Engine_Api::_()->getItem('user', $user_id);
    // Process
    $db = $user->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      // Get the owner of the photo
      $photoOwnerId = null;
      if( isset($photo->user_id) ) {
        $photoOwnerId = $photo->user_id;
      } else if( isset($photo->owner_id) && (!isset($photo->owner_type) || $photo->owner_type == 'user') ) {
        $photoOwnerId = $photo->owner_id;
      }

      // if it is from your own profile album do not make copies of the image
      if( $photo instanceof Sesgroupalbum_Model_Photo &&
          ($photoParent = $photo->getParent()) instanceof Sesgroupalbum_Model_Album &&
          $photoParent->owner_id == $photoOwnerId &&
          $photoParent->type == 'profile' ) {

        // ensure thumb.icon and thumb.profile exist
        $newStorageFile = Engine_Api::_()->getItem('storage_file', $photo->file_id);
        $filesTable = Engine_Api::_()->getDbtable('files', 'storage');
        if( $photo->file_id == $filesTable->lookupFile($photo->file_id, 'thumb.profile') ) {
          try {
            $tmpFile = $newStorageFile->temporary();
            $image = Engine_Image::factory();
            $image->open($tmpFile)
              ->resize(200, 400)
              ->write($tmpFile)
              ->destroy();
            $iProfile = $filesTable->createFile($tmpFile, array(
              'parent_type' => $user->getType(),
              'parent_id' => $user->getIdentity(),
              'user_id' => $user->getIdentity(),
              'name' => basename($tmpFile),
            ));
            $newStorageFile->bridge($iProfile, 'thumb.profile');
            @unlink($tmpFile);
          } catch( Exception $e ) {	echo json_encode(array('status'=>"error"));die;}
        }
        if( $photo->file_id == $filesTable->lookupFile($photo->file_id, 'thumb.icon') ) {
          try {
            $tmpFile = $newStorageFile->temporary();
            $image = Engine_Image::factory();
            $image->open($tmpFile);
            $size = min($image->height, $image->width);
            $x = ($image->width - $size) / 2;
            $y = ($image->height - $size) / 2;
            $image->resample($x, $y, $size, $size, 48, 48)
              ->write($tmpFile)
              ->destroy();
            $iSquare = $filesTable->createFile($tmpFile, array(
              'parent_type' => $user->getType(),
              'parent_id' => $user->getIdentity(),
              'user_id' => $user->getIdentity(),
              'name' => basename($tmpFile),
            ));
            $newStorageFile->bridge($iSquare, 'thumb.icon');
            @unlink($tmpFile);
          } catch( Exception $e ) {	echo json_encode(array('status'=>"error"));die;}
        }

        // Set it
        $user->photo_id = $photo->file_id;
        $user->save();
        
        // Insert activity
        // @todo maybe it should read "changed their profile photo" ?
        $action = Engine_Api::_()->getDbtable('actions', 'activity')
            ->addActivity($user, $user, 'profile_photo_update',
                '{item:$subject} changed their profile photo.');
        if( $action ) {
          Engine_Api::_()->getDbtable('actions', 'activity')
              ->attachActivity($action, $photo);
        }
				$db->commit();
				echo json_encode(array('status'=>"true",'src'=>Engine_Api::_()->storage()->get($user->photo_id)->getPhotoUrl('')));die;
      }

      // Otherwise copy to the profile album
      else {
        $userUp = $user->setPhoto($photo);

        // Insert activity
        $action = Engine_Api::_()->getDbtable('actions', 'activity')
            ->addActivity($user, $user, 'profile_photo_update',
                '{item:$subject} added a new profile photo.');
        
        // Hooks to enable albums to work
        $newStorageFile = Engine_Api::_()->getItem('storage_file', $user->photo_id);
        $event = Engine_Hooks_Dispatcher::_()
          ->callEvent('onUserProfilePhotoUpload', array(
              'user' => $user,
              'file' => $newStorageFile,
            ));

        $attachment = $event->getResponse();
        if( !$attachment ) {
          $attachment = $newStorageFile;
        }
        
        if( $action  ) {
          // We have to attach the user himself w/o album plugin
          Engine_Api::_()->getDbtable('actions', 'activity')
              ->attachActivity($action, $attachment);
        }
      }

      $db->commit();
			echo json_encode(array('status'=>"true",'src'=>Engine_Api::_()->storage()->get($userUp->photo_id)->getPhotoUrl('')));die;
    }
	 // Otherwise it's probably a problem with the database or the storage system (just throw it)
    catch( Exception $e )
    {
      $db->rollBack();
      echo json_encode(array('status'=>"error"));die;
    }
		echo json_encode(array('status'=>"error"));die;
	}
	//update cover photo 
	function uploadExistingcoverAction(){
		$id = $this->_getParam('id', null);
		$album_id = $this->_getParam('album_id', null);
     if(!$id){
		 	echo json_encode(array('status'=>"error"));die;
		 }
     $photo = Engine_Api::_()->getItem('sesgroupalbum_photo', $id);
		 $album = Engine_Api::_()->getItem('sesgroupalbum_album', $album_id);
		 $art_cover = $album->art_cover;
		 $storage_file = Engine_Api::_()->getItem('storage_file', $photo->file_id)->storage_path;
		 $coverAlbum = $album->setCoverPhoto($storage_file);
		 if($art_cover != 0){
			$im = Engine_Api::_()->getItem('storage_file', $art_cover);
			$im->delete();
		 }
		echo json_encode(array('file'=>Engine_Api::_()->getItem('storage_file', $coverAlbum->art_cover)->getPhotoUrl('')));die;
	}
	//get album photos as per given album id
	public function existingAlbumphotosAction(){
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$this->view->album_id = $album_id = isset($_POST['id']) ? $_POST['id'] : 0;
		if($album_id == 0){
			echo "";die;
		}
		$paginator = $this->view->paginator = Engine_Api::_()->getDbTable('photos', 'sesgroupalbum')->getPhotoSelect(array('album_id'=>$album_id,'pagNator'=>true));
		$limit = 12;
		$paginator->setItemCountPerPage($limit);
		$paginator->setCurrentPageNumber($page);
		$this->view->page = $page ;
	}
	//get existing photo for profile photo change widget
	public function existingPhotosAction(){
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$paginator = $this->view->paginator = Engine_Api::_()->getDbTable('albums', 'sesgroupalbum')->getUserAlbum();
		$this->view->limit = $limit = 12;
		$paginator->setItemCountPerPage($limit);
		$this->view->page = $page ;
		$paginator->setCurrentPageNumber($page);
	}
	//change cover photo action function
	public function changePositionAction(){
		$album_id = $this->_getParam('album_id', '0');
		if ($album_id == 0)
			return;
		$album = Engine_Api::_()->getItem('sesgroupalbum_album', $album_id);
		if(!$album)
			return;
		$album->position_cover = $_POST['position'];
			$album->save();
		echo "true"; die;
	}
	//update cover photo function
	public function uploadCoverAction(){
		$album_id = $this->_getParam('album_id', '0');
		if ($album_id == 0)
			return;
		$album = Engine_Api::_()->getItem('sesgroupalbum_album', $album_id);
		if(!$album)
			return;
		$art_cover = $album->art_cover;
		if(isset($_FILES['Filedata']))
			$data = $_FILES['Filedata'];
		else if(isset($_FILES['webcam']))
			$data = $_FILES['webcam'];
		$album->setCoverPhoto($data);
		if($art_cover != 0){
			$im = Engine_Api::_()->getItem('storage_file', $art_cover);
			$im->delete();
		}
		echo json_encode(array('file'=>Engine_Api::_()->storage()->get($album->art_cover)->getPhotoUrl('')));die;
	}
	//remove cover photo action
	public function removeCoverAction(){
		$album_id = $this->_getParam('album_id', '0');
		if ($album_id == 0)
			return;
		$album = Engine_Api::_()->getItem('sesgroupalbum_album', $album_id);		
		if(!$album)
			return;
		if(isset($album->art_cover) && $album->art_cover>0){
			$im = Engine_Api::_()->getItem('storage_file', $album->art_cover);
			$album->art_cover = 0;
			$album->save();
			$im->delete();
		}
		echo "true";die;
	}
}
