<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemoji
 * @package    Sesemoji
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$emojiiconsTable = Engine_Api::_()->getDbtable('emojis', 'sesemoji' ); 
$paginator = $emojiiconsTable->getPaginator();
$PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesemoji' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "category" . DIRECTORY_SEPARATOR;
foreach($paginator as $emoji) {
  $file = $PathFile . $emoji->emoji_id . '.png'; 
  if(!empty($file)) {
    $file_ext = pathinfo($file);
    $file_ext = $file_ext['extension'];

    $storage = Engine_Api::_()->getItemTable('storage_file');
    $storageObject = $storage->createFile(@$file, array(
      'parent_id' => $emoji->getIdentity(),
      'parent_type' => $emoji->getType(),
      'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
    ));
    // Remove temporary file
    @unlink($file['tmp_name']);
    $emoji->file_id = $storageObject->file_id;
    $emoji->save();
  }
}

//Emoji Icon upload work
$this->uploadEmojis();

$composerOptions = array_merge(array('emojisses'), Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedactivity.composeroptions', 1));
Engine_Api::_()->getApi('settings', 'core')->removeSetting('sesadvancedactivity.composeroptions');
Engine_Api::_()->getApi('settings', 'core')->setSetting('sesadvancedactivity.composeroptions', $composerOptions);