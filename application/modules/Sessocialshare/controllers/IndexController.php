<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialshare_IndexController extends Core_Controller_Action_Standard {

  public function indexAction() {

    $resource_id = $this->_getParam('resource_id', null);
    $resource_type = $this->_getParam('resource_type', null);
    if($resource_type == 'sespagevideo') {
        $resource_type = 'pagevideo';
    }
    if($resource_id && $resource_type) {
      $this->view->resource = Engine_Api::_()->getItem($resource_type, $resource_id);
    } else {
      $this->view->url = $this->_getParam('url', null);
    }
  }


  public function emailAction() {

    $this->_helper->layout->setLayout('default-simple');

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewr_id = $viewer->getIdentity();

    $this->view->resource_id = $item_id = $this->_getParam('resource_id', null);
    $this->view->resource_type = $item_type = $this->_getParam('resource_type', null);
    $this->view->url = $url = $_SERVER['HTTP_REFERER']; //$this->_getParam('url', null);

    if($item_type && $item_id) {
      $this->view->item = $item = Engine_Api::_()->getItem($item_type, $item_id);
    }

    $this->view->form = $form = new Sessocialshare_Form_Email();

    if (!empty($viewr_id)) {
      $value['sender_email'] = $viewer->email;
      $value['sender_name'] = $viewer->displayname;
      $form->populate($value);
    }

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {



      $values = $form->getValues();


      $reciver_ids = explode(',', $values['reciver_emails']);
      if (!empty($values['send_me'])) {
        $reciver_ids[] = $values['sender_email'];
      }
      $sender_email = $values['sender_email'];

      $validator = new Zend_Validate_EmailAddress();

//       if (!$validator->isValid($sender_email)) {
//         $form->addError(Zend_Registry::get('Zend_Translate')->_('Invalid sender email address value'));
//         return;
//       }

//       foreach ($reciver_ids as $reciver_id) {
//         $reciver_id = trim($reciver_id, ' ');
//         if (!$validator->isValid($reciver_id)) {
//           $form->addError(Zend_Registry::get('Zend_Translate')->_('Please enter correct email address of the receiver(s).'));
//           return;
//         }
//       }

      $message = $values['message'];
      if($item) {
        $href = 'http://'.$_SERVER['HTTP_HOST'].$item->getHref();
      } else {
        $href = $_SERVER['HTTP_REFERER'];
      }

      Engine_Api::_()->getApi('mail', 'core')->sendSystem($reciver_ids, 'SESSOCIALSHARE_TELLAFRIEND_EMAIL', array(
        'host' => $_SERVER['HTTP_HOST'],
        'sender_name' => $values['sender_name'],
        'sender_email' => $sender_email,
        'message' => $message ,
        'object_link' => $href,
        'queue' => false
      ));

      ?>
      <script>window.close();</script>
      <?php
      echo json_encode(array('emails_sent' => 1));die;
//       $this->_forward('success', 'utility', 'core', array(
//         'smoothboxClose' => true,
//         'parentRefreshTime' => '15',
//         'format' => 'smoothbox',
//         'messages' => Zend_Registry::get('Zend_Translate')->_('Your content has been shared successfully.')
//       ));
    }
  }

  public function emailsentAction() {

    //$this->_helper->layout->setLayout('default-simple');

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewr_id = $viewer->getIdentity();

    //$this->view->form = $form = new Sessocialshare_Form_Email();

//     if (!empty($viewr_id)) {
//       $value['sender_email'] = $viewer->email;
//       $value['sender_name'] = $viewer->displayname;
//       $form->populate($value);
//     }

    //if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      if (isset($_POST['params']) && $_POST['params'])
        parse_str($_POST['params'], $values);

      if($viewr_id) {
        $values['sender_email'] = $viewer->email;
        $values['sender_name'] = $viewer->displayname;
      }

      $item_id = $this->_getParam('resource_id', null);
      $item_type = $this->_getParam('resource_type', null);
      $url = $this->_getParam('url', null);
      if($item_type && $item_id) {
        $item = Engine_Api::_()->getItem($item_type, $item_id);
      }

      //$values = $form->getValues();

      $reciver_ids = explode(',', $values['reciver_emails']);
      if (!empty($values['send_me'])) {
        $reciver_ids[] = $values['sender_email'];
      }
      $sender_email = $values['sender_email'];

      //$validator = new Zend_Validate_EmailAddress();

//       if (!$validator->isValid($sender_email)) {
//         $form->addError(Zend_Registry::get('Zend_Translate')->_('Invalid sender email address value'));
//         return;
//       }

//       foreach ($reciver_ids as $reciver_id) {
//         $reciver_id = trim($reciver_id, ' ');
//         if (!$validator->isValid($reciver_id)) {
//           $form->addError(Zend_Registry::get('Zend_Translate')->_('Please enter correct email address of the receiver(s).'));
//           return;
//         }
//       }

      $message = $values['message'];
      if($item) {
        $href = 'http://'.$_SERVER['HTTP_HOST'].$item->getHref();
      } else {
        $href = $url; //$_SERVER['HTTP_REFERER'];
      }

      Engine_Api::_()->getApi('mail', 'core')->sendSystem($reciver_ids, 'SESSOCIALSHARE_TELLAFRIEND_EMAIL', array(
        'host' => $_SERVER['HTTP_HOST'],
        'sender_name' => $values['sender_name'],
        'sender_email' => $sender_email,
        'message' => $message ,
        'object_link' => $href,
        'queue' => false
      ));
      echo json_encode(array('emails_sent' => 1));die;
  }

  public function savesocialsharecountAction() {

    $title = $this->_getParam('title', null);
    $pageurl = $this->_getParam('pageurl', null);
    $type = $this->_getParam('type', null);

    $linksavesTable = Engine_Api::_()->getDbtable('linksaves', 'sessocialshare');
    $linksavesTableName = $linksavesTable->info('name');

    $isLinkExist = $linksavesTable->isLinkExist(array('title' => $type, 'pageurl' => urldecode($pageurl), 'creation_date' => date('Y-m-d')));


    $values['title'] = $type;
    $values['pageurl'] =  urldecode($pageurl);

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
      if(empty($isLinkExist)) {
        $row = $linksavesTable->createRow();
        $row->setFromArray($values);
        $row->share_count++;
        $row->save();

      } else {
        $linkSave = Engine_Api::_()->getItem('sessocialshare_linksave', $isLinkExist);
        $linkSave->share_count++;
        $linkSave->save();
      }
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }


  public function getcontentsAction() {

    $share_type = $this->_getParam('share_type', null);
    if($share_type == 'email')
      return '';

    $content_title = $this->_getParam('text', null);

    $table = Engine_Api::_()->getDbtable('search', 'core');

    if(!in_array($share_type, array('email', 'self_friend', 'message'))) {
      $select = $table->select()->where('title LIKE ? OR description LIKE ? OR keywords LIKE ? OR hidden LIKE ?', '%' . $content_title . '%')->order('id DESC');

      if (!empty($share_type)) {
        $select->where('type =?', $share_type);
      }
      $select->limit('10');
    } else if($share_type == 'self_friend') {

      $table = Engine_Api::_()->getItemTable('user');
      $userTableName = $table->info('name');

      $select = $table->select()
                      ->from($userTableName)
                      ->where("{$userTableName}.search = ?", 1)
                      ->where("{$userTableName}.enabled = ?", 1)
                      ->where("(`{$userTableName}`.`displayname` LIKE ?)", "%{$content_title}%");
      $viewer = Engine_Api::_()->user()->getViewer();
      if ($viewer->getIdentity()) {
        $users = $viewer->membership()->getMembershipsOfIds();
        if ($users)
          $select->where($userTableName . '.user_id IN (?)', $users);
        else
          $select->where($userTableName . '.user_id IN (?)', 0);
      }
    } else if($share_type == 'message') {

      $viewer = Engine_Api::_()->user()->getViewer();
      $viewer_id = $viewer->getIdentity();
      $table = Engine_Api::_()->getItemTable('user');
      $userTableName = $table->info('name');
      $select = $table->select()
              ->from($userTableName)
              ->where("{$userTableName}.search = ?", 1)
              ->where("{$userTableName}.enabled = ?", 1)
              ->where("(`{$userTableName}`.`displayname` LIKE ?)", "%{$content_title}%");

      if ($viewer_id) {
        $users = $viewer->membership()->getMembershipsOfIds();
        if ($users)
          $select->where($userTableName . '.user_id IN (?)', $users);
        else
          $select->where($userTableName . '.user_id IN (?)', 0);
      }

    }

    $results = Zend_Paginator::factory($select);

    foreach ($results as $result) {

      if($share_type == 'self_friend') {
        $photo_icon_photo = $this->view->itemPhoto($result, 'thumb.icon');
        $data[] = array(
          'id' => $result->user_id,
          'label' => $result->getTitle(),
          'photo' => $photo_icon_photo,
        );
      } elseif($share_type == 'message') {
        $item = Engine_Api::_()->getItem('user', $result->user_id);
        $photo_icon_photo = $this->view->itemPhoto($item, 'thumb.icon');
        $data[] = array(
          'id' => $item->user_id,
          'label' => $item->getTitle(),
          'photo' => $photo_icon_photo,
        );
      } else {
        $itemType = $result->type;
        if (Engine_Api::_()->hasItemType($itemType)) {
          if ($itemType == 'sesblog')
            continue;
          $item = Engine_Api::_()->getItem($itemType, $result->id);
          $item_type = ucfirst($item->getShortType());
          $photo_icon_photo = $this->view->itemPhoto($item, 'thumb.icon');
          $data[] = array(
            'id' => $result->id,
            'label' => $item->getTitle(),
            'photo' => $photo_icon_photo,
          );
        }
      }
    }
    return $this->_helper->json($data);
  }



	public function shareAction() {

    if( !$this->_helper->requireUser()->isValid() ) return;

    $this->view->type = $type = $this->_getParam('type');
    $this->view->id = $id = $this->_getParam('id');


    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->attachment = $attachment = Engine_Api::_()->getItem($type, $id);
    $this->view->form = $form = new Sessocialshare_Form_Share();

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
    $this->view->share_type = 0;
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
    $values = $form->getValues();
    if($values['share_type'] != 'self_profile') {
      $this->view->share_type = $values['share_type'];
    }

    if(!in_array($values['share_type'], array('self_profile','email'))) {
      if(empty($values['content_id'])) {
        $error = Zend_Registry::get('Zend_Translate')->_("Please choose atleast one content.");
        $form->getDecorator('errors')->setOption('escape', false);
        $form->addError($error);
        return;
      }
    }


    if($values['share_type'] != 'message') {
      $db = Engine_Api::_()->getDbtable('actions', 'activity')->getAdapter();
      $db->beginTransaction();
    } elseif($values['share_type'] == 'message') {
      //$recipient = Engine_Api::_()->getItem('user', $values['content_id']);
      $db = Engine_Api::_()->getDbtable('messages', 'messages')->getAdapter();
      $db->beginTransaction();
    }
    try {

      // Get body
      $body = $form->getValue('body');

      // Set Params for Attachment
      $params = array('type' => '<a href="'.$attachment->getHref().'">'.$attachment->getMediaType().'</a>');

      // Add activity
      $api = Engine_Api::_()->getDbtable('actions', 'activity');

      if($values['share_type'] == 'self_friend') {

        $contentIds = explode(',', $values['content_id']);
        //$content_id = $values['content_id'];
        foreach($contentIds as $contentId) {
          $resource = Engine_Api::_()->getItem('user', $contentId);

          $action = $api->addActivity($attachment->getOwner(), $resource, 'sessocialshare_share', $body, $params);
          if( $action ) {
            $api->attachActivity($action, $attachment);
          }
        }
      } else if($values['share_type'] == 'self_profile') {

        //$action = $api->addActivity($viewer, $viewer, 'post_self', $body);
        $action = $api->addActivity($viewer, $attachment->getOwner(), 'share', $body, $params);
        if( $action ) {
          $api->attachActivity($action, $attachment);
        }
      } else if($values['share_type'] == 'email') {


        $mediaType = $attachment->getMediaType();
        if($mediaType == 'item') {
          $mediaType = $attachment->getShortType();
        }

        $emails =  $contentIds = explode(',', $values['content_title']); //$values['content_title'];
        foreach($emails as $email) {
          // Send user an email
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($email, 'CONTENT_SHARE_EMAIL', array(
            'host' => $_SERVER['HTTP_HOST'],
            'email' => $email,
            'date' => time(),
            'object_link' => $attachment->getHref(),
            'object_title' => $attachment->getTitle(),
            'object_description' => $attachment->getDescription(),
            'sender_name' => $viewer->getTitle(),
            'message' => $body,
            'queue' => false,
          ));
        }
      } else if($values['share_type'] == 'message') {

        $contentIds = explode(',', $values['content_id']);
        foreach($contentIds as $contentId) {
          $recipient = Engine_Api::_()->getItem('user', $contentId);

          $conversation = Engine_Api::_()->getItemTable('messages_conversation')->send($viewer, $recipient, "Shared Content ", $body, $attachment);
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($recipient, $viewer, $conversation, 'message_new');
          Engine_Api::_()->getDbtable('statistics', 'core')->increment('messages.creations');
        }
      }
      else {

        if($values['share_type']) {
          $contentIds = explode(',', $values['content_id']);
          foreach($contentIds as $contentId) {
            $resource = Engine_Api::_()->getItem($values['share_type'], $contentId);
            $action = $api->addActivity($viewer, $resource, 'sessocialshare_share', $body, $params);
            if( $action ) {
              $api->attachActivity($action, $attachment);
            }
          }
        } else {
          $action = $api->addActivity($viewer, $attachment->getOwner(), 'share', $body, $params);
          if( $action ) {
            $api->attachActivity($action, $attachment);
          }
        }
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
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully shared.')),
        'smoothboxClose' => true,
        'parentRefresh'=> false,
      ));
	}
}
