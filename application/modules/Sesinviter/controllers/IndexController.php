<?php

class Sesinviter_IndexController extends Core_Controller_Action_Standard {

  public function manageReferralsAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) return;

    // Render
    $this->_helper->content->setEnabled();

    // Prepare data
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Sesinviter_Form_ManageSearch();

    // Process form
    $defaultValues = $form->getValues();
    if( $form->isValid($this->_getAllParams()) ) {
      $values = $form->getValues();
    } else {
      $values = $defaultValues;
    }
    $this->view->formValues = array_filter($values);
    $values['user_id'] = $viewer->getIdentity();

    if( $this->getRequest()->isPost() ) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $invite = Engine_Api::_()->getItem('sesinviter_invite', $value);
          $invite->delete();
        }
      }
    }

    $tableInvite = Engine_Api::_()->getDbtable('invites', 'sesinviter');
    $inviteTableName = $tableInvite->info('name');

    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');

    $select = $tableInvite->select()
            ->from($inviteTableName)
            ->setIntegrityCheck(false)
            ->joinLeft($tableUserName, "$tableUserName.user_id = $inviteTableName.sender_id", null)
            ->where($inviteTableName.'.sender_id =?', $viewer->getIdentity())
            ->where($inviteTableName.'.new_user_id <> ?', 0)
            ->order('invite_id DESC');

    if( isset($_GET['email']) && $_GET['email'] != '')
      $select->where($tableUserName.'.email = ?', $values['email']);

    if( !empty($_GET['displayname']) )
      $select->where($tableUserName.'.displayname LIKE ?', '%' . $values['displayname'] . '%');

    if( isset($_GET['recipient_email']) && $_GET['recipient_email'] != '')
      $select->where($inviteTableName.'.recipient_email = ?', $values['recipient_email']);

    if( isset($_GET['import_method']) && $_GET['import_method'] != '')
      $select->where($inviteTableName.'.import_method = ?', $values['import_method']);

    if( !empty($values['creation_date']) )
      $select->where($inviteTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

    $page = $this->_getParam('page', 1);

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber( $values['page'] );
  }

  public function manageAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) return;

    // Render
    $this->_helper->content->setEnabled();

    // Prepare data
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Sesinviter_Form_Search();

    // Process form
    $defaultValues = $form->getValues();
    if( $form->isValid($this->_getAllParams()) ) {
      $values = $form->getValues();
    } else {
      $values = $defaultValues;
    }
    $this->view->formValues = array_filter($values);
    $values['user_id'] = $viewer->getIdentity();

    if( $this->getRequest()->isPost() ) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $invite = Engine_Api::_()->getItem('sesinviter_invite', $value);
          $invite->delete();
        }
      }
    }


    $tableInvite = Engine_Api::_()->getDbtable('invites', 'sesinviter');
    $inviteTableName = $tableInvite->info('name');

    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');

    $select = $tableInvite->select()
            ->from($inviteTableName)
            ->setIntegrityCheck(false)
            ->joinLeft($tableUserName, "$tableUserName.user_id = $inviteTableName.sender_id", null)
            ->where($inviteTableName.'.sender_id =?', $viewer->getIdentity())
            ->order('invite_id DESC');

    if( isset($_GET['email']) && $_GET['email'] != '')
      $select->where($tableUserName.'.email = ?', $values['email']);

    if( !empty($_GET['displayname']) )
      $select->where($tableUserName.'.displayname LIKE ?', '%' . $values['displayname'] . '%');

    if( isset($_GET['recipient_email']) && $_GET['recipient_email'] != '')
      $select->where($inviteTableName.'.recipient_email = ?', $values['recipient_email']);

    if( isset($_GET['import_method']) && $_GET['import_method'] != '')
      $select->where($inviteTableName.'.import_method = ?', $values['import_method']);

    if( !empty($values['creation_date']) )
      $select->where($inviteTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

    $page = $this->_getParam('page', 1);

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber( $values['page'] );
  }

  public function deleteAction() {

    $invite = Engine_Api::_()->getItem('sesinviter_invite', $this->getRequest()->getParam('id'));
    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    $this->view->form = $form = new Sesinviter_Form_Delete();
    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    $db = $invite->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $invite->delete();
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your entry has been deleted.');
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sesinviter_general', true),
      'messages' => Array($this->view->message)
    ));
  }

  public function signupAction() {

    // Psh, you're already signed up
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    if ($viewer && $viewerId) {
      return $this->_helper->redirector->gotoRoute(array(), 'default', true);
    }
    $affiliateCode = $this->_getParam('affiliate');
    if (!empty($affiliateCode)) {
      $affiliateTable = Engine_Api::_()->getDbTable('affiliates', 'sesinviter');
      $userId = $affiliateTable->select()
              ->from($affiliateTable->info('name'), 'user_id')
              ->where('affiliate =?', $affiliateCode)
              ->query()
              ->fetchColumn();
      if ($userId) {
        $session = new Zend_Session_Namespace('sesinviter_affiliate_signup');
        $session->user_id = $userId;
      }
    }
    // Get invite params
    $session = new Zend_Session_Namespace('invite');
    $session->invite_code = $this->_getParam('code');
    $session->invite_email = $this->_getParam('email');

    // Check code now if set
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if ($settings->getSetting('user.signup.inviteonly') > 0) {
      // Tsk tsk no code
      if (empty($session->invite_code)) {
        return $this->_helper->redirector->gotoRoute(array(), 'default', true);
      }

      // Check code
      $inviteTable = Engine_Api::_()->getDbtable('invites', 'invite');
      $inviteSelect = $inviteTable->select()
              ->where('code = ?', $session->invite_code);

      // Check email
      if ($settings->getSetting('user.signup.checkemail')) {
        // Tsk tsk no email
        if (empty($session->invite_email)) {
          return $this->_helper->redirector->gotoRoute(array(), 'default', true);
        }
        $inviteSelect
                ->where('recipient = ?', $session->invite_email);
      }

      $inviteRow = $inviteTable->fetchRow($inviteSelect);

      // No invite or already signed up
      if (!$inviteRow || $inviteRow->new_user_id) {
        return $this->_helper->redirector->gotoRoute(array(), 'default', true);
      }
    }

    return $this->_helper->redirector->gotoRoute(array(), 'user_signup', true);
  }

  public function saveintroAction() {

    $description = $this->_getParam('description');
    $introduce_id = $this->_getParam('introduce_id');
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if($introduce_id) {
      $introduce = Engine_Api::_()->getItem('sesinviter_introduce', $introduce_id);
      $introduce->delete();
    }

    $introduce = Engine_Api::_()->getDbtable('introduces', 'sesinviter')->createRow();
    $introduce->description = $description;
    $introduce->user_id = $viewer_id;
    $introduce->save();
    echo json_encode(array('status' => 1, 'introduce_id' => $introduce->getIdentity()));die;
  }

  public function csvimportAction() {

    $socialMediaName = $this->_getParam('socialMediaName', null);
    $is_ajax = $this->_getParam('is_ajax', null);
    $settings = Engine_Api::_()->getApi('settings', 'core');

    if($socialMediaName == 'gmail' && !empty($is_ajax)) {

      $socialEmails = $this->_getParam('socialEmails', null);
      if(empty($socialEmails)) {
        echo json_encode(array('status'=>"false"));die;
      } else {
        $socialEmails = explode(',', $socialEmails);
        $importedData = array();
        foreach($socialEmails as $key => $socialEmail) {
          $socialContent = explode('||', $socialEmail);
          if(!$socialContent[0] && !$socialContent[1]) continue;
          if (filter_var($socialContent[0], FILTER_VALIDATE_EMAIL)) {
            $importedData[] = array('name' => $socialContent[1], 'email' => $socialContent[0]);
          }
        }

        if($importedData) {
          $showData =  $this->view->partial('_csvimport.tpl','sesinviter',array('importedData' => $importedData, 'importmethod' => 'gmail'));
        }
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'importmethod' => 'gmail'));exit();
      }
    } else if($socialMediaName == 'hotmail') {

			$client_id = 	$settings->getSetting('sesinviter.hotmailclientid',false);
			$client_secret = $settings->getSetting('sesinviter.hotmailclientsecret',false);

			$baseURL = Zend_Registry::get('StaticBaseUrl');

			if($baseURL)
				$baseurl = $baseURL;
			else
				$baseurl = '/';

			$redirect_uri = ( isset($_SERVER["HTTPS"]) && (strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] .$baseurl.'sesinviter/index/csvimport/socialMediaName/hotmail/';

      if(!isset($_GET['code'])) {
        $urls_ = 'https://login.live.com/oauth20_authorize.srf?client_id='.$client_id.'&scope=wl.signin%20wl.basic%20wl.emails%20wl.contacts_emails&response_type=code&redirect_uri='.$redirect_uri;

        header('location:'.$urls_);
      }
			if(isset($_GET['code'])) {
				$auth_code = $_GET["code"];
				$fields=array(
				'code'=>  urlencode($auth_code),
				'client_id'=>  urlencode($client_id),
				'client_secret'=>  urlencode($client_secret),
				'redirect_uri'=>  urlencode($redirect_uri),
				'grant_type'=>  urlencode('authorization_code')
				);
				$post = '';
				foreach($fields as $key=>$value) { $post .= $key.'='.$value.'&'; }
				$post = rtrim($post,'&');
				$curl = curl_init();
				curl_setopt($curl,CURLOPT_URL,'https://login.live.com/oauth20_token.srf');
				curl_setopt($curl,CURLOPT_POST,5);
				curl_setopt($curl,CURLOPT_POSTFIELDS,$post);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
				$result = curl_exec($curl);
				curl_close($curl);
				$response =  json_decode($result);
				$accesstoken = $response->access_token;
				$url = 'https://apis.live.net/v5.0/me/contacts?access_token='.$accesstoken.'&limit=500';
				$xmlresponse =  $this->curl_file_get_contents($url);
				$xml = json_decode($xmlresponse, true);
				$msn_email = "";
				$counter = 0;
				foreach($xml['data'] as $emails) {

					$execute = false;
					$name = $emails['name'];
					$email_ids = implode(",",array_unique($emails['emails'])); //will get more email primary,sec etc with comma separate
					$email_ids = trim($email_ids,',');
					if(count(explode(',',$email_ids))){
						$dataEx = explode(',',$email_ids);
						foreach($dataEx as $val){
							if(!$val)
								continue;
							$importedData[$counter]['email'] = $val;
							$importedData[$counter]['name'] = $name;
							$execute = true;
							$counter++;
						}
					}
          if(!$execute){
            $importedData[$counter]['email'] = $email_ids;
            $importedData[$counter]['name'] = $name;
            $counter++;
          }
				}
			}
    } elseif($socialMediaName == 'yahoo' && empty($is_ajax)) {

			define('OAUTH_CONSUMER_KEY', $settings->getSetting('sesinviter.yahooconsumerkey',''));
			define('OAUTH_CONSUMER_SECRET', $settings->getSetting('sesinviter.yahooconsumersecret',''));
			define('OAUTH_DOMAIN',( isset($_SERVER["HTTPS"]) && (strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] );
			define('OAUTH_APP_ID', $settings->getSetting('sesinviter.yahooappid',false));
			// Include the YOS library.
			require realpath(dirname(__FILE__) . '/..').DIRECTORY_SEPARATOR.'Api'.DIRECTORY_SEPARATOR.'Import'.DIRECTORY_SEPARATOR.'Yahoo'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'Yahoo.inc';
			$hasSession = YahooSession::hasSession(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, OAUTH_APP_ID);
			if($hasSession == FALSE) {
					// create the callback url,
					$callback = YahooUtil::current_url()."?in_popup";
					$sessionStore = new NativeSessionStore();
					// pass the credentials to get an auth url.
					// this URL will be used for the pop-up.
				 header("location:".YahooSession::createAuthorizationUrl(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $callback, $sessionStore));
				 die;
			} else {
        // pass the credentials to initiate a session
        $session = YahooSession::requireSession(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, OAUTH_APP_ID);
        // if the in_popup flag is detected,
        // the pop-up has loaded the callback_url and we can close this window.
        //if(array_key_exists("in_popup", $_GET)) { echo "sdf";die;

        // if a session is initialized, fetch the user's profile information
        if($session) {
          // Get the currently sessioned user.
          $user = $session->getSessionedUser();
          // Load the profile for the current user.
          $profile = $user->getProfile();
          $profile_contacts=$this->XmltoArray($user->getContactSync());
          $counter = 0;
          foreach($profile_contacts['contactsync']['contacts'] as $key=>$profileContact){
            foreach($profileContact['fields'] as $contact){
                if($contact['type'] == 'name'){
                  $importedData[$counter]['name']=$contact['value']['givenName'];
                if($contact['value']['middleName'] != '')
                  $importedData[$counter]['name'] = $importedData[$key]['name'] .' '.$contact['value']['middleName'];
                if($contact['value']['familyName'] != '')
                  $importedData[$counter]['name'] = $importedData[$key]['name'].' '.$contact['value']['familyName'];
                }else if($contact['type'] == 'email'){
                    $importedData[$counter]['email'] .= $contact['value'];
                }
              }
              if(!isset($importedData[$counter]['email']))
              unset($importedData[$counter]);
              $counter++;
          }

        ?>
        <script type="text/javascript">
          window.opener.inviterYahooData('<?php echo Zend_Json::encode($importedData); ?>');
          window.close();
        </script>
        <?php
        }
      }
    } else if($socialMediaName == 'yahoo' && !empty($is_ajax)) {

      $socialEmails = $this->_getParam('socialEmails', null);
      $socialEmails = Zend_Json::decode($socialEmails);
      if(empty($socialEmails)) {
        echo json_encode(array('status'=>"false"));die;
      } else {
        $importedData = $socialEmails;
        if($importedData) {
          $showData =  $this->view->partial('_csvimport.tpl','sesinviter',array('importedData' => $importedData, 'importmethod' => 'yahoo'));
        }
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'importmethod' => 'yahoo'));exit();
      }
    } else if($socialMediaName == 'twitter' && empty($is_ajax)) {

      $key = $settings->getSetting('sesinviter.twitterclientid','');
      $screatKey = $settings->getSetting('sesinviter.twitterclientsecret','');

      if( isset($_SESSION['twitter_token'], $_SESSION['twitter_secret'],
        $_GET['oauth_verifier']) ) {

        //Include the Twitter library.
        require realpath(dirname(__FILE__) . '/..').DIRECTORY_SEPARATOR.'Api'.DIRECTORY_SEPARATOR.'Import'.DIRECTORY_SEPARATOR.'Twitter'.DIRECTORY_SEPARATOR.'twitteroauth.php';

        // Load classes
        include_once 'Services/Twitter.php';
        include_once 'HTTP/OAuth/Consumer.php';

        if( !class_exists('Services_Twitter', false) ||
            !class_exists('HTTP_OAuth_Consumer', false) ) {
          throw new Core_Model_Exception('Unable to load twitter API classes');
        }

        $api = new Services_Twitter();

        // Get oauth
        $oauth = $this->_oauth = new HTTP_OAuth_Consumer($key, $screatKey, $_SESSION['twitter_token'], $_SESSION['twitter_secret']);

        $api->setOAuth($oauth);

        $oauth->getAccessToken('https://twitter.com/oauth/access_token', $_GET['oauth_verifier']);

        $twitter_token = $oauth->getToken();
        $twitter_secret = $oauth->getTokenSecret();

        $accountInfo = $api->account->verify_credentials(array('include_email' => 'true'));


        $tweet = new TwitterOAuth($key, $screatKey, $_SESSION['oauth_token'], $_SESSION['twitter_secret']);

        $out="";
        $t = json_decode($tweet->get('followers/list', array('screen_name' => $accountInfo->screen_name, 'count' => 200)), true);
        $counter = 0;
        $followersList = array();
        foreach($t['users'] as $followerList) {
          $followersList[$counter]['screen_name'] = $followerList['screen_name'];
          $followersList[$counter]['name'] = $followerList['name'];
          $counter++;
        }

        $importedData = $followersList;

        ?>
        <script type="text/javascript">
          window.opener.inviterTwitterData('<?php echo Zend_Json::encode($importedData); ?>');
          window.close();
        </script>
        <?php

      } else {

        // Load classes
        include_once 'Services/Twitter.php';
        include_once 'HTTP/OAuth/Consumer.php';

        if( !class_exists('Services_Twitter', false) ||
            !class_exists('HTTP_OAuth_Consumer', false) ) {
          throw new Core_Model_Exception('Unable to load twitter API classes');
        }

        $api = new Services_Twitter();

        // Get oauth
        $oauth = new HTTP_OAuth_Consumer($key, $screatKey);
        $api->setOAuth($oauth);

        // Connect account
        $oauth->getRequestToken('https://twitter.com/oauth/request_token', 'http://' . $_SERVER['HTTP_HOST'].$this->view->url());

        $_SESSION['twitter_token']  = $oauth->getToken();
        $_SESSION['twitter_secret'] = $oauth->getTokenSecret();

        $url = $oauth->getAuthorizeUrl('http://twitter.com/oauth/authenticate');
        return $this->_helper->redirector->gotoUrl($url, array('prependBase' => false));
      }
    } else if($socialMediaName == 'twitter' && !empty($is_ajax)) {

      $socialEmails = $this->_getParam('socialEmails', null);
      $socialEmails = Zend_Json::decode($socialEmails);
      if(empty($socialEmails)) {
        echo json_encode(array('status'=>"false"));die;
      } else {
        $importedData = $socialEmails;
        if($importedData) {
          $showData =  $this->view->partial('_csvimport.tpl','sesinviter',array('importedData' => $importedData, 'importmethod' => 'twitter'));
        }
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'importmethod' => 'twitter'));exit();
      }
    }

    if(isset($_FILES['contact']) && $_FILES['contact']['name'] != '') {

      $csv_file = $_FILES['contact']['tmp_name']; // specify CSV file path

      $csvfile = fopen($csv_file, 'r');
      $theData = fgets($csvfile);
      $thedata = explode(',',$theData);
      $name = $email = $counter = 0;

      foreach($thedata as $data) {

        //Direct CSV
        if(trim(strtolower($data)) == 'name'){
          $name = $counter;
        } else if(trim(strtolower($data)) == 'email'){
          $email = $counter;
        }

        //Outlook
        if($data == 'First Name'){
          $name = $counter;
        } else if($data == 'E-mail Address'){
          $email = $counter;
        }

        //Yahoo
        if($data == '"First"'){
          $name = $counter;
        } else if($data == '"Email"'){
          $email = $counter;
        }

        $counter++;
      }

      $i = 0;
      $importedData = array();
      while (!feof($csvfile))
      {
        $csv_data[] = fgets($csvfile, 1024);
        $csv_array = explode(",", $csv_data[$i]);
        if(!count($csv_array))
          continue;

        if($_FILES['contact']['name'] == 'yahoo_contacts.csv') {

          $email = trim($csv_array[$email], '"');
          if(empty($email)) continue;
          $importedData[$i]['name'] = trim($csv_array[$name], '"');

          if(isset($email))
            $importedData[$i]['email'] = $email;

          if(!$importedData[$i]['email'] && !$importedData[$i]['name'])
            unset($importedData[$i]);

        } else {
        if(isset($csv_array[$name]))
            $importedData[$i]['name'] = $csv_array[$name];
          if(isset($csv_array[$email]))
            $importedData[$i]['email'] = $csv_array[$email];
          if(!$importedData[$i]['email'] && !$importedData[$i]['name'])
            unset($importedData[$i]);
        }
        $i++;
      }
      fclose($csvfile);


      if($importedData) {
        $showData =  $this->view->partial('_csvimport.tpl','sesinviter',array('importedData' => $importedData, 'importmethod' => 'csv'));
      }
      echo Zend_Json::encode(array('status' => 1, 'message' => $showData, 'importmethod' => 'csv'));exit();
    }
    echo json_encode(array('status'=>"false"));die;

  }

	function XmltoArray($xml) {

    $array = json_decode(json_encode($xml), TRUE);

    foreach ( array_slice($array, 0) as $key => $value ) {
      if ( empty($value) ) $array[$key] = NULL;
      elseif ( is_array($value) ) $array[$key] = $this->XmltoArray($value);
    }

    return $array;
  }


  public function inviterefAction() {

    //Take Reference From SE Invite module
    $settings = Engine_Api::_()->getApi('settings', 'core');

    // Check if admins only
    if ($settings->getSetting('user.signup.inviteonly') == 1) {
      if (!$this->_helper->requireAdmin()->isValid()) {
        return;
      }
    }

    // Check for users only
    if (!$this->_helper->requireUser()->isValid()) {
      return;
    }

    $enableSignupReferral = $settings->getSetting('sesinviter.affiliateforsingup', 1);
    if (!$enableSignupReferral) {
      return;
    }

    // Make form
    $this->view->form = $form = new Sesinviter_Form_Inviteref();

    if (!$this->getRequest()->isPost()) {
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    // Process
    $values = $form->getValues();

    $viewer = Engine_Api::_()->user()->getViewer();
    $inviteTable = Engine_Api::_()->getDbtable('invites', 'invite');
    $db = $inviteTable->getAdapter();
    $db->beginTransaction();
    try {
      $emailsSent = Engine_Api::_()->getDbtable('invites', 'sesinviter')->sendInvites($viewer, $values['recipients'], @$values['message'], $values['friendship']);
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      if (APPLICATION_ENV == 'development') {
        throw $e;
      }
    }
    //$this->view->alreadyMembers = $alreadyMembers;
    $this->view->emails_sent = $emailsSent;

    return $this->render('sent');
  }

  public function inviteAction() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $is_ajax = $this->_getParam('is_ajax', 0);

    if(!$is_ajax)
      $this->_helper->content->setEnabled();

    // Check if admins only
    if( $settings->getSetting('user.signup.inviteonly') == 1 ) {
      if( !$this->_helper->requireAdmin()->isValid() ) {
        return;
      }
    }

    // Check for users only
    if( !$this->_helper->requireUser()->isValid() ) {
      return;
    }

    if(empty($is_ajax)) {
      // Make form
      $this->view->form = $form = new Sesinviter_Form_Invite();

      if( !$this->getRequest()->isPost() ) {
        return;
      }

      if( !$form->isValid($this->getRequest()->getPost()) ) {
        return;
      }
    }

    if (isset($_POST['params']) && $_POST['params'])
      parse_str($_POST['params'], $searchArray);

    $viewer = Engine_Api::_()->user()->getViewer();
    $inviteTable = Engine_Api::_()->getDbtable('invites', 'invite');
    $db = $inviteTable->getAdapter();
    $db->beginTransaction();

    try {
      $emailsSent = $inviteTable->sendInvites($viewer, $searchArray['recipients'], @$searchArray['message'],$searchArray['friendship']);
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      if( APPLICATION_ENV == 'development' ) {
        throw $e;
      }
    }
    echo json_encode(array('emails_sent' => $emailsSent));
    //$this->view->alreadyMembers = $alreadyMembers;
    //$this->view->emails_sent = $emailsSent;
    die;
    //return $this->render('sent');
  }


  public function importinviteAction() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $viewer = Engine_Api::_()->user()->getViewer();

    // Check if admins only
    if( $settings->getSetting('user.signup.inviteonly') == 1 ) {
      if( !$this->_helper->requireAdmin()->isValid() ) {
        return;
      }
    }

    // Check for users only
    if( !$this->_helper->requireUser()->isValid() ) {
      return;
    }

    $importEmails = $_POST['importEmails'];
    $importEmails = explode(',', $importEmails);


    if($_POST['import_subject']) {
      $import_subject = $_POST['import_subject'];
    } else {
      $import_subject = 'You have received an invitation to join our social network.';
    }
    $import_message = $_POST['import_message'];

    $viewer = Engine_Api::_()->user()->getViewer();
    $inviteTable = Engine_Api::_()->getDbtable('invites', 'sesinviter');
    //$db = $inviteTable->getAdapter();
    //$db->beginTransaction();

    try {

      if($_POST['import_method'] != 'twitter') {
        foreach($importEmails as $importEmail) {

          if(empty($importEmail)) continue;

          $getAlreadyEmail = Engine_Api::_()->getDbtable('invites', 'sesinviter')->getAlreadyEmail($viewer->user_id, $importEmail);
          if(empty($getAlreadyEmail)) {
            $row = $inviteTable->createRow();
            $values['sender_id'] = $viewer->user_id;
            $values['recipient_email'] = $importEmail;
            $values['subject'] = $import_subject;
            $values['message'] = $import_message;
            $values['import_method'] = $_POST['import_method'];
            $row->setFromArray($values);
            $row->save();
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($importEmail, 'sesinviter_invitation', array('host' => $_SERVER['HTTP_HOST'], 'message' => $import_message,'sender_title' => $viewer->getTitle()));
          }
        }
      } else {

        $key = $settings->getSetting('sesinviter.twitterclientid','');
        $screatKey = $settings->getSetting('sesinviter.twitterclientsecret','');

        //Include the Twitter library.
        require realpath(dirname(__FILE__) . '/..').DIRECTORY_SEPARATOR.'Api'.DIRECTORY_SEPARATOR.'Import'.DIRECTORY_SEPARATOR.'Twitter'.DIRECTORY_SEPARATOR.'twitteroauth.php';

        $tweet = new TwitterOAuth($key, $screatKey, $_SESSION['oauth_token'], $_SESSION['twitter_secret']);
        foreach($importEmails as $importEmail) {
          if(empty($importEmail)) continue;
          $tweet->post('direct_messages/new', array('screen_name' => $importEmail, 'text' => $import_message));
          //$out = $out."Username ".$user['screen_name']." ID ".$user['id_str']."<br>";
        }
      }
      //$emailsSent = $inviteTable->sendInvites($viewer, $searchArray['recipients'], @$searchArray['message'],$searchArray['friendship']);
      //$db->commit();
      echo json_encode(array('emails_sent' => 1));die;
    } catch( Exception $e ) {
      $db->rollBack();
      if( APPLICATION_ENV == 'development' ) {
        throw $e;
      }
    }
  }
}
