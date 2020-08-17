<?php

//folder name or directory name.
$module_name = 'seseventsponsorship';

//product title and module title.
$module_title = 'Advanced Event Sponsorship Extension';

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
  $postdata['licenseKey'] = @base64_encode($_POST['seseventsponsorship_licensekey']);
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
 // if ($server_output == "OK" && $error != 1) {
  if (1) {

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventsponsorship.pluginactivated')) {
      $db = Zend_Db_Table_Abstract::getDefaultAdapter();

      $db->query('INSERT IGNORE INTO `engine4_sesevent_dashboards` (`type`, `title`, `enabled`, `main`) VALUES 
				("sponsorship", "Sponsorship", "1", "1"),
				("sponsorship_manage", "Manage Sponsorships", "1", "0"),
				("sponsorship_create", "Create Sponsorship", "1", "0"),
				("sponsorship_requests", "Sponsorship Requests", "1", "0"),
				("sponsorship_sales_stats", "Sales Stats", "1", "0"),
				("sponsorship_manage_orders", "Manage Orders", "1", "0"),
				("sponsorship_sales_reports", "Sales Reports", "1", "0"),
				("sponsorship_payment_requests", "Payment Requests", "1", "0"),
				("sponsorship_payment_transactions", "Payment Transactions", "1", "0");
			');

			$db->query('DROP TABLE IF EXISTS `engine4_sesevent_sponsorships` ;');
			$db->query('CREATE TABLE `engine4_sesevent_sponsorships` (
			  `sponsorship_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(11) unsigned NOT NULL,
				`owner_id` int(11) unsigned NOT NULL,
				`price` float DEFAULT "0.00",
			  `title` varchar(255) NULL,
			  `description` TEXT NULL,
				`total` TINYINT(11)  unsigned NOT NULL default "0",
				`sponsor_count` int(11)  unsigned NOT NULL default "0",
				`photo_id` int(11) unsigned NOT NULL default "0",
				`is_delete` enum("0","1") NOT NULL DEFAULT "0",
				`status` enum("0","1") NOT NULL DEFAULT "1",
			  `creation_date` datetime NOT NULL,
			  `modified_date` datetime NOT NULL,
			   PRIMARY KEY (`sponsorship_id`),
			   KEY (`event_id`),
				 KEY (`owner_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
			
			$db->query('DROP TABLE IF EXISTS `engine4_sesevent_sponsorshipdetails` ;');
			$db->query('CREATE TABLE `engine4_sesevent_sponsorshipdetails` (
			  `sponsorshipdetail_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(11) unsigned NOT NULL,
				`sponsorship_id` int(11) unsigned NOT NULL,
				`user_id` int(11) unsigned NOT NULL,
				`sponsorshipmemeber_id` int(11) unsigned NOT NULL,
			  `title` varchar(255) NOT NULL,
			  `description` TEXT NULL,
				`website` VARCHAR(255) NULL,
				`logo_id` int(11) unsigned NOT NULL default "0",
				 PRIMARY KEY (`sponsorshipdetail_id`),
			   KEY (`event_id`),
				 KEY (`sponsorship_id`),
				 KEY (`user_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
			
			$db->query('DROP TABLE IF EXISTS `engine4_sesevent_sponsorshiprequests`;');
			$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesevent_sponsorshiprequests` (
				`sponsorshiprequest_id` int(11) unsigned NOT NULL auto_increment,
				`event_id` int(11) unsigned NOT NULL,
				`user_id` int(11) unsigned NOT NULL,
			  `description` text,
				PRIMARY KEY (`sponsorshiprequest_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
			
			$db->query('DROP TABLE IF EXISTS `engine4_sesevent_sponsorshipmembers` ;');
			$db->query('CREATE TABLE `engine4_sesevent_sponsorshipmembers` (
			  `sponsorshipmemeber_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(11) unsigned NOT NULL,
				`sponsorship_id` int(11) unsigned NOT NULL,
				`owner_id` int(11) unsigned NOT NULL,
				`status` ENUM("pending","cancelled","failed","incomplete","complete","refund") DEFAULT "incomplete",
			  `creation_date` datetime NOT NULL,
			  `modified_date` datetime NOT NULL,
			   PRIMARY KEY (`sponsorshipmemeber_id`),
			   KEY (`event_id`),
				 KEY (`owner_id`),
				 KEY(`sponsorship_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
			
			$db->query('DROP TABLE IF EXISTS `engine4_sesevent_sponsorshiporders`;');
			$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesevent_sponsorshiporders` (
				`sponsorshiporder_id` int(11) unsigned NOT NULL auto_increment,
				`sponsorship_id` int(11) unsigned NOT NULL,
				`sponsorshipmember_id` int(11) unsigned NOT NULL,
				`event_id` int(11) unsigned NOT NULL,
				`owner_id` int(11) unsigned NOT NULL,
				`gateway_id` varchar(128) DEFAULT NULL,
				`gateway_transaction_id` varchar(128) DEFAULT NULL,
				`commission_amount` float DEFAULT 0,
				`total_service_tax` float DEFAULT 0,
				`total_entertainment_tax` float DEFAULT 0,
				`order_note` TEXT DEFAULT NULL,
				`private` TINYINT(1) DEFAULT "0",
				`state` ENUM("pending","cancelled","failed","incomplete","complete","refund") DEFAULT "incomplete",
				`change_rate` float DEFAULT "0.00",
				`total_amount` float DEFAULT "0.00",
				`currency_symbol` VARCHAR(45) NOT NULL,
				`gateway_type` VARCHAR(45) NOT NULL DEFAULT "Paypal",
				`is_delete` TINYINT(1) NOT NULL DEFAULT "0",
				`ip_address` varchar(55) NOT NULL DEFAULT "0.0.0.0",
				`creation_date` datetime NOT NULL,
			  `modified_date` datetime NOT NULL,
				PRIMARY KEY (`sponsorshiporder_id`),
				KEY `event_id` (`event_id`),
				KEY `sponsorship_id` (`sponsorship_id`),
				KEY `sponsorshipmember_id` (`sponsorshipmember_id`),
				KEY `owner_id` (`owner_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
			
			$db->query('DROP TABLE IF EXISTS `engine4_sesevent_usersponsorshippayrequests`;');
			$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesevent_usersponsorshippayrequests` (
				`usersponsorshippayrequest_id` INT(11) unsigned NOT NULL auto_increment,
				`event_id` INT(11) unsigned NOT NULL,
				`owner_id` INT(11) unsigned NOT NULL,
				`requested_amount` FLOAT DEFAULT "0",
				`release_amount` FLOAT DEFAULT "0",
				`user_message` TEXT,
				`admin_message` TEXT,
				`creation_date` datetime NOT NULL,
				`release_date` datetime NOT NULL,
				`is_delete` TINYINT(1) NOT NULL DEFAULT "0",
				`gateway_id` TINYINT (1) DEFAULT "2",
				`gateway_transaction_id`  varchar(128) DEFAULT NULL,
				`state` ENUM("pending","cancelled","failed","incomplete","complete","refund") DEFAULT "pending",
				`currency_symbol` VARCHAR(45) NOT NULL,
				`gateway_type` VARCHAR(45) NOT NULL DEFAULT "Paypal",
				PRIMARY KEY (`usersponsorshippayrequest_id`),
				KEY `event_id` (`event_id`),
				KEY `owner_id` (`owner_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
			
			$db->query('DROP TABLE IF EXISTS `engine4_sesevent_remainingsponsorshippayments`;');
			$db->query('CREATE TABLE IF NOT EXISTS `engine4_sesevent_remainingsponsorshippayments` (
				`remainingsponsorshippayment_id` INT(11) unsigned NOT NULL auto_increment,
				`event_id` INT(11) unsigned NOT NULL,
				`remaining_payment` FLOAT DEFAULT 0,
				PRIMARY KEY (`remainingsponsorshippayment_id`),
				KEY `event_id` (`event_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
			
			$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
			  ("sesevent_admin_main_currency", "sesevent", "Manage Currency", "", \'{"route":"admin_default","module":"sesevent","controller":"settings","action":"currency"}\', "sesevent_admin_main", "", 5),
				("sesevent_admin_main_gateway", "sesevent", "Manage Gateways", "", \'{"route":"admin_default","module":"sesevent","controller":"gateway"}\', "sesevent_admin_main", "", 7),
				("sesevent_admin_main_sponsorshippaymentrequest", "sesevent", "Sponsorship Payment Requests", "", \'{"route":"admin_default","module":"sesevent","controller":"payment-sponsorship"}\', "sesevent_admin_main", "", 8),
				("sesevent_admin_main_managesponsorship", "sesevent", "Manage Sponsorship Orders", "", \'{"route":"admin_default","module":"sesevent","controller":"sponsorship","action":"index"}\', "sesevent_admin_main", "", 16),
				("sesevent_admin_main_managesopnshorshipeventowner", "sesevent", "Manage Sponsorship for Event Owner", "", \'{"route":"admin_default","module":"sesevent","controller":"sponsorship","action":"manage-sponsorship-payment-event-owner"}\', "sesevent_admin_main", "", 17);
			');

      include_once APPLICATION_PATH . "/application/modules/Seseventsponsorship/controllers/defaultsettings.php";

      Engine_Api::_()->getApi('settings', 'core')->setSetting('seseventsponsorship.pluginactivated', 1);

      Engine_Api::_()->getApi('settings', 'core')->setSetting('seseventsponsorship.licensekey', $_POST['seseventsponsorship_licensekey']);
    }
    $domain_name = @base64_encode($_SERVER['HTTP_HOST']);
		$licensekey = Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventsponsorship.licensekey');
		$licensekey = @base64_encode($licensekey);
		Engine_Api::_()->getApi('settings', 'core')->setSetting('seseventsponsorship.sesdomainauth', $domain_name);
		Engine_Api::_()->getApi('settings', 'core')->setSetting('seseventsponsorship.seslkeyauth', $licensekey);
  } else {
    $error = $this->view->translate('Please enter correct License key for this product.');
    $error = Zend_Registry::get('Zend_Translate')->_($error);
    $form->getDecorator('errors')->setOption('escape', false);
    $form->addError($error);
    Engine_Api::_()->getApi('settings', 'core')->setSetting('seseventsponsorship.licensekey', $_POST['seseventsponsorship_licensekey']);
    return;
    $this->_helper->redirector->gotoRoute(array());
  }
}