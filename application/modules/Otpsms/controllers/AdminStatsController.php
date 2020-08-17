<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminStatsController.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Otpsms_AdminStatsController extends Core_Controller_Action_Admin {
  public function indexAction() {
    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('otpsms_admin_main', array(), 'otpsms_admin_main_stats');
	
	$table = Engine_Api::_()->getDbTable('statistics','otpsms');
	
	if(!empty($_GET['type'])){
		$service = $_GET['type'];
	}else{
		$service = "twilio";
	}
	
	$this->view->service = $service;

	$select = $table->select()->from($table->info('name'), 'count(*) AS res')->where('service =?', $service)->where('type =?','admin');
    $this->view->admin = $select->query()->fetchColumn();
	
	$select = $table->select()->from($table->info('name'), 'count(*) AS res')->where('service =?', $service)->where('type =?','signup_template');
    $this->view->signup_template = $select->query()->fetchColumn();

	$select = $table->select()->from($table->info('name'), 'count(*) AS res')->where('service =?', $service)->where('type =?','edit_number_template');
    $this->view->edit_number_template = $select->query()->fetchColumn();
	
	$select = $table->select()->from($table->info('name'), 'count(*) AS res')->where('service =?', $service)->where('type =?','add_number_template');
    $this->view->add_number_template = $select->query()->fetchColumn();
	  
	$select = $table->select()->from($table->info('name'), 'count(*) AS res')->where('service =?', $service)->where('type =?','forgot_template');
    $this->view->forgot_template = $select->query()->fetchColumn();
	
	$select = $table->select()->from($table->info('name'), 'count(*) AS res')->where('service =?', $service)->where('type =?','login_template');
    $this->view->login_template = $select->query()->fetchColumn();
	
  }
}
