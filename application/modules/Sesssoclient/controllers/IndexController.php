<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesssoclient
 * @package    Sesssoclient
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesssoclient_IndexController extends Core_Controller_Action_Standard
{
    function sendResponse($type = "",$user_id = 0){
        if($type != "error"){
            header("HTTP/1.1 200 OK");
            header('Content-Type: text/plain');
            if($user_id){
                echo $user_id;
            }else
                echo 'true';
        }else{
            header("HTTP/1.1 400 Bad Request");
            header('Content-Type: text/plain');
            echo 'false';
        }
        exit;
    }
    public function loginAction()
    {

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        //get token secret and token client
        $client_org_secret = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesssoclient.client.secret','');
        $client_org_token = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesssoclient.client.token','');
        $values = $this->_getAllParams();

        $client_secret = $values['client_secret'];
        $client_token= $values['client_token'];

        if($client_token != $client_org_token || $client_secret != $client_org_secret)
            $this->sendResponse("error");
        $email = $values['email'];
        $password = $values['password'];
        //get user from user table
        $user = $db->query("SELECT user_id,enabled,verified,approved FROM engine4_users WHERE email = '".$email."' ")->fetchAll();

        if(count($user)){
            $user = $user[0];
        }else
            $this->sendResponse("error");

        if($user['approved'] && $user['verified'] && $user['approved']){
            $user = Engine_Api::_()->getItem('user',$user['user_id']);
            $db = Engine_Db_Table::getDefaultAdapter();
            $ipObj = new Engine_IP();
            $ipExpr = new Zend_Db_Expr($db->quoteInto('UNHEX(?)', bin2hex($ipObj->toBinary())));
            // Register login
            $loginTable = Engine_Api::_()->getDbtable('logins', 'user');
            $loginTable->insert(array(
                'user_id' => $user->getIdentity(),
                'email' => $email,
                'ip' => $ipExpr,
                'timestamp' => new Zend_Db_Expr('NOW()'),
                'state' => 'success',
                'active' => true,
            ));
            $_SESSION['login_id'] = $login_id = $loginTable->getAdapter()->lastInsertId();

            // Remember
            if( $remember ) {
                $lifetime = 1209600; // Two weeks
                Zend_Session::getSaveHandler()->setLifetime($lifetime, true);
                Zend_Session::rememberMe($lifetime);
            }

            // Increment sign-in count
            Engine_Api::_()->getDbtable('statistics', 'core')
                ->increment('user.logins');

            // Test activity @todo remove
            $viewer = Engine_Api::_()->user()->getViewer();
            if( $viewer->getIdentity() ) {
                $viewer->lastlogin_date = date("Y-m-d H:i:s");
                if( 'cli' !== PHP_SAPI ) {
                    $viewer->lastlogin_ip = $ipExpr;
                }
                $viewer->save();
                Engine_Api::_()->getDbtable('actions', 'activity')
                    ->addActivity($viewer, $viewer, 'login');
            }
            Engine_Api::_()->user()->getAuth()->getStorage()->write($user->getIdentity());

            $this->sendResponse('',$user->getIdentity());
        }
        $this->sendResponse("error");
    }
    public function getBaseUrl($staticBaseUrl = true,$url = ""){
        return $_SERVER['HTTP_HOST'];
        if(strpos($url,'http') !== false)
            return $url;
        $http = 'http://';
        if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'){
            $http = 'https://';
        }
        $baseUrl =  $_SERVER['HTTP_HOST'];
        if(Zend_Registry::get('StaticBaseUrl') != "/")
            $url = str_replace(Zend_Registry::get('StaticBaseUrl'),'',$url);
        $baseUrl = $baseUrl.Zend_Registry::get('StaticBaseUrl') ;
        return $http.str_replace('//','/',$baseUrl.$url);
    }
    protected function checkUsername($username,$userTable){
        $checkUsername = 1;
        $counter = 1;
        do {
            $checkUsername =  $userTable->select()->from($userTable->info('name'),'username')->where('username =?',$username)->query()->fetchColumn();
            if($checkUsername){
                $username = $checkUsername.$counter;
                $checkUsername = 1;
            }else
                $checkUsername = 0;
            $counter++;
        } while ($checkUsername != 0);
        return $username;
    }
    public function signupAction(){

        $db = Engine_Db_Table::getDefaultAdapter();
        $values = $value = $this->_getAllParams();
        $email = $values['email'];
        if(!$email)
            $this->sendResponse("error");
        $userTable = Engine_Api::_()->getDbTable('users','user');
        //check email exists
        $select = $userTable->select()->where('email =?',$email)->limit(1);
        $emailExists = $userTable->fetchRow($select);
        if($emailExists)
            $this->sendResponse("error");
        $value['password'] = $values['password'];
        $value['level_id'] = Engine_Api::_()->getDbTable('levels','authorization')->getDefaultLevel()->getIdentity();
        $value['enabled'] = 1;
        $value['verified'] = 1;
        $value['approved'] = 1;

        $username = $this->checkUsername(preg_replace('/[^A-Za-z]/', '', strtolower($values['username'])),$userTable);
        //create user

        $user = $userTable->createRow();
        $user->setFromArray($value);
        $user->save();

        try{
            if(!empty($values['photo_url'])){
                $fileName = time().'_sesssoclient';
                $photo = $values['photo_url'];
                $PhotoExtension='.'.pathinfo($photo, PATHINFO_EXTENSION);
                if($PhotoExtension == ".")
                    $PhotoExtension = ".jpg";
                $filenameInsert=$fileName.$PhotoExtension;
                $fileName = $filenameInsert;
                $copySuccess=@copy($values['photo_url'], APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary/'.$filenameInsert);
                if($copySuccess){
                    $file = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary'.DIRECTORY_SEPARATOR.$filenameInsert;
                    $user->setPhoto($file);
                }
            }
        }catch(Exception $e){
            //silence
        }
        $user_id = $user->getIdentity();
        $fieldIds = $this->getFieldIds($values);
        $db->query("INSERT INTO engine4_user_fields_values (`item_id`,`field_id`,`value`) VALUES ('".$user_id."' ,1,'".(!empty($values['profile_type']) ? $values['profile_type'] : '')."') ");

        if(count($fieldIds)){
            foreach($fieldIds as $fields){
                if(!empty($values[$fields['type']])){
                    $db->query("INSERT INTO engine4_user_fields_values (`item_id`,`field_id`,`value`) VALUES ('".$user_id."' ,'".$fields['field_id']."','".(!empty($values[$fields['type']]) ? $values[$fields['type']] : '')."') ");
                }
            }
        }


        $usermapstable = Engine_Api::_()->fields()->getTable('user', 'search');
        $search = $usermapstable->createRow();

        foreach($values as $key=>$value){
            if(isset($search->{$key}))
                $search->{$key} = $value;
        }
        $search->item_id = $user_id;
        $search->save();
        Zend_Auth::getInstance()->getStorage()->write($user->getIdentity());
        Engine_Api::_()->user()->setViewer();
        $this->sendResponse('',$user->getIdentity());
    }
    function getFieldIds($values){
        $profile_type = $values['profile_type'];

        $usermetatable = Engine_Api::_()->fields()->getTable('user', 'meta');
        $usermetatablename = $usermetatable->info('name');

        $usermapstable = Engine_Api::_()->fields()->getTable('user', 'maps');
        $usermapstablename = $usermapstable->info('name');

        $select = $usermetatable->select()
            ->setIntegrityCheck(false)
            ->from($usermetatablename, array('field_id','type'))
            ->joinLeft($usermapstablename, "$usermetatablename.field_id = $usermapstablename.child_id", null)
            ->where($usermetatablename . '.type IN (?)', array_keys($values))
            ->where($usermetatablename . '.display = ?', '1')
            ->where($usermapstablename . '.option_id = ?', $profile_type);
        return $usermetatable->fetchAll($select);
    }
}
