<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seselegant_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seselegant_admin_main', array(), 'seselegant_admin_main_settings');

    $this->view->form = $form = new Seselegant_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Seselegant/controllers/License.php";
      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seselegant.pluginactivated')) {

				if (!empty($values['seselegant_layout_enable'])) {
				
          //Landing Page
					$LandingPageOrder = 1;
					$db->query("DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`page_id` =3  AND `engine4_core_content`.`name` !='main' AND `engine4_core_content`.`name` !='middle' AND `engine4_core_content`.`type`='container';");

					$db->query("DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`page_id` =3;");
          $page_id = 3;
          // Insert top
          $db->insert('engine4_core_content', array(
              'type' => 'container',
              'name' => 'top',
              'page_id' => $page_id,
              'order' => $LandingPageOrder++,
          ));
          $top_id = $db->lastInsertId();
          // Insert main
          $db->insert('engine4_core_content', array(
              'type' => 'container',
              'name' => 'main',
              'page_id' => $page_id,
              'order' => $LandingPageOrder++,
          ));
          $main_id = $db->lastInsertId();
          // Insert top-middle
          $db->insert('engine4_core_content', array(
              'type' => 'container',
              'name' => 'middle',
              'page_id' => $page_id,
              'parent_content_id' => $top_id,
              'order' => $LandingPageOrder++,
          ));
          $top_middle_id = $db->lastInsertId();
          // Insert main-middle
          $db->insert('engine4_core_content', array(
              'type' => 'container',
              'name' => 'middle',
              'page_id' => $page_id,
              'parent_content_id' => $main_id,
              'order' => $LandingPageOrder++,
          ));
          $main_middle_id = $db->lastInsertId();

					$db->insert('engine4_core_content', array(
							'type' => 'widget',
							'name' => 'seshtmlbackground.slideshow',
							'page_id' => 3,
							'order' => $LandingPageOrder++,
							'parent_content_id' => $top_middle_id,
							'params' => '{"gallery_id":"1","full_width":"1","logo":"0","logo_url":"0","main_navigation":"0","mini_navigation":"0","autoplay":"1","thumbnail":"0","searchEnable":"1","height":"630","limit_data":"0","order":"adminorder","autoplaydelay":"5000","signupformtopmargin":"150","title":"","nomobile":"0","name":"seshtmlbackground.slideshow"}',
					));

					$db->insert('engine4_core_content', array(
							'type' => 'widget',
							'name' => 'seselegant.html-block-1',
							'page_id' => 3,
							'order' => $LandingPageOrder++,
							'parent_content_id' => $main_middle_id,
					));

					$db->insert('engine4_core_content', array(
							'type' => 'widget',
							'name' => 'seselegant.popularalbum-widget',
							'page_id' => 3,
							'order' => $LandingPageOrder++,
							'parent_content_id' => $main_middle_id,
							'params' => '{"search_type":"featured","show_criteria":["like","comment","view","title","by","favouriteCount"],"limit_data":"10","title":"Popular Albums","nomobile":"0","name":"seselegant.popularalbum-widget"}',
					));

					$db->insert('engine4_core_content', array(
							'type' => 'widget',
							'name' => 'sesvideo.popularity-videos',
							'page_id' => 3,
							'order' => $LandingPageOrder++,
							'parent_content_id' => $main_middle_id,
							'params' => '{"popularity":"creation_date","textVideo":"Share Your Videos at once place","show_criteria":["like","comment","rating","favourite","view","title","by","watchnow"],"pagging":"fixedbutton","video_limit":"5","height":"200","width":"200","title":"","nomobile":"0","name":"sesvideo.popularity-videos"}',
					));


					$db->insert('engine4_core_content', array(
							'type' => 'widget',
							'name' => 'seselegant.featured-sponsored-hot-carousel',
							'page_id' => 3,
							'order' => $LandingPageOrder++,
							'parent_content_id' => $main_middle_id,
							'params' => '{"popularity":"creation_date","displayContentType":"featured","information":["likeCount","commentCount","viewCount","title","postedby"],"height":"250","width":"269","title":"Popular Music","nomobile":"0","name":"seselegant.featured-sponsored-hot-carousel"}',
					));

					$db->insert('engine4_core_content', array(
							'type' => 'widget',
							'name' => 'seselegant.member-cloud',
							'page_id' => 3,
							'order' => $LandingPageOrder++,
							'parent_content_id' => $main_middle_id,
							'params' => '{"heading":"1","showTitle":"1","memberCount":"9","height":"100","width":"100","title":"","nomobile":"0","name":"seselegant.member-cloud"}',
					));

					$db->insert('engine4_core_content', array(
							'type' => 'widget',
							'name' => 'seselegant.paralex',
							'page_id' => 3,
							'order' => $LandingPageOrder++,
							'parent_content_id' => $main_middle_id,
					));
				}

				foreach ($values as $key => $value) {
					Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
				}
				
				//Here we have set the value of theme active.
				if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seselegant.themeactive')) {
					
					$db = Engine_Db_Table::getDefaultAdapter();
					
					Engine_Api::_()->getApi('settings', 'core')->setSetting('seselegant.themeactive', 1);
					
					$db->query("INSERT IGNORE INTO `engine4_core_themes` (`name`, `title`, `description`, `active`) VALUES ('elegant', 'Elegant', '', 0)");

					$themeName = 'elegant';
					$themeTable = Engine_Api::_()->getDbtable('themes', 'core');
					$themeSelect = $themeTable->select()
									->orWhere('theme_id = ?', $themeName)
									->orWhere('name = ?', $themeName)
									->limit(1);
					$theme = $themeTable->fetchRow($themeSelect);

					if ($theme) {

						$db = $themeTable->getAdapter();
						$db->beginTransaction();

						try {
							$themeTable->update(array('active' => 0), array('1 = ?' => 1));
							$theme->active = true;
							$theme->save();

							// clear scaffold cache
							Core_Model_DbTable_Themes::clearScaffoldCache();

							// Increment site counter
							$settings = Engine_Api::_()->getApi('settings', 'core');
							$settings->core_site_counter = $settings->core_site_counter + 1;

							$db->commit();
						} catch (Exception $e) {
							$db->rollBack();
							throw $e;
						}
					}
				}

				$form->addNotice('Your changes have been saved.');
				if($error)
				$this->_helper->redirector->gotoRoute(array());
      }
    }
  }
  
  public function widgetCheck($params = array()) {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    return $db->select()
                    ->from('engine4_core_content', 'content_id')
                    ->where('type = ?', 'widget')
                    ->where('page_id = ?', $params['page_id'])
                    ->where('name = ?', $params['widget_name'])
                    ->limit(1)
                    ->query()
                    ->fetchColumn();
  }
}
