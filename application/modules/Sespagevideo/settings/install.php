<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagevideo
 * @package    Sespagevideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagevideo_Installer extends Engine_Package_Installer_Module {

  public function onPreinstall() {

    $db = $this->getDb();

    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules')
            ->where('name = ?', 'sespage')
            ->where('enabled = ?', 1);
    $sespage_Check = $select->query()->fetchObject();

    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_modules')
            ->where('name = ?', 'sespage');
    $sespageCheck = $select->query()->fetchAll();

    $select = new Zend_Db_Select($db);
    $select->from('engine4_core_settings')
            ->where('name = ?', 'sespage.pluginactivated')
            ->limit(1);
    $page_activate = $select->query()->fetchAll();

    if(!empty($sespage_Check) && !empty($page_activate[0]['value'])) {
      $plugin_currentversion = '4.10.3p17';
      $error = include APPLICATION_PATH . "/application/modules/Sesbasic/controllers/checkPluginVersion.php";
      if($error != '1') {
        return $this->_error($error);
      }
    } elseif(!empty($sespage_Check) && empty($page_activate[0]['value'])) {
      return $this->_error('<div class="global_form"><div><div><p style="color:red;">The "<a href="https://www.socialenginesolutions.com/social-engine/page-directories-plugin/" target="_blank">Page Directories Plugin</a>" is installed on your website, but is not yet activated. So, please first activate it before installing the Page Videos Extension.</p></div></div></div>');
    } elseif(!empty($sespageCheck) && empty($sespage_Check)) {
      return $this->_error('<div class="global_form"><div><div><p style="color:red;">The "<a href="https://www.socialenginesolutions.com/social-engine/page-directories-plugin/" target="_blank">Page Directories Plugin</a>" is installed on your website, but is not yet enabled. So, please first enable it from the "Manage" >> "Packages & Plugins" section to proceed further.</p></div></div></div>');
    } elseif(empty($sespageCheck)) {
      return $this->_error('<div class="global_form"><div><div><p style="color:red;">The required "<a href="https://www.socialenginesolutions.com/social-engine/page-directories-plugin/" target="_blank">Page Directories Plugin</a>" is not installed on your website. Please download the latest version of "<a href="https://www.socialenginesolutions.com/social-engine/page-directories-plugin/" target="_blank">Page Directories Plugin</a>" from <a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions.com</a> website.</p></div></div></div>');
    }

    parent::onPreinstall();
  }

  public function onInstall() {

    $db = $this->getDb();
	$this->_addPageProfileVideoDesign1();
    $this->_addPageProfileVideoDesign2();
    $this->_addPageProfileVideoDesign3();
    $this->_addPageProfileVideoDesign4();

    parent::onInstall();
  }
	protected function _addPageProfileVideoDesign1(){
	  // profile page design1
		$db = $this->getDb();
		$design1_page_id = $db->select()
		  ->from('engine4_core_pages', 'page_id')
		  ->where('name = ?', 'sespage_profile_index_1')
		  ->limit(1)
		  ->query()
		  ->fetchColumn();
		  if($design1_page_id){
			 $tab_id=  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'core.container-tabs')
				->where('page_id = ?', $design1_page_id)
				->limit(1)
				->query()
				->fetchColumn();
			// insert if it doesn't exist yet
			if ($tab_id){
				$isWidgetExist =  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'sespagevideo.profile-videos')
				->where('page_id = ?', $design1_page_id)
				->where('parent_content_id = ?', $tab_id)
				->limit(1)
				->query()
				->fetchColumn();
				if(!$isWidgetExist){
					$db->insert('engine4_core_content', array(
					'type' => 'widget',
					'name' => 'sespagevideo.profile-videos',
					'page_id' => $design1_page_id,
					'parent_content_id' => $tab_id,
					'order' => 10,
					'params' => '{"enableTabs":"","openViewType":"list","viewTypeStyle":"fixed","showTabType":"1","show_criteria":"","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"auto_load","title_truncation_grid":"45","title_truncation_list":"45","title_truncation_pinboard":"45","limit_data_pinboard":"10","limit_data_list":"10","limit_data_grid":"10","show_limited_data":"no","description_truncation_list":"45","description_truncation_grid":"45","description_truncation_pinboard":"45","height_grid":"270","width_grid":"389","height_list":"230","width_list":"260","width_pinboard":"300","title":"Videos","nomobile":"0","name":"sespagevideo.profile-videos"}',
				));
				}
			}
		}
	}
	protected function _addPageProfileVideoDesign2(){
		// profile page design2
		 $db = $this->getDb();
		$design2_page_id = $db->select()
		  ->from('engine4_core_pages', 'page_id')
		  ->where('name = ?', 'sespage_profile_index_2')
		  ->limit(1)
		  ->query()
		  ->fetchColumn();
		  if($design2_page_id){
			 $tab_id=  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'core.container-tabs')
				->where('page_id = ?', $design2_page_id)
				->limit(1)
				->query()
				->fetchColumn();

			// insert if it doesn't exist yet
			if ($tab_id){
				$isWidgetExist =  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'sespagevideo.profile-videos')
				->where('page_id = ?', $design2_page_id)
				->where('parent_content_id = ?', $tab_id)
				->limit(1)
				->query()
				->fetchColumn();
				if(!$isWidgetExist){
					$db->insert('engine4_core_content', array(
					'type' => 'widget',
					'name' => 'sespagevideo.profile-videos',
					'page_id' => $design2_page_id,
					'parent_content_id' => $tab_id,
					'order' => 10,
					'params' => '{"enableTabs":"","openViewType":"list","viewTypeStyle":"fixed","showTabType":"1","show_criteria":"","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"auto_load","title_truncation_grid":"45","title_truncation_list":"45","title_truncation_pinboard":"45","limit_data_pinboard":"10","limit_data_list":"10","limit_data_grid":"10","show_limited_data":"no","description_truncation_list":"45","description_truncation_grid":"45","description_truncation_pinboard":"45","height_grid":"270","width_grid":"389","height_list":"230","width_list":"260","width_pinboard":"300","title":"Videos","nomobile":"0","name":"sespagevideo.profile-videos"}',
				));
				}
			}
		}
	}
	protected function _addPageProfileVideoDesign3(){
		// profile page design3
		 $db = $this->getDb();
		$design3_page_id = $db->select()
		  ->from('engine4_core_pages', 'page_id')
		  ->where('name = ?', 'sespage_profile_index_3')
		  ->limit(1)
		  ->query()
		  ->fetchColumn();
		  if($design3_page_id){
			 $tab_id=  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'core.container-tabs')
				->where('page_id = ?', $design3_page_id)
				->limit(1)
				->query()
				->fetchColumn();

			// insert if it doesn't exist yet
			if ($tab_id){
				$isWidgetExist =  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'sespagevideo.profile-videos')
				->where('page_id = ?', $design3_page_id)
				->where('parent_content_id = ?', $tab_id)
				->limit(1)
				->query()
				->fetchColumn();
				if(!$isWidgetExist){
					$db->insert('engine4_core_content', array(
					'type' => 'widget',
					'name' => 'sespagevideo.profile-videos',
					'page_id' => $design3_page_id,
					'parent_content_id' => $tab_id,
					'order' => 10,
					'params' => '{"enableTabs":"","openViewType":"list","viewTypeStyle":"fixed","showTabType":"1","show_criteria":"","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"auto_load","title_truncation_grid":"45","title_truncation_list":"45","title_truncation_pinboard":"45","limit_data_pinboard":"10","limit_data_list":"10","limit_data_grid":"10","show_limited_data":"no","description_truncation_list":"45","description_truncation_grid":"45","description_truncation_pinboard":"45","height_grid":"270","width_grid":"389","height_list":"230","width_list":"260","width_pinboard":"300","title":"Videos","nomobile":"0","name":"sespagevideo.profile-videos"}',
				));
				}
			}
		}
	}
	protected function _addPageProfileVideoDesign4(){
		 $db = $this->getDb();
		// profile page design4
		$design4_page_id = $db->select()
		  ->from('engine4_core_pages', 'page_id')
		  ->where('name = ?', 'sespage_profile_index_4')
		  ->limit(1)
		  ->query()
		  ->fetchColumn();
		  if($design4_page_id){
			 $tab_id=  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'core.container-tabs')
				->where('page_id = ?', $design4_page_id)
				->limit(1)
				->query()
				->fetchColumn();

			// insert if it doesn't exist yet
			if ($tab_id){
				$isWidgetExist =  $db->select()->where('type = ?', 'widget')
				->from('engine4_core_content', 'content_id')
				->where('name = ?', 'sespagevideo.profile-videos')
				->where('page_id = ?', $design4_page_id)
				->where('parent_content_id = ?', $tab_id)
				->limit(1)
				->query()
				->fetchColumn();
				if(!$isWidgetExist){
					$db->insert('engine4_core_content', array(
					'type' => 'widget',
					'name' => 'sespagevideo.profile-videos',
					'page_id' => $design4_page_id,
					'parent_content_id' => $tab_id,
					'order' => 10,
					'params' => '{"enableTabs":"","openViewType":"list","viewTypeStyle":"fixed","showTabType":"1","show_criteria":"","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"auto_load","title_truncation_grid":"45","title_truncation_list":"45","title_truncation_pinboard":"45","limit_data_pinboard":"10","limit_data_list":"10","limit_data_grid":"10","show_limited_data":"no","description_truncation_list":"45","description_truncation_grid":"45","description_truncation_pinboard":"45","height_grid":"270","width_grid":"389","height_list":"230","width_list":"260","width_pinboard":"300","title":"Videos","nomobile":"0","name":"sespagevideo.profile-videos"}',
					));
				}
			}
		}
	}
	public function onEnable() {
		$db = $this->getDb();
		$db->query("UPDATE `engine4_core_menuitems` SET `enabled` = '1' WHERE `engine4_core_menuitems`.`name` = 'sespage_admin_main_sespagevideo';");
		parent::onEnable();
	}

  public function onDisable() {
    $db = $this->getDb();
    $db->query("UPDATE `engine4_core_menuitems` SET `enabled` = '0' WHERE `engine4_core_menuitems`.`name` = 'sespage_admin_main_sespagevideo';");
    parent::onDisable();
  }
}
