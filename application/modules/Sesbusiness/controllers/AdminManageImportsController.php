<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageImportsController.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesbusiness_AdminManageImportsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbusiness_admin_main', array(), 'sesbusiness_admin_main_manageimport');
  }

  public function importAction() {


    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesbusiness_Form_Admin_Import();
    //$businessesTable = Engine_Api::_()->getDbTable('businesses', 'sesbusiness');

    if ($this->getRequest()->isPost()) {
        //$db = $businessesTable->getAdapter();
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

            $business_title = $description = $category_id = $subcat_id = $subsubcat_id = $businessstyle = $counter = 0;

            foreach($thedata as $data) {

                //Direct CSV
                if(trim(strtolower($data)) == '[Business Title]'){
                    $business_title = $counter;
                } else if(trim(strtolower($data)) == '[Description]'){
                    $description = $counter;
                } else if(trim(strtolower($data)) == '[Category Id]'){
                    $category_id = $counter;
                } else if(trim(strtolower($data)) == '[2nd Category Id]'){
                    $subcat_id = $counter;
                } else if(trim(strtolower($data)) == '[3rd Category Id]'){
                    $subsubcat_id = $counter;
                } else if(trim(strtolower($data)) == '[Business Style]'){
                    $businessstyle = $counter;
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

                if(isset($csv_array[$business_title]))
                    $importedData[$i]['title'] = @$csv_array[0];

                if(isset($csv_array[$description]))
                    $importedData[$i]['description'] = @$csv_array[1];

                if(isset($csv_array[$category_id]))
                    $importedData[$i]['category_id'] = @$csv_array[2];

                if(isset($csv_array[$subcat_id]))
                    $importedData[$i]['subcat_id'] = @$csv_array[3];

                if(isset($csv_array[$subsubcat_id]))
                    $importedData[$i]['subsubcat_id'] = @$csv_array[4];

                if(isset($csv_array[$businessstyle]))
                    $importedData[$i]['businessestyle'] = @$csv_array[5];
                $i++;
            }
            fclose($csvfile);

            $values = $form->getValues();

            foreach($importedData as $result) {

                if(isset($result['title']) && !empty($result['title'])) {
                    $values = array_merge($values, $result);
                    $this->saveBusiness($values);
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
            'messages' => array('You have successfully imported Businesses.')
        ));
    }
  }

  public function saveBusiness($values) {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $viewer = $this->view->viewer();
    $values['owner_id'] = $viewer->getIdentity();

    if (!isset($values['can_join']))
      $values['approval'] = $settings->getSetting('sesbusiness.default.joinoption', 1) ? 0 : 1;
    elseif (!isset($values['approval']))
      $values['approval'] = $settings->getSetting('sesbusiness.default.approvaloption', 1) ? 0 : 1;

    $businessTable = Engine_Api::_()->getDbTable('businesses', 'sesbusiness');
    $db = $businessTable->getAdapter();
    $db->beginTransaction();
    try {

        // Create business
        $business = $businessTable->createRow();

        $sesbusiness_draft = $settings->getSetting('sesbusiness.draft', 1);
        if (empty($sesbusiness_draft)) {
            $values['draft'] = 1;
        }

        if (empty($values['category_id']))
            $values['category_id'] = 0;
        if (empty($values['subsubcat_id']))
            $values['subsubcat_id'] = 0;
        if (empty($values['subcat_id']))
            $values['subcat_id'] = 0;

        if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinesspackage')) {
            $values['package_id'] = Engine_Api::_()->getDbTable('packages', 'sesbusinesspackage')->getDefaultPackage();
        }

        $business->setFromArray($values);
        if(!isset($values['search']))
            $business->search = 1;
        else
            $business->search = $values['search'];

        if (!isset($values['auth_view'])) {
            $values['auth_view'] = 'everyone';
        }
        $business->view_privacy = $values['auth_view'];
        $business->save();

      //Manage Apps
      Engine_Db_Table::getDefaultAdapter()->query('INSERT IGNORE INTO `engine4_sesbusiness_managebusinessapps` (`business_id`) VALUES ("' . $business->business_id . '");');

      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.auto.join', 1)) {
        $business->membership()->addMember($viewer)->setUserApproved($viewer)->setResourceApproved($viewer);
      }

    if (!Engine_Api::_()->authorization()->getPermission($viewer, 'businesses', 'business_approve'))
        $business->is_approved = 0;
    if (Engine_Api::_()->authorization()->getPermission($viewer, 'businesses', 'business_featured'))
        $business->featured = 1;
    if (Engine_Api::_()->authorization()->getPermission($viewer, 'businesses', 'business_sponsored'))
        $business->sponsored = 1;
    if (Engine_Api::_()->authorization()->getPermission($viewer, 'businesses', 'business_verified'))
        $business->verified = 1;
    if (Engine_Api::_()->authorization()->getPermission($viewer, 'businesses', 'business_hot'))
    $business->hot = 1;

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
        $auth->setAllowed($business, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($business, $role, 'comment', ($i <= $commentMax));

        $auth->setAllowed($business, $role, 'album', ($i <= $albumMax));
        $auth->setAllowed($business, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($business, $role, 'note', ($i <= $noteMax));
        $auth->setAllowed($business, $role, 'offer', ($i <= $offerMax));
      }

      $value = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->checkCustomUrl($business->getSlug());
      if(empty($value))
        $business->custom_url = $business->getSlug();
      else
        $business->custom_url = $business->getSlug().'_'.$business->business_id;
      $business->save();

      //insert admin of business
      $businessRole = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->createRow();
      $businessRole->user_id = $viewer->getIdentity();
      $businessRole->business_id = $business->getIdentity();
      $businessRole->memberrole_id = 1;
      $businessRole->save();

      //$custom_url = $business->getSlug();

      if(!Engine_Api::_()->sesbasic()->isWordExist('businesses', $business->business_id, $business->custom_url)) {
        Zend_Db_Table_Abstract::getDefaultAdapter()->insert('engine4_sesbasic_bannedwords', array(
          'resource_type' => 'businesses',
          'resource_id' => $business->business_id,
          'word' => $business->getSlug(),
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

    $filepath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesbusiness' . DIRECTORY_SEPARATOR . "settings" .DIRECTORY_SEPARATOR.'default_template.csv';

    //KILL ZEND'S OB
    while (ob_get_level() > 0) {
      ob_end_clean();
    }

    @chmod($filepath, 0777);
    $default_template = '[Business Title]|[Description]|[Category Id]|[2nd Category Id]|[3rd Category Id]|[Business Style]';
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
