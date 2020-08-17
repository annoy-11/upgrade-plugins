<?php

class Sesgroupalbum_Installer extends Engine_Package_Installer_Module {

  public function onPreinstall() {

    $db = $this->getDb();
    $plugin_currentversion = '4.8.10';
	  $error = include APPLICATION_PATH . "/application/modules/Sesbasic/controllers/checkPluginVersion.php";
	  if($error != '1') {
		  return $this->_error($error);
		}

    parent::onPreinstall();
  }

  public function onInstall() {

    $db = $this->getDb();
    parent::onInstall();
  }
  
  public function onEnable() {
  
    $db = $this->getDb();
    $db->query("UPDATE  `engine4_group_albums` SET  `title` =  'Untitled Album' WHERE  `engine4_group_albums`.`title` =  '';");
    $db->query("UPDATE `engine4_core_comments` SET  `resource_type` =  'sesgroupalbum_photo' WHERE  `engine4_core_comments`.`resource_type` ='group_photo';");
		$db->query("UPDATE `engine4_core_comments` SET  `resource_type` =  'sesgroupalbum_album' WHERE  `engine4_core_comments`.`resource_type` ='group_album';");
		$db->query("UPDATE `engine4_core_likes` SET  `resource_type` =  'sesgroupalbum_photo' WHERE  `engine4_core_likes`.`resource_type` ='group_photo';");
		$db->query("UPDATE `engine4_core_likes` SET  `resource_type` =  'sesgroupalbum_album' WHERE  `engine4_core_likes`.`resource_type` ='group_album';");
		
    parent::onEnable();
  }
  
  public function onDisable() {
  
    $db = $this->getDb();
    
    $db->query("UPDATE `engine4_core_comments` SET  `resource_type` =  'group_photo' WHERE  `engine4_core_comments`.`resource_type` ='sesgroupalbum_photo';");
		$db->query("UPDATE `engine4_core_comments` SET  `resource_type` =  'group_album' WHERE  `engine4_core_comments`.`resource_type` ='sesgroupalbum_album';");
		$db->query("UPDATE `engine4_core_likes` SET  `resource_type` =  'group_photo' WHERE  `engine4_core_likes`.`resource_type` ='sesgroupalbum_photo';");
		$db->query("UPDATE `engine4_core_likes` SET  `resource_type` =  'group_album' WHERE  `engine4_core_likes`.`resource_type` ='sesgroupalbum_album';");
		
    parent::onDisable();
  }

}