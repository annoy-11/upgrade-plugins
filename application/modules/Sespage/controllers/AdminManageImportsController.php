<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageImportsController.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sespage_AdminManageImportsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sespage_admin_main', array(), 'sespage_admin_main_manageimport');
  }

  public function importAction() {


    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sespage_Form_Admin_Import();
    //$pagesTable = Engine_Api::_()->getDbTable('pages', 'sespage');

    if ($this->getRequest()->isPost()) {
        //$db = $pagesTable->getAdapter();
        //$db->beginTransaction();
        try {
            $csvFile = explode(".", $_FILES['csvfile']['name']);


            if (($csvFile[1] != "csv")) {
                $itemError = Zend_Registry::get('Zend_Translate')->_("Choose only CSV file.");
                $form->addError($itemError);
                return;
            }

            $csv_file = $_FILES['csvfile']['tmp_name']; // specify CSV file path

            $csvfile = fopen($csv_file, 'r');
            $theData = fgets($csvfile);
            $thedata = explode('|',$theData);

            $page_title = $description = $category_id = $subcat_id = $subsubcat_id = $pagestyle = $counter = 0;

            foreach($thedata as $data) {

                //Direct CSV
                if(trim(strtolower($data)) == '[Page Title]'){
                    $page_title = $counter;
                } else if(trim(strtolower($data)) == '[Description]'){
                    $description = $counter;
                } else if(trim(strtolower($data)) == '[Category Id]'){
                    $category_id = $counter;
                } else if(trim(strtolower($data)) == '[2nd Category Id]'){
                    $subcat_id = $counter;
                } else if(trim(strtolower($data)) == '[3rd Category Id]'){
                    $subsubcat_id = $counter;
                } else if(trim(strtolower($data)) == '[Page Style]'){
                    $pagestyle = $counter;
                }
                $counter++;
            }

            $i = 0;
            $importedData = array();
            while (!feof($csvfile))
            {
                $csv_data[] = fgets($csvfile, 1024);
                $csv_array = explode("|", $csv_data[$i]);

                if(!count($csv_array))
                    continue;

                if(isset($csv_array[$page_title]))
                    $importedData[$i]['title'] = @$csv_array[0];

                if(isset($csv_array[$description]))
                    $importedData[$i]['description'] = @$csv_array[1];

                if(isset($csv_array[$category_id]))
                    $importedData[$i]['category_id'] = @$csv_array[2];

                if(isset($csv_array[$subcat_id]))
                    $importedData[$i]['subcat_id'] = @$csv_array[3];

                if(isset($csv_array[$subsubcat_id]))
                    $importedData[$i]['subsubcat_id'] = @$csv_array[4];

                if(isset($csv_array[$pagestyle]))
                    $importedData[$i]['pagestyle'] = @$csv_array[5];
                $i++;
            }
            fclose($csvfile);

            $values = $form->getValues();

            foreach($importedData as $result) {

                if(isset($result['title']) && !empty($result['title'])) {
                    $values = array_merge($values, $result);
                    $this->savePage($values);
                }
            }
            //$db->commit();
        } catch (Exception $e) {
            //$db->rollBack();
            throw $e;
        }

        $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh' => 10,
            'messages' => array('You have successfully imported FAQ.')
        ));
    }
  }

  public function savePage($values) {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $viewer = $this->view->viewer();
    $values['owner_id'] = $viewer->getIdentity();

    if (!isset($values['can_join']))
      $values['approval'] = $settings->getSetting('sespage.default.joinoption', 1) ? 0 : 1;
    elseif (!isset($values['approval']))
      $values['approval'] = $settings->getSetting('sespage.default.approvaloption', 1) ? 0 : 1;

    $pageTable = Engine_Api::_()->getDbTable('pages', 'sespage');
    $db = $pageTable->getAdapter();
    $db->beginTransaction();
    try {

        // Create page
        $page = $pageTable->createRow();

        $sespage_draft = $settings->getSetting('sespage.draft', 1);
        if (empty($sespage_draft)) {
            $values['draft'] = 1;
        }

        if (empty($values['category_id']))
            $values['category_id'] = 0;
        if (empty($values['subsubcat_id']))
            $values['subsubcat_id'] = 0;
        if (empty($values['subcat_id']))
            $values['subcat_id'] = 0;

        if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagepackage')) {
            $values['package_id'] = Engine_Api::_()->getDbTable('packages', 'sespagepackage')->getDefaultPackage();
        }

        $page->setFromArray($values);
        if(!isset($values['search']))
            $page->search = 1;
        else
            $page->search = $values['search'];

        if (!isset($values['auth_view'])) {
            $values['auth_view'] = 'everyone';
        }
        $page->view_privacy = $values['auth_view'];
        $page->save();

      //Manage Apps
      Engine_Db_Table::getDefaultAdapter()->query('INSERT IGNORE INTO `engine4_sespage_managepageapps` (`page_id`) VALUES ("' . $page->page_id . '");');

      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.auto.join', 1)) {
        $page->membership()->addMember($viewer)->setUserApproved($viewer)->setResourceApproved($viewer);
      }

    if (!Engine_Api::_()->authorization()->getPermission($viewer, 'sespage_page', 'page_approve'))
        $page->is_approved = 0;
    if (Engine_Api::_()->authorization()->getPermission($viewer, 'sespage_page', 'page_featured'))
        $page->featured = 1;
    if (Engine_Api::_()->authorization()->getPermission($viewer, 'sespage_page', 'page_sponsored'))
        $page->sponsored = 1;
    if (Engine_Api::_()->authorization()->getPermission($viewer, 'sespage_page', 'page_verified'))
        $page->verified = 1;
    if (Engine_Api::_()->authorization()->getPermission($viewer, 'sespage_page', 'page_hot'))
    $page->hot = 1;

      // Set auth
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'member', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
      if (!isset($values['auth_view']) || empty($values['auth_view'])) {
        $values['auth_view'] = 'everyone';
      }
      if (!isset($values['auth_comment']) || empty($values['auth_comment'])) {
        $values['auth_comment'] = 'everyone';
      }
      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);

      $albumMax = array_search($values['auth_album'], $roles);
      $videoMax = array_search($values['auth_video'], $roles);
      $noteMax = array_search($values['auth_note'], $roles);
      $offerMax = array_search($values['auth_offer'], $roles);

      foreach ($roles as $i => $role) {
        $auth->setAllowed($page, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($page, $role, 'comment', ($i <= $commentMax));

        $auth->setAllowed($page, $role, 'album', ($i <= $albumMax));
        $auth->setAllowed($page, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($page, $role, 'note', ($i <= $noteMax));
        $auth->setAllowed($page, $role, 'offer', ($i <= $offerMax));
      }

      $value = Engine_Api::_()->getDbTable('pages', 'sespage')->checkCustomUrl($page->getSlug());
      if(empty($value))
        $page->custom_url = $page->getSlug();
      else
        $page->custom_url = $page->getSlug().'_'.$page->page_id;
      $page->save();

      //insert admin of page
      $pageRole = Engine_Api::_()->getDbTable('pageroles', 'sespage')->createRow();
      $pageRole->user_id = $viewer->getIdentity();
      $pageRole->page_id = $page->getIdentity();
      $pageRole->memberrole_id = 1;
      $pageRole->save();

      //$custom_url = $page->getSlug();

      if(!Engine_Api::_()->sesbasic()->isWordExist('sespage_page', $page->page_id, $page->custom_url)) {
        Zend_Db_Table_Abstract::getDefaultAdapter()->insert('engine4_sesbasic_bannedwords', array(
          'resource_type' => 'sespage_page',
          'resource_id' => $page->page_id,
          'word' => $page->getSlug(),
        ));
      }

      // Commit
      $db->commit();
    } catch (Engine_Image_Exception $e) {
      $db->rollBack();
      $form->addError(Zend_Registry::get('Zend_Translate')->_('The image you selected was too large.'));
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  public function downloadAction() {

    $filepath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sespage' . DIRECTORY_SEPARATOR . "settings" .DIRECTORY_SEPARATOR.'default_template.csv';

    //KILL ZEND'S OB
    while (ob_get_level() > 0) {
      ob_end_clean();
    }

    @chmod($filepath, 0777);
    $default_template = '[Email Address]|[Password]|[First Name]|[Last Name]|[Gender (Male/Female)]|[Birthdate (yyyy-mm-dd)]';
    $fp = fopen(APPLICATION_PATH . '/temporary/default_template.csv', 'w+');
    fwrite($fp, $default_template);
    fclose($fp);

    $filepath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary'. DIRECTORY_SEPARATOR . 'default_template.csv';

    header("Content-Disposition: attachment; filename=" . urlencode(basename($filepath)), true);
    header("Content-Type: application/force-download", true);
    header("Content-Type: application/octet-stream", true);
    header("Content-Transfer-Encoding: Binary", true);
    header("Content-Type: application/download", true);
    header("Content-Description: File Transfer", true);
    header("Content-Length: " . filesize($filepath), true);
    readfile("$filepath");
    exit();
    return;
  }
}
