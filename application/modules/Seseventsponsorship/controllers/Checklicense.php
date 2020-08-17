<?php

$domain_name = @base64_encode($_SERVER['HTTP_HOST']);
$licensekey = Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventsponsorship.licensekey');
$licensekey = @base64_encode($licensekey);

$sesdomainauth = Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventsponsorship.sesdomainauth'); 
$seslkeyauth = Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventsponsorship.seslkeyauth');

if(($domain_name == $sesdomainauth) && ($licensekey == $seslkeyauth)) {
	Zend_Registry::set('seseventsponsorship_buyspo', 1);
	Zend_Registry::set('seseventsponsorship_spoviewpage', 1);
	Zend_Registry::set('seseventsponsorship_eventspo', 1);
	Zend_Registry::set('seseventsponsorship_requestspo', 1);
} else {
	Zend_Registry::set('seseventsponsorship_buyspo', 0);
	Zend_Registry::set('seseventsponsorship_spoviewpage', 0);
	Zend_Registry::set('seseventsponsorship_eventspo', 0);
	Zend_Registry::set('seseventsponsorship_requestspo', 0);
}