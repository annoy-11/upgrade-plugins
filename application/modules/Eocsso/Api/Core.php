<?php

class Eocsso_Api_Core extends Core_Api_Abstract
{
	const KEY = "eocssoPublicKey";

	function get_domain($url)
	{
		$pieces = parse_url($url);
		$domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
		if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
			return $regs['domain'];
		}
		return false;
	}

	function login($user)
	{
		$userSelected = Engine_Api::_()->getItem('user', $user->getIdentity());
		$loginUserData = Engine_Api::_()->fields()->getFieldsValuesByAlias($userSelected);
		$value['email'] = $userSelected->email;
		$value['password'] = $_POST['password'];
		$value['firstname'] =  $loginUserData['first_name'];
		$value['lastname'] =  $loginUserData['last_name'];
		$clients = $this->getCients();
		$server = array('sedevopencart', 'opencart');
		foreach ($clients as $key => $client) {
			$domain = str_replace('.', '', $this->get_domain(trim($client['url'], '/'))) . "" . $client['client_id'];
			$cookieNameLogout = "EOCSSOLoggedOut_" . $domain;
			unset($_COOKIE[$cookieNameLogout]);
			setcookie($cookieNameLogout, null, -1, "/",  $this->get_domain($_SERVER["HTTP_HOST"]));
			$url = trim($client['url'], '/');
			//API URL
			$data = array(
				'email' => $value['email'],
				'password' => $value['password'],
				'firstname' => $value['firstname'],
				'lastname' => $value['lastname'],
				'client_secret' => $value['client_secret'],
				'client_token' => $value['client_token']
			);
			$data['client_secret'] = $client['client_secret'];
			$data['client_token'] = $client['client_token'];
			$data['client_domain'] = $client['url'];
			if (!empty($client['sub_dir']))
				$client['sub_dir'] = '/' . $client['sub_dir'];
			$url = $url . '/' . $server[$key] . '' . $client['sub_dir'] . '/index.php?route=eocssoclient/eocsso/login';
			//create a new cURL resource
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			//execute the POST request

			$result = trim(curl_exec($ch), ' ');
			//close cURL resource
			if (!empty($result)) {
				if ($result == 'false') {
					$cookieNameLogout = "EOCSSOLoggedOut_" . $domain;
					setcookie(
						$cookieNameLogout,
						1,
						time() + (86400 * 30),
						"/",
						'.' . $this->get_domain($_SERVER["HTTP_HOST"])
					);
					return;
				}
				$cookieName = "EOCSSOLoggedinUserId_" . $domain;
				setcookie(
					$cookieName,
					0,
					time() - (86400 * 30),
					"/",
					'.' . $this->get_domain($_SERVER["HTTP_HOST"])
				);
				setcookie(
					$cookieName,
					$result,
					time() + (86400 * 30),
					"/",
					'.' . $this->get_domain($_SERVER["HTTP_HOST"])
				);
			}
			curl_close($ch);
		}
	}

	function logout()
	{
		$clients = $this->getCients();
		$server = array('sedevopencart', 'opencart');
		foreach ($clients as $key => $client) {
			$domain = str_replace('.', '', $this->get_domain(trim($client['url'], '/'))) . "" . $client['client_id'];
			$cookieName = "EOCSSOLoggedinUserId_" . $domain;
			unset($_COOKIE[$cookieName]);
			setcookie($cookieName, null, -1, "/",  $this->get_domain($_SERVER["HTTP_HOST"]));
			$cookieNameLogout = "EOCSSOLoggedOut_" . $domain;
			setcookie(
				$cookieNameLogout,
				1,
				time() + (86400 * 30),
				"/",
				'.' . $this->get_domain($_SERVER["HTTP_HOST"])
			);
		}
	}

	function getCients()
	{
		$table = Engine_Api::_()->getDbTable('clients', 'eocsso');
		$select = $table->select()->where('active =?', 1);
		$clients = $table->fetchAll($select);
		return $clients;
	}
	function signup($user)
	{
		$db = Engine_Db_Table::getDefaultAdapter();
		$userSelected = Engine_Api::_()->getItem('user', $user->getIdentity());
		$value = Engine_Api::_()->fields()->getFieldsValuesByAlias($userSelected);
		$data = array(
			'email' => $userSelected->email,
			'password' => $_SESSION['eocsso'],
			'firstname' => $value['first_name'],
			'lastname' => $value['last_name'],
			'username' => $userSelected->username,
			'displayname' => $userSelected->username
		);
		$clients = $this->getCients();
		$server = array('sedevopencart', 'opencart');
		foreach ($clients as $key => $client) {
			$domain = str_replace('.', '', $this->get_domain(trim($client['url'], '/'))) . "" . $client['client_id'];;
			$cookieNameLogout = "EOCSSOLoggedOut_" . $domain;
			unset($_COOKIE[$cookieNameLogout]);
			setcookie($cookieNameLogout, null, -1, "/",  $this->get_domain($_SERVER["HTTP_HOST"]));
			$url = trim($client['url'], '/');
			$data['client_secret'] = $client['client_secret'];
			$data['client_token'] = $client['client_token'];
			$data['client_domain'] = $client['url'];
			if (!empty($client['sub_dir']))
				$client['sub_dir'] = '/' . $client['sub_dir'];
			$url = $url . '/' . $server[$key] . '' . $client['sub_dir'] . '/index.php?route=eocssoclient/eocsso/signup';
			//create a new cURL resource
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			$result = trim(curl_exec($ch), ' ');
			if (!empty($result)) {
				if ($result == 'false')
					return;
				$cookieName = "EOCSSOLoggedinUserId_"  . $domain;
				setcookie(
					$cookieName,
					0,
					time() - (86400 * 30),
					"/",
					'.' . $this->get_domain($_SERVER["HTTP_HOST"])
				);
				setcookie(
					$cookieName,
					$result,
					time() + (86400 * 30),
					"/",
					'.' . $this->get_domain($_SERVER["HTTP_HOST"])
				);
			}
			curl_close($ch);
		}
	}

	function encryptCookie($plainText)
	{
		$ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
		$iv = openssl_random_pseudo_bytes($ivlen);
		$ciphertext_raw = openssl_encrypt($plainText, $cipher, self::KEY, $options = OPENSSL_RAW_DATA, $iv);
		$hmac = hash_hmac('sha256', $ciphertext_raw, self::KEY, $as_binary = true);
		$ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
		return $ciphertext;
	}

	function dencryptCookie($dencryptCookieToken)
	{
		$c = base64_decode($dencryptCookieToken);
		$ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
		$iv = substr($c, 0, $ivlen);
		$hmac = substr($c, $ivlen, $sha2len = 32);
		$ciphertext_raw = substr($c, $ivlen + $sha2len);
		$original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, self::KEY, $options = OPENSSL_RAW_DATA, $iv);
		$calcmac = hash_hmac('sha256', $ciphertext_raw, self::KEY, $as_binary = true);
		if (hash_equals($hmac, $calcmac)) //PHP 5.6+ timing attack safe comparison
			return $original_plaintext;
		return $c;
	}
}
