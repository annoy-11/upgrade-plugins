<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_IndexController extends Core_Controller_Action_Standard {

  public function init() {

		// only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('crowdfunding', null, 'view')->isValid() ) return;
    $id = $this->_getParam('crowdfunding_id', $this->_getParam('id', null));

    if($id) {
        $crowdfunding_id = Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding')->getCrowdfundingId($id);
        if ($crowdfunding_id) {
            $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $crowdfunding_id);
            if ($crowdfunding) {
                Engine_Api::_()->core()->setSubject($crowdfunding);
            }
        }
    }
  }

  public function currencyConverterAction() {

    //default currency
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $defaultCurrency = $settings->getSetting('sesbasic.defaultcurrency', 'USD');
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    if ($is_ajax) {
      $curr = $this->_getParam('curr', 'USD');
      $val = $this->_getParam('val', '1');
      $currencyVal = $settings->getSetting('sesbasic.' . $curr);
      echo round($currencyVal*$val,2);die;
    }

    //currecy Array
    $fullySupportedCurrenciesExists = array();
    $fullySupportedCurrencies = Engine_Api::_()->sesmultiplecurrency()->getSupportedCurrency();
    foreach ($fullySupportedCurrencies as $key => $values) {
      if ($settings->getSetting('sesbasic.' . $key))
        $fullySupportedCurrenciesExists[$key] = $values;
    }
    $this->view->form = $form = new Sesbasic_Form_Conversion();
    $form->currency->setMultioptions($fullySupportedCurrenciesExists);
    $form->currency->setValue($defaultCurrency);
  }

  public function messageownerAction() {

    if (!$this->_helper->requireUser()->isValid())
      return;

    $viewer = Engine_Api::_()->user()->getViewer();

    $user_id = $this->_getParam("user_id", null);
    $crowdfunding_id = $this->_getParam("crowdfunding_id");

    if(!Engine_Api::_()->core()->hasSubject())
      $sescrowdfunding = Engine_Api::_()->getItem('crowdfunding', $crowdfunding_id);
    else
      $sescrowdfunding = Engine_Api::_()->core()->getSubject();

    $this->view->form = $form = new Sescrowdfunding_Form_Compose();
    if($user_id) {
        $form->setTitle('Say Thank You To Doner');
        $form->setDescription('Write thank you message to doner.');
        $form->removeElement('to');
    } else {
        $form->setTitle('Message to Crowdfunding Owner');
        $form->setDescription('Create your message with the form given below. Your message will be sent to the owner of this Crowdfunding.');
        $form->removeElement('to');
    }

    if($user_id)
        $form->toValues->setValue($user_id);
    else
        $form->toValues->setValue($sescrowdfunding->owner_id);

    if (!$this->getRequest()->isPost())
      return;

    $db = Engine_Api::_()->getDbtable('messages', 'messages')->getAdapter();
    $db->beginTransaction();
    try {

      $values = $this->getRequest()->getPost();
      $form->populate($values);
      if (empty($values['title'])) {
        $error_message = Zend_Registry::get('Zend_Translate')->_('Subject is required field.');
        $form->getDecorator('errors')->setOption('escape', false);
        $form->addError($error_message);
        return;
      }

      $conversation = Engine_Api::_()->getItemTable('messages_conversation')->send($viewer, $values['toValues'], $values['title'], $values['body'] . "<br><br>" . $this->view->translate("This message corresponds to the Crowdfunding:") . '<a href='.$sescrowdfunding->getHref().'>'.$sescrowdfunding->getTitle().'</a>');

      $recipientsuser = Engine_Api::_()->getItem('user', $values['toValues']);

      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($recipientsuser, $viewer, $conversation, 'message_new');
      Engine_Api::_()->getDbtable('statistics', 'core')->increment('messages.creations');
      $db->commit();
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => false,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your message has been sent successfully.'))
      ));
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  public function tellafriendAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $crowdfunding_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('crowdfunding_id', 0);
    if(!Engine_Api::_()->core()->hasSubject())
      $sescrowdfunding = Engine_Api::_()->getItem('crowdfunding', $crowdfunding_id);
    else
      $sescrowdfunding = Engine_Api::_()->core()->getSubject();

    $this->view->form = $form = new Sescrowdfunding_Form_Tellafriend();

    //For Loggined user
    if (!empty($viewer_id)) {
      $value['sender_name'] = $viewer->getTitle();
      $value['sender_email'] = $viewer->email;
      $form->populate($value);
    }

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      $receiverIds = explode(',', $values['sescrowdfunding_receiverEmails']);
      if (!empty($values['sescrowdfunding_sendMe']))
        $receiverIds[] = $values['sescrowdfunding_sender_email'];

      $sender_email = $values['sescrowdfunding_sender_email'];

      $validator = new Zend_Validate_EmailAddress();
      $validator->getHostnameValidator()->setValidateTld(false);
      if (!$validator->isValid($sender_email)) {
        $form->addError(Zend_Registry::get('Zend_Translate')->_('Invalid sender email address value'));
        return;
      }

      foreach ($receiverIds as $receiver_id) {
        $receiver_id = trim($receiver_id, ' ');
        if (!$validator->isValid($receiver_id)) {
          $form->addError(Zend_Registry::get('Zend_Translate')->_('Please enter correct email address of the receiver(s).'));
          return;
        }
      }

      foreach ($receiverIds as $receiver_id) {

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($receiver_id, 'sescrowdfunding_tellafriendemail', array(
          'host' => $_SERVER['HTTP_HOST'],
          'crowdfunding_title' => ucfirst($sescrowdfunding->getTitle()),
          'sender_name' => $values['sescrowdfunding_sender_name'],
          'message' => '<div>' . $values['sescrowdfunding_message'] . '</div>',
          'object_link' => 'http://' . $_SERVER['HTTP_HOST'] . $sescrowdfunding->getHref(),
          'sender_email' => $sender_email,
          'queue' => false
        ));
      }

      $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => false,
        'format' => 'smoothbox',
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your message to your friend has been sent successfully.'))
      ));
    }
  }

  public function rateAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $user_id = $viewer->getIdentity();

    $rating = $this->_getParam('rating');
    $crowdfunding_id =  $this->_getParam('crowdfunding_id');


    $table = Engine_Api::_()->getDbtable('ratings', 'sescrowdfunding');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try
    {
      Engine_Api::_()->sescrowdfunding()->setRating($crowdfunding_id, $user_id, $rating);

      $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $crowdfunding_id);
      $crowdfunding->rating = Engine_Api::_()->sescrowdfunding()->getRating($crowdfunding->getIdentity());
      $crowdfunding->save();

      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    $total = Engine_Api::_()->sescrowdfunding()->ratingCount($crowdfunding->getIdentity());

    $data = array();
    $data[] = array(
      'total' => $total,
      'rating' => $rating,
    );
    return $this->_helper->json($data);
    $data = Zend_Json::encode($data);
    $this->getResponse()->setBody($data);
  }

  public function welcomeAction(){
    $this->_helper->content->setEnabled();
  }

  public function homeAction() {
    $this->_helper->content->setEnabled();
  }

  public function crowdfundingOwnerFaqsAction() {
    $this->_helper->content->setEnabled();
  }

  public function donersFaqsAction() {
    $this->_helper->content->setEnabled();
  }

  public function browseCrowdfundingsAction() {

    $integrateothermodule_id = $this->_getParam('integrateothermodule_id', null);
    $page = 'sescrowdfunding_index_' . $integrateothermodule_id;
    //Render
    $this->_helper->content->setContentName($page)->setEnabled();
  }

  
  public function browseAction() {
    $this->_helper->content->setEnabled();
  }

  public function tagsAction() {
    $this->_helper->content->setEnabled();
  }

  public function manageAction() {

    if( !$this->_helper->requireUser()->isValid() ) return;

    //Permission check
    if( !$this->_helper->requireAuth()->setAuthParams('crowdfunding', null, 'create')->isValid())
      return;

    $this->_helper->content->setEnabled();
  }

  public function manageReceivedDonationsAction() {

    if( !$this->_helper->requireUser()->isValid() ) return;

//     //Permission check
//     if( !$this->_helper->requireAuth()->setAuthParams('crowdfunding', null, 'create')->isValid())
//       return;

    $this->_helper->content->setEnabled();
  }

  public function manageDonationsAction() {

    if( !$this->_helper->requireUser()->isValid() ) return;

//     //Permission check
//     if( !$this->_helper->requireAuth()->setAuthParams('crowdfunding', null, 'create')->isValid())
//       return;

    $this->_helper->content->setEnabled();
  }

  public function createAction() {

    //Auth Check
    if( !$this->_helper->requireUser()->isValid() ) return;

    //Permission check
    if( !$this->_helper->requireAuth()->setAuthParams('crowdfunding', null, 'create')->isValid()) return;

		$viewer = Engine_Api::_()->user()->getViewer();

    $session = new Zend_Session_Namespace();
		if(empty($_POST))
      unset($session->album_id);

    if (isset($sescrowdfunding->category_id) && $sescrowdfunding->category_id != 0) {
      $this->view->category_id = $sescrowdfunding->category_id;
    } else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;

    if (isset($sescrowdfunding->subsubcat_id) && $sescrowdfunding->subsubcat_id != 0) {
      $this->view->subsubcat_id = $sescrowdfunding->subsubcat_id;
    } else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;

    if (isset($sescrowdfunding->subcat_id) && $sescrowdfunding->subcat_id != 0) {
      $this->view->subcat_id = $sescrowdfunding->subcat_id;
    } else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
      $this->view->subcat_id = $_POST['subcat_id'];
    else
      $this->view->subcat_id = 0;

    //Render
    $this->_helper->content->setEnabled();
    
    $resource_id = $this->_getParam('resource_id', null);
    $resource_type = $this->_getParam('resource_type', null);

    //$paginator = Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding')->getSescrowdfundingsPaginator($values);

    $this->view->quota = $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sescrowdfunding', 'max');
    $this->view->current_count = 0; //$paginator->getTotalItemCount();

    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'sescrowdfunding')->getCategoriesAssoc();

    //Prepare form
    $this->view->defaultProfileId = 1;
    $this->view->form = $form = new Sescrowdfunding_Form_Create(array('defaultProfileId' => 1));

    //If not post or form not valid, return
    if(!$this->getRequest()->isPost())
      return;

    if(!$form->isValid($this->getRequest()->getPost()))
      return;

    //Check custom url
    if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
      $custom_url = Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding')->checkCustomUrl($_POST['custom_url']);
      if ($custom_url) {
        $form->addError($this->view->translate("Custom Url is not available. Please select another URL."));
        return;
      }
    }

    //Process
    $table = Engine_Api::_()->getDbTable('crowdfundings', 'sescrowdfunding');
    $db = $table->getAdapter();
    $db->beginTransaction();
    try {

      $values = $form->getValues();

      $values['owner_id'] = $viewer->getIdentity();

      //Create
      $sescrowdfunding = $table->createRow();
      if (is_null($values['subsubcat_id']))
        $values['subsubcat_id'] = 0;
      if (is_null($values['subcat_id']))
        $values['subcat_id'] = 0;
      $values['crowdfunding_contact_name'] = $viewer->getTitle();
      $values['crowdfunding_contact_email'] = $viewer->email;
      $sescrowdfunding->setFromArray($values);

      //Set photo
      if( !empty($values['photo_file']) ) {
        $sescrowdfunding->setPhoto($form->photo_file);
      }

        if(isset($_POST['start_date']) && $_POST['start_date'] != '') {
            $starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['start_date'].' '.$_POST['start_time'])) : '';
            $sescrowdfunding->publish_date =$starttime;
        }

        if(isset($_POST['start_date']) && $viewer->timezone && $_POST['start_date'] != ''){
            //Convert Time Zone
            $oldTz = date_default_timezone_get();
            date_default_timezone_set($viewer->timezone);
            $start = strtotime($_POST['start_date'].' '.$_POST['start_time']);
            date_default_timezone_set($oldTz);
            $sescrowdfunding->publish_date = date('Y-m-d H:i:s', $start);
        } else {
            $sescrowdfunding->publish_date = date('Y-m-d H:i:s',strtotime("-2 minutes", time()));
        }

      $sescrowdfunding->save();
      $crowdfunding_id = $sescrowdfunding->crowdfunding_id;

      // Custom url work
      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
        $sescrowdfunding->custom_url = $_POST['custom_url'];
      else
        $sescrowdfunding->custom_url = $sescrowdfunding->crowdfunding_id;

      $sescrowdfunding->save();
      
			// Other module work
			if(!empty($resource_type) && !empty($resource_id)) {
        $sescrowdfunding->resource_id = $resource_id;
        $sescrowdfunding->resource_type = $resource_type;
        $sescrowdfunding->save();
			}
			
      //Location work
      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '') {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $crowdfunding_id . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","crowdfunding")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      }

      //Auth
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

      if( empty($values['auth_view']) ) {
        $values['auth_view'] = 'everyone';
      }

      if( empty($values['auth_comment']) ) {
        $values['auth_comment'] = 'everyone';
      }
      if (!Engine_Api::_()->authorization()->getPermission($viewer, 'crowdfunding', 'crwdapprove')) {
          $sescrowdfunding->approved = 0;
          $sescrowdfunding->save();
      }
      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
      $videoMax = array_search(@$values['auth_video'], $roles);
      foreach( $roles as $i => $role ) {
        $auth->setAllowed($sescrowdfunding, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($sescrowdfunding, $role, 'comment', ($i <= $commentMax));

        $auth->setAllowed($sescrowdfunding, $role, 'video', ($i <= $videoMax));
      }

      // Add tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $sescrowdfunding->save();
      $sescrowdfunding->tags()->addTagMaps($viewer, $tags);

        //Add fields
        $customfieldform = $form->getSubForm('fields');
        if ($customfieldform) {
            $customfieldform->setItem($sescrowdfunding);
            $customfieldform->saveValues();
        }

      $session = new Zend_Session_Namespace();

      if(!empty($session->album_id)) {

				$album_id = $session->album_id;
				if(isset($crowdfunding_id) && isset($sescrowdfunding->title)) {

					Engine_Api::_()->getDbTable('albums', 'sescrowdfunding')->update(array('crowdfunding_id' => $crowdfunding_id,'owner_id' => $viewer->getIdentity(),'title' => $sescrowdfunding->title), array('album_id = ?' => $album_id));
					if(isset ($_POST['cover']) && !empty($_POST['cover'])) {
						Engine_Api::_()->getDbTable('albums', 'sescrowdfunding')->update(array('photo_id' => $_POST['cover']), array('album_id = ?' => $album_id));
					}

					Engine_Api::_()->getDbTable('photos', 'sescrowdfunding')->update(array('crowdfunding_id' => $crowdfunding_id), array('album_id = ?' => $album_id));
					unset($session->album_id);
				}
      }

      //Add activity only if sescrowdfunding is published
      //if( $values['draft'] == 0 && (!$sescrowdfunding->publish_date || strtotime($sescrowdfunding->publish_date) <= time())) {
      if( $values['draft'] == 0) {

        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sescrowdfunding, 'sescrowdfunding_create');
        if( $action ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sescrowdfunding);
        }

      	$sescrowdfunding->draft = 0;
      	$sescrowdfunding->save();
      }
      //Commit
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $redirect = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.redirect', 1);
    if(!empty($resource_id) && !empty($resource_type)) {
      // Other module work
      $resource = Engine_Api::_()->getItem($resource_type, $resource_id);
      header('location:' . $resource->getHref());
      die;
    } else if(empty($redirect)) {
        return $this->_helper->redirector->gotoRoute(array('action' =>  'dashboard','action'=>'edit','crowdfunding_id' => $sescrowdfunding->custom_url),'sescrowdfunding_dashboard',true);
    } else {
        return $this->_helper->redirector->gotoRoute(array('action' => 'view','crowdfunding_id' => $sescrowdfunding->custom_url),'sescrowdfunding_entry_view',true);
    }
  }

  public function deleteAction() {

    $sescrowdfunding = Engine_Api::_()->getItem('crowdfunding', $this->getRequest()->getParam('crowdfunding_id'));
    if( !$this->_helper->requireAuth()->setAuthParams($sescrowdfunding, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sescrowdfunding_Form_Delete();

    if( !$sescrowdfunding ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Sescrowdfunding entry doesn't exist or not authorized to delete");
      return;
    }

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $sescrowdfunding->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      Engine_Api::_()->sescrowdfunding()->deleteCrowdfunding($sescrowdfunding);;

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your crowdfunding entry has been deleted.');
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sescrowdfunding_general', true),
      'messages' => Array($this->view->message)
    ));
  }

  public function viewAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    $id = $this->_getParam('crowdfunding_id', null);

    $crowdfunding_id = Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding')->getCrowdfundingId($id);

    if(!Engine_Api::_()->core()->hasSubject())
      $sescrowdfunding = Engine_Api::_()->getItem('crowdfunding', $crowdfunding_id);
    else
      $sescrowdfunding = Engine_Api::_()->core()->getSubject();

    if( !$this->_helper->requireSubject()->isValid() )
      return;

    if( !$this->_helper->requireAuth()->setAuthParams($sescrowdfunding, $viewer, 'view')->isValid() )
      return;

    if( !$sescrowdfunding || !$sescrowdfunding->getIdentity() || ($sescrowdfunding->draft && !$sescrowdfunding->isOwner($viewer)))
      return $this->_helper->requireSubject->forward();

    $getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0) {
      $view->doctype('XHTML1_RDFA');
      if ($sescrowdfunding->seo_title)
        $view->headTitle($sescrowdfunding->seo_title, 'SET');
      if ($sescrowdfunding->seo_description)
        $view->headMeta()->appendName('description', $sescrowdfunding->seo_description);
    }

    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', 'crowdfunding')
            ->where('id = ?', $sescrowdfunding->getIdentity())
            ->limit();
    $row = $table->fetchRow($select);
    if (null !== $row && !empty($row->style)) {
      $this->view->headStyle()->appendStyle($row->style);
    }

    // Increment view count
    if (!$sescrowdfunding->getOwner()->isSelf($viewer)) {
      $sescrowdfunding->view_count++;
      $sescrowdfunding->save();
    }

    if ($viewer->getIdentity() != 0) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_sescrowdfunding_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $sescrowdfunding->getIdentity() . '", "' . $sescrowdfunding->getType() . '","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
    }

    if ($sescrowdfunding->pagestyle == 1)
      $page = 'sescrowdfunding_index_view_1';
    elseif ($sescrowdfunding->pagestyle == 2)
      $page = 'sescrowdfunding_index_view_2';
    elseif ($sescrowdfunding->pagestyle == 3)
      $page = 'sescrowdfunding_index_view_3';
    elseif ($sescrowdfunding->pagestyle == 4)
      $page = 'sescrowdfunding_index_view_4';

    $this->_helper->content->setContentName($page)->setEnabled();
  }

  public function customUrlCheckAction() {

    $value = $this->sanitize($this->_getParam('value', null));
    if (!$value) {
      echo json_encode(array('error' => true));
      die;
    }

    $crowdfunding_id = $this->_getParam('crowdfunding_id',null);
    $custom_url = Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding')->checkCustomUrl($value,$crowdfunding_id);
    if($custom_url) {
      echo json_encode(array('error' => true, 'value' => $value));die;
    } else {
      echo json_encode(array('error' => false,'value' => $value));die;
    }
  }

  function sanitize($string, $force_lowercase = true, $anal = false) {
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
          'type' => '<a href="' . $attachment->getHref() . '">' . $attachment->getMediaType() . '</a>',
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
    $typeItem = ucwords(str_replace(array('sescrowdfunding_'), '', $attachment->getType()));
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

  function likeAction() {

    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }

    $type = 'crowdfunding';
    $dbTable = 'crowdfundings';
    $resorces_id = 'crowdfunding_id';
    $notificationType = 'liked';
    $actionType = 'sescrowdfunding_like_crowdfunding';

    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $itemTable = Engine_Api::_()->getDbtable($dbTable, 'sescrowdfunding');
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

      //$itemTable->update(array('like_count' => new Zend_Db_Expr('like_count - 1')), array($resorces_id . ' = ?' => $item_id));

      $item = Engine_Api::_()->getItem($type, $item_id);
      $item->like_count--;
      $item->save();

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

        //$itemTable->update(array('like_count' => new Zend_Db_Expr('like_count + 1')), array($resorces_id . '= ?' => $item_id));
        $item = Engine_Api::_()->getItem($type, $item_id);
        $item->like_count++;
        $item->save();

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
          if($subject && empty($subject->title) && $this->_getParam('type') == 'sescrowdfunding_photo') {
            $album_id = $subject->album_id;
            $subject = Engine_Api::_()->getItem('sescrowdfunding_album', $album_id);
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

  public function subcategoryAction() {

    $category_id = $this->_getParam('category_id', null);
    $CategoryType = $this->_getParam('type', null);
    if ($category_id) {
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'sescrowdfunding');
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
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'sescrowdfunding');
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


  public function getCrowdfundingAction() {

    $sesdata = array();
    $value['textSearch'] = $this->_getParam('text', null);
    $value['search'] = 1;
		$value['fetchAll'] = true;
		$value['getcrowdfunding'] = true;
    $crowdfundings = Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding')->getSescrowdfundingsSelect($value);
    foreach ($crowdfundings as $crowdfunding) {
      $crowdfunding_icon = $this->view->itemPhoto($crowdfunding, 'thumb.icon');
      $sesdata[] = array(
          'id' => $crowdfunding->crowdfunding_id,
          'crowdfunding_id' => $crowdfunding->crowdfunding_id,
          'label' => $crowdfunding->title,
          'photo' => $crowdfunding_icon
      );
    }
    return $this->_helper->json($sesdata);
  }
}
