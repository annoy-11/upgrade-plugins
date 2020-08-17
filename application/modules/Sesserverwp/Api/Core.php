<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesserverwp
 * @package    Sesserverwp
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesserverwp_Api_Core extends Core_Api_Abstract{
	function get_domain($url)
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }
        return false;
    }
	function login($user){
		$userSelected = Engine_Api::_()->getItem('user',$user->getIdentity());
     	$value['email'] = $userSelected->email;
     	$value['password'] = $_POST['password'];
     	$clients = $this->getCients();

     	foreach($clients as $client){
    		$url = trim($client['url'],'/');
			//API URL
			$data = array(
			    'email' => $value['email'],
			    'password' => $value['password'],
			    'client_secret'=>$value['client_secret'],
			    'client_token'=>$value['client_token']
			);
			$data['client_secret'] = $client['client_secret'];
		    $data['client_token'] = $client['client_token'];
			$url = $url.'?sesssowp=login&'.http_build_query($data);
			//create a new cURL resource
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, true);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			//execute the POST request
			$result = trim(curl_exec($ch),' ');

			//close cURL resource
			if($result && $result != "false"){
				$result = (int)$result;
				if($result == 0)
					return;
				$cookieName = "SSOWPLoggedinUserId_".str_replace('.','',$this->get_domain(trim($url,'/')));
				setcookie(
		        	$cookieName, 
		        	0,
		        	time() - (86400 * 30), 
		        	"/",
		        	'.'.$this->get_domain($_SERVER["HTTP_HOST"]));
		        setcookie(
		        	$cookieName, 
		        	$result,
		        	time() + (86400 * 30), 
		        	"/",
		        	'.'.$this->get_domain($_SERVER["HTTP_HOST"]));
			}
			curl_close($ch);
		}
	}
	function getCients(){
	    $table = Engine_Api::_()->getDbTable('clients','sesserverwp');
	    $select = $table->select()->where('active =?',1);
	    $clients = $table->fetchAll($select);
	    return $clients;
  }
  function signup($user){
  		$db = Engine_Db_Table::getDefaultAdapter();
	    $userSelected = Engine_Api::_()->getItem('user',$user->getIdentity());
	    $value = Engine_Api::_()->fields()->getFieldsValuesByAlias($userSelected);
	    $data = array(
		    'email' => $userSelected->email,
		    'password' => $_SESSION['sesserverwp'],
		    'first_name'=>$value['first_name'],
		    'last_name'=>$value['last_name'],
		    'username'=>$userSelected->username,
			'displayname'=>$userSelected->username
		);
	    $clients = $this->getCients();
     	foreach($clients as $client){
    		$url = trim($client['url'],'/');
		    $data['client_secret'] = $client['client_secret'];
		    $data['client_token'] = $client['client_token'];
		    $url = $url.'?sesssowp=register&'.http_build_query($data);
			//create a new cURL resource
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, true);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			$result = trim(curl_exec($ch),' ');
			if(!empty($result)){
				$result = (int)$result;
				if($result == 0)
					return;
				$cookieName = "SSOWPLoggedinUserId_".str_replace('.','',$this->get_domain(trim($url,'/')));
				setcookie(
		        	$cookieName, 
		        	0,
		        	time() - (86400 * 30), 
		        	"/",
		        	'.'.$this->get_domain($_SERVER["HTTP_HOST"]));
		        setcookie(
		        	$cookieName, 
		        	$result,
		        	time() + (86400 * 30), 
		        	"/",
		        	'.'.$this->get_domain($_SERVER["HTTP_HOST"]));
			}
			curl_close($ch);
		}
	}
}
?>