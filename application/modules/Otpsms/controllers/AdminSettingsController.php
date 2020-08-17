<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Otpsms_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('otpsms_admin_main', array(), 'otpsms_admin_main_settings');
    $this->view->form = $form = new Otpsms_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())){

      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Otpsms/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('otpsms.pluginactivated')) {
        foreach ($values as $key => $value){
            if($key == "otpsms_allowed_countries"){
            if(Engine_Api::_()->getApi('settings', 'core')->hasSetting($key))
                Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
            }
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  function manageUsersAction(){
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('otpsms_admin_main', array(), 'otpsms_admin_main_manageusers');
    $this->view->formFilter = $formFilter = new Otpsms_Form_Admin_Manage_Filter();
    $page = $this->_getParam('page', 1);

    $table = Engine_Api::_()->getDbtable('users', 'user');
    $select = $table->select();

    // Process form
    $values = array();
    if( $formFilter->isValid($this->_getAllParams()) ) {
      $values = $formFilter->getValues();
    }

    foreach( $values as $key => $value ) {
      if( null === $value ) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array(
      'order' => 'user_id',
      'order_direction' => 'DESC',
    ), $values);

    $this->view->assign($values);

    // Set up select info
    $select->order(( !empty($values['order']) ? $values['order'] : 'user_id' ) . ' ' . ( !empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));

    if( !empty($values['displayname']) ) {
      $select->where('displayname LIKE ?', '%' . $values['displayname'] . '%');
    }
    if( !empty($values['phone_number']) ) {
      $select->where('phone_number LIKE ?', '%' . $values['phone_number'] . '%');
    }
    if( isset($values['country_code']) && $values['country_code'] != 0 &&  $values['country_code'] != '' ) {
      $select->where('country_code = ?', $values['country_code']);
    }
    if( !empty($values['username']) ) {
      $select->where('username LIKE ?', '%' . $values['username'] . '%');
    }
    if( !empty($values['email']) ) {
      $select->where('email LIKE ?', '%' . $values['email'] . '%');
    }
    if( !empty($values['level_id']) ) {
      $select->where('level_id = ?', $values['level_id'] );
    }
    if( isset($values['enabled']) && $values['enabled'] != -1 ) {
      $select->where('enabled = ?', $values['enabled'] );
    }
    if( !empty($values['user_id']) ) {
      $select->where('user_id = ?', (int) $values['user_id']);
    }
    $select->where("phone_number is not null AND phone_number != 0 AND phone_number != '' ");
    // Filter out junk
    $valuesCopy = array_filter($values);
    // Reset enabled bit
    if( isset($values['enabled']) && $values['enabled'] == 0 ) {
      $valuesCopy['enabled'] = 0;
    }


    $settings = Engine_Api::_()->getApi('settings', 'core');
    $countries = Engine_Api::_()->otpsms()->getCountryCodes();
    $allowedCountries = $settings->getSetting('otpsms_allowed_countries');
    $countriesArray = array(''=>'');
    foreach ($countries as $code => $country) {
      $countryName = ucwords(strtolower($country["name"]));

      if(count($allowedCountries) && !in_array($code,$allowedCountries))
        continue;
      $countriesArray[$country["code"]]['code'] = $country["code"];
      $countriesArray[$country["code"]]['title'] = $country['name'];
    }
    $this->view->countriesArray = $countriesArray;
    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber( $page );
    $this->view->formValues = $valuesCopy;
    $this->view->superAdminCount = count(Engine_Api::_()->user()->getSuperAdmins());
    $this->view->hideEmails = _ENGINE_ADMIN_NEUTER;
    $this->view->openUser = (bool) ( $this->_getParam('open') && $paginator->getTotalItemCount() == 1 );
  }
  function enableServiceAction(){
      $type = $this->_getParam('type');
      if($type){
          Engine_Api::_()->getApi('settings', 'core')->setSetting('otpsms.integration', $type);
      }
      header("Location:".$_SERVER["HTTP_REFERER"]);
  }
  function sendMessageAction(){
    $this->view->formFilter = $formFilter = new Otpsms_Form_Admin_Messages();
    $this->_helper->layout->setLayout('admin-simple');
    if(!$this->getRequest()->isPost())
      return;
    if(!$formFilter->isValid($this->_getAllParams())){
      return;
    }

    if( $this->getRequest()->isPost() && $formFilter->isValid($this->_getAllParams()) ) {
       $value = $formFilter->getValues();
		try{
			$table = Engine_Api::_()->getDbTable('sendmessages','otpsms');
			//create row
			$row = $table->createRow();
			$values['parent_type'] = $value['type'];
			$values['message'] = $value['message'];
			if($values['parent_type'] != 'profiletype'){
				$values['type'] = $value['memberlevel'];
				$values['specific'] = $value['sendto'];
				$values['specific'] = 0;
				if($values['specific'] == "specific") {
                    $values['specific'] = 1;
                    $values['user_id'] = $value['user_id'];
                    if (!empty($values["user_id"])) {
                        $user = Engine_Api::_()->getItem('user', $values['user_id']);
                        $values['type'] = $user->level_id;
                        if ($user->phone_number)
                            Engine_Api::_()->otpsms()->sedMessageCode("+" . $user->country_code . $user->phone_number, $values['message'], '', '', '', $direct = false);
                    }
                    return;
				}else{
				  $tableName = Engine_Api::_()->getDbTable('users', 'user');
				  $select = $tableName->select();
				  if( !empty($values['memberlevel']) ) {
					$select->where("level_id=?", $values['memberlevel']);
				  }
				  $users = $tableName->fetchAll($select);
				  foreach( $users as $user ) {
					if($user->phone_number)
						Engine_Api::_()->otpsms()->sedMessageCode("+".$user->country_code.$user->phone_number,$values['message'],'','','',$direct = false);
				  }
				}
			}else{
			  $values['type'] = $value['profiletype'];
			  if( empty($values['type']) ) {
				$tableName = Engine_Api::_()->getDbTable('users', 'user');
				$select = $tableName->select();
				$users = $tableName->fetchAll($select);
				foreach( $users as $user ) {
				  if($user->phone_number)
					Engine_Api::_()->otpsms()->sedMessageCode("+".$user->country_code.$user->phone_number,$values['message'],'','','',$direct = false);
				}
			  } else {
				//fetch user of a specific profile id.
				$db = Engine_Db_Table::getDefaultAdapter();
				$topStructure = Engine_Api::_()->fields()->getFieldStructureTop('user');
				if( count($topStructure) == 1 && $topStructure[0]->getChild()->type == 'profile_type' ) {
				  $profiletype = $topStructure[0]->getChild();
				  $options = $profiletype->getOptions();
				  $value = $options[0]['field_id'];
				}
				$users = $db->select()
				  ->from('engine4_user_fields_values')
				  ->where('value = ?', $values['type'])
				  ->where('field_id = ?', $value)
				  ->query()
				  ->fetchAll();
				if( !empty($users) ) {
				  foreach( $users as $obj ) {
					$user = Engine_Api::_()->getItem('user', $obj['item_id']);

					if($user->phone_number)
						Engine_Api::_()->otpsms()->sedMessageCode("+".$user->country_code.$user->phone_number,$values['message'],'','','',$direct = false);
				  }
				}
			  }
			}
			$values['creation_date'] = date('Y-m-d H:i:s');
			$values['modified_date'] = date('Y-m-d H:i:s');
			$row->setFromArray($values);
			$row->save();
		}catch(Exception $e){
			throw $e;
		}
    }
      $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('')
      ));

  }
  public function usersAction()
  {
    // for suggestions of users
    $text = $this->_getParam('search');

    $limit = $this->_getParam('limit', 10);
    $tableName = Engine_Api::_()->getDbTable('users', 'user');
    try {

      $select = $tableName->select()
        ->where('displayname  LIKE ? ', '%' . $text . '%');

      $select->order('displayname ASC')
        ->limit($limit);

      $res = $tableName->fetchAll($select);

      $data = array();
      //FETCH RESULTS

      foreach( $res as $users ) {
        $data[] = array(
          'id' => $users->user_id,
          'label' => $users->getTitle(),
          'photo' => $this->view->itemPhoto($users, 'thumb.icon'),
        );
      }
    } catch( Exception $e ) {
      throw $e;
    }
    return $this->_helper->json($data);
  }
  function sendMessagesAction(){
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('otpsms_admin_main', array(), 'otpsms_admin_main_sendmessages');
    $table = Engine_Api::_()->getDbTable('sendmessages','otpsms');
    $tableName = $table->info('name');
    $usertable = Engine_Api::_()->getDbTable('users','user');
    $usertableName = $usertable->info('name');
	$topStructure = Engine_Api::_()->fields()->getFieldStructureTop('user');
    if( count($topStructure) == 1 && $topStructure[0]->getChild()->type == 'profile_type' ) {
      $profileTypeField = $topStructure[0]->getChild();
      $options = $profileTypeField->getElementParams('user');
      $this->view->profile_type = $options['options']['multiOptions'];
    }
    $this->view->formFilter = $formFilter = new Otpsms_Form_Admin_Manage_Messages();
    $page = $this->_getParam('page', 1);
    // Process form
    $values = array();
    $formFilter->populate($this->_getAllParams());
    $values = $formFilter->getValues();
    foreach( $values as $key => $value ) {
      if( null === $value ) {
        unset($values[$key]);
      }
    }
    $this->view->assign($values);
    $select = $table->select()->from($tableName)
              ->setIntegrityCheck(false)
              ->joinLeft($usertableName,$usertableName.'.user_id = '.$tableName.'.user_id',null)
			 ->order('creation_date DESC');
			 
    if( !empty($values['username']) ) {
		$select->where('displayname =?',$_GET['username']);
	}
    if( !empty($values['message']) ) {
	  $select->where("message LIKE ?", '%' . trim($_GET['message']) . '%');
    }
	if( !empty($values['interval']) ) {
      switch( $values['interval'] ) {
        case 'today':
		  $select->where("CAST($tableName.creation_date AS DATE)=?", date('Y-m-d'));
          break;
        case 'sevendays':
		  $select->where("$tableName.creation_date >= DATE(NOW()) - INTERVAL 7 DAY");
          break;
        case 'specific':
          if( !empty($values['starttime']) ) {
            $select->where("CAST($tableName.creation_date AS DATE) >=?", trim($values['starttime']));
          }
          if( !empty($values['endtime']) ) {
            $select->where("CAST($tableName.creation_date AS DATE) <=?", trim($values['endtime']));
          } break;
      }
    }
	if(!empty($values['type'])){
		if($values['type']== "memberlevel"){
			if(!empty($values['memberlevel'])){
				$case = "CASE when parent_type = 'memberlevel' AND type = ".$values['memberlevel']." THEN true ELSE false END";
				$select->where($case);
			}
		}else{
			if(!empty($values['profiletype'])){
				$case = "CASE when parent_type = 'profiletype' AND type = ".$values['profiletype']." THEN true ELSE false END";
				$select->where($case);
			}
		}
	}
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator->setItemCountPerPage(50);
    $this->view->paginator = $paginator->setCurrentPagenumber($page);
  }

  function editAction(){
    $id = $this->_getParam('id', null);
    $user = Engine_Api::_()->getItem('user', $id);
    $userLevel = Engine_Api::_()->getItem('authorization_level', $user->level_id);
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerLevel = Engine_Api::_()->getItem('authorization_level', $viewer->level_id);
    $superAdminLevels = Engine_Api::_()->getItemTable('authorization_level')->fetchAll(array(
      'flag = ?' => 'superadmin',
    ));

    if( !$user || !$userLevel || !$viewer || !$viewerLevel ) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    }

    $this->view->user = $user;
    $this->view->form = $form = new Otpsms_Form_Admin_Manage_Edit(array(
      'userIdentity' => $id,
    ));

    // Do not allow editing level if the last superadmin
    if( $userLevel->flag == 'superadmin' && count(Engine_Api::_()->user()->getSuperAdmins()) == 1 ) {
      $form->removeElement('level_id');
    }

    // Do not allow admins to change to super admin
    if( $viewerLevel->flag != 'superadmin' && $form->getElement('level_id') ) {
      if( $userLevel->flag == 'superadmin' ) {
        $form->removeElement('level_id');
      } else {
        foreach( $superAdminLevels as $superAdminLevel ) {
          unset($form->getElement('level_id')->options[$superAdminLevel->level_id]);
        }
      }
    }

    // Get values
    $values = $user->toArray();
    unset($values['password']);
    if( _ENGINE_ADMIN_NEUTER ) {
      unset($values['email']);
    }

    // Get networks
    $select = Engine_Api::_()->getDbtable('membership', 'network')->getMembershipsOfSelect($user);
    $networks = Engine_Api::_()->getDbtable('networks', 'network')->fetchAll($select);
    $values['network_id'] = $oldNetworks = array();
    foreach( $networks as $network ) {
      $values['network_id'][] = $oldNetworks[] = $network->getIdentity();
    }

    // Check if user can be enabled?
    $subscriptionsTable = Engine_Api::_()->getDbtable('subscriptions', 'payment');
    if( !$subscriptionsTable->check($user) && !$values['enabled'] ) {
      $form->enabled->setAttrib('disable', array('enabled'));
      $note = '<p>Note: You cannot enable a member using this form if he / she has not '
        . 'yet chosen a subscription plan for their account. You can just approve them '
        . 'here after which they\'ll be able to choose a subscription plan before trying '
        . 'to login on your site.</p>';
    } elseif( 2 === (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('user.signup.verifyemail', 0) ) {
      $note = '<p>Note - Member can only be enabled when they are both approved and verified.</p>';
    } else {
      $note = '<p>Note - Member can only be enabled after they have been approved.</p>';
    }

    $form->addElement('note', 'desc', array(
      'value' => $note,
      'order' => 9
    ));

    // Populate form
    $form->populate($values);

    // Check method/valid
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    $values = $form->getValues();
    $phonenumber = $values['phone_number'];
    if($phonenumber && strlen($phonenumber) > 10){
        $form->addError("Enter valid phone number.");
        return;
    }
    // Check password validity
    if( empty($values['password']) && empty($values['password_conf']) ) {
      unset($values['password']);
      unset($values['password_conf']);
    } else if( $values['password'] != $values['password_conf'] ) {
      return $form->getElement('password')->addError('Passwords do not match.');
    } else {
      unset($values['password_conf']);
    }

    // Process
    $oldValues = $user->toArray();

    // Set new network
    $userNetworks = $values['network_id'];
    unset($values['network_id']);
    if($userNetworks == NULL) { $userNetworks = array(); }
    $joinIds = array_diff($userNetworks, $oldNetworks);
    foreach( $joinIds as $id ) {
      $network = Engine_Api::_()->getItem('network', $id);
      $network->membership()->addMember($user)
          ->setUserApproved($user)
          ->setResourceApproved($user);
    }
    $leaveIds = array_diff($oldNetworks, $userNetworks);
    foreach( $leaveIds as $id ) {
      $network = Engine_Api::_()->getItem('network', $id);
      if( !is_null($network) ){
        $network->membership()->removeMember($user);
      }
    }

    // Check for null usernames
    if( $values['username'] == '' ) {
      // If value is "NULL", then set to zend Null
        $values['username'] = new Zend_Db_Expr("NULL");
    }

    $user->setFromArray($values);
    $user->save();

    if ($oldValues['level_id'] != $values['level_id']) {
      if (Engine_Api::_()->getDbtable('values', 'authorization')->changeUsersProfileType($user)) {
        Engine_Api::_()->getDbtable('values', 'authorization')->resetProfileValues($user);
      }
    }


    if( !$oldValues['enabled'] && $values['enabled'] ) {
      // trigger `onUserEnable` hook
      $payload = array(
        'user' => $user,
        'shouldSendWelcomeEmail' => Engine_Api::_()->getApi('settings', 'core')->getSetting('user.signup.enablewelcomeemail', 0),
        'shouldSendApprovedEmail' => true
      );
      Engine_Hooks_Dispatcher::getInstance()->callEvent('onUserEnable', $payload);
    } else if( $oldValues['enabled'] && !$values['enabled'] ) {
      // trigger `onUserDisable` hook
      Engine_Hooks_Dispatcher::getInstance()->callEvent('onUserDisable', $user);
    }


    // Forward
    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => true,
      'format'=> 'smoothbox',
      'messages' => array('Your changes have been saved.')
    ));
  }
  public function twilioAction(){
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('otpsms_admin_main', array(), 'otpsms_admin_main_serviceintegration');

    $this->view->form = $form = new Otpsms_Form_Admin_Twilio();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if( !empty($settings->getSetting('otpsms_twilio')) )
      $form->populate($settings->getSetting('otpsms_twilio'));
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }
    $values = $form->getValues();
    if( empty($values['clientId']) || empty($values['clientSecret']) || empty($values['phoneNumber'])) {
      $values['clientId'] = '';
      $values['clientSecret'] = '';
      $values['phoneNumber'] = '';
    }
    if( Engine_Api::_()->getApi('settings', 'core')->otpsms_twilio )
      Engine_Api::_()->getApi('settings', 'core')->removeSetting('otpsms_twilio');
    Engine_Api::_()->getApi('settings', 'core')->otpsms_twilio = $values;
    $service = Engine_Api::_()->getApi('settings', 'core')->getSetting('otpsms.integration');
    if( !empty($values['enabled']) &&  !empty($values['clientSecret']) && !empty($values['clientId']) && !empty($values['phoneNumber'])) {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('otpsms.integration', 'twilio');
    } else if( $service != 'amazon' ) {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('otpsms.integration', '');
    }
    $form->addNotice('Your changes have been saved.');
    $form->populate($values);
  }
  public function amazonAction(){
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('otpsms_admin_main', array(), 'otpsms_admin_main_serviceintegration');
    $this->view->form = $form = new Otpsms_Form_Admin_Amazon();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if( !empty($settings->getSetting('otpsms_amazon')) )
      $form->populate($settings->getSetting('otpsms_amazon'));
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }
    $values = $form->getValues();
    if( empty($values['clientId']) || empty($values['clientSecret']) ) {
      $values['clientId'] = '';
      $values['clientSecret'] = '';
    }
    if( Engine_Api::_()->getApi('settings', 'core')->otpsms_amazon )
      Engine_Api::_()->getApi('settings', 'core')->removeSetting('otpsms_amazon');


    Engine_Api::_()->getApi('settings', 'core')->otpsms_amazon = $values;
    $service = Engine_Api::_()->getApi('settings', 'core')->getSetting('otpsms.integration');
    if( !empty($values['enabled']) &&  !empty($values['clientSecret']) && !empty($values['clientId'])) {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('otpsms.integration', 'amazon');
    } else if( $service != 'twilio' ) {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('otpsms.integration', '');
    }
    $form->addNotice('Your changes have been saved.');
    $form->populate($values);
  }
    public function integrationAction(){
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('otpsms_admin_main', array(), 'otpsms_admin_main_serviceintegration');
        $this->view->enabledService = Engine_Api::_()->getApi('settings', 'core')->getSetting('otpsms.integration','');

    }
    public function supportAction() {
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('otpsms_admin_main', array(), 'otpsms_admin_main_support');

    }
}
