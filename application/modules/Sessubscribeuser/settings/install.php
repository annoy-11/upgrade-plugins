<?php

class Sessubscribeuser_Installer extends Engine_Package_Installer_Module {

  public function onInstall() {

    $db = $this->getDb();
    
    
    //memebr profile page
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sessubscribeuser_profile_index')
      ->limit(1)
      ->query()
      ->fetchColumn();
    
    if (!$page_id) {
       // Insert page
        $db->insert('engine4_core_pages', array(
          'name' => 'sessubscribeuser_profile_index',
          'displayname' => 'SES - Member Profile Page',
          'title' => 'Member Profile Page',
          'description' => 'This is the memebr profile page.',
          'provides' => 'no-viewer;no-subject',
          'custom' => 0,
        ));
        $page_id = $db->lastInsertId();

       // Insert main
        $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'main',
          'page_id' => $page_id,
        ));
        $main_id = $db->lastInsertId();

        // Insert middle
        $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'middle',
          'page_id' => $page_id,
          'parent_content_id' => $main_id,
          'order' => 2,
        ));
        $middle_id = $db->lastInsertId();

//         // Insert content
//         $db->insert('engine4_core_content', array(
//           'type' => 'widget',
//           'name' => 'core.content',
//           'page_id' => $page_id,
//           'parent_content_id' => $middle_id,
//           'order' => 1,
//         ));
    }
    parent::onInstall();
  }

}
