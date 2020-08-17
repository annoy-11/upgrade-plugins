<?php

//folder name or directory name.
$module_name = 'seseventspeaker';

//product title and module title.
$module_title = 'Advanced Events - Speakers Extension';

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
  $postdata['licenseKey'] = @base64_encode($_POST['seseventspeaker_licensekey']);
  $postdata['module_name'] = @base64_encode($module_name);
  $postdata['module_title'] = @base64_encode($module_title);

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, "http://www.socialenginesolutions.com/licensenewcheck.php");
  
  
  curl_setopt($ch, CURLOPT_POST, 1);

// in real life you should use something like:
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));

// receive server response ...
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $server_output = curl_exec($ch);
  $output = explode(" sesquerysql ",$server_output);
  $error = 0;
  if (curl_error($ch)) {
    $error = 1;
  }
  curl_close($ch);

  //Here we can set some variable for checking in plugin files.
  if (1) {
//  if ($output[0] == "OK" && $error != 1) {

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventspeaker.pluginactivated')) {
      $db = Zend_Db_Table_Abstract::getDefaultAdapter();
      
      $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
      ("sesevent_admin_main_managespeaker", "seseventspeaker", "Manage Speakers", "", \'{"route":"admin_default","module":"seseventspeaker","controller":"speaker"}\', "seseventspeaker_admin_main", "", 6),
      ("seseventspeaker_main_index", "seseventspeaker", "Browse Speakers", "", \'{"route":"seseventspeaker_general","action":"browse"}\', "sesevent_main", "", 2);');
      
      $db->query('INSERT IGNORE INTO `engine4_sesevent_dashboards` (`type`, `title`, `enabled`, `main`) VALUES 
      ("speaker_event", "Manage Speakers", "1", "0");');
      
      $db->query('DROP TABLE IF EXISTS `engine4_seseventspeaker_speakers`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_seseventspeaker_speakers` (
        `speaker_id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `name` varchar(255) NOT NULL,
        `description` varchar(255) DEFAULT NULL,
        `email` varchar(255) DEFAULT NULL,
        `location` varchar(255) DEFAULT NULL,
        `phone` varchar(255) DEFAULT NULL,
        `website` varchar(255) DEFAULT NULL,
        `skype` varchar(64) DEFAULT NULL,
        `facebook` varchar(255) DEFAULT NULL,
        `twitter` varchar(255) DEFAULT NULL,
        `linkdin` varchar(255) DEFAULT NULL,
        `googleplus` varchar(255) DEFAULT NULL,
        `enabled` tinyint(1) NOT NULL DEFAULT "1",
        `featured` tinyint(1) NOT NULL,
        `sponsored` tinyint(1) NOT NULL,
        `offtheday` tinyint(1) NOT NULL,
        `starttime` date NOT NULL,
        `endtime` date NOT NULL,
        `type` varchar(255) NOT NULL DEFAULT "admin",
        `photo_id` int(11) NOT NULL,
        `like_count` int(11) NOT NULL,
        `favourite_count` int(11) NOT NULL,
        `view_count` int(11) NOT NULL,
        `creation_date` datetime NOT NULL,
        PRIMARY KEY (`speaker_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');
      
      $db->query('DROP TABLE IF EXISTS `engine4_seseventspeaker_eventspeakers`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_seseventspeaker_eventspeakers` (
        `eventspeaker_id` int(11) NOT NULL AUTO_INCREMENT,
        `speaker_id` int(11) NOT NULL,
        `event_id` int(11) NOT NULL,
        `type` varchar(255) DEFAULT NULL,
        `enabled` tinyint(1) NOT NULL DEFAULT "1",
        `owner_id` int(11) NOT NULL,
        PRIMARY KEY (`eventspeaker_id`),
        UNIQUE KEY `speaker_id` (`speaker_id`,`event_id`,`type`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');
      
      include_once APPLICATION_PATH . "/application/modules/Seseventspeaker/controllers/defaultsettings.php";
      
      Engine_Api::_()->getApi('settings', 'core')->setSetting('seseventspeaker.pluginactivated', 1);
      Engine_Api::_()->getApi('settings', 'core')->setSetting('seseventspeaker.licensekey', $_POST['seseventspeaker_licensekey']);
      $error = 1;
    }
  } else {
    $error = $this->view->translate('Please enter correct License key for this product.');
    $error = Zend_Registry::get('Zend_Translate')->_($error);
    $form->getDecorator('errors')->setOption('escape', false);
    $form->addError($error);
    $error = 0;
    Engine_Api::_()->getApi('settings', 'core')->setSetting('seseventspeaker.licensekey', $_POST['seseventspeaker_licensekey']);
    return;
    $this->_helper->redirector->gotoRoute(array());
  }
}