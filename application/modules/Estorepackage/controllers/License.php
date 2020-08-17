<?php

//folder name or directory name.
$module_name = 'estorepackage';

//product title and module title.
$module_title = 'Store Directories - Packages for Allowing Store Creation Extension';

if (!$this->getRequest()->isPost()) {
  return;
}

if (!$form->isValid($this->getRequest()->getPost())) {
  return;
}

if ($this->getRequest()->isPost()) {

  //here we can set some variable for checking in plugin files.
  if (1) {

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('estorepackage.pluginactivated')) {

      $db = Zend_Db_Table_Abstract::getDefaultAdapter();

      $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("estore_admin_package", "estorepackage", "Manage Packages", "", \'{"route":"admin_default","module":"estorepackage","controller":"package"}\', "estore_admin_packagesetting", "", 2),
      ("estorepackage_admin_main_transaction", "estorepackage", "Manage Transactions", "", \'{"route":"admin_default","module":"estorepackage","controller":"package", "action":"manage-transaction"}\', "estore_admin_packagesetting", "", 3);');

      $db->query('DROP TABLE IF EXISTS `engine4_estorepackage_packages`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_estorepackage_packages` (
        `package_id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255),
        `description` text,
        `item_count` INT(11) DEFAULT "0",
        `custom_fields` TEXT DEFAULT NULL,
        `member_level` varchar(255) DEFAULT NULL,
        `price` float DEFAULT "0",
        `recurrence` varchar(25) DEFAULT "0",
        `renew_link_days` INT(11) DEFAULT "0",
        `is_renew_link` tinyint(1) DEFAULT "0",
        `recurrence_type` varchar(25) DEFAULT NULL,
        `duration` varchar(25) DEFAULT "0",
        `duration_type` varchar(10) DEFAULT NULL,
        `enabled` tinyint(1) NOT NULL DEFAULT "1",
        `params` text DEFAULT NULL,
        `custom_fields_params` TEXT DEFAULT NULL,
        `default` tinyint(1) NOT NULL DEFAULT "0",
        `order` INT(11) NOT NULL DEFAULT "0",
        `highlight` TINYINT(1) NOT NULL DEFAULT "0",
        `show_upgrade` INT(11) NOT NULL DEFAULT "0",
        `creation_date` datetime NOT NULL,
        `modified_date` datetime NOT NULL,
        PRIMARY KEY (`package_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

      $db->query('INSERT IGNORE INTO `engine4_estorepackage_packages` (`title`, `description`, `member_level`, `price`, `recurrence`, `recurrence_type`, `duration`, `duration_type`, `enabled`, `params`, `default`, `creation_date`, `modified_date`) VALUES ("Free Store Package", NULL, "0,1,2,3,4", "0", "0", "forever", "0", "forever", "1", \'{"is_featured":"1","is_sponsored":"1","is_verified":"1","award_count":"5","allow_participant":null,"upload_cover":"1","upload_mainphoto":"1","store_choose_style":"1","store_chooselayout":["1","2","3","4"],"store_approve":"1","store_featured":"0","store_sponsored":"0","store_verified":"0","store_hot":0,"store_seo":"1","store_overview":"1","store_bgphoto":"1","store_contactinfo":"1","custom_fields":1}\', "1", "NOW()", "NOW()");');

      $db->query('DROP TABLE IF EXISTS `engine4_estorepackage_transactions`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_estorepackage_transactions` (
        `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
        `package_id` int(11) NOT NULL,
        `owner_id` int(11) NOT NULL,
        `order_id` int(11) NOT NULL,
        `orderspackage_id` int(11) NOT NULL,
        `gateway_id` tinyint(1) DEFAULT NULL,
        `gateway_transaction_id` varchar(128) DEFAULT NULL,
        `gateway_parent_transaction_id` varchar(128) DEFAULT NULL,
        `item_count` int(11) NOT NULL DEFAULT "0",
        `gateway_profile_id` VARCHAR(128) DEFAULT NULL,
        `state` enum("pending","cancelled","failed","imcomplete","complete","refund","okay","overdue","initial","active") NOT NULL DEFAULT "pending",
        `change_rate` float NOT NULL DEFAULT "0",
        `total_amount` float NOT NULL DEFAULT "0",
        `currency_symbol` varchar(45) DEFAULT NULL,
        `gateway_type` varchar(45) DEFAULT NULL,
        `ip_address` varchar(45) NOT NULL DEFAULT "0.0.0.0",
        `expiration_date` datetime NOT NULL,
        `creation_date` datetime NOT NULL,
        `modified_date` datetime NOT NULL,
        PRIMARY KEY (`transaction_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT = 1 ;');

        $db->query('DROP TABLE IF EXISTS `engine4_estorepackage_orderspackages`;');
        $db->query('CREATE TABLE IF NOT EXISTS `engine4_estorepackage_orderspackages` (
        `orderspackage_id` int(11) NOT NULL AUTO_INCREMENT,
        `package_id` int(11) NOT NULL,
        `item_count` int(11) NOT NULL,
        `owner_id` int(11) NOT NULL,
        `state` enum("pending","cancelled","failed","imcomplete","complete","refund","okay","overdue","active") NOT NULL DEFAULT "pending",
        `expiration_date` datetime NOT NULL,
        `ip_address` varchar(45) NOT NULL DEFAULT "0.0.0.0",
        `creation_date` datetime NOT NULL,
        `modified_date` datetime NOT NULL,
        PRIMARY KEY (`orderspackage_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES ("estore_payment_notify_page", "estore", \'Make payment of your store {item:$object} to get your store approved.\', 0, "");');

        $db->query('INSERT IGNORE INTO `engine4_estore_dashboards` (`type`, `title`, `enabled`, `main`) VALUES
        ("upgrade", "Upgrade Package", "1", "0");');

        $store_table = $db->query('SHOW TABLES LIKE \'engine4_estore_stores\'')->fetch();
        if($store_table) {

            $package_id = $db->query('SHOW COLUMNS FROM engine4_estore_stores LIKE \'package_id\'')->fetch();
            if (empty($package_id)) {
                $db->query('ALTER TABLE `engine4_estore_stores` ADD `package_id` INT(11) NOT NULL DEFAULT "0";');
            }

            $transaction_id = $db->query('SHOW COLUMNS FROM engine4_estore_stores LIKE \'transaction_id\'')->fetch();
            if (empty($transaction_id)) {
                $db->query('ALTER TABLE  `engine4_estore_stores` ADD  `transaction_id` INT(11) NOT NULL DEFAULT "0";');
            }

            $existing_package_order = $db->query('SHOW COLUMNS FROM engine4_estore_stores LIKE \'existing_package_order\'')->fetch();
            if (empty($existing_package_order)) {
                $db->query('ALTER TABLE  `engine4_estore_stores` ADD  `existing_package_order` INT(11) NOT NULL DEFAULT "0";');
            }

            $orderspackage_id = $db->query('SHOW COLUMNS FROM engine4_estore_stores LIKE \'orderspackage_id\'')->fetch();
            if (empty($orderspackage_id)) {
                $db->query('ALTER TABLE  `engine4_estore_stores` ADD  `orderspackage_id` INT(11) NOT NULL DEFAULT "0";');
            }
        }

        include_once APPLICATION_PATH . "/application/modules/Estorepackage/controllers/defaultsettings.php";

        Engine_Api::_()->getApi('settings', 'core')->setSetting('estorepackage.pluginactivated', 1);
        Engine_Api::_()->getApi('settings', 'core')->setSetting('estorepackage.licensekey', $_POST['estorepackage_licensekey']);
    }
    $domain_name = @base64_encode(str_replace(array('http://', 'https://', 'www.'), array('', '', ''), $_SERVER['HTTP_HOST']));
    $licensekey = Engine_Api::_()->getApi('settings', 'core')->getSetting('estorepackage.licensekey');
    $licensekey = @base64_encode($licensekey);
    Engine_Api::_()->getApi('settings', 'core')->setSetting('estorepackage.sesdomainauth', $domain_name);
    Engine_Api::_()->getApi('settings', 'core')->setSetting('estorepackage.seslkeyauth', $licensekey);
    $error = 1;
  } else {
    $error = $this->view->translate('Please enter correct License key for this product.');
    $error = Zend_Registry::get('Zend_Translate')->_($error);
    $form->getDecorator('errors')->setOption('escape', false);
    $form->addError($error);
    $error = 0;
    Engine_Api::_()->getApi('settings', 'core')->setSetting('estorepackage.licensekey', $_POST['estorepackage_licensekey']);
    return;
    $this->_helper->redirector->gotoRoute(array());
  }
}
