<?php

//folder name or directory name.
$module_name = 'sesbusinessreview';

//product title and module title.
$module_title = 'Business Directories - Reviews & Ratings Extension';

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
    $postdata['licenseKey'] = @base64_encode($_POST['sesbusinessreview_licensekey']);
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

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.pluginactivated')) {

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();

        $db->query('INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`) VALUES("sesbusinessreview_reviewprofile", "standard", "SES - Business Directories - Review Profile Options Menu");');

        $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
        ("sesbusinessreview_review_profile_edit", "sesbusinessreview", "Edit Review", "Sesbusinessreview_Plugin_Menus", "", "sesbusinessreview_reviewprofile", "", 1),
        ("sesbusinessreview_review_profile_delete", "sesbusinessreview", "Delete Review", "Sesbusinessreview_Plugin_Menus", "", "sesbusinessreview_reviewprofile", "", 2),
        ("sesbusinessreview_review_profile_report", "sesbusinessreview", "Report", "Sesbusinessreview_Plugin_Menus", "", "sesbusinessreview_reviewprofile", "", 3),
        ("sesbusinessreview_review_profile_share", "sesbusinessreview", "Share", "Sesbusinessreview_Plugin_Menus", "", "sesbusinessreview_reviewprofile", "", 4);');

        $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
        ("sesbusinessreview_admin_main_managereview", "sesbusinessreview", "Manage Reviews", "", \'{"route":"admin_default","module":"sesbusinessreview","controller":"manage", "action":"manage-reviews"}\', "sesbusinessreview_admin_settings", "", 2),
        ("sesbusinessreview_admin_main_levelsettings", "sesbusinessreview", "Member Level Settings", "", \'{"route":"admin_default","module":"sesbusinessreview","controller":"manage", "action":"level-settings"}\', "sesbusinessreview_admin_settings", "", 3),
        ("sesbusinessreview_admin_main_reviewparameter", "sesbusinessreview", "Review parameters", "", \'{"route":"admin_default","module":"sesbusinessreview","controller":"manage","action":"review-parameter"}\', "sesbusinessreview_admin_settings", "", 4);');

        $db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`, `default`) VALUES
        ("sesbusinessreview_reviewpost", "sesbusinessreview", \'{item:$subject} has written a review {item:$object}.\', "0", "", "1");');

        $db->query('INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES
        ("sesbusinessreview_reviewpost", "sesbusinessreview", \'{item:$subject} rated and written a review for the business {item:$object}:\', 1, 5, 1, 1, 1, 1);');

        $db->query('DROP TABLE IF EXISTS `engine4_sesbusinessreview_reviewvotes`;');
        $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesbusinessreview_reviewvotes` (
        `reviewvote_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `user_id` INT(11) unsigned NOT NULL,
        `review_id` INT(11) unsigned NOT NULL ,
        `type` tinyint(1) NOT NULL,
        PRIMARY KEY (`reviewvote_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');

        $db->query('DROP TABLE IF EXISTS `engine4_sesbusinessreview_reviews`;');
        $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesbusinessreview_reviews` (
        `review_id` int(11) NOT NULL AUTO_INCREMENT,
        `owner_id` int(11) unsigned NOT NULL,
        `business_id` int(11) unsigned NOT NULL DEFAULT "0",
        `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `pros` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `cons` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `recommended` tinyint(1) NOT NULL DEFAULT "1",
        `like_count` int(11) NOT NULL,
        `comment_count` int(11) NOT NULL,
        `view_count` int(11) NOT NULL,
        `rating` tinyint(1) DEFAULT NULL,
        `featured` tinyint(1) NOT NULL DEFAULT "0",
        `verified` tinyint(1) NOT NULL DEFAULT "0",
        `oftheday` tinyint(1) DEFAULT "0",
        `starttime` datetime DEFAULT NULL,
        `endtime` datetime DEFAULT NULL,
        `creation_date` datetime NOT NULL,
        `useful_count` int(11) NOT NULL DEFAULT "0",
        `funny_count` int(11) NOT NULL DEFAULT "0",
        `cool_count` int(11) NOT NULL DEFAULT "0",
        PRIMARY KEY (`review_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');

        $db->query('DROP TABLE IF EXISTS `engine4_sesbusinessreview_parameters`;');
        $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesbusinessreview_parameters` (
        `parameter_id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `rating` float NOT NULL,
        `category` int(2) DEFAULT NULL,
        PRIMARY KEY (`parameter_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');

        $db->query('DROP TABLE IF EXISTS `engine4_sesbusinessreview_review_parametervalues`;');
        $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesbusinessreview_review_parametervalues` (
        `parametervalue_id` int(11) NOT NULL AUTO_INCREMENT,
        `parameter_id` int(11) NOT NULL,
        `rating` float NOT NULL,
        `business_id` INT(11) NOT NULL,
        `content_id` INT(11) NOT NULL,
        PRIMARY KEY (`parametervalue_id`),
        UNIQUE KEY `uniqueKey` (`parameter_id`,`business_id`,`content_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

        $pageTable = $db->query('SHOW TABLES LIKE \'engine4_sesbusiness_businesses\'')->fetch();
        if($pageTable) {
            $rating = $db->query('SHOW COLUMNS FROM engine4_sesbusiness_businesses LIKE \'rating\'')->fetch();
            if (empty($rating)) {
                $db->query('ALTER TABLE `engine4_sesbusiness_businesses` ADD `rating` VARCHAR(32) NOT NULL DEFAULT "0";');
            }
            $cool_count = $db->query('SHOW COLUMNS FROM engine4_sesbusiness_businesses LIKE \'cool_count\'')->fetch();
            if (empty($cool_count)) {
                $db->query('ALTER TABLE  `engine4_sesbusiness_businesses` ADD  `cool_count` INT( 11 ) NOT NULL DEFAULT "0";');
            }
            $funny_count = $db->query('SHOW COLUMNS FROM engine4_sesbusiness_businesses LIKE \'funny_count\'')->fetch();
            if (empty($funny_count)) {
                $db->query('ALTER TABLE  `engine4_sesbusiness_businesses` ADD  `funny_count` INT( 11 ) NOT NULL DEFAULT "0";');
            }
            $useful_count = $db->query('SHOW COLUMNS FROM engine4_sesbusiness_businesses LIKE \'useful_count\'')->fetch();
            if (empty($useful_count)) {
                $db->query('ALTER TABLE  `engine4_sesbusiness_businesses` ADD  `useful_count` INT( 11 ) NOT NULL DEFAULT "0";');
            }
            $review_count = $db->query('SHOW COLUMNS FROM engine4_sesbusiness_businesses LIKE \'review_count\'')->fetch();
            if (empty($review_count)) {
                $db->query('ALTER TABLE `engine4_sesbusiness_businesses` ADD `review_count` INT(11) UNSIGNED NOT NULL;');
            }
        }

        include_once APPLICATION_PATH . "/application/modules/Sesbusinessreview/controllers/defaultsettings.php";

        Engine_Api::_()->getApi('settings', 'core')->setSetting('sesbusinessreview.pluginactivated', 1);
        Engine_Api::_()->getApi('settings', 'core')->setSetting('sesbusinessreview.licensekey', $_POST['sesbusinessreview_licensekey']);
    }
    $domain_name = @base64_encode(str_replace(array('http://','https://','www.'),array('','',''),$_SERVER['HTTP_HOST']));
    $licensekey = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.licensekey');
    $licensekey = @base64_encode($licensekey);
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sesbusinessreview.sesdomainauth', $domain_name);
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sesbusinessreview.seslkeyauth', $licensekey);
    $error = 1;
  } else {
    $error = $this->view->translate('Please enter correct License key for this product.');
    $error = Zend_Registry::get('Zend_Translate')->_($error);
    $form->getDecorator('errors')->setOption('escape', false);
    $form->addError($error);
    $error = 0;
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sesbusinessreview.licensekey', $_POST['sesbusinessreview_licensekey']);
    return;
    $this->_helper->redirector->gotoRoute(array());
  }
}