<?php

if (!$this->getRequest()->isPost()) {
  return;
}

if (!$form->isValid($this->getRequest()->getPost())) {
  return;
}

if ($this->getRequest()->isPost()) {

  //here we can set some variable for checking in plugin files.
  if (1) {

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespoke.pluginactivated')) {
      $db = Zend_Db_Table_Abstract::getDefaultAdapter();

      $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
      ("sespoke_admin_main_manageactions", "sespoke", "Add Actions & Gifts", "", \'{"route":"admin_default","module":"sespoke","controller":"manageactions"}\', "sespoke_admin_main", "", 2),
      ("sespoke_admin_main_manage", "sespoke", "Manage Actions & Gifts", "", \'{"route":"admin_default","module":"sespoke","controller":"manage"}\', "sespoke_admin_main", "", 3),
      ("sespoke_pokepage", "sespoke", "Pokes & Gifts", "", \'{"route":"sespoke_pokepage","module":"sespoke","controller":"index","action":"index"}\', "core_main", "", 999);');
      $db->query('DROP TABLE IF EXISTS `engine4_sespoke_pokes`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sespoke_pokes` (
      `poke_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `poster_id` int(11) unsigned NOT NULL,
      `receiver_id` int(11) unsigned NOT NULL,
      `creation_date` datetime NOT NULL,
      `manageaction_id` int(11) NOT NULL,
      `modified_date` datetime NOT NULL,
      PRIMARY KEY (`poke_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');

      $db->query('DROP TABLE IF EXISTS `engine4_sespoke_manageactions`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sespoke_manageactions` (
      `manageaction_id` int(11) NOT NULL AUTO_INCREMENT,
      `action` varchar(64) NOT NULL,
      `name` varchar(64) NOT NULL,
      `verb` varchar(64) NOT NULL,
      `icon` int(11) NOT NULL,
      `enabled` tinyint(1) NOT NULL,
      `enable_activity` tinyint(1) NOT NULL,
      `member_levels` varchar(255) NOT NULL,
      `enabled_gutter` TINYINT(1) NOT NULL,
      PRIMARY KEY (`manageaction_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;');

      $db->query('DROP TABLE IF EXISTS `engine4_sespoke_userinfos`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sespoke_userinfos` (
        `userinfo_id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `poke_count` int(11) NOT NULL,
        `call_count` int(11) NOT NULL,
        `wink_count` int(11) NOT NULL,
        `slap_count` int(11) NOT NULL,
        `kiss_count` int(11) NOT NULL,
        `hug_count` int(11) NOT NULL,
        `high_five_count` int(11) NOT NULL,
        `smirk_count` int(11) NOT NULL,
        `heart_count` int(11) NOT NULL,
        `flower_count` int(11) NOT NULL,
        `coffee_count` int(11) NOT NULL,
        `pizza_count` int(11) NOT NULL,
        `cake_count` int(11) NOT NULL,
        `beer_count` int(11) NOT NULL,
        `star_count` int(11) NOT NULL,
        `punch_count` int(11) NOT NULL,
        `gift_count` int(11) NOT NULL,
        `angel_count` int(11) NOT NULL,
        `cat_count` int(11) NOT NULL,
        `cash_count` int(11) NOT NULL,
        PRIMARY KEY (`userinfo_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;');

      $db->query('INSERT IGNORE INTO `engine4_sespoke_manageactions` (`action`, `name`, `verb`, `icon`, `enabled`, `enable_activity`, `member_levels`, `enabled_gutter`) VALUES
        ("action", "Poke", "poked", 0, 1, 1, \'["1", "2", "3", "4"]\', 1),
        ("action", "Call", "called", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("action", "Wink", "winked", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("action", "Slap", "slapped", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("action", "Kiss", "kissed", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("action", "Hug", "hugged", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("action", "High five", "high fived", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("action", "Smirk", "smirked", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("gift", "Heart", "heart", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("gift", "Flower", "", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("gift", "Coffee", "", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("gift", "Pizza", "", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("gift", "Cake", "", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("gift", "Beer", "", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("gift", "Star", "", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("action", "Punch", "punched", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("gift", "Gift", "", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("gift", "Angel", "", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("gift", "Cat", "", 0, 1, 1, \'["1", "2", "3", "4"]\', 0),
        ("gift", "Cash", "", 0, 1, 1, \'["1", "2", "3", "4"]\', 0);');

      $db->query('INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES
      ("sespoke_angel", "sespoke", \'{item:$subject} sent {item:$object} a angel.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_beer", "sespoke", \'{item:$subject} sent {item:$object} a beer.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_cake", "sespoke", \'{item:$subject} sent {item:$object} a cake.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_call", "sespoke", \'{item:$subject} called {item:$object}.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_cash", "sespoke", \'{item:$subject} sent {item:$object} a cash.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_cat", "sespoke", \'{item:$subject} sent {item:$object} a cat.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_coffee", "sespoke", \'{item:$subject} sent {item:$object} a coffee.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_flower", "sespoke", \'{item:$subject} sent {item:$object} a flower.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_gift", "sespoke", \'{item:$subject} sent {item:$object} a gift.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_heart", "sespoke", \'{item:$subject} sent {item:$object} a heart.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_high_five", "sespoke", \'{item:$subject} high fived {item:$object}.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_hug", "sespoke", \'{item:$subject} hugged {item:$object}.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_kiss", "sespoke", \'{item:$subject} kissed {item:$object}.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_pizza", "sespoke", \'{item:$subject} sent {item:$object} a pizza.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_poke", "sespoke", \'{item:$subject} poked {item:$object}.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_punch", "sespoke", \'{item:$subject} punched {item:$object}.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_slap", "sespoke", \'{item:$subject} slapped {item:$object}.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_smirk", "sespoke", \'{item:$subject} smirked {item:$object}.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_star", "sespoke", \'{item:$subject} sent {item:$object} a star.\', 1, 6, 1, 1, 1, 1),
      ("sespoke_wink", "sespoke", \'{item:$subject} winked {item:$object}.\', 1, 6, 1, 1, 1, 1);');

      $db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`, `default`) VALUES
      ("sespoke_back_angel", "sespoke", \'{item:$subject} back Angel to you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_beer", "sespoke", \'{item:$subject} back Beer to you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_cake", "sespoke", \'{item:$subject} back Cake to you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_call", "sespoke", \'{item:$subject} called you back. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_cash", "sespoke", \'{item:$subject} back Cash to you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_cat", "sespoke", \'{item:$subject} back Cat to you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_coffee", "sespoke", \'{item:$subject} back Coffee to you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_flower", "sespoke", \'{item:$subject} back Flower to you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_gift", "sespoke", \'{item:$subject} back Gift to you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_heart", "sespoke", \'{item:$subject} back Heart to you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_high_five", "sespoke", \'{item:$subject} high fived you back. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_hug", "sespoke", \'{item:$subject} hugged you back. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_kiss", "sespoke", \'{item:$subject} kissed you back. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_pizza", "sespoke", \'{item:$subject} back Pizza to you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_poke", "sespoke", \'{item:$subject} poked you back. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_punch", "sespoke", \'{item:$subject} punched you back. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_slap", "sespoke", \'{item:$subject} slapped you back. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_smirk", "sespoke", \'{item:$subject} smirked you back. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_star", "sespoke", \'{item:$subject} back Star to you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_back_wink", "sespoke", \'{item:$subject} winked you back. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_beer", "sespoke", \'{item:$subject} sent you a beer. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_cake", "sespoke", \'{item:$subject} sent you a cake. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_call", "sespoke", \'{item:$subject} called you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_cash", "sespoke", \'{item:$subject} sent you a cash. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_cat", "sespoke", \'{item:$subject} sent you a cat. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_coffee", "sespoke", \'{item:$subject} sent you a coffee. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_flower", "sespoke", \'{item:$subject} sent you a flower. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_gift", "sespoke", \'{item:$subject} sent you a gift. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_heart", "sespoke", \'{item:$subject} sent you a heart. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_high_five", "sespoke", \'{item:$subject} high fived you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_hug", "sespoke", \'{item:$subject} hugged you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_kiss", "sespoke", \'{item:$subject} kissed you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_pizza", "sespoke", \'{item:$subject} sent you a pizza. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_poke", "sespoke", \'{item:$subject} poked you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_punch", "sespoke", \'{item:$subject} punched you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_slap", "sespoke", \'{item:$subject} slapped you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_smirk", "sespoke", \'{item:$subject} smirked you. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_star", "sespoke", \'{item:$subject} sent you a star. {var:$pokedPageLink}\', 0, "", 1),
      ("sespoke_wink", "sespoke", \'{item:$subject} winked you. {var:$pokedPageLink}\', 0, "", 1);');
      include_once APPLICATION_PATH . "/application/modules/Sespoke/controllers/defaultsettings.php";
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sespoke.pluginactivated', 1);
    }
  }
}
