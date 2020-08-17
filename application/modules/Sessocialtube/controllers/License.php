<?php

//folder name or directory name.
$module_name = 'sessocialtube';

//product title and module title.
$module_title = 'Responsive SocialTube Theme';

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
  $postdata['licenseKey'] = @base64_encode($_POST['sessocialtube_licensekey']);
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
  if ($server_output == "OK" && $error != 1) {

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialtube.pluginactivated')) {
      $db = Zend_Db_Table_Abstract::getDefaultAdapter();

      $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
			("sessocialtube_admin_main_menus", "sessocialtube", "Manage Header", "", \'{"route":"admin_default","module":"sessocialtube","controller":"manage", "action":"header-template"}\', "sessocialtube_admin_main", "", 3),
			("sessocialtube_admin_main_footer", "sessocialtube", "Footer", "", \'{"route":"admin_default","module":"sessocialtube","controller":"manage", "action":"footer-settings"}\', "sessocialtube_admin_main", "", 4),
			("sessocialtube_admin_main_styling", "sessocialtube", "Color Schemes", "", \'{"route":"admin_default","module":"sessocialtube","controller":"settings", "action":"styling"}\', "sessocialtube_admin_main", "", 5),
			("sessocialtube_admin_main_managebanners", "sessocialtube", "Manage Banners", "", \'{"route":"admin_default","module":"sessocialtube","controller":"manage-banner","action":"index"}\', "sessocialtube_admin_main", "", 6);
      ');
      
      $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
      ("socialtube.header.loggedin.options.0", "search"),
      ("socialtube.header.loggedin.options.1", "miniMenu"),
      ("socialtube.header.loggedin.options.2", "mainMenu"),
      ("socialtube.header.loggedin.options.3", "logo");');
      
      $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
      ("socialtube.header.nonloggedin.options.0", "search"),
      ("socialtube.header.nonloggedin.options.1", "miniMenu"),
      ("socialtube.header.nonloggedin.options.2", "mainMenu"),
      ("socialtube.header.nonloggedin.options.3", "logo");');
      
      $db->query('DROP TABLE IF EXISTS `engine4_sessocialtube_banners`;');
			$db->query('CREATE TABLE IF NOT EXISTS `engine4_sessocialtube_banners` (
				`banner_id` int(11) unsigned NOT NULL auto_increment,
				`banner_name` VARCHAR(255)  NULL ,
				`creation_date` datetime NOT NULL,
				`modified_date` datetime NOT NULL,
				`enabled` TINYINT(1) NOT NULL DEFAULT "1",
				PRIMARY KEY (`banner_id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;'
			);
			
      $db->query('DROP TABLE IF EXISTS `engine4_sessocialtube_headerphotos`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sessocialtube_headerphotos` (
        `headerphoto_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `file_id` int(11) DEFAULT "0",
        `order` tinyint(10) NOT NULL DEFAULT "0",
        `enabled` tinyint(1) DEFAULT "1",
        `creation_date` datetime NOT NULL,
        `modified_date` datetime NOT NULL,
        PRIMARY KEY (`headerphoto_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
      $db->query('DROP TABLE IF EXISTS `engine4_sessocialtube_slides`;');
			$db->query('CREATE TABLE IF NOT EXISTS `engine4_sessocialtube_slides` (
				`slide_id` int(11) unsigned NOT NULL auto_increment,
				`banner_id` int(11) DEFAULT NULL, 
				`title` varchar(255) DEFAULT NULL,
				`title_button_color` varchar(255) DEFAULT NULL,
				`description` text,
				`description_button_color` varchar(255) DEFAULT NULL,
				`file_type` varchar(255) DEFAULT NULL,
				`file_id` INT(11) DEFAULT "0",
				`status` ENUM("1","2","3") NOT NULL DEFAULT "1",
				`extra_button_linkopen` TINYINT(1) NOT NULL DEFAULT "0",
				`extra_button` tinyint(1) DEFAULT "0",
				`extra_button_text` varchar(255) DEFAULT NULL,
				`extra_button_link` varchar(255) DEFAULT NULL,
				`order` tinyint(10) NOT NULL DEFAULT "0",
				`creation_date` datetime NOT NULL,
				`modified_date` datetime NOT NULL,
				`enabled` TINYINT(1) NOT NULL DEFAULT "1",
				PRIMARY KEY (`slide_id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
			');
			
			$db->query('DROP TABLE IF EXISTS `engine4_sessocialtube_socialicons`;');
			$db->query('CREATE TABLE IF NOT EXISTS `engine4_sessocialtube_socialicons` (
				  `socialicon_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `title` varchar(255) NOT NULL,
				  `url` varchar(255) NOT NULL,
				  `enabled` tinyint(1) NOT NULL DEFAULT "1",
				  `order` int(11) NOT NULL,
				  PRIMARY KEY (`socialicon_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');

		  $db->query('INSERT IGNORE INTO `engine4_sessocialtube_socialicons` (`socialicon_id`, `name`, `title`, `url`, `enabled`, `order`) VALUES
			(1, "facebook", "Like Us on Facebook", "http://facebook.com", 1, 1),
			(2, "google", "Google Plus", "http://google.com", 1, 2),
			(3, "linkdin", "Linkdin", "http://linkdin.com", 1, 3),
			(4, "twitter", "Twitter", "http://twitter.com", 1, 4),
			(5, "pinintrest", "Pinintrest", "http://pinintrest.com", 1, 5),
			(6, "instragram", "Instagram", "http://instagram.com", 1, 6),
			(7, "youtube", "YouTube", "http://youtube.com", 1, 7),
			(8, "vimeo", "Vimeo", "http://vimeo.com", 1, 8),
			(9, "tumblr", "Tumblr", "http://tumblr.com", 1, 9),
			(10, "flickr", "Flickr", "http://flickr.com", 1, 10)');

		  $db->query('DROP TABLE IF EXISTS `engine4_sessocialtube_footerlinks`;');
		  $db->query('CREATE TABLE IF NOT EXISTS `engine4_sessocialtube_footerlinks` (
			`footerlink_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`name` varchar(255) NOT NULL,
			`url` varchar(255) NOT NULL,
			`enabled` tinyint(1) NOT NULL DEFAULT "1",
			`sublink` tinyint(1) NOT NULL DEFAULT "0",
			PRIMARY KEY (`footerlink_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');
			
		  $db->query('INSERT IGNORE INTO `engine4_sessocialtube_footerlinks` (`name`, `url`, `enabled`, `sublink`) VALUES
			("Footer Column 1", "", 1, 0),
			("Footer Column 2", "", 1, 0),
			("Footer Column 3", "", 1, 0),
			("Footer Column 4", "", 1, 0);');
			
			$db->query('ALTER TABLE `engine4_sessocialtube_footerlinks` ADD `nonloginenabled` TINYINT(1) NOT NULL DEFAULT "1";');
      $db->query('ALTER TABLE `engine4_sessocialtube_footerlinks` ADD `nonlogintarget` TINYINT(1) NOT NULL DEFAULT "0";');
      $db->query('ALTER TABLE `engine4_sessocialtube_footerlinks` ADD `loginurl` VARCHAR(255) NOT NULL;');
      $db->query('ALTER TABLE `engine4_sessocialtube_footerlinks` ADD `loginenabled` TINYINT(1) NOT NULL DEFAULT "1";');
      $db->query('ALTER TABLE `engine4_sessocialtube_footerlinks` ADD `logintarget` TINYINT(1) NOT NULL DEFAULT "0";');
      
		  $db->query('DROP TABLE IF EXISTS `engine4_sessocialtube_managesearchoptions`;');
		  $db->query('CREATE TABLE IF NOT EXISTS `engine4_sessocialtube_managesearchoptions` (
			  `managesearchoption_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `type` varchar(255) NOT NULL,
			  `title` varchar(255) NOT NULL,
			  `file_id` INT(11) DEFAULT "0",
			  `enabled` tinyint(1) NOT NULL DEFAULT "1",
			  `order` int(11) NOT NULL,
			  PRIMARY KEY (`managesearchoption_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');

      include_once APPLICATION_PATH . "/application/modules/Sessocialtube/controllers/defaultsettings.php";

      Engine_Api::_()->getApi('settings', 'core')->setSetting('sessocialtube.pluginactivated', 1);

      Engine_Api::_()->getApi('settings', 'core')->setSetting('sessocialtube.licensekey', $_POST['sessocialtube_licensekey']);
    }
  } else {

    $error = $this->view->translate('Please enter correct License key for this product.');
    $error = Zend_Registry::get('Zend_Translate')->_($error);
    $form->getDecorator('errors')->setOption('escape', false);
    $form->addError($error);
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sessocialtube.licensekey', $_POST['sessocialtube_licensekey']);
    return;
    $this->_helper->redirector->gotoRoute(array());
  }
}