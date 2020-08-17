<?php

//folder name or directory name.
$module_name = 'sescrowdfundingteam';

//product title and module title.
$module_title = 'Crowdfunding Team Showcase Extension';

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
  $postdata['licenseKey'] = @base64_encode($_POST['sescrowdfundingteam_licensekey']);
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

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingteam.pluginactivated')) {
      $db = Zend_Db_Table_Abstract::getDefaultAdapter();

      $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
      ("sescrowdfundingteam_admin_main_managedesignation", "sescrowdfundingteam", "Designations", "", \'{"route":"admin_default","module":"sescrowdfundingteam","controller":"manage", "action":"designations"}\', "sescrowdfundingteam_admin_main", "", 2),

      ("sescrowdfundingteam_admin_main_manage", "sescrowdfundingteam", "Manage Crowdfunding Team", "", \'{"route":"admin_default","module":"sescrowdfundingteam","controller":"manage"}\', "sescrowdfundingteam_admin_main", "", 3);');

      $db->query('DROP TABLE IF EXISTS `engine4_sescrowdfundingteam_designations`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sescrowdfundingteam_designations` (
        `designation_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `designation` varchar(255) NOT NULL,
        `crowdfunding_id` INT(11) NOT NULL DEFAULT "0",
        `is_admincreated` tinyint(1) NOT NULL DEFAULT "1",
        `enabled` tinyint(1) NOT NULL DEFAULT "1",
        `order` int(3) NOT NULL,
        PRIMARY KEY (`designation_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');

      $db->query('DROP TABLE IF EXISTS `engine4_sescrowdfundingteam_teams`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sescrowdfundingteam_teams` (
      `team_id` int(11) NOT NULL AUTO_INCREMENT,
      `crowdfunding_id` int(11) NOT NULL,
      `user_id` int(11) NOT NULL,
      `name` varchar(255)  NOT NULL,
      `designation_id` int(11) DEFAULT NULL,
      `designation` varchar(255)  DEFAULT NULL,
      `description` varchar(255)  DEFAULT NULL,
      `detail_description` longtext  NOT NULL,
      `email` varchar(255)  DEFAULT NULL,
      `location` varchar(255)  DEFAULT NULL,
      `phone` varchar(255)  DEFAULT NULL,
      `website` varchar(255)  DEFAULT NULL,
      `skype` varchar(64)  DEFAULT NULL,
      `facebook` varchar(255)  DEFAULT NULL,
      `twitter` varchar(255)  DEFAULT NULL,
      `linkdin` varchar(255)  DEFAULT NULL,
      `googleplus` varchar(255)  DEFAULT NULL,
      `enabled` tinyint(1) NOT NULL DEFAULT "1",
      `featured` tinyint(1) NOT NULL,
      `sponsored` tinyint(1) NOT NULL,
      `offtheday` tinyint(1) NOT NULL,
      `starttime` date NOT NULL,
      `endtime` date NOT NULL,
      `type` varchar(255)  NOT NULL DEFAULT "sitemember",
      `photo_id` int(11) NOT NULL,
      `order` int(11) DEFAULT NULL,
      PRIMARY KEY (`team_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');

      include_once APPLICATION_PATH . "/application/modules/Sescrowdfundingteam/controllers/defaultsettings.php";

      Engine_Api::_()->getApi('settings', 'core')->setSetting('sescrowdfundingteam.pluginactivated', 1);

      Engine_Api::_()->getApi('settings', 'core')->setSetting('sescrowdfundingteam.licensekey', $_POST['sescrowdfundingteam_licensekey']);
    }
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sescrowdfundingteam.teammembers', 1);
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sescrowdfundingteam.sponsoredmem', 1);
  } else {

    $error = $this->view->translate('Please enter correct License key for this product.');
    $error = Zend_Registry::get('Zend_Translate')->_($error);
    $form->getDecorator('errors')->setOption('escape', false);
    $form->addError($error);
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sescrowdfundingteam.teammembers', 0);
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sescrowdfundingteam.sponsoredmem', 0);
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sescrowdfundingteam.licensekey', $_POST['sescrowdfundingteam_licensekey']);
    return;
    $this->_helper->redirector->gotoRoute(array());
  }
}
