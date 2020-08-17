<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Place widget in header
$parent_content_id = $db->select()
                        ->from('engine4_core_content', 'content_id')
                        ->where('type = ?', 'container')
                        ->where('page_id = ?', '1')
                        ->where('name = ?', 'main')
                        ->limit(1)
                        ->query()
                        ->fetchColumn();
if($parent_content_id) {
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesbrowserpush.notification-button',
    'page_id' => 1,
    'parent_content_id' => $parent_content_id,
    'order' => 20,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesbrowserpush.push',
    'page_id' => 1,
    'parent_content_id' => $parent_content_id,
    'order' => 21,
  ));

}

//domain name
$domain = $_SERVER['HTTP_HOST'];
$domain = explode('.', $domain);
$domain = array_reverse($domain);
$domain = isset($domain[1]) ? $domain[1] : Zend_Registry::get('StaticBaseUrl');
if(!$domain)
  $domain = str_replace('/','',Zend_Registry::get('StaticBaseUrl'));
Engine_Api::_()->getApi('settings', 'core')->setSetting('sesbrowserpush_welcomeenable', 1);
$title = 'Welcome to '.ucfirst($domain);
Engine_Api::_()->getApi('settings', 'core')->setSetting('sesbrowserpush_welcometitle', $title);
$description = 'Thanks for subscribing and welcome you to '.ucfirst($domain).'!';
Engine_Api::_()->getApi('settings', 'core')->setSetting('sesbrowserpush_welcomedescription', $description);
$baseURL =(!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : 'http://';
$website = $baseURL. $_SERVER['HTTP_HOST'].Zend_Registry::get('StaticBaseUrl');
Engine_Api::_()->getApi('settings', 'core')->setSetting('sesbrowserpush_welcomelink', $website);
$PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesbrowserpush' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images"  . DIRECTORY_SEPARATOR;
if (is_file($PathFile . "welcome.png"))
{
  $image = $PathFile . "welcome.png";
  $key = 'sesbrowserpush_welcomeicon';
  $file_ext = pathinfo($image);
  $file_ext = $file_ext['extension'];
  $storage = Engine_Api::_()->getItemTable('storage_file');
  $storageObject = $storage->createFile($image, array(
    'parent_id' => '1',
    'parent_type' => 'sesbrowserpush_token',
    'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
  ));
  // Remove temporary file
  @unlink($file['tmp_name']);
  if($storageObject->getIdentity()){
    $file = Engine_Api::_()->getItemTable('storage_file')->getFile($storageObject->getIdentity());
      if( $file ) {
        $image =  $file->map();
        $baseURL =(!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : 'http://';
        $baseURL = $baseURL. $_SERVER['HTTP_HOST'];
        if(strpos($image,'http') === false)
          $image = $baseURL.$image;
      }
  }
  $value = $image;
  Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
}
