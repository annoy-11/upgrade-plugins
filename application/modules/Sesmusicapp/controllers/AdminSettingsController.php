<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmusicapp
 * @package    Sesmusicapp
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-12-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmusicapp_AdminSettingsController extends Core_Controller_Action_Admin {
  public function indexAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmusicapp_admin_main', array(), 'sesmusicapp_admin_main_settings');
    $this->view->form = $form = new Sesmusicapp_Form_Admin_Settings_Global();
    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      if (@$values['sesmusicapp_changelanding']) {
        $this->landingpageSet();
      }
			if (@$values['sesmusicapp_changememberhome']) {
        $this->memberhomepageSet();
      }
			if (@$values['sesmusicapp_changewelcome']) {
        $this->welcomepageSet();
      }
      include_once APPLICATION_PATH . "/application/modules/Sesmusicapp/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmusicapp.pluginactivated')) {
        foreach ($values as $key => $value) {
          if($value != '') 
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
  public function uploadEmojis() {
    $emojiiconsTable = Engine_Api::_()->getDbtable('emojiicons', 'sesmusicapp' ); 
    $paginator = Engine_Api::_()->getDbTable('emojis','sesmusicapp')->getPaginator();
    foreach($paginator as $emoji) {
      if($emoji->title == 'Animals & Nature') {
        $title = 'Animals_Nature';
      } else if($emoji->title == 'Food & Drink') {
        $title = 'Food_Drink';
      } else if($emoji->title == 'Smilies & People') {
        $title = 'Smilies_People';
      } else if($emoji->title == 'Travel & Places') {
        $title = 'Travel_Places';
      } else {
        $title = $emoji->title;
      }
      $PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesmusicapp' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . $title . DIRECTORY_SEPARATOR;
      // Get all existing log files
      $logFiles = array();
      $file_display = array('jpg', 'jpeg', 'png', 'gif');
      if (file_exists(@$PathFile)) {
        $dir_contents = scandir( $PathFile );
        foreach ( $dir_contents as $file ) {
          $file_type = strtolower( end( explode('.', @$file ) ) );
          if ( ($file !== '.') && ($file !== '..') && (in_array( $file_type, $file_display)) ) {
            $images = explode('.', $file);
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            // If we're here, we're done
            try {
              //$fullname = explode('_',$images[0]);
              //$title = str_replace('_', ' ', $images[0]);
              //$title = str_replace($fullname[0], '', $title);
              $values['emoji_icon'] = $images[0]; //$fullname[0]; //$images[0];
              $values['emoji_id'] = $emoji->emoji_id;
              $values['title'] = '';

              $emoIconCode = "\u{$values['emoji_icon']}";
              $emoIcon = preg_replace("/\\\\u([0-9A-F]{2,5})/i", "&#x$1;", $emoIconCode);

              $emojisCode = Engine_Api::_()->sesmusicapp()->EncodeEmoji(IntlChar::chr(hexdec($emoIcon)));
              $values['emoji_encodecode'] = $emojisCode;
        
              $getEmojiIconExist = Engine_Api::_()->getDbTable('emojiicons', 'sesmusicapp')->getEmojiIconExist(array('emoji_icon' => $images[0]));
              
              if(empty($getEmojiIconExist)) {
                
                $item = $emojiiconsTable->createRow();
                $item->setFromArray($values);
                $item->save();
                $item->order = $item->getIdentity();
                $item->save();

                if(!empty($file)) {
                  $file_ext = pathinfo($file);
                  $file_ext = $file_ext['extension']; 
                  $storage = Engine_Api::_()->getItemTable('storage_file');

                  $pngFile = $PathFile . $file;

                  $storageObject = $storage->createFile(@$pngFile, array(
                    'parent_id' => $item->getIdentity(),
                    'parent_type' => $item->getType(),
                    'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
                  ));
                  
                  // Remove temporary file
                  @unlink($file['tmp_name']);
                  $item->file_id = $storageObject->file_id;
                  $item->save();
                }
                $db->commit();
              }
            } catch(Exception $e) {
              $db->rollBack();
              throw $e;  
            }
          }
        }
      }
    }
  }
  public function landingpageSet() {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    //Set Welcomw page as Landing Page and backup of Old Landing Page
    $orlanpage_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'core_index_index')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if ($orlanpage_id) {
      $db->query('UPDATE `engine4_core_content` SET `page_id` = "990002" WHERE `engine4_core_content`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `page_id` = "990002" WHERE `engine4_core_pages`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index_1" WHERE `engine4_core_pages`.`name` = "core_index_index";');
    }
    //New Landing Page
    $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sesmusicapp_index_sesbackuplandingppage')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if (!$pageId) {
      $widgetOrder = 1;
      //Insert page
      $db->insert('engine4_core_pages', array(
          'name' => 'sesmusicapp_index_sesbackuplandingppage',
          'displayname' => 'Landing Page',
          'title' => 'Landing Page',
          'description' => 'This is your site\'s landing page.',
          'custom' => 0,
      ));
       $newpagelastId = $page_id =  $pageId = $db->lastInsertId();
			$db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => $widgetOrder++,
      ));
      $main_id = $db->lastInsertId();
				// Insert top-middle
			$db->insert('engine4_core_content', array(
				'type' => 'container',
				'name' => 'middle',
				'page_id' => $page_id,
				'parent_content_id' => $main_id,
				'order' => $widgetOrder++,
			));
			$topMiddleId = $db->lastInsertId();
			 $db->insert('engine4_core_content', array(
			'type' => 'container',
			'name' => 'right',
			'page_id' => $page_id,
			'parent_content_id' => $main_id,
			'order' => 3,
			));
			$topRightId = $db->lastInsertId();
			// update content
			$coreContentTable = Engine_Api::_()->getDbTable('content', 'core');
			$coreContentTableName = $coreContentTable->info('name');
			$corePagesTable = Engine_Api::_()->getDbTable('pages', 'core');
			$corePagesTableName = $corePagesTable->info('name');
			$select = $corePagesTable->select()
				->setIntegrityCheck(false)
				->from($corePagesTable, null)
				->joinLeft($coreContentTableName, $corePagesTableName . '.page_id = ' . $coreContentTableName . '.page_id')
				->where($corePagesTableName . '.name = ?', 'sesmusicapp_index_home');
			$widgetsData = $select->query()->fetchAll();
			
			//get page id
			$select = $corePagesTable->select()
					->from($corePagesTableName, 'page_id')
					->where('name = ?', 'sesmusicapp_index_home');
			$oldpage_id = $select->query()->fetchColumn();
			//get main id
			$selectmainid = $coreContentTable->select()
            ->from($coreContentTableName, 'content_id')
						->where('type = ?', 'container')
						->where('name = ?', 'main')
						->where('page_id = ?', $oldpage_id);
			$OldMainIdQueryObject = $selectmainid->query()->fetchAll();
			$OldMainId = $OldMainIdQueryObject[0]['content_id'];
			//get right id
			$selectrightid = $coreContentTable->select()
            ->from($coreContentTableName, 'content_id')
						->where('type = ?', 'container')
						->where('name = ?', 'right')
						->where('page_id = ?', $oldpage_id);
			$OldRightIdQueryObject = $selectrightid->query()->fetchAll();
			$OldRightId = $OldRightIdQueryObject[0]['content_id'];
			//get middle id
			$selectmiddleid = $coreContentTable->select()
            ->from($coreContentTableName, 'content_id')
						->where('type = ?', 'container')
						->where('name = ?', 'middle')
						->where('page_id = ?', $oldpage_id);
			$OldMiddleIdQueryObject = $selectmiddleid->query()->fetchAll();
			$OldMiddleId = $OldMiddleIdQueryObject[0]['content_id'];
		
			$widgetContentId = 0;
			foreach($widgetsData as $widget){
				if($widget['type'] == 'widget' && $widget['parent_content_id'] == $OldMiddleId){
					$widgetContentId = $topMiddleId;
				}
				elseif($widget['type'] == 'widget' && $widget['parent_content_id'] == $OldRightId){
					$widgetContentId = $topRightId;
				}
				if($widgetContentId){
					$db->insert('engine4_core_content', array(
					'type' => $widget['type'],
					'name' => $widget['name'],
					'page_id' => $page_id,
					'parent_content_id' => $widgetContentId ,
					'order' => $widget['order'],
					'params' => $widget['params'],
					));
				}
			}
			// update content
      $newbakpage_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'sesmusicapp_index_sesbackuplandingppage')
              ->limit(1)
              ->query()
              ->fetchColumn();
      if ($newbakpage_id) {
        $db->query('UPDATE `engine4_core_content` SET `page_id` = "3" WHERE `engine4_core_content`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `page_id` = "3" WHERE `engine4_core_pages`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "core_index_index" WHERE `engine4_core_pages`.`name` = "sesmusicapp_index_sesbackuplandingppage";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "sesmusicapp_index_sesbackuplandingppage" WHERE `engine4_core_pages`.`name` = "core_index_index_1";');
        $db->query('UPDATE `engine4_core_pages` SET `displayname` = "SES - Advanced Music App  - Landing Page Backup" WHERE `engine4_core_pages`.`name` = "sesmusicapp_index_sesbackuplandingppage";');
      }
    }
  }
	public function memberhomepageSet() {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    //Set Member Home Page as Welcome Page of Music app home and backup of Old Member  Home Page
    $orlanpage_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'user_index_home')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if ($orlanpage_id) {
      $db->query('UPDATE `engine4_core_content` SET `page_id` = "990003" WHERE `engine4_core_content`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `page_id` = "990003" WHERE `engine4_core_pages`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `name` = "user_index_home_1" WHERE `engine4_core_pages`.`name` = "user_index_home";');
    }
		//New Landing Page
    $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sesmusicapp_index_sesbackupuserhomepage')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if (!$pageId) {
      $widgetOrder = 1;
      //Insert page
      $db->insert('engine4_core_pages', array(
          'name' => 'sesmusicapp_index_sesbackupuserhomepage',
          'displayname' => 'Member Home Page',
          'title' => 'Member Home Page',
          'description' => 'This is your site\'s member home page.',
          'custom' => 0,
      ));
      $newpagelastId = $page_id =  $pageId = $db->lastInsertId();
			$db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => $widgetOrder++,
      ));
      $main_id = $db->lastInsertId();
				// Insert top-middle
			$db->insert('engine4_core_content', array(
				'type' => 'container',
				'name' => 'middle',
				'page_id' => $page_id,
				'parent_content_id' => $main_id,
				'order' => $widgetOrder++,
			));
			$topMiddleId = $db->lastInsertId();
			 $db->insert('engine4_core_content', array(
			'type' => 'container',
			'name' => 'right',
			'page_id' => $page_id,
			'parent_content_id' => $main_id,
			'order' => 3,
			));
			$topRightId = $db->lastInsertId();
			// update content
			$coreContentTable = Engine_Api::_()->getDbTable('content', 'core');
			$coreContentTableName = $coreContentTable->info('name');
			$corePagesTable = Engine_Api::_()->getDbTable('pages', 'core');
			$corePagesTableName = $corePagesTable->info('name');
			$select = $corePagesTable->select()
				->setIntegrityCheck(false)
				->from($corePagesTable, null)
				->joinLeft($coreContentTableName, $corePagesTableName . '.page_id = ' . $coreContentTableName . '.page_id')
				->where($corePagesTableName . '.name = ?', 'sesmusicapp_index_home');
			$widgetsData = $select->query()->fetchAll();
			
			//get page id
			$select = $corePagesTable->select()
					->from($corePagesTableName, 'page_id')
					->where('name = ?', 'sesmusicapp_index_home');
			$oldpage_id = $select->query()->fetchColumn();
			//get main id
			$selectmainid = $coreContentTable->select()
            ->from($coreContentTableName, 'content_id')
						->where('type = ?', 'container')
						->where('name = ?', 'main')
						->where('page_id = ?', $oldpage_id);
			$OldMainIdQueryObject = $selectmainid->query()->fetchAll();
			$OldMainId = $OldMainIdQueryObject[0]['content_id'];
			//get right id
			$selectrightid = $coreContentTable->select()
            ->from($coreContentTableName, 'content_id')
						->where('type = ?', 'container')
						->where('name = ?', 'right')
						->where('page_id = ?', $oldpage_id);
			$OldRightIdQueryObject = $selectrightid->query()->fetchAll();
			$OldRightId = $OldRightIdQueryObject[0]['content_id'];
			//get middle id
			$selectmiddleid = $coreContentTable->select()
            ->from($coreContentTableName, 'content_id')
						->where('type = ?', 'container')
						->where('name = ?', 'middle')
						->where('page_id = ?', $oldpage_id);
			$OldMiddleIdQueryObject = $selectmiddleid->query()->fetchAll();
			$OldMiddleId = $OldMiddleIdQueryObject[0]['content_id'];
		
			$widgetContentId = 0;
			foreach($widgetsData as $widget){
				if($widget['type'] == 'widget' && $widget['parent_content_id'] == $OldMiddleId){
					$widgetContentId = $topMiddleId;
				}
				elseif($widget['type'] == 'widget' && $widget['parent_content_id'] == $OldRightId){
					$widgetContentId = $topRightId;
				}
				if($widgetContentId){
					$db->insert('engine4_core_content', array(
					'type' => $widget['type'],
					'name' => $widget['name'],
					'page_id' => $page_id,
					'parent_content_id' => $widgetContentId ,
					'order' => $widget['order'],
					'params' => $widget['params'],
					));
				}
			}
			// update content
      $newbakpage_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'sesmusicapp_index_sesbackupuserhomepage')
              ->limit(1)
              ->query()
              ->fetchColumn();
      if ($newbakpage_id) {
        $db->query('UPDATE `engine4_core_content` SET `page_id` = "4" WHERE `engine4_core_content`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `page_id` = "4" WHERE `engine4_core_pages`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "user_index_home" WHERE `engine4_core_pages`.`name` = "sesmusicapp_index_sesbackupuserhomepage";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "sesmusicapp_index_sesbackupuserhomepage" WHERE `engine4_core_pages`.`name` = "user_index_home_1";');
        $db->query('UPDATE `engine4_core_pages` SET `displayname` = "SES - Advanced Music App - Member Home Page Backup" WHERE `engine4_core_pages`.`name` = "sesmusicapp_index_sesbackupuserhomepage";');
      }
    }
  }
  public function welcomepageSet() {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    //Set Member Home Page as Welcome Page of Music app home and backup of Old Member  Home Page
    $orlanpage_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sesmusic_index_welcome')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if ($orlanpage_id) {
      $db->query('UPDATE `engine4_core_content` SET `page_id` = "990006" WHERE `engine4_core_content`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `page_id` = "990006" WHERE `engine4_core_pages`.`page_id` = "' . $orlanpage_id . '";');
      $db->query('UPDATE `engine4_core_pages` SET `name` = "sesmusic_index_welcome_1" WHERE `engine4_core_pages`.`name` = "sesmusic_index_welcome";');
    }
    //New Landing Page
    $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sesmusicapp_index_sesbackupmusicwelcome')
            ->limit(1)
            ->query()
            ->fetchColumn();
    if (!$pageId) {
      $widgetOrder = 1;
      //Insert page
      $db->insert('engine4_core_pages', array(
          'name' => 'sesmusicapp_index_sesbackupmusicwelcome',
          'displayname' => 'Professional Music - Welcome Page',
          'title' => 'Professional Music - Welcome Page',
          'description' => 'This page is Professional music\'s welcome page.',
          'custom' => 0,
      ));
      $newpagelastId = $page_id =  $pageId = $db->lastInsertId();
			$db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => $widgetOrder++,
      ));
      $main_id = $db->lastInsertId();
				// Insert top-middle
			$db->insert('engine4_core_content', array(
				'type' => 'container',
				'name' => 'middle',
				'page_id' => $page_id,
				'parent_content_id' => $main_id,
				'order' => $widgetOrder++,
			));
			$topMiddleId = $db->lastInsertId();
			 $db->insert('engine4_core_content', array(
			'type' => 'container',
			'name' => 'right',
			'page_id' => $page_id,
			'parent_content_id' => $main_id,
			'order' => 3,
			));
			$topRightId = $db->lastInsertId();
			// update content
			$coreContentTable = Engine_Api::_()->getDbTable('content', 'core');
			$coreContentTableName = $coreContentTable->info('name');
			$corePagesTable = Engine_Api::_()->getDbTable('pages', 'core');
			$corePagesTableName = $corePagesTable->info('name');
			$select = $corePagesTable->select()
				->setIntegrityCheck(false)
				->from($corePagesTable, null)
				->joinLeft($coreContentTableName, $corePagesTableName . '.page_id = ' . $coreContentTableName . '.page_id')
				->where($corePagesTableName . '.name = ?', 'sesmusicapp_index_home');
			$widgetsData = $select->query()->fetchAll();
			
			//get page id
			$select = $corePagesTable->select()
					->from($corePagesTableName, 'page_id')
					->where('name = ?', 'sesmusicapp_index_home');
			$oldpage_id = $select->query()->fetchColumn();
			//get main id
			$selectmainid = $coreContentTable->select()
            ->from($coreContentTableName, 'content_id')
						->where('type = ?', 'container')
						->where('name = ?', 'main')
						->where('page_id = ?', $oldpage_id);
			$OldMainIdQueryObject = $selectmainid->query()->fetchAll();
			$OldMainId = $OldMainIdQueryObject[0]['content_id'];
			//get right id
			$selectrightid = $coreContentTable->select()
            ->from($coreContentTableName, 'content_id')
						->where('type = ?', 'container')
						->where('name = ?', 'right')
						->where('page_id = ?', $oldpage_id);
			$OldRightIdQueryObject = $selectrightid->query()->fetchAll();
			$OldRightId = $OldRightIdQueryObject[0]['content_id'];
			//get middle id
			$selectmiddleid = $coreContentTable->select()
            ->from($coreContentTableName, 'content_id')
						->where('type = ?', 'container')
						->where('name = ?', 'middle')
						->where('page_id = ?', $oldpage_id);
			$OldMiddleIdQueryObject = $selectmiddleid->query()->fetchAll();
			$OldMiddleId = $OldMiddleIdQueryObject[0]['content_id'];
		
			$widgetContentId = 0;
			foreach($widgetsData as $widget){
				if($widget['type'] == 'widget' && $widget['parent_content_id'] == $OldMiddleId){
					$widgetContentId = $topMiddleId;
				}
				elseif($widget['type'] == 'widget' && $widget['parent_content_id'] == $OldRightId){
					$widgetContentId = $topRightId;
				}
				if($widgetContentId > 0){
					$db->insert('engine4_core_content', array(
					'type' => $widget['type'],
					'name' => $widget['name'],
					'page_id' => $page_id,
					'parent_content_id' => $widgetContentId ,
					'order' => $widget['order'],
					'params' => $widget['params'],
					));
				}
			}
			// update content
      $newbakpage_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'sesmusicapp_index_sesbackupmusicwelcome')
              ->limit(1)
              ->query()
              ->fetchColumn();
      if ($newbakpage_id) {
        $db->query('UPDATE `engine4_core_content` SET `page_id` = "'.$orlanpage_id.'" WHERE `engine4_core_content`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `page_id` = "'.$orlanpage_id.'" WHERE `engine4_core_pages`.`page_id` = "' . $newbakpage_id . '";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "sesmusic_index_welcome" WHERE `engine4_core_pages`.`name` = "sesmusicapp_index_sesbackupmusicwelcome";');
        $db->query('UPDATE `engine4_core_pages` SET `name` = "sesmusicapp_index_sesbackupmusicwelcome" WHERE `engine4_core_pages`.`name` = "sesmusic_index_welcome_1";');
        $db->query('UPDATE `engine4_core_pages` SET `displayname` = "SES - Advanced Music App - Professional music welcome Page Backup" WHERE `engine4_core_pages`.`name` = "sesmusicapp_index_sesbackupmusicwelcome";');
      }
    }
  }
	public function manageWidgetizePageAction() {
		$this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmusicapp_admin_main', array(), 'sesmusicapp_admin_main_managewidgetizepage');
		
    $pagesArray = array('sesmusicapp_index_home');
    $this->view->pagesArray = $pagesArray;
  }
 }