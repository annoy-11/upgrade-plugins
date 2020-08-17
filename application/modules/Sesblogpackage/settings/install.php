<?php
class Sesblogpackage_Installer extends Engine_Package_Installer_Module {
	
  public function onPreinstall() {
    $db = $this->getDb();
		/*
    $plugin_currentversion = '4.8.10p2';
	  $error = include APPLICATION_PATH . "/application/modules/Sesbasic/controllers/checkPluginVersion.php";
	  if($error != '1') {
		  return $this->_error($error);
		}*/
		//$db->query("UPDATE engine4_sesblog_blogs SET package_id = 1 WHERE package_id = 0");		
    parent::onPreinstall();
  }
  public function onInstall() {
		$db = $this->getDb();
		$currency = $db->query("SELECT * FROM engine4_core_menuitems WHERE name = 'sesbasic_admin_main_currency' LIMIT 1")->fetchAll();
		if(!count($currency)){
			$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("sesbasic_admin_main_currency", "sesbasic", "Manage Currency", "", \'{"route":"admin_default","module":"sesbasic","controller":"settings","action":"currency"}\', "sesbasic_admin_main", "", 5)');
			$db->query('INSERT IGNORE INTO `engine4_core_tasks` (`task_id`, `title`, `module`, `plugin`, `timeout`, `processes`, `semaphore`, `started_last`, `started_count`, `completed_last`, `completed_count`, `failure_last`, `failure_count`, `success_last`, `success_count`) VALUES (NULL, "SES: Get Currency Values", "sesbasic", "Sesbasic_Plugin_Task_Jobs", "600", "1", "0", "0", "0", "0", "0", "0", "0", "0", "0"),;');
		}
		$db->query("ALTER TABLE  `engine4_sesblog_blogs` ADD  `package_id` INT(11) NOT NULL DEFAULT '0'");
		$db->query("UPDATE engine4_sesblog_blogs SET package_id = 1 WHERE package_id = 0");	
		$db->query("INSERT INTO `engine4_sesblog_dashboards` (`dashboard_id`, `type`, `title`, `enabled`, `main`) VALUES (NULL, 'fields', 'Fields', '1', '0'), (NULL, 'upgrade', 'Upgrade Package', '1', '0');");	
    parent::onInstall();
  }
	public function onDisable(){
		$db = $this->getDb();
		parent::onEnable();
 }
}
