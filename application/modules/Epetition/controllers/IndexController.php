<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: IndexController.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_IndexController extends Core_Controller_Action_Standard
{
  public function init()
  {
    if (!$this->_helper->requireAuth()->setAuthParams('epetition', null, 'view')->isValid()) {
      return;
    }

    $id = $this->_getParam('epetition_id', $this->_getParam('id', null));
    $epetition_id = Engine_Api::_()->getDbtable('epetitions', 'epetition')->getPetitionId($id);
    if ($epetition_id) {
      $petition = Engine_Api::_()->getItem('epetition', $epetition_id);

      if ($petition) {
        Engine_Api::_()->core()->setSubject($petition);
      }
    }

  }


	public function deleteforgutterAction()
	{
		$epetition = Engine_Api::_()->getItem('epetition', $this->getRequest()->getParam('epetition_id'));
		if (!$this->_helper->requireAuth()->setAuthParams($epetition, null, 'delete')->isValid()) return;

		// In smoothbox
		$this->_helper->layout->setLayout('default-simple');


		if (!$epetition) {
			$this->view->status = false;
			$this->view->error = Zend_Registry::get('Zend_Translate')->_("Epetition entry doesn't exist or not authorized to delete");
			return;
		}

		$db = $epetition->getTable()->getAdapter();
		$db->beginTransaction();

		try {
			Engine_Api::_()->epetition()->deletePetition($epetition);

			$db->commit();
		} catch (Exception $e) {
			$db->rollBack();
			throw $e;
		}

		$this->view->status = true;
		$this->view->message = Zend_Registry::get('Zend_Translate')->_('Your petition entry has been deleted.');
		return $this->_forward('success', 'utility', 'core', array(
			'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'epetition_general', true),
			'messages' => Array($this->view->message)
		));
	}

  public function shareAction() {

    if (!$this->_helper->requireUser()->isValid())
      return;
    $type = $this->_getParam('type');
    $id = $this->_getParam('id');
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->attachment = $attachment = Engine_Api::_()->getItem($type, $id);
    if (empty($_POST['is_ajax']))
      $this->view->form = $form = new Activity_Form_Share();
    if (!$attachment) {
      // tell smoothbox to close
      $this->view->status = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('You cannot share this item because it has been removed.');
      $this->view->smoothboxClose = true;
      return $this->render('deletedItem');
    }
    // hide facebook and twitter option if not logged in
    $facebookTable = Engine_Api::_()->getDbtable('facebook', 'user');
    if (!$facebookTable->isConnected() && empty($_POST['is_ajax'])) {
      $form->removeElement('post_to_facebook');
    }
    $twitterTable = Engine_Api::_()->getDbtable('twitter', 'user');
    if (!$twitterTable->isConnected() && empty($_POST['is_ajax'])) {
      $form->removeElement('post_to_twitter');
    }
    if (empty($_POST['is_ajax']) && !$this->getRequest()->isPost()) {
      return;
    }
    if (empty($_POST['is_ajax']) && !$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    // Process
    $db = Engine_Api::_()->getDbtable('actions', 'activity')->getAdapter();
    $db->beginTransaction();
    try {
      // Get body
      if (empty($_POST['is_ajax']))
        $body = $form->getValue('body');
      else
        $body = '';
      // Set Params for Attachment
      $params = array(
        'type' => '<a href="' . $attachment->getHref() . '">Petition</a>',
      );
      // Add activity
      $api = Engine_Api::_()->getDbtable('actions', 'activity');
      //$action = $api->addActivity($viewer, $viewer, 'post_self', $body);
      $action = $api->addActivity($viewer, $attachment->getOwner(), 'share', $body, $params);
      if ($action) {
        $api->attachActivity($action, $attachment);
      }
      $db->commit();
      // Notifications
      $notifyApi = Engine_Api::_()->getDbtable('notifications', 'activity');
      // Add notification for owner of activity (if user and not viewer)
      if ($action->subject_type == 'user' && $attachment->getOwner()->getIdentity() != $viewer->getIdentity()) {
        $notifyApi->addNotification($attachment->getOwner(), $viewer, $action, 'shared', array(
          'label' => $attachment->getMediaType(),
        ));
      }
      // Preprocess attachment parameters
      if (empty($_POST['is_ajax']))
        $publishMessage = html_entity_decode($form->getValue('body'));
      else
        $publishMessage = '';
      $publishUrl = null;
      $publishName = null;
      $publishDesc = null;
      $publishPicUrl = null;
      // Add attachment
      if ($attachment) {
        $publishUrl = $attachment->getHref();
        $publishName = $attachment->getTitle();
        $publishDesc = $attachment->getDescription();
        if (empty($publishName)) {
          $publishName = ucwords($attachment->getShortType());
        }
        if (($tmpPicUrl = $attachment->getPhotoUrl())) {
          $publishPicUrl = $tmpPicUrl;
        }
        // prevents OAuthException: (#100) FBCDN image is not allowed in stream
        if ($publishPicUrl &&
          preg_match('/fbcdn.net$/i', parse_url($publishPicUrl, PHP_URL_HOST))) {
          $publishPicUrl = null;
        }
      } else {
        $publishUrl = $action->getHref();
      }
      // Check to ensure proto/host
      if ($publishUrl &&
        false === stripos($publishUrl, 'http://') &&
        false === stripos($publishUrl, 'https://')) {
        $publishUrl = 'http://' . $_SERVER['HTTP_HOST'] . $publishUrl;
      }
      if ($publishPicUrl &&
        false === stripos($publishPicUrl, 'http://') &&
        false === stripos($publishPicUrl, 'https://')) {
        $publishPicUrl = 'http://' . $_SERVER['HTTP_HOST'] . $publishPicUrl;
      }
      // Add site title
      if ($publishName) {
        $publishName = Engine_Api::_()->getApi('settings', 'core')->core_general_site_title
          . ": " . $publishName;
      } else {
        $publishName = Engine_Api::_()->getApi('settings', 'core')->core_general_site_title;
      }
      // Publish to facebook, if checked & enabled
      if ($this->_getParam('post_to_facebook', false) &&
        'publish' == Engine_Api::_()->getApi('settings', 'core')->core_facebook_enable) {
        try {
          $facebookTable = Engine_Api::_()->getDbtable('facebook', 'user');
          $facebookApi = $facebook = $facebookTable->getApi();
          $fb_uid = $facebookTable->find($viewer->getIdentity())->current();
          if ($fb_uid &&
            $fb_uid->facebook_uid &&
            $facebookApi &&
            $facebookApi->getUser() &&
            $facebookApi->getUser() == $fb_uid->facebook_uid) {
            $fb_data = array(
              'message' => $publishMessage,
            );
            if ($publishUrl) {
              $fb_data['link'] = $publishUrl;
            }
            if ($publishName) {
              $fb_data['name'] = $publishName;
            }
            if ($publishDesc) {
              $fb_data['description'] = $publishDesc;
            }
            if ($publishPicUrl) {
              $fb_data['picture'] = $publishPicUrl;
            }
            $res = $facebookApi->api('/me/feed', 'POST', $fb_data);
          }
        } catch (Exception $e) {
          // Silence
        }
      } // end Facebook
      // Publish to twitter, if checked & enabled
      if ($this->_getParam('post_to_twitter', false) &&
        'publish' == Engine_Api::_()->getApi('settings', 'core')->core_twitter_enable) {
        try {
          $twitterTable = Engine_Api::_()->getDbtable('twitter', 'user');
          if ($twitterTable->isConnected()) {
            // Get attachment info
            $title = $attachment->getTitle();
            $url = $attachment->getHref();
            $picUrl = $attachment->getPhotoUrl();
            // Check stuff
            if ($url && false === stripos($url, 'http://')) {
              $url = 'http://' . $_SERVER['HTTP_HOST'] . $url;
            }
            if ($picUrl && false === stripos($picUrl, 'http://')) {
              $picUrl = 'http://' . $_SERVER['HTTP_HOST'] . $picUrl;
            }
            // Try to keep full message
            // @todo url shortener?
            $message = html_entity_decode($form->getValue('body'));
            if (strlen($message) + strlen($title) + strlen($url) + strlen($picUrl) + 9 <= 140) {
              if ($title) {
                $message .= ' - ' . $title;
              }
              if ($url) {
                $message .= ' - ' . $url;
              }
              if ($picUrl) {
                $message .= ' - ' . $picUrl;
              }
            } else if (strlen($message) + strlen($title) + strlen($url) + 6 <= 140) {
              if ($title) {
                $message .= ' - ' . $title;
              }
              if ($url) {
                $message .= ' - ' . $url;
              }
            } else {
              if (strlen($title) > 24) {
                $title = Engine_String::substr($title, 0, 21) . '...';
              }
              // Sigh truncate I guess
              if (strlen($message) + strlen($title) + strlen($url) + 9 > 140) {
                $message = Engine_String::substr($message, 0, 140 - (strlen($title) + strlen($url) + 9)) - 3 . '...';
              }
              if ($title) {
                $message .= ' - ' . $title;
              }
              if ($url) {
                $message .= ' - ' . $url;
              }
            }
            $twitter = $twitterTable->getApi();
            $twitter->statuses->update($message);
          }
        } catch (Exception $e) {
          // Silence
        }
      }
      // Publish to janrain
      if (//$this->_getParam('post_to_janrain', false) &&
        'publish' == Engine_Api::_()->getApi('settings', 'core')->core_janrain_enable) {
        try {
          $session = new Zend_Session_Namespace('JanrainActivity');
          $session->unsetAll();
          $session->message = $publishMessage;
          $session->url = $publishUrl ? $publishUrl : 'http://' . $_SERVER['HTTP_HOST'] . _ENGINE_R_BASE;
          $session->name = $publishName;
          $session->desc = $publishDesc;
          $session->picture = $publishPicUrl;
        } catch (Exception $e) {
          // Silence
        }
      }
    } catch (Exception $e) {
      $db->rollBack();
      throw $e; // This should be caught by error handler
    }
    // If we're here, we're done
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Success!');
    $typeItem = ucwords(str_replace(array('epetition_'), '', $attachment->getType()));
    // Redirect if in normal context
    if (null === $this->_helper->contextSwitch->getCurrentContext()) {
      $return_url = $form->getValue('return_url', false);
      if (!$return_url) {
        $return_url = $this->view->url(array(), 'default', true);
      }
      return $this->_helper->redirector->gotoUrl($return_url, array('prependBase' => false));
    } else if ('smoothbox' === $this->_helper->contextSwitch->getCurrentContext()) {
      $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => false,
        'messages' => array($typeItem . ' share successfully.')
      ));
    } else if (isset($_POST['is_ajax'])) {
      echo "true";
      die();
    }
  }

  public function mysignAction()
  {
    $this->_helper->content->setEnabled();

  }
  public function locationsAction()
  {
    $this->_helper->content->setEnabled();
  }
  public function tagsAction()
  {
    $this->_helper->content->setEnabled();
  }

  public function approveletterAction()
  {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_POST['id']) && isset($_POST['type'])) {
      $decisionmaker = Engine_Api::_()->getItem('epetition_decisionmaker', $_POST['id']);
      $decisionmaker->letter_approve = trim($_POST['type']);
      $arr = array();
      if ($decisionmaker->save()) {
        $types = 'Approve';
        if ($_POST['type'] == 3) {
          $types = 'cancel';
        }
        $epetition = Engine_Api::_()->getItem('epetition', $decisionmaker->epetition_id);
        if($decisionmaker->letter_approve == 2){
          $epetition->victory = 1;
          $epetition->vicotry_time = date('Y-m-d H:i:s');
          $epetition->save();
        }
        $sender = Engine_Api::_()->getItem('user', $decisionmaker->user_id);

        // All user id
        $super_admin = Engine_Api::_()->epetition()->getAdminnSuperAdmins();
        $signuser = Engine_Api::_()->getDbtable('signatures', 'epetition')->signAllUser($epetition['epetition_id']);
        $decisionMaker = Engine_Api::_()->getDbtable('decisionmakers', 'epetition')->getAllUserId($epetition['epetition_id']);
        foreach ($super_admin as $admin) {
          $admin_obj = Engine_Api::_()->getItem('user', $admin['user_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($admin_obj->email, 'epetition_email', array(
            'host' => $_SERVER['HTTP_HOST'],
            'subject' => "Petition letter " . $types,
            'message' => "<a href='" . $sender->getHref() . "'>" . $sender->getTitle() . "</a> have " . $types . "  letter of the petition <a href='" . $epetition->getHref() . "'>" . $epetition['title'] . "</a>.",
          ));
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($admin_obj, $sender, $epetition, 'epetition_letterapprove1', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>", 'type' => $types));
        }

        // send email and notification for user
        foreach ($signuser as $signuse) {
          $viewer_user = Engine_Api::_()->getItem('user', $signuse['owner_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer_user->email, 'epetition_email', array(
            'host' => $_SERVER['HTTP_HOST'],
            'subject' => "Petition letter " . $types,
            'message' => "<a href='" . $sender->getHref() . "'>" . $sender->getTitle() . "</a> have " . $types . "  letter of the petition <a href='" . $epetition->getHref() . "'>" . $epetition['title'] . "</a>.",
          ));

          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer_user, $sender, $epetition, 'epetition_letterapprove2', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>", 'type' => $types));
        }

        // send email and notification for decision maker
        foreach ($decisionMaker as $dem) {
          $viewer_dec = Engine_Api::_()->getItem('user', $dem['user_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer_dec->email, 'epetition_email', array(
            'host' => $_SERVER['HTTP_HOST'],
            'subject' => "Petition letter " . $types,
            'message' => "<a href='" . $sender->getHref() . "'>" . $sender->getTitle() . "</a> have " . $types . "  letter of the petition <a href='" . $epetition->getHref() . "'>" . $epetition['title'] . "</a>.",
          ));
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer_dec, $sender, $epetition, 'epetition_letteradd2', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>", 'type' => $types));
        }
        $arr['status'] = 1;
        $arr['msg'] = "You successfully done.";
      } else {
        $arr['status'] = 0;
        $arr['msg'] = "You can not change status. Please retry";
      }
      echo json_encode($arr);
      exit();
    }
  }

  public function petletterupdateAction()
  {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_POST['id'])) {
      $viewer = Engine_Api::_()->user()->getViewer();
      $viewer_id = $viewer->getIdentity();
      $sender = Engine_Api::_()->getItem('user', $viewer_id);
      $epetition = Engine_Api::_()->getItem('epetition', $_POST['id']);
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->update('engine4_epetition_decisionmakers', array('letter_approve' => 1), array("epetition_id=?" => $_POST['id']));
      $decisionMaker = Engine_Api::_()->getDbtable('decisionmakers', 'epetition')->getAllUserId($_POST['id']);
      foreach ($decisionMaker as $dem) {
        $viewer_dec = Engine_Api::_()->getItem('user', $dem['user_id']);
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer_dec->email, 'epetition_email', array(
          'host' => $_SERVER['HTTP_HOST'],
          'subject' => "Petition letter approve",
          'message' => "<a href='" . $viewer_dec->getHref() . "'>" . $viewer_dec->getTitle() . "</a> have send the petition <a href='" . $epetition->getHref() . "'>" . $epetition['title'] . "</a> letter for approve. which you have decision maker",
        ));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer_dec, $sender, $epetition, 'epetition_letter', array('owner' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
      }
      $arr = array();
      $arr['status'] = 1;
      $arr['msg'] = "Letter send successfully";
      echo json_encode($arr);
      exit();
    }
  }

  public function deletesignAction()
  {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_POST['id'])) {
      $viewer = Engine_Api::_()->user()->getViewer();
      $viewer_id = $viewer->getIdentity();
      $signature = Engine_Api::_()->getItem('epetition_signature', $_POST['id']);
      $array = array();
      if ($viewer_id != $signature['owner_id']) {
        $array['status'] = 0;
        $array['msg'] = "You can not delete this sign";
      } else {
        $signature->delete();
        $array['status'] = 1;
        $array['msg'] = "You deleted successfully";
      }
      echo json_encode($array);
      exit();
    }
    exit();
  }

  public function signupdateAction()
  {
    $this->view->form = $form = new Epetition_Form_Signatureupdate();
    $epetition_update = Engine_Api::_()->getItem('epetition_signature', $_GET['id']);
    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      $epetition_update->location = $values['epetition_location'];
      $epetition_update->support_statement = $values['epetition_support_statement'];
      $epetition_update->support_reason = $values['epetition_support_reason'];
      $epetition_update->save();
      $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your sign updated successfully.'))
      ));

    }
    $form->populate(array(
      'epetition_location' => $epetition_update['location'],
      'epetition_support_statement' => $epetition_update['support_statement'],
      'epetition_support_reason' => $epetition_update['support_reason'],
    ));
  }

  public function homeAction()
  {
    // Render
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_POST['ids'])) {
      $all_id = json_decode($_POST['ids']);
      $array = array();
      foreach ($all_id as $key => $id) {
        $array[$key] = Engine_Api::_()->getItemTable('epetition', 'epetition')->getDetailsForAjaxUpdate($id);
      }
      $array['lenght'] = count($array);
      $array['status'] = 1;
      echo json_encode($array);
      exit();
    }
    $this->_helper->content->setEnabled();

  }

  public function browseAction()
  {
    // Render
    $this->_helper->content->setEnabled();
  }

  public function popsignpetitionAction()
  {

    if (!$this->_helper->requireUser->isValid())
    {
     return;
    }
    $this->view->form = $form = new Epetition_Form_Signaturecreate();
    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();

      $table = Engine_Api::_()->getDbtable('signatures', 'epetition')->createRow();
      $viewer = Engine_Api::_()->user()->getViewer();
      $viewer_id = $viewer->getIdentity();
      if (empty($viewer_id)) {
        // check for same petition and same email for not loging user
        $signatureTable = Engine_Api::_()->getDbTable('signatures', 'epetition')->select()->where('epetition_id =?', $_GET['id'])->where('email =?', trim($values['email']))->query()->fetchAll();
        if (count($signatureTable) > 0) {
          $form->addError($this->view->translate("This email for this petition already submit signature."));
          return false;
        }

        // check for email id formate
        if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
          $form->addError($this->view->translate("Your email formate is not correct"));
          return false;
        }
        $table->first_name = isset($values['first_name']) ? trim($values['first_name']) : null;
        $table->last_name = isset($values['last_name']) ? trim($values['last_name']) : null;
        $table->email = isset($values['email']) ? trim($values['email']) : null;
      } else {
        $table->owner_id = $viewer_id;
      }
      $table->location = isset($values['epetition_location']) ? trim($values['epetition_location']) : null;
      $table->support_statement = isset($values['epetition_support_statement']) ? trim($values['epetition_support_statement']) : null;
      $table->epetition_id = isset($_GET['id']) ? $_GET['id'] : null;
      $table->creation_date = date('Y-m-d H:i:s');
      $table->support_reason = isset($values['epetition_support_reason']) ? trim($values['epetition_support_reason']) : null;
      $table->save();

      $array = Engine_Api::_()->getItemTable('epetition', 'epetition')->getDetailsForAjaxUpdate($table->epetition_id);
      if ($array['signpet'] == $array['goal']) {
        $epetition = Engine_Api::_()->getItem('epetition', $table->epetition_id);
        $title = $epetition['title'];
        $sender = Engine_Api::_()->getItem('user', $viewer_id);
        $viewer = Engine_Api::_()->getItem('user', $epetition['owner_id']);
        // All user id
        $super_admin = Engine_Api::_()->epetition()->getAdminnSuperAdmins();
        $signuser = Engine_Api::_()->getDbtable('signatures', 'epetition')->signAllUser($table->epetition_id);
        $decisionMaker = Engine_Api::_()->getDbtable('decisionmakers', 'epetition')->getAllUserId($table->epetition_id);
        foreach ($super_admin as $admin) {
          $admin_obj = Engine_Api::_()->getItem('user', $admin['user_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($admin_obj->email, 'epetition_email', array(
            'host' => $_SERVER['HTTP_HOST'],
            'subject' => $title . " Signature Goal reached for " . $sender->getTitle() . " petition",
            'message' => " Signature Goal " . $epetition['signature_goal'] . "  for petition <a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>  has been reached.",
          ));
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($admin_obj, $sender, $epetition, 'epetition_signreach', array('goal' => $epetition['signature_goal'], 'title' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
        }

        // send email and notification for user
        foreach ($signuser as $signuse) {
          $viewer_user = Engine_Api::_()->getItem('user', $signuse['owner_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer_user->email, 'epetition_email', array(
            'host' => $_SERVER['HTTP_HOST'],
            'subject' => $title . " Signature Goal reached for " . $sender->getTitle() . " petition",
            'message' => " Signature Goal " . $epetition['signature_goal'] . "  for petition <a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>  has been reached.",
          ));

          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer_user, $sender, $epetition, 'epetition_signreach', array('goal' => $epetition['signature_goal'], 'title' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
        }

        // send email and notification for decision maker
        foreach ($decisionMaker as $dem) {
          $viewer_dec = Engine_Api::_()->getItem('user', $dem['user_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer_dec->email, 'epetition_email', array(
            'host' => $_SERVER['HTTP_HOST'],
            'subject' => $title . " Signature Goal reached for " . $sender->getTitle() . " petition",
            'message' => " Signature Goal " . $epetition['signature_goal'] . "  for petition <a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>  has been reached.",
          ));
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($viewer_dec, $sender, $epetition, 'epetition_signreach', array('goal' => $epetition['signature_goal'], 'title' => "<a href=" . $epetition->getHref() . ">" . $epetition['title'] . "</a>"));
        }
      }
      $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have submitted successfully.'))
      ));
    }
    // $this->_helper->content->setEnabled();
  }

  public function indexAction()
  {

    $this->_helper->content->setEnabled();
  }


  public function subcategoryAction() {
    $category_id = $this->_getParam('category_id', null);
    $CategoryType = $this->_getParam('type', null);
    if ($category_id) {
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'epetition');
      $category_select = $categoryTable->select()
        ->from($categoryTable->info('name'))
        ->where('subcat_id = ?', $category_id);
      $subcategory = $categoryTable->fetchAll($category_select);
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
        if($CategoryType == 'search') {
          $data .= '<option value="0">' . Zend_Registry::get('Zend_Translate')->_("Choose 2nd Level Category") . '</option>';
          foreach ($subcategory as $category) {
            $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '" >' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
          }
        }
        else {
          //$data .= '<option value="0">' . Zend_Registry::get('Zend_Translate')->_("Choose 2nd Level Category") . '</option>';
          $data .= '<option value=""></option>';
          foreach ($subcategory as $category) {
            $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '" >' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
          }

        }
      }
    } else
      $data = '';
    echo $data;
    die;
  }
  public function subsubcategoryAction() {

    $category_id = $this->_getParam('subcategory_id', null);
    $CategoryType = $this->_getParam('type', null);
    if ($category_id) {
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'epetition');
      $category_select = $categoryTable->select()
        ->from($categoryTable->info('name'))
        ->where('subsubcat_id = ?', $category_id);
      $subcategory = $categoryTable->fetchAll($category_select);
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
    } else
      $data = '';
    echo $data;
    die;
  }



  public function welcomeAction()
  {
    $this->_helper->content->setEnabled();
  }

  public function createAction()
  {

    if (!$this->_helper->requireUser()->isValid()) return;
    if (!$this->_helper->requireAuth()->setAuthParams('epetition', null, 'create')->isValid()) return;
    $quckCreate = 0;
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('epetcre.bcategory', 1)) {
      $quckCreate = 1;
    }
    $this->view->quickCreate = $quckCreate;
    $sessmoothbox = $this->view->typesmoothbox = false;
    if ($this->_getParam('typesmoothbox', false)) {
      // Render
      $sessmoothbox = true;
      $this->view->typesmoothbox = true;
      $this->_helper->layout->setLayout('default-simple');
      $layoutOri = $this->view->layout()->orientation;
      if ($layoutOri == 'right-to-left') {
        $this->view->direction = 'rtl';
      } else {
        $this->view->direction = 'ltr';
      }

      $language = explode('_', $this->view->locale()->getLocale()->__toString());
      $this->view->language = $language[0];
    } else {
      $this->_helper->content->setEnabled();
    }


    $viewer = Engine_Api::_()->user()->getViewer();

    $this->view->createLimit = 1;
    $totalPage = Engine_Api::_()->getDbTable('epetitions', 'epetition')->countPages($viewer->getIdentity());
    $allowPageCount = Engine_Api::_()->authorization()->getPermission($viewer, 'epetition', 'page_count');
    if ($totalPage >= $allowPageCount && $allowPageCount != 0) {
      $this->view->createLimit = 0;
    } else {
      if (!isset($_GET['category_id']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetcre.bcategory', 1)) {
        $this->view->categories = Engine_Api::_()->getDbTable('categories', 'epetition')->getCategory(array('fetchAll' => true));
      }
      $this->view->defaultProfileId = 1;
    }


    $session = new Zend_Session_Namespace();
    if (empty($_POST))
      unset($session->album_id);
    $this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'epetition')->profileFieldId();
    if (isset($epetition->category_id) && $epetition->category_id != 0) {
      $this->view->category_id = $epetition->category_id;
    } else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;
    if (isset($epetition->subsubcat_id) && $epetition->subsubcat_id != 0) {
      $this->view->subsubcat_id = $epetition->subsubcat_id;
    } else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;
    if (isset($epetition->subcat_id) && $epetition->subcat_id != 0) {
      $this->view->subcat_id = $epetition->subcat_id;
    } else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
      $this->view->subcat_id = $_POST['subcat_id'];
    else
      $this->view->subcat_id = 0;

    $resource_id = $this->_getParam('resource_id', null);
    $resource_type = $this->_getParam('resource_type', null);


    // set up data needed to check quota
    $parentType = $this->_getParam('parent_type', null);
    if ($parentType)
      $event_id = $this->_getParam('event_id', null);


    $parentId = $this->_getParam('parent_id', 0);
    if ($parentId && !Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.subpetition', 1)) {
      return $this->_forward('notfound', 'error', 'core');
    }
    $values['user_id'] = $viewer->getIdentity();
    $paginator = Engine_Api::_()->getDbtable('epetitions', 'epetition')->getEpetitionPaginator($values);



    $this->view->quota = $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'epetition', 'max');
    $this->view->current_count = $paginator->getTotalItemCount();


    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'epetition')->getCategoriesAssoc();

    // Prepare form
    $this->view->form = $form = new Epetition_Form_Create(array('defaultProfileId' => $defaultProfileId, 'smoothboxType' => $sessmoothbox,));


    // If not post or form not valid, return
    if (!$this->getRequest()->isPost())
      return;

    if (!$form->isValid($this->getRequest()->getPost()))
      return;


    //check custom url

    if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
      $custom_url = Engine_Api::_()->getItemTable('epetition', 'epetition')->checkCustomUrl($_POST['custom_url']);
      if ($custom_url) {
        $form->addError($this->view->translate("Custom Url is not available. Please select another URL."));
        return;
      }
    }

    // Process
    $table = Engine_Api::_()->getItemTable('epetition', 'epetition');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try {

      // Create epetition
      $viewer = Engine_Api::_()->user()->getViewer();
      $values = array_merge($form->getValues(), array(
        'owner_type' => $viewer->getType(),
        'owner_id' => $viewer->getIdentity(),
      ));

      if (isset($values['levels']))
        $values['levels'] = implode(',', $values['levels']);

      if (isset($values['networks']))
        $values['networks'] = implode(',', $values['networks']);

      $values['ip_address'] = $_SERVER['REMOTE_ADDR'];
      $values['is_approved'] = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('epetition', $viewer, 'petition_approve');
      $epetition = $table->createRow();
      if (is_null($values['subsubcat_id']))
        $values['subsubcat_id'] = 0;
      if (is_null($values['subcat_id']))
        $values['subcat_id'] = 0;
      if ($_POST['petitionstyle'])
        $values['style'] = $_POST['petitionstyle'];


      //SEO By Default Work
      //$values['seo_title'] = $values['title'];
      if ($values['tags'])
        $values['seo_keywords'] = $values['tags'];

      $epetition->setFromArray($values);
      $epetition->save();

      // while petition create admin notification #notification 1->for admin, 2->petition owner
      $sender = Engine_Api::_()->getItem('user', $viewer->getIdentity());
      // For petition owner activity feed
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($sender, $epetition, 'epetition_adminpetcre',null ,array('user' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => $epetition['title']));
      if($action) {
        Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $epetition);
      }

      $super_admin = Engine_Api::_()->epetition()->getAdminnSuperAdmins();
      foreach ($super_admin as $super_admin_id) {
        $receiver = Engine_Api::_()->getItem('user', $super_admin_id['user_id']);
        if($super_admin_id['user_id']!=$epetition['owner_id']) {
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($receiver, $sender, $epetition, 'epetition_adminpetcre', array('user' => "<a href=" . $sender->getHref() . ">" . $sender->getTitle() . "</a>", 'petition' => $epetition['title']));
        }
      }
      if(!Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('epetition', $viewer, 'petition_approve'))
      {

        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($sender, $receiver, $epetition, 'epetition_approve', array('petition' => $epetition['title']));
        //Upload Main Image
        if (isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != '') {
          $epetition->photo_id = Engine_Api::_()->sesbasic()->setPhoto($form->photo_file, false, false, 'epetition', 'epetition', '', $epetition, true);
          $photo_id = $epetition->setPhoto($form->photo_file, 'direct');
        }
      }


      if (isset($_POST['start_date']) && $_POST['start_date'] != '') {
        $starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s', strtotime($_POST['start_date'] . ' ' . $_POST['start_time'])) : '';
        $epetition->publish_date = $starttime;
        $epetition->starttime = $starttime;
      }
      if (isset($_POST['deadline_date']) && trim($_POST['deadline_date']) != '' && isset($_POST['deadline_time']) && trim($_POST['deadline_time']) != '') {
        $epetition->endtime = isset($_POST['deadline_date']) ? date('Y-m-d H:i:s', strtotime($_POST['deadline_date'] . ' ' . $_POST['deadline_time'])) : '';
      }

      if (isset($_POST['start_date']) && $viewer->timezone && $_POST['start_date'] != '') {
        //Convert Time Zone
        $oldTz = date_default_timezone_get();
        date_default_timezone_set($viewer->timezone);
        $start = strtotime($_POST['start_date'] . ' ' . $_POST['start_time']);
        date_default_timezone_set($oldTz);
        $epetition->publish_date = date('Y-m-d H:i:s', $start);
      }

      $epetition->parent_id = $parentId;
      $epetition->save();

      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
        $epetition->custom_url = trim($_POST['custom_url']);
      else
        $epetition->custom_url = $epetition->epetition_id;
      $epetition->save();

      $epetition_id = $epetition->epetition_id;

      $roleTable = Engine_Api::_()->getDbtable('roles', 'epetition');
      $row = $roleTable->createRow();
      $row->epetition_id = $epetition_id;
      $row->user_id = $viewer->getIdentity();
      $row->resource_approved = '1';
      $row->save();

      // Other module work
      if (!empty($resource_type) && !empty($resource_id)) {
        $epetition->resource_id = $resource_id;
        $epetition->resource_type = $resource_type;
        $epetition->save();
      }

      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '') {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $epetition_id . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","epetition")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      }

      if ($parentType == 'epetition') {
        $epetition->parent_type = $parentType;
        $epetition->event_id = $event_id;
        $epetition->save();
        $eeventpetition = Engine_Api::_()->getDbtable('mapevents', 'epetition')->createRow();
        $eeventpetition->event_id = $event_id;
        $eeventpetition->epetition_id = $epetition_id;
        $eeventpetition->save();
      }

      if (isset($_POST['cover']) && !empty($_POST['cover'])) {
        $epetition->photo_id = $_POST['cover'];
        $epetition->save();
      }

      $customfieldform = $form->getSubForm('fields');
      if (!is_null($customfieldform)) {
        $customfieldform->setItem($epetition);
        $customfieldform->saveValues();
      }

      // Auth
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

      if (empty($values['auth_view'])) {
        $values['auth_view'] = 'everyone';
      }

      if (empty($values['auth_comment'])) {
        $values['auth_comment'] = 'everyone';
      }

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
      $videoMax = array_search(isset($values['auth_video']) ? $values['auth_video'] : '', $roles);
      $musicMax = array_search(isset($values['auth_music']) ? $values['auth_music'] : '', $roles);

      foreach ($roles as $i => $role) {
        $auth->setAllowed($epetition, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($epetition, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($epetition, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($epetition, $role, 'music', ($i <= $musicMax));
      }

      // Add tags
      $tags = preg_split('/[,]+/', $values['tags']);
      //$epetition->seo_keywords = implode(',',$tags);
      //$epetition->seo_title = $epetition->title;

      $epetition->save();
      $epetition->tags()->addTagMaps($viewer, $tags);


      $session = new Zend_Session_Namespace();
      if (!empty($session->album_id)) {
        $album_id = $session->album_id;
        if (isset($epetition_id) && isset($epetition->title)) {
          Engine_Api::_()->getDbTable('albums', 'epetition')->update(array('epetition_id' => $epetition_id, 'owner_id' => $viewer->getIdentity(), 'title' => $epetition->title), array('album_id = ?' => $album_id));
          if (isset($_POST['cover']) && !empty($_POST['cover'])) {
            Engine_Api::_()->getDbTable('albums', 'epetition')->update(array('photo_id' => $_POST['cover']), array('album_id = ?' => $album_id));
          }
          Engine_Api::_()->getDbTable('photos', 'epetition')->update(array('epetition_id' => $epetition_id), array('album_id = ?' => $album_id));
          unset($session->album_id);
        }
      }



      // Add activity only if epetition is published
      if ($values['draft'] == 0 && $values['is_approved'] == 1 && (!$epetition->publish_date || strtotime($epetition->publish_date) <= time())) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $epetition, 'epetition_new');
        // make sure action exists before attaching the epetition to the activity
        if ($action) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $epetition);
        }

        //Tag Work
        if ($action && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags) {
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          foreach ($tags as $tag) {
            $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("' . $action->getIdentity() . '", "' . $tag . '")');
          }
        }

        //Send notifications for subscribers
        Engine_Api::_()->getDbtable('subscriptions', 'epetition')->sendNotifications($epetition);
        $epetition->is_publish = 1;
        $epetition->save();
      }
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    $autoOpenSharePopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.autoopenpopup', 1);
    if ($autoOpenSharePopup && $epetition->draft && $epetition->is_approved) {
      $_SESSION['newPage'] = true;
    }


    $redirect = Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.redirect.creation', 0);
    if ($parentType) {
      echo 1;
      exit();
      $eventCustom_url = Engine_Api::_()->getItem('sesevent_event', $event_id)->custom_url;
      return $this->_helper->redirector->gotoRoute(array('id' => $eventCustom_url), 'sesevent_profile', true);
    } else if (!empty($resource_id) && !empty($resource_type)) {
      // Other module work
      $resource = Engine_Api::_()->getItem($resource_type, $resource_id);
      header('location:' . $resource->getHref());
      die;
    } else if ($redirect) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'dashboard', 'action' => 'edit', 'epetition_id' => $epetition->custom_url), 'epetition_dashboard', true);
    } else {
      return $this->_helper->redirector->gotoRoute(array('action' => 'view', 'epetition_id' => $epetition->custom_url), 'epetition_entry_view', true);
    }
  }

  public function customUrlCheckAction()
  {
    $value = $this->sanitize($this->_getParam('value', null));
    if (!$value) {
      echo json_encode(array('error' => true));
      die;
    }
    $epetition_id = $this->_getParam('epetition_id', null);
    $custom_url = Engine_Api::_()->getItemTable('epetition')->checkCustomUrl($value, $epetition_id);
    if ($custom_url) {
      echo json_encode(array('error' => true, 'value' => $value));
      die;
    } else {
      echo json_encode(array('error' => false, 'value' => $value));
      die;
    }
  }

  function sanitize($string, $force_lowercase = true, $anal = false)
  {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
      "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
      "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
    return ($force_lowercase) ?
      (function_exists('mb_strtolower')) ?
        mb_strtolower($clean, 'UTF-8') :
        strtolower($clean) :
      $clean;
  }

  public function viewAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $id = $this->_getParam('epetition_id', null);
    $this->view->epetition_id = $epetition_id = Engine_Api::_()->getDbtable('epetitions', 'epetition')->getPetitionId($id);

    if (!Engine_Api::_()->core()->hasSubject()) {
      $epetition = Engine_Api::_()->getItem('epetition', $epetition_id);
    } else {
      $epetition = Engine_Api::_()->core()->getSubject();
    }

    if (!$this->_helper->requireSubject()->isValid())
      return;

    if (!$this->_helper->requireAuth()->setAuthParams($epetition, $viewer, 'view')->isValid())
      return;

    if (!$epetition || !$epetition->getIdentity() || ((!$epetition->is_approved || $epetition->draft) && !$epetition->isOwner($viewer)))
    {
      $viewer = Engine_Api::_()->user()->getViewer();
      if(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'epetition', 'view')!=2)
      {
        return $this->_helper->requireSubject->forward();
       }

    }


    //Privacy: networks and member level based
    if (Engine_Api::_()->authorization()->isAllowed('epetition', $epetition->getOwner(), 'allow_levels') || Engine_Api::_()->authorization()->isAllowed('epetition', $epetition->getOwner(), 'allow_networks')) {
      $returnValue = Engine_Api::_()->epetition()->checkPrivacySetting($epetition->getIdentity());
      if ($returnValue == false) {
        return $this->_forward('requireauth', 'error', 'core');
      }
    }


    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
      ->where('type = ?', $epetition->getType())
      ->where('id = ?', $epetition->getIdentity())
      ->limit();
    $row = $table->fetchRow($select);
    if (null !== $row && !empty($row->style)) {
      $this->view->headStyle()->appendStyle($row->style);
    }

    $this->_helper->content->setEnabled();
  }


  public function deleteAction()
  {

    $epetition = Engine_Api::_()->getItem('epetition', $this->getRequest()->getParam('epetition_id'));
    if (!$this->_helper->requireAuth()->setAuthParams($epetition, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Epetition_Form_Delete();

    if (!$epetition) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Epetition entry doesn't exist or not authorized to delete");
      return;
    }

    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $epetition->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      Engine_Api::_()->epetition()->deletePetition($epetition);

      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your petition entry has been deleted.');
    return $this->_forward('success', 'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'epetition_general', true),
      'messages' => Array($this->view->message)
    ));
  }

  function likeAction()
  {


    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }

    $type = 'epetition';
    $dbTable = 'epetitions';
    $resorces_id = 'epetition_id';
    $notificationType = 'liked';
    $actionType = 'epetition_like';
    if ($this->_getParam('type', false) && $this->_getParam('type') == 'epetition_album') {
      $type = 'epetition_album';
      $dbTable = 'albums';
      $resorces_id = 'album_id';
      $actionType = 'epetition_album_like';
    } else if ($this->_getParam('type', false) && $this->_getParam('type') == 'epetition_photo') {
      $type = 'epetition_photo';
      $dbTable = 'photos';
      $resorces_id = 'photo_id';
      $actionType = 'epetition_photo_like';
    }


    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $itemTable = Engine_Api::_()->getDbtable($dbTable, 'epetition');
    $tableLike = Engine_Api::_()->getDbtable('likes', 'core');
    $tableMainLike = $tableLike->info('name');


    $select = $tableLike->select()
      ->from($tableMainLike)
      ->where('resource_type = ?', $type)
      ->where('poster_id = ?', $viewer_id)
      ->where('poster_type = ?', 'user')
      ->where('resource_id = ?', $item_id);
    $result = $tableLike->fetchRow($select);

    if (count($result) > 0) {

      //delete
      $db = $result->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $result->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $item = Engine_Api::_()->getItem($type, $item_id);
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->like_count));
      die;
    } else {

      //update
      $db = Engine_Api::_()->getDbTable('likes', 'core')->getAdapter();
      $db->beginTransaction();
      try {

        $like = $tableLike->createRow();
        $like->poster_id = $viewer_id;
        $like->resource_type = $type;
        $like->resource_id = $item_id;
        $like->poster_type = 'user';
        $like->save();

        $itemTable->update(array('like_count' => new Zend_Db_Expr('like_count + 1')), array($resorces_id . '= ?' => $item_id));

        //Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      //Send notification and activity feed work.
      $item = Engine_Api::_()->getItem($type, $item_id);
      $subject = $item;
      $owner = $subject->getOwner();
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
        $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
        $result = $activityTable->fetchRow(array('type =?' => $actionType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          if ($subject && empty($subject->title) && $this->_getParam('type') == 'epetition_photo') {
            $album_id = $subject->album_id;
            $subject = Engine_Api::_()->getItem('epetition_album', $album_id);
          }
          $action = $activityTable->addActivity($viewer, $subject, $actionType);
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->like_count));
      die;
    }
  }

  public function manageAction()
  {

    if (!$this->_helper->requireUser()->isValid()) return;


    // Render
    $this->_helper->content
      //->setNoRender()
      ->setEnabled();

    // Prepare data
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Epetition_Form_Search();
    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('epetition', null, 'create')->checkRequire();

    $form->removeElement('show');

    // Populate form
    $categories = Engine_Api::_()->getDbtable('categories', 'epetition')->getCategoriesAssoc();
    if (!empty($categories) && is_array($categories) && $form->getElement('category')) {
      $form->getElement('category')->addMultiOptions($categories);
    }
  }


  //item favourite as per item tye given
  function favouriteAction()
  {
    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }
    if ($this->_getParam('type') == 'epetition') {
      $type = 'epetition';
      $dbTable = 'epetitions';
      $resorces_id = 'epetition_id';
      $notificationType = 'epetition_favourite';
    } else if ($this->_getParam('type') == 'epetition_photo') {
      $type = 'epetition_photo';
      $dbTable = 'photos';
      $resorces_id = 'photo_id';
      // $notificationType = 'sesevent_favourite_playlist';
    } else if ($this->_getParam('type') == 'epetition_album') {
      $type = 'epetition_album';
      $dbTable = 'albums';
      $resorces_id = 'album_id';
      // $notificationType = 'sesevent_favourite_playlist';
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $Fav = Engine_Api::_()->getDbTable('favourites', 'epetition')->getItemfav($type, $item_id);

    $favItem = Engine_Api::_()->getDbtable($dbTable, 'epetition');
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
      if (@$notificationType) {
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
        Engine_Api::_()->getDbtable('actions', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
        Engine_Api::_()->getDbtable('actions', 'activity')->detachFromActivity($item);
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->favourite_count));
      $this->view->favourite_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('favourites', 'epetition')->getAdapter();
      $db->beginTransaction();
      try {
        $fav = Engine_Api::_()->getDbTable('favourites', 'epetition')->createRow();
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
      if (@$notificationType) {
        $subject = $item;
        $owner = $subject->getOwner();
        if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity() && @$notificationType) {
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
      }
      $this->view->favourite_id = 1;
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->favourite_count, 'favourite_id' => 1));
      die;
    }
  }

  function ajaxcallforupdateAction()
  {
    $result_array = array();
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_POST['id'])) {
      $epetition_id = $_POST['id'];
      $table = Engine_Api::_()->getDbtable('signatures', 'epetition');
      $data = $table->select()
        ->where('epetition_id =?', $epetition_id)
        ->query()
        ->fetchAll();
      $sign_goal = Engine_Api::_()->getItemTable('epetition', 'epetition');
      $sign_goals = $sign_goal->select()
        ->where('epetition_id =?', $epetition_id)
        ->query()
        ->fetch();
      $result_array['status'] = true;
      $result_array['signpet'] = count($data);
      $result_array['goal'] = $sign_goals['signature_goal'];
      $result_array['pecent'] = round(((count($data) * 100) / $sign_goals['signature_goal']), 2);
    } else {
      $result_array['status'] = false;
      $result_array['signpet'] = '';
      $result_array['goal'] = '';
      $result_array['pecent'] = '';
    }
    echo json_encode($result_array);
    exit();
  }

  function ajaxcallforrecentAction()
  {
    $result_array = array();
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_POST['id'])) {
      $epetition_id = $_POST['id'];
      $table = Engine_Api::_()->getDbtable('signatures', 'epetition');
      $data = $table->select()
        ->where('epetition_id =?', $epetition_id)
        ->order('creation_date DESC')
        ->limit(5)
        ->query()
        ->fetchAll();
      $c = 0;
      foreach ($data as $item) {
        $user = Engine_Api::_()->getItem('user', $item['owner_id']);
        $new_array = array();
        $new_array['id'] = $item['signature_id'];
        $new_array['profile_photo'] = $this->view->itemPhoto($user, 'thumb.icon');
        $new_array['name'] = ((!empty($item['first_name']) && !empty($item['last_name'])) ? ($item['first_name'] . " " . $item['last_name']) : (!empty($item['owner_id']) ? "<a href=" . $user->getHref() . ">" . $user->getTitle() . "</a>" : " "));
        $new_array['create_date'] = Engine_Api::_()->epetition()->getTimeDifference($item['creation_date']);
        $new_array['support_statement'] = (strlen($item['support_statement']) > 15 ? (substr(strip_tags($item['support_statement']), 0, 15) . '...') : (strip_tags($item['support_statement'])));
        $new_array['support_reason'] = (strlen($item['support_reason']) > 20 ? substr(strip_tags($item['support_reason']), 0, 20) . '...' : strip_tags($item['support_reason']));
        array_push($result_array, $new_array);
        ++$c;
      }
      $result_array['length'] = $c;
      $result_array['status'] = 1;
      echo json_encode($result_array);
      exit();
    }
  }

  public function listAction()
  {
    // Preload info
    $this->view->viewer = Engine_Api::_()->user()->getViewer();
    $this->view->owner = $owner = Engine_Api::_()->getItem('user', $this->_getParam('user_id'));
    Engine_Api::_()->core()->setSubject($owner);

    if (!$this->_helper->requireSubject()->isValid())
      return;

    // Make form
    $form = new Epetition_Form_Search();
    $form->populate($this->getRequest()->getParams());
    $values = $form->getValues();
    $this->view->formValues = array_filter($form->getValues());
    $values['user_id'] = $owner->getIdentity();
    $epetitionTable = Engine_Api::_()->getDbtable('epetitions', 'epetition');

    // Get paginator
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('epetitions', 'epetition')->getEpetitionsPaginator($values);

    $items_per_page = Engine_Api::_()->getApi('settings', 'core')->epetition_page;
    $paginator->setItemCountPerPage($items_per_page);
    $this->view->paginator = $paginator->setCurrentPageNumber($values['page']);

    // Render
    $this->_helper->content
      //->setNoRender()
      ->setEnabled();
  }
}
