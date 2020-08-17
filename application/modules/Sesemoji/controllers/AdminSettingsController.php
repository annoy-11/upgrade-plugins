<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemoji
 * @package    Sesemoji
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesemoji_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesemoji_admin_main', array(), 'sesemoji_admin_main_settings');

    $this->view->form = $form = new Sesemoji_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      unset($values['defaulttext']);
      include_once APPLICATION_PATH . "/application/modules/Sesemoji/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesemoji.pluginactivated')) {
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
    
    $emojiiconsTable = Engine_Api::_()->getDbtable('emojiicons', 'sesemoji' ); 
    $paginator = Engine_Api::_()->getDbTable('emojis','sesemoji')->getPaginator();
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
    
      $PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesemoji' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . $title . DIRECTORY_SEPARATOR;

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

              $emojisCode = Engine_Api::_()->sesemoji()->EncodeEmoji(IntlChar::chr(hexdec($emoIcon)));
              $values['emoji_encodecode'] = $emojisCode;
        
              $getEmojiIconExist = Engine_Api::_()->getDbTable('emojiicons', 'sesemoji')->getEmojiIconExist(array('emoji_icon' => $images[0]));
              
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
}