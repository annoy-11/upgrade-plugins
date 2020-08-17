<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: instal.php  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinesspoll_Installer extends Engine_Package_Installer_Module{
public function onPreinstall() {

    $db = $this->getDb();

    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules')
            ->where('name = ?', 'sesbusiness')
            ->where('enabled = ?', 1);
    $sesbusiness_Check = $select->query()->fetchObject();

    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules')
            ->where('name = ?', 'sesbusiness');
    $sesbusinessCheck = $select->query()->fetchAll();

    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_settings')
            ->where('name = ?', 'sesbusiness.pluginactivated')
            ->limit(1);
    $business_activate = $select->query()->fetchAll();

    if(!empty($sesbusiness_Check) && !empty($business_activate[0]['value'])) {
      $plugin_currentversion = '4.10.3p8';
      $error = include APPLICATION_PATH . "/application/modules/Sesbasic/controllers/checkPluginVersion.php";
      if($error != '1') {
        return $this->_error($error);
      }
    } elseif(!empty($sesbusiness_Check) && empty($business_activate[0]['value'])) {
      return $this->_error('<div class="global_form"><div><div><p style="color:red;">The "<a href="https://www.socialenginesolutions.com/social-engine/business-directories-plugin/" target="_blank">Business Directories Plugin</a>" is installed on your website, but is not yet activated. So, please first activate it before installing the Business Polls Extension.</p></div></div></div>');
    } elseif(!empty($sesbusinessCheck) && empty($sesbusiness_Check)) {
      return $this->_error('<div class="global_form"><div><div><p style="color:red;">The "<a href="https://www.socialenginesolutions.com/social-engine/business-directories-plugin/" target="_blank">Business Directories Plugin</a>" is installed on your website, but is not yet enabled. So, please first enable it from the "Manage" >> "Packages & Plugins" section to proceed further.</p></div></div></div>');
    } elseif(empty($sesbusinessCheck)) {
      return $this->_error('<div class="global_form"><div><div><p style="color:red;">The required "<a href="https://www.socialenginesolutions.com/social-engine/business-directories-plugin/" target="_blank">Business Directories Plugin</a>" is not installed on your website. Please download the latest version of "<a href="https://www.socialenginesolutions.com/social-engine/business-directories-plugin/" target="_blank">Business Directories Plugin</a>" from <a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions.com</a> website.</p></div></div></div>');
    }

    parent::onPreinstall();
  }
  public function onInstall(){
    $this->_addPollBrowsePage();
    $this->_addPollHomePage();
    $this->_addPollViewPage();
    $this->_addPollCreatePage();
    $this->_addPollEditPage();
    $this->_addBusinessProfilePollDesign1();
    $this->_addBusinessProfilePollDesign2();
    $this->_addBusinessProfilePollDesign3();
    $this->_addBusinessProfilePollDesign4();
    parent::onInstall();
  }
  protected function _addBusinessProfilePollDesign1(){
	  $db = $this->getDb();
		// profile page
		$page_id = $db->select()
		  ->from('engine4_core_pages', 'page_id')
		  ->where('name = ?', 'sesbusiness_profile_index_1')
		  ->limit(1)
		  ->query()
		  ->fetchColumn();
		   $tab_id =  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
			  ->where('name = ?', 'core.container-tabs')
			  ->where('page_id = ?', $page_id)
			  ->limit(1) 
			  ->query()
			->fetchColumn();
		// insert if it doesn't exist yet
		  if ($page_id){
			$db->insert('engine4_core_content', array(
		  'type' => 'widget',
		  'name' => 'sesbusinesspoll.profile-polls',
		  'page_id' => $page_id,
		  'parent_content_id' => $tab_id,
		  'order' => 11,
		  'params' => '{"title":"Polls","load_content":"auto_load","show_criteria":["like","description","vote","in", "comment","by","favourite","title", "favouriteButton", "likeButton", "socialSharing", "view"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","pagging":"auto_load","gridlist":"0","show_limited_data":null,"limit_data":"20","nomobile":"0","name":"sesbusinesspoll.profile-polls"}',
	  ));
	}
  }
  protected function _addBusinessProfilePollDesign2(){
	  $db = $this->getDb();
		// profile page
		$page_id = $db->select()
		  ->from('engine4_core_pages', 'page_id')
		  ->where('name = ?', 'sesbusiness_profile_index_2')
		  ->limit(1)
		  ->query()
		  ->fetchColumn();
		   $tab_id =  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
			  ->where('name = ?', 'core.container-tabs')
			  ->where('page_id = ?', $page_id)
			  ->limit(1) 
			  ->query()
			->fetchColumn();
		// insert if it doesn't exist yet
		  if ($page_id){
			
			//$tab_id = $db->lastInsertId('engine4_core_content');
			$db->insert('engine4_core_content', array(
		  'type' => 'widget',
		  'name' => 'sesbusinesspoll.profile-polls',
		  'page_id' => $page_id,
		  'parent_content_id' => $tab_id,
		  'order' => 11,
		  'params' => '{"title":"Polls","load_content":"auto_load","show_criteria":["like","description","vote","in", "comment","by","favourite","title", "favouriteButton", "likeButton", "socialSharing", "view"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","pagging":"auto_load","gridlist":"0","show_limited_data":null,"limit_data":"20","nomobile":"0","name":"sesbusinesspoll.profile-polls"}',
	  ));
	}
  }
  protected function _addBusinessProfilePollDesign3(){
	  $db = $this->getDb();
		// profile page
		$page_id = $db->select()
		  ->from('engine4_core_pages', 'page_id')
		  ->where('name = ?', 'sesbusiness_profile_index_3')
		  ->limit(1)
		  ->query()
		  ->fetchColumn();
		   $tab_id =  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
			  ->where('name = ?', 'core.container-tabs')
			  ->where('page_id = ?', $page_id)
			  ->limit(1) 
			  ->query()
			->fetchColumn();
		  if ($page_id){
			//$tab_id = $db->lastInsertId('engine4_core_content');
			$db->insert('engine4_core_content', array(
		  'type' => 'widget',
		  'name' => 'sesbusinesspoll.profile-polls',
		  'page_id' => $page_id,
		  'parent_content_id' => $tab_id,
		  'order' => 11,
		  'params' => '{"title":"Polls","load_content":"auto_load","show_criteria":["title","vote","socialSharing","like","likeButton","favourite","comment","view"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","pagging":"auto_load","gridlist":"0","show_limited_data":null,"limit_data":"20","nomobile":"0","name":"sesbusiness.profile-polls"}',
	  ));
	}
   }
  protected function _addBusinessProfilePollDesign4(){
	  $db = $this->getDb();
		// profile page
		$page_id = $db->select()
		  ->from('engine4_core_pages', 'page_id')
		  ->where('name = ?', 'sesbusiness_profile_index_4')
		  ->limit(1)
		  ->query()
		  ->fetchColumn();
		   $tab_id =  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
			  ->where('name = ?', 'core.container-tabs')
			  ->where('page_id = ?', $page_id)
			  ->limit(1) 
			  ->query()
			->fetchColumn();
		  if ($page_id){
			
			//$tab_id = $db->lastInsertId('engine4_core_content');
			$db->insert('engine4_core_content', array(
		  'type' => 'widget',
		  'name' => 'sesbusinesspoll.profile-polls',
		  'page_id' => $page_id,
		  'parent_content_id' => $tab_id,
		  'order' => 11,
		  'params' => '{"title":"Polls","load_content":"auto_load","show_criteria":["like","description","vote","in", "comment","by","favourite","title", "favouriteButton", "likeButton", "socialSharing", "view"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","pagging":"auto_load","gridlist":"0","show_limited_data":null,"limit_data":"20","nomobile":"0","name":"sesbusinesspoll.profile-polls"}',
	  ));
	}
 }
  protected function _addPollCreatePage()
  {
  
  $db = $this->getDb();

    // profile page
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesbusinesspoll_index_create')
      ->limit(1)
      ->query()
      ->fetchColumn();
      
    if( !$page_id ) {
      
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesbusinesspoll_index_create',
		'displayname' => 'SES - Business Polls Extension - Poll Create Page',
        'title' => 'Create New Poll',
        'description' => 'This page is the poll create page.',
        'custom' => 0,
      ));
      $page_id = $db->lastInsertId();
      
      // Insert top
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'top',
        'page_id' => $page_id,
        'order' => 1,
      ));
      $top_id = $db->lastInsertId();
      
      // Insert main
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => 2,
      ));
      $main_id = $db->lastInsertId();
      
      // Insert top-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
      ));
      $top_middle_id = $db->lastInsertId();
      
      // Insert main-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 2,
      ));
      $main_middle_id = $db->lastInsertId();
      // Insert content
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => 1,
      ));
    }
  }
 protected function _addPollEditPage(){
  $db = $this->getDb();

    // profile page
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesbusinesspoll_poll_edit')
      ->limit(1)
      ->query()
      ->fetchColumn();

    if( !$page_id ) {

      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesbusinesspoll_poll_edit',
		'displayname' => 'SES - Business Polls Extension - Poll Edit Page',
        'title' => 'Edit Poll',
        'description' => 'This page is the poll edit page.',
        'custom' => 0,
      ));
      $page_id = $db->lastInsertId();

      // Insert top
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'top',
        'page_id' => $page_id,
        'order' => 1,
      ));
      $top_id = $db->lastInsertId();

      // Insert main
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => 2,
      ));
      $main_id = $db->lastInsertId();

      // Insert top-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
      ));
      $top_middle_id = $db->lastInsertId();
	   // 	breadcrumb widget
	   $db->insert('engine4_core_content', array(
		  'type' => 'widget',
		  'name' => 'sesbusinesspoll.breadcrumb',
		  'page_id' => $page_id,
		  'parent_content_id' => $top_middle_id,
		  'order' => 1,
	  ));

      // Insert main-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 2,
      ));
      $main_middle_id = $db->lastInsertId();
      // Insert content
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'core.content',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => 1,
      ));
    }
  }
  protected function _addPollBrowsePage(){
    $db = $this->getDb();
    // profile page
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesbusinesspoll_index_browse')
      ->limit(1)
      ->query()
      ->fetchColumn();
    // insert if it doesn't exist yet
    if( !$page_id ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesbusinesspoll_index_browse',
		'displayname' => 'SES - Business Polls Extension - Poll Browse Page',
        'title' => 'Poll Browse',
        'description' => 'This page lists polls.',
        'custom' => 0,
      ));
      $page_id = $db->lastInsertId();
      // Insert top
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'top',
        'page_id' => $page_id,
        'order' => 1,
      ));
      $top_id = $db->lastInsertId();
      
      // Insert main
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => 2,
      ));
      $main_id = $db->lastInsertId();
      
      // Insert top-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
      ));
      $top_middle_id = $db->lastInsertId();
	    // 	page menu widget
	   $db->insert('engine4_core_content', array(
		  'type' => 'widget',
		  'name' => 'sesbusiness.browse-menu',
		  'page_id' => $page_id,
		  'parent_content_id' => $top_middle_id,
		  'order' => 1,
	  ));
      // Insert main-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 2,
      ));
      $main_middle_id = $db->lastInsertId();
      // Insert main-right
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'right',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 1,
      ));
      $main_right_id = $db->lastInsertId();
      // Insert browse
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesbusinesspoll.browse-polls',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => 1,
      ));
      // Insert search
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesbusinesspoll.browse-search',
        'page_id' => $page_id,
        'parent_content_id' => $main_right_id,
        'order' => 1,
		'params'=>'{"title":"Polls","show_criteria":["favouriteButton","vote","by","in","description","title","socialSharing","like","likeButton","favourite","comment","view"],"socialshare_enable_plusicon":"1","pagging":"auto_load","gridlist":"0","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","show_limited_data":"no","limit_data":"20","nomobile":"0","name":"sesbusinesspoll.profile-polls"}',
      ));
    }
  }
  protected function _addPollHomePage(){
    $db = $this->getDb();
    // profile page
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesbusinesspoll_index_home')
      ->limit(1)
      ->query()
      ->fetchColumn();
    // insert if it doesn't exist yet
    if( !$page_id ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesbusinesspoll_index_home',
		'displayname' => 'SES - Business Polls Extension - Polls Home Page',
        'title' => 'Poll Home',
        'description' => 'This page lists polls.',
        'custom' => 0,
      ));
      $page_id = $db->lastInsertId();

      // Insert top
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'top',
        'page_id' => $page_id,
        'order' => 1,
      ));
      $top_id = $db->lastInsertId();

      // Insert main
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => 2,
      ));
      $main_id = $db->lastInsertId();

      // Insert top-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
      ));
      $top_middle_id = $db->lastInsertId();
	  // 	page menu widget
	  $db->insert('engine4_core_content', array(
		  'type' => 'widget',
		  'name' => 'sesbusiness.browse-menu',
		  'page_id' => $page_id,
		  'parent_content_id' => $top_middle_id,
		  'order' => 1,
	  ));
	  $db->insert('engine4_core_content', array(
		  'type' => 'widget',
		  'name' => 'sesbusinesspoll.browse-poll-button',
		  'page_id' => $page_id,
		  'parent_content_id' => $top_middle_id,
		  'order' => 1,
	  ));
      // Insert main-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 2,
      ));
      $main_middle_id = $db->lastInsertId();
      // Insert main-right
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'right',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 1,
      ));
      $main_right_id = $db->lastInsertId();
	  $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesbusinesspoll.tabbed-widget-poll',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => 1,
		'params'=>'{"title":"Home","tabOption":"1","show_criteria":["favouriteButton","vote","by","in","description","title","socialSharing","like","likeButton","favourite","comment","view"],"search_type":["open","close","recentlySPcreated","mostSPliked","mostSPcommented","mostvoted","mostSPviewed","mostSPfavourite"],"socialshare_enable_plusicon":"1","pagging":"auto_load","gridlist":"0","socialshare_icon_limit":"2","title_truncation":"45","description_truncation":"45","show_limited_data":"no","limit_data":"20","nomobile":"0","name":"sesbusinesspoll.tabbed-widget-poll"}',
      ));
      // Insert content
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesbusinesspoll.list-popular-polls',
        'page_id' => $page_id,
        'parent_content_id' => $main_right_id,
        'order' => 1,
		'params'=>'{"title":"Popular Polls","show_criteria":["favouriteButton","vote","by","in","description","title","socialSharing","like","likeButton","favourite","comment","view"],"popular_type":"mostvoted","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"15","limit_data":"3","nomobile":"0","name":"sesbusinesspoll.list-popular-polls"}',
      ));
    }
  }
  protected function _addPollViewPage(){
    $db = $this->getDb();
	$select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules')
            ->where('name = ?', 'sesadvancedcomment')
            ->where('enabled = ?', 1);
    $sesadvancedcomment_Check = $select->query()->fetchObject();
// profile page
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesbusinesspoll_poll_view')
      ->limit(1)
      ->query()
      ->fetchColumn();
    // insert if it doesn't exist yet
    if( !$page_id ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesbusinesspoll_poll_view',
		'displayname' => 'SES - Business Polls Extension - Poll View Page',
        'title' => 'Poll Home',
        'description' => 'This page view polls.',
        'custom' => 0,
      ));
      $page_id = $db->lastInsertId();

      // Insert top
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'top',
        'page_id' => $page_id,
        'order' => 1,
      ));
      $top_id = $db->lastInsertId();

      // Insert main
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => 2,
      ));
      $main_id = $db->lastInsertId();

      // Insert top-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
      ));
      $top_middle_id = $db->lastInsertId();
	  // 	page menu widget
	  $db->insert('engine4_core_content', array(
		  'type' => 'widget',
		  'name' => 'sesbusinesspoll.breadcrumb',
		  'page_id' => $page_id,
		  'parent_content_id' => $top_middle_id,
		  'order' => 1,
	  ));
      // Insert main-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 2,
      ));
      $main_middle_id = $db->lastInsertId();
      // Insert main-right
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'right',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 1,
      ));
      $main_right_id = $db->lastInsertId();
      // Insert content
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesbusinesspoll.view-poll',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => 1,
		'params'=>'{"show_criteria":["favouriteButton","vote","likeButton","socialSharing","likecount","favouritecount","viewcount","votecount"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","name":"sesbusinesspoll.poll-view"}',
      ));
		if($sesadvancedcomment_Check){
			$db->insert('engine4_core_content', array(
			'page_id' => $page_id,
			'type' => 'widget',
			'name' => 'sesadvancedcomment.comments',
			'parent_content_id' => $main_middle_id,
			'order' => 2,

		  ));
		}else{
			$db->insert('engine4_core_content', array(
			'page_id' => $page_id,
			'type' => 'widget',
			'name' => 'core.comments',
			'parent_content_id' => $main_middle_id,
			'order' => 2,
			'params' => '',
		  ));
		} 
    }
  }

}
?>
