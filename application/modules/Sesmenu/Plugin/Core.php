<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmenu_Plugin_Core extends Zend_Controller_Plugin_Abstract {
    public function getAdminNotifications($event) {
        $db = Engine_Db_Table::getDefaultAdapter();
        $menuItemsTable = Engine_Api::_()->getDbtable('menuItems', 'core');
        $select = $menuItemsTable->select()
        ->where("id  NOT IN ( Select id from engine4_sesmenu_menuitems) and menu='core_main'");
        $results = $menuItemsTable->fetchAll($select);

        if(count($results) > 0) {

            $translate = Zend_Registry::get('Zend_Translate');
            $message = vsprintf($translate->translate(array('<div class="sesmenu_notice_tip">There are <a href="%s">%d new menus</a> on your website which are not synced with the Ultimate Menu Plugin. To sink the menus go to, "Ultimate Menu Plugin" >> "Manage Templates" section.</div>', '<div class="sesmenu_notice_tip">There are <a href="%s">%d new menus</a> on your website which are not synced with the Ultimate Menu Plugin\'s Layout Editor. To sink the menus go to, "Ultimate Menu Plugin" >> "Manage Templates" section.</div>', count($results))), array(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesmenu', 'controller' => 'settings', 'action' => 'sink-menus'), 'admin_default', array('class' => 'smoothbox')), count($results)));
            $event->addResponse($message);
        }
    }
}
