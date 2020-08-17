<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_settings');
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Sescrowdfunding_Form_Admin_Settings_Global();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sescrowdfunding/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.pluginactivated')) {

        //START TEXT CHNAGE WORK IN CSV FILE
        $oldSigularWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.text.singular', 'crowdfunding');
        $oldPluralWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.text.plural', 'crowdfundings');
        $newSigularWord = @$values['sescrowdfunding_text_singular'] ? @$values['sescrowdfunding_text_singular'] : 'crowdfunding';
        $newPluralWord = @$values['sescrowdfunding_text_plural'] ? @$values['sescrowdfunding_text_plural'] : 'crowdfundings';
        $newSigularWordUpper = ucfirst($newSigularWord);
        $newPluralWordUpper = ucfirst($newPluralWord);
        if ($newSigularWord != $oldSigularWord && $newPluralWord != $oldPluralWord) {

          $tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/sescrowdfunding.csv', 'null', array('delimiter' => ';', 'enclosure' => '"'));
          if (!empty($tmp['null']) && is_array($tmp['null']))
            $inputData = $tmp['null'];
          else
            $inputData = array();

          $OutputData = array();
          $chnagedData = array();
          foreach ($inputData as $key => $input) {
            $chnagedData = str_replace(array($oldPluralWord, $oldSigularWord, ucfirst($oldPluralWord), ucfirst($oldSigularWord), strtoupper($oldPluralWord), strtoupper($oldSigularWord)), array($newPluralWord, $newSigularWord, ucfirst($newPluralWord), ucfirst($newSigularWord), strtoupper($newPluralWord), strtoupper($newSigularWord)), $input);
            $OutputData[$key] = $chnagedData;
          }

          $targetFile = APPLICATION_PATH . '/application/languages/en/sescrowdfunding.csv';
          if (file_exists($targetFile))
            @unlink($targetFile);

          touch($targetFile);
          chmod($targetFile, 0777);

          $writer = new Engine_Translate_Writer_Csv($targetFile);
          $writer->setTranslations($OutputData);
          $writer->write();
          //END CSV FILE WORK
        }

        foreach ($values as $key => $value) {
          if(Engine_Api::_()->getApi('settings', 'core')->hasSetting($key, $value))
          Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
          if(!$value && strlen($value) == 0)
            continue;
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function ownerFaqsAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_crodownerfaq');
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Sescrowdfunding_Form_Admin_Settings_OwnerFaqs();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
        $values = $form->getValues();
        foreach ($values as $key => $value) {
          $settings->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
    }
  }

  public function donerFaqsAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_donerfaqs');
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Sescrowdfunding_Form_Admin_Settings_DonerFaqs();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
        $values = $form->getValues();

        foreach ($values as $key => $value) {
          $settings->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
    }
  }


    public function crowdfundingcreateAction() {

        $db = Engine_Db_Table::getDefaultAdapter();
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_crowdfundingcreate');

        $settings = Engine_Api::_()->getApi('settings', 'core');
        $this->view->form = $form = new Sescrowdfunding_Form_Admin_CreateCrowdfundingSettings();

        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            $values = $form->getValues();
            $db = Engine_Db_Table::getDefaultAdapter();
            foreach ($values as $key => $value) {
                Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
            }
            $form->addNotice('Your changes have been saved.');
            $this->_helper->redirector->gotoRoute(array());
        }
    }


  public function manageWidgetizePageAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_managewidgetizepage');
    $pagesArray = array('sescrowdfunding_index_welcome', 'sescrowdfunding_index_home', 'sescrowdfunding_index_browse', 'sescrowdfunding_category_browse', 'sescrowdfunding_index_tags', 'sescrowdfunding_category_index', 'sescrowdfunding_index_manage', 'sescrowdfunding_index_view_1', 'sescrowdfunding_index_view_2', 'sescrowdfunding_index_view_3', 'sescrowdfunding_index_view_4', 'sescrowdfunding_index_create', 'sescrowdfunding_order_donate', 'sescrowdfunding_index_manage-donations', 'sescrowdfunding_index_doners-faqs', 'sescrowdfunding_index_crowdfunding-owner-faqs');
    $this->view->pagesArray = $pagesArray;
  }

  //site statis for sescrowdfunding plugin
  public function statisticAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_statistic');

    $crowdfundingTable = Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding');
    $crowdfundingTableName = $crowdfundingTable->info('name');

    $crowdfundingPhotoTable = Engine_Api::_()->getDbtable('photos', 'sescrowdfunding');
    $crowdfundingPhotoTableName = $crowdfundingPhotoTable->info('name');

    $crowdfundingAlbumTable = Engine_Api::_()->getDbtable('albums', 'sescrowdfunding');
    $crowdfundingAlbumTableName = $crowdfundingAlbumTable->info('name');

    //Total Crowdfunding
    $select = $crowdfundingTable->select()->from($crowdfundingTableName, 'count(*) AS totalcrowdfunding');
    $this->view->totalcrowdfunding = $select->query()->fetchColumn();

    //Total featured crowdfunding
    $select = $crowdfundingTable->select()->from($crowdfundingTableName, 'count(*) AS totalfeatured')->where('featured =?', 1);
    $this->view->totalcrowdfundingfeatured = $select->query()->fetchColumn();

    //Total albums of crowdfunding
    $select = $crowdfundingAlbumTable->select()->from($crowdfundingAlbumTableName, 'count(*) AS totalalbums');
    $this->view->totalalbums = $select->query()->fetchColumn();

    //Total photos of crowdfunding
    $select = $crowdfundingPhotoTable->select()->from($crowdfundingPhotoTableName, 'count(*) AS totalphotos');
    $this->view->totalphotos = $select->query()->fetchColumn();


    //Total comments crowdfunding
    $select = $crowdfundingTable->select()->from($crowdfundingTableName, 'count(*) AS totalcomment')->where('comment_count <>?', 0);
    $this->view->totalcrowdfundingcomments = $select->query()->fetchColumn();

     //Total view crowdfunding
    $select = $crowdfundingTable->select()->from($crowdfundingTableName, 'count(*) AS totalview')->where('view_count <>?', 0);
    $this->view->totalcrowdfundingviews = $select->query()->fetchColumn();

     //Total like crowdfunding
    $select = $crowdfundingTable->select()->from($crowdfundingTableName, 'count(*) AS totallike')->where('like_count <>?', 0);
    $this->view->totalcrowdfundinglikes = $select->query()->fetchColumn();

    //Total rated crowdfunding
    $select = $crowdfundingTable->select()->from($crowdfundingTableName, 'count(*) AS totalrated')->where('rating <>?', 0);
    $this->view->totalcrowdfundingrated = $select->query()->fetchColumn();
  }

  public function manageDashboardsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_managedashboards');

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->paginator = Engine_Api::_()->getDbtable('dashboards', 'sescrowdfunding')->getDashboardsItems();
  }

  //Enable Action
  public function enabledAction() {

    $id = $this->_getParam('dashboard_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sescrowdfunding_dashboards', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sescrowdfunding/settings/manage-dashboards');
  }

  public function editDashboardsSettingsAction() {

    $dashboards = Engine_Api::_()->getItem('sescrowdfunding_dashboards', $this->_getParam('dashboard_id'));
    $this->_helper->layout->setLayout('admin-simple');
    $form = $this->view->form = new Sescrowdfunding_Form_Admin_EditDashboard();
    $form->setTitle('Edit This Item');
    $form->button->setLabel('Save Changes');

    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

    if (!($id = $this->_getParam('dashboard_id')))
      throw new Zend_Exception('No identifier specified');

    $form->populate($dashboards->toArray());

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $dashboards->title = $values["title"];
        $dashboards->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      return $this->_forward('success', 'utility', 'core', array(
                  'smoothboxClose' => 10,
                  'parentRefresh' => 10,
                  'messages' => array('You have successfully edit entry.')
      ));
      $this->_redirect('admin/sescrowdfunding/settings/manage-dashboards');
    }
  }

	public function uploadDefaultCategory() {

		$catgoryData = array('0' =>
            array('Medical', 'medical.jpg', 'medical.png',''),
            array('Social Welfare', 'socialwelfare.jpg', 'socialwelfare.png',''),
            array('Photography', 'photography.jpg', 'photography.png',''),
            array('Monetary Fund', 'monetaryfund.jpg', 'monetaryfund.png',''),
            array('Film, Theater & Video', 'film.jpg', 'film.png',''),
            array('Technology', 'technology.jpg', 'technology.png',' '),
            array('Others', 'others.jpg', 'others.png',''),

            array('Organ Transplant', 'organtransplant.jpg', 'others.png',''),
            array('Medicines', 'medicines.jpg', 'Medicines.png',''),
            array('Health Checkup', 'helathcheckup.jpg', 'others.png',''),
            array('Build Society', 'buildsociety.jpg', 'BuildSociety.png',''),
            array('Share Food', 'sharefood.jpg', 'ShareFood.png',''),
            array('Provide Shelter', 'provideshelter.jpg', 'ProvideShelter.png',''),
            array('Recreation', 'recreation.jpg', 'Recreation.png',''),
            array('Nature', 'nature.jpg', 'Nature.png',''),
            array('Animal', 'animal.jpg', 'Animal.png',''),
            array('Place', 'place.jpg', 'Place.png',''),
            array('Business Models', 'businessmodel.jpg', 'BusinessModels.png',''),
            array('Financial Support', 'financialsupport.jpg', 'FinancialSupport.png',''),
            array('Scholarship', 'scholarship.jpg', 'scholarship.png',''),
            array('Social Issues', 'socialissues.jpg', 'SocialIssues.png',''),
            array('Acting', 'acting.jpg', 'Acting.png',''),
            array('Dancing', 'dancing.jpg', 'Dancing.png',''),
            array('Musical', 'musical.jpg', 'Musical.png',''),
            array('Software', 'software.jpg', 'Software.png',''),
            array('Gadgets', 'gadgets.jpg', 'Gadget.png',''),
            array('Digital Marketing', 'digitalmarketing.jpg', 'others.png',''),
            array('Hip-hop', 'hiphop.jpg', 'HipHop.png',''),
            array('Poverty', 'poverty.jpg', 'poverty.png',''),
            array('Education Loan', 'education.jpg', 'Education.png',''),
            array('Enterpreneurship', 'entreprenurship.jpg', 'entrepreneurship.png',''),
            array('Monument', 'monuments.jpg', 'Monument.png',''),
            array('Yoga', 'yoga.jpg', 'yoga.png',''),
            array('Camps', 'camp.jpg', 'Camp.png',''),
            array('Educate People', 'educatepeople.jpg', 'EducatePeople.png',''),
            array('MRI Scan', 'mri.jpg', 'MRI.png',''),
            array('Women', 'women.jpg', 'Women.png',''),
            array('Heart', 'heart.jpg', 'heart.png',''),
            array('Eyes', 'eyes.jpg', 'Eyes.png',''),
		);

		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		foreach($catgoryData as $data) {

            $catId = $db->query("SELECT category_id FROM `engine4_sescrowdfunding_categories` WHERE category_name = '" . $data[0] . "'")->fetchAll();

            if(!empty($catId[0]['category_id'])) {
                $catId = $catId[0]['category_id'];
            } else
                continue;

            $PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sescrowdfunding' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "category" . DIRECTORY_SEPARATOR;

            //upload thumbnails
            if (is_file($PathFile . "banner" . DIRECTORY_SEPARATOR . $data[1]))
                $thumbnail_icon = $this->setCategoryPhoto($PathFile . "banner" . DIRECTORY_SEPARATOR . $data[1], $catId, true);
            else
                $thumbnail_icon = 0;

			 //upload icons
			 if (is_file($PathFile . "icons" . DIRECTORY_SEPARATOR . $data[2]))
                $cat_icon = $this->setCategoryPhoto($PathFile . "icons" . DIRECTORY_SEPARATOR . $data[2], $catId, true);
			 else
                $cat_icon = 0;

			 //$db->query("UPDATE `engine4_sescrowdfunding_categories` SET `cat_icon` = '" . $cat_icon . "' WHERE category_id = " . $catId);

 			 $db->query("UPDATE `engine4_sescrowdfunding_categories` SET `cat_icon` = '" . $cat_icon . "',`colored_icon` = '" . $thumbnail_icon . "' WHERE category_id = " . $catId);

			 $db->query("UPDATE `engine4_sescrowdfunding_categories` set `title` = category_name WHERE category_id = ".$catId ." AND ( title IS NULL OR title = '')");
             $db->query("UPDATE `engine4_sescrowdfunding_categories` set `slug` = LOWER(REPLACE(REPLACE(REPLACE(REPLACE(category_name,'&',''),'  ',' '),' ','-'),'/','-'))  WHERE category_id = ".$catId ." AND ( title IS NULL OR slug = '')");
             $db->query("UPDATE `engine4_sescrowdfunding_categories` SET `order` = `category_id`  WHERE category_id = ".$catId ." AND ( `order` IS NULL OR `order` = 0)");
		}
	}

	// for default installation
  function setCategoryPhoto($file, $cat_id, $resize = false) {

    $fileName = $file;
    $name = basename($file);
    $extension = ltrim(strrchr($fileName, '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => 'sescrowdfunding_category',
        'parent_id' => $cat_id,
        'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        'name' => $fileName,
    );
    // Save
    $filesTable = Engine_Api::_()->getDbtable('files', 'storage');
    if ($resize) {
      // Resize image (main)
      $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_poster.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
              ->resize(800, 800)
              ->write($mainPath)
              ->destroy();
      // Resize image (normal) make same image for activity feed so it open in pop up with out jump effect.
      $normalPath = $path . DIRECTORY_SEPARATOR . $base . '_thumb.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
              ->resize(500, 500)
              ->write($normalPath)
              ->destroy();
    } else {
      $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_poster.' . $extension;
      copy($file, $mainPath);
    }
    if ($resize) {
      // normal main  image resize
      $normalMainPath = $path . DIRECTORY_SEPARATOR . $base . '_icon.' . $extension;
      $image = Engine_Image::factory();
      $image->open($file)
              ->resize(100, 100)
              ->write($normalMainPath)
              ->destroy();
    } else {
      $normalMainPath = $path . DIRECTORY_SEPARATOR . $base . '_icon.' . $extension;
      copy($file, $normalMainPath);
    }
    // Store
    try {
      $iMain = $filesTable->createFile($mainPath, $params);
      if ($resize) {
        $iIconNormal = $filesTable->createFile($normalPath, $params);
        $iMain->bridge($iIconNormal, 'thumb.thumb');
      }
      $iNormalMain = $filesTable->createFile($normalMainPath, $params);
      $iMain->bridge($iNormalMain, 'thumb.icon');
    } catch (Exception $e) {
      // Remove temp files
      @unlink($mainPath);
      if ($resize) {
        @unlink($normalPath);
      }
      @unlink($normalMainPath);
      // Throw
      if ($e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE) {
        throw new Sescrowdfunding_Model_Exception($e->getMessage(), $e->getCode());
      } else {
        throw $e;
      }
    }
    // Remove temp files
    @unlink($mainPath);
    if ($resize) {
      @unlink($normalPath);
    }
    @unlink($normalMainPath);
    // Update row
    // Delete the old file?
    if (!empty($tmpRow)) {
      $tmpRow->delete();
    }
    return $iMain->file_id;
  }
}
