<?php

//folder name or directory name.
$module_name = 'sesadvminimenu';

//product title and module title.
$module_title = 'SES - Advanced Mini Navigation Menu';

if (!$this->getRequest()->isPost()) {
  return;
}

if (!$form->isValid($this->getRequest()->getPost())) {
  return;
}

if ($this->getRequest()->isPost()) {

  $postdata = array();
  //domain name
  $postdata['domain_name'] = $_SERVER['HTTP_HOST'];
  //license key
  $postdata['licenseKey'] = @base64_encode($_POST['sesadvminimenu_licensekey']);
  $postdata['module_title'] = @base64_encode($module_title);

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, "http://www.socialenginesolutions.com/licensecheck.php");
  curl_setopt($ch, CURLOPT_POST, 1);

  // in real life you should use something like:
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));

  // receive server response ...
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $server_output = curl_exec($ch);

  $error = 0;
  if (curl_error($ch)) {
    $error = 1;
  }
  curl_close($ch);

  //here we can set some variable for checking in plugin files.
  //if ($server_output == "OK" && $error != 1) {
  if (1) {

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvminimenu.pluginactivated')) {
    
      $db = Zend_Db_Table_Abstract::getDefaultAdapter();

      include_once APPLICATION_PATH . "/application/modules/Sesadvminimenu/controllers/defaultsettings.php";

      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesadvminimenu.pluginactivated', 1);
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesadvminimenu.licensekey', $_POST['sesadvminimenu_licensekey']);
    }
    $domain_name = @base64_encode(str_replace(array('http://','https://','www.'),array('','',''),$_SERVER['HTTP_HOST']));
		$licensekey = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvminimenu.licensekey');
		$licensekey = @base64_encode($licensekey);
		Engine_Api::_()->getApi('settings', 'core')->setSetting('sesadvminimenu.sesdomainauth', $domain_name);
		Engine_Api::_()->getApi('settings', 'core')->setSetting('sesadvminimenu.seslkeyauth', $licensekey);
		$error = 1;
  } else {
    $error = $this->view->translate('Please enter correct License key for this product.');
    $error = Zend_Registry::get('Zend_Translate')->_($error);
    $form->getDecorator('errors')->setOption('escape', false);
    $form->addError($error);
    $error = 0;
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sesadvminimenu.licensekey', $_POST['sesadvminimenu_licensekey']);
    return;
    $this->_helper->redirector->gotoRoute(array());
  }
}