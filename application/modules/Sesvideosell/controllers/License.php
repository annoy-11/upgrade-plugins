<?php

//folder name or directory name.
$module_name = 'sesvideosell';

//product title and module title.
$module_title = 'Advanced Video - Sell Extension';

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
  $postdata['licenseKey'] = @base64_encode($_POST['sesvideosell_licensekey']);
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
  if (1) {
  //if ($server_output == "OK" && $error != 1) {

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesvideosell.pluginactivated')) {
    
      $db = Zend_Db_Table_Abstract::getDefaultAdapter();
      
      $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
      ("sesvideosell_admin_paymentmade", "sesvideosell", "Remaining Payments", "", \'{"route":"admin_default","module":"sesvideosell","controller":"paymentmade"}\', "sesvideosell_admin_main", "", 3),
      
      ("sesvideosell_admin_remainingpaymentmade", "sesvideosell", "Payments Made", "", \'{"route":"admin_default","module":"sesvideosell","controller":"remainingpaymentmade"}\', "sesvideosell_admin_main", "", 4),
      
      ("sesvideosell_admin_manageorders", "sesvideosell", "Purchased Videos", "", \'{"route":"admin_default","module":"sesvideosell","controller":"manage-orders"}\', "sesvideosell_admin_main", "", 5),
      ("sesvideosell_admin_main_level", "sesvideosell", "Member Level Settings", "", \'{"route":"admin_default","module":"sesvideosell","controller":"level"}\', "sesvideosell_admin_main", "", 6);');
      
      $db->query('DROP TABLE IF EXISTS `engine4_sesvideosell_orders`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesvideosell_orders` (
        `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `video_id` int(11) UNSIGNED NOT NULL,
        `user_id` int(11) UNSIGNED NOT NULL,
        `gateway_id` varchar(128) DEFAULT NULL,
        `fname` varchar(128) DEFAULT NULL,
        `lname` varchar(128) DEFAULT NULL,
        `email` varchar(128) DEFAULT NULL,
        `order_no` varchar(255) DEFAULT NULL,
        `gateway_transaction_id` varchar(128) DEFAULT NULL,
        `commission_amount` float DEFAULT "0",
        `private` tinyint(1) DEFAULT "0",
        `state` enum("pending","cancelled","failed","incomplete","complete","refund") DEFAULT "incomplete",
        `total_amount` float DEFAULT "0",
        `total_useramount` float DEFAULT "0",
        `currency_symbol` varchar(45) NOT NULL,
        `gateway_type` varchar(45) NOT NULL DEFAULT "Paypal",
        `is_delete` tinyint(1) NOT NULL DEFAULT "0",
        `creation_date` datetime NOT NULL,
        `modified_date` datetime NOT NULL,
        `gateway_profile_id` VARCHAR(128) NULL,
        PRIMARY KEY (`order_id`),
        KEY `video_id` (`video_id`),
        KEY `user_id` (`user_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');
      
      $db->query('DROP TABLE IF EXISTS `engine4_sesvideosell_transactions`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesvideosell_transactions` (
        `transaction_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `user_id` int(10) unsigned NOT NULL default "0",
        `gateway_id` int(10) unsigned NOT NULL,
        `timestamp` datetime NOT NULL,
        `order_id` int(10) unsigned NOT NULL default "0",
        `type` varchar(64)  NULL,
        `state` varchar(64)  NULL,
        `gateway_transaction_id` varchar(128)  NOT NULL,
        `gateway_parent_transaction_id` varchar(128)  NULL,
        `gateway_order_id` varchar(128)  NULL,
        `amount` decimal(16,2) NOT NULL,
        `currency` char(3)  NOT NULL default "",
        `expiration_date` datetime NOT NULL,
        `video_id` int(10) unsigned NOT NULL default "0",
        `gateway_profile_id` VARCHAR(128) DEFAULT NULL,
        `package_id` INT(11) NOT NULL,
        PRIMARY KEY  (`transaction_id`),
        KEY `user_id` (`user_id`),
        KEY `gateway_id` (`gateway_id`),
        KEY `type` (`type`),
        KEY `state` (`state`),
        KEY `gateway_transaction_id` (`gateway_transaction_id`),
        KEY `gateway_parent_transaction_id` (`gateway_parent_transaction_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');
      
      $db->query('DROP TABLE IF EXISTS `engine4_sesvideosell_remainingpayments`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesvideosell_remainingpayments` (
        `remainingpayment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `user_id` int(11) UNSIGNED NOT NULL,
        `remaining_payment` float DEFAULT "0",
        PRIMARY KEY (`remainingpayment_id`),
        KEY `user_id` (`user_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');
      
      $db->query('INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
      ("sesvideosell_purchased_videoowner", "sesvideosell", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[video_title],[object_link],[buyer_name]"),
      ("sesvideosell_purchased_adminemail", "sesvideosell", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[video_title],[object_link],[buyer_name],[total_useramount],[commission_amount],[total_amount]"),
      ("sesvideosell_videoinvoice_buyer", "sesvideosell", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[video_title],[object_link],[invoice_body]");');
      
      $db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
      ("sesvideosell_purchased_videoowner", "sesvideosell", \'{item:$subject} has purchased your video {item:$object}.\', 0, "");');
      
      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
      level_id as `level_id`,
      "sesvideosell" as `type`,
      "sesvideosell_commison" as `name`,
      0 as `value`,
      NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
      
      $db->query('DROP TABLE IF EXISTS `engine4_video_samplevideos`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_video_samplevideos` (
        `samplevideo_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `video_id` int(11) unsigned DEFAULT NULL,
        `code` text COLLATE utf8_unicode_ci NOT NULL,
        `photo_id` int(11) unsigned DEFAULT NULL,
        `status` tinyint(1) NOT NULL,
        `file_id` int(11) unsigned NOT NULL,
        `duration` int(9) unsigned NOT NULL,
        `type` tinyint(1) NOT NULL,
        `owner_id` int(11) NOT NULL,
        `rotation` smallint(5) NOT NULL,
        PRIMARY KEY (`samplevideo_id`),
        UNIQUE KEY `video_id` (`video_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');

      $db->query('ALTER TABLE `engine4_video_videos` ADD `price` DECIMAL(16, 2) NOT NULL DEFAULT "0.00";');
      $db->query('ALTER TABLE `engine4_video_videos` ADD `samplevideo_id` INT(11) NULL;');
      $db->query('ALTER TABLE `engine4_video_videos` ADD `payment_type` VARCHAR(255) NOT NULL DEFAULT "free";');
      $db->query('INSERT IGNORE INTO `engine4_core_jobtypes` (`title`, `type`, `module`, `plugin`, `enabled`, `multi`, `priority`) VALUES
      ("Advanced Videos & Channels Plugin - Sample Video Encode", "samplevideo_encode", "sesvideo", "Sesvideo_Plugin_Job_Encodesample", 1, 2, 75),
      ("Advanced Videos & Channels Plugin -  Rebuild Sample Video Privacy", "samplevideo_maintenance_rebuild_privacy", "sesvideo", "Sesvideo_Plugin_Job_Maintenance_RebuildPrivacySample", 1, 1, 50);');

      include_once APPLICATION_PATH . "/application/modules/Sesvideosell/controllers/defaultsettings.php";

      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesvideosell.pluginactivated', 1);
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesvideosell.licensekey', $_POST['sesvideosell_licensekey']);
    }
    $domain_name = @base64_encode(str_replace(array('http://','https://','www.'),array('','',''),$_SERVER['HTTP_HOST']));
		$licensekey = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesvideosell.licensekey');
		$licensekey = @base64_encode($licensekey);
		Engine_Api::_()->getApi('settings', 'core')->setSetting('sesvideosell.sesdomainauth', $domain_name);
		Engine_Api::_()->getApi('settings', 'core')->setSetting('sesvideosell.seslkeyauth', $licensekey);
		$error = 1;
  } else {
    $error = $this->view->translate('Please enter correct License key for this product.');
    $error = Zend_Registry::get('Zend_Translate')->_($error);
    $form->getDecorator('errors')->setOption('escape', false);
    $form->addError($error);
    $error = 0;
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sesvideosell.licensekey', $_POST['sesvideosell_licensekey']);
    return;
    $this->_helper->redirector->gotoRoute(array());
  }
}