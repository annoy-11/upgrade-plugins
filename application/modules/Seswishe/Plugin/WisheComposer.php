<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: WisheComposer.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seswishe_Plugin_WisheComposer extends Core_Plugin_Abstract
{
  public function onAttachWishe($data,$location = '',$postData)
  {
    $table = Engine_Api::_()->getDbTable('wishes','seswishe');
    $db = $table->getAdapter();
    $db->beginTransaction();
    try {

      $wishe = $table->createRow();
      $viewer = Engine_Api::_()->user()->getViewer();
      $wishe->owner_id = $viewer->getIdentity();
      $wishe->owner_type = $viewer->getType();
      $wishe->title = $postData['wishe-description'];
      $wishe->source = $postData['wishe-source'];
      $wishe->wishetitle = $postData['wishe-title'];
      if($postData['category_id'])
        $wishe->category_id = $postData['category_id'];
      if($postData['subcat_id'])
        $wishe->subcat_id = $postData['subcat_id'];
      if($postData['subsubcat_id'])
        $wishe->subsubcat_id = $postData['subsubcat_id'];
      $wishe->save();
      
      if($postData['video']) {
        $information = $this->handleIframelyInformation($postData['video']);
        try{
          $wishe->setPhoto($information['thumbnail']);
        }catch(Exception $e){
          //silence  
        }
        $wishe->mediatype = $postData['mediatype'];
        $wishe->code = $information['code'];
        $wishe->save();
      }

      if(isset($_FILES['photo']['tmp_name']) && !empty($_FILES['photo']['tmp_name']) ) {
        $photo_id = $this->setPhoto($_FILES['photo'], $wishe->wishe_id);
        $wishe->photo_id = $photo_id;
        $wishe->save();
      }
      
      // Add tags
      $tags = preg_split('/[,]+/', $postData['tags']);
      $wishe->tags()->addTagMaps($viewer, $tags);
      $wishe->save();
    } catch( Exception $e ) {
      throw $e;
      return;
    }
    return $wishe;
  }
  
  public function handleIframelyInformation($uri) {
  
    $iframelyDisallowHost = Engine_Api::_()->getApi('settings', 'core')->getSetting('seswishe_iframely_disallow');
    if (parse_url($uri, PHP_URL_SCHEME) === null) {
        $uri = "http://" . $uri;
    }
    $uriHost = Zend_Uri::factory($uri)->getHost();
    if ($iframelyDisallowHost && in_array($uriHost, $iframelyDisallowHost)) {
        return;
    }
    $config = Engine_Api::_()->getApi('settings', 'core')->core_iframely;
    $iframely = Engine_Iframely::factory($config)->get($uri);
    if (!in_array('player', array_keys($iframely['links']))) {
        return;
    }
    $information = array('thumbnail' => '', 'title' => '', 'description' => '', 'duration' => '');
    if (!empty($iframely['links']['thumbnail'])) {
        $information['thumbnail'] = $iframely['links']['thumbnail'][0]['href'];
        if (parse_url($information['thumbnail'], PHP_URL_SCHEME) === null) {
            $information['thumbnail'] = str_replace(array('://', '//'), '', $information['thumbnail']);
            $information['thumbnail'] = "http://" . $information['thumbnail'];
        }
    }
    if (!empty($iframely['meta']['title'])) {
        $information['title'] = $iframely['meta']['title'];
    }
    if (!empty($iframely['meta']['description'])) {
        $information['description'] = $iframely['meta']['description'];
    }
    if (!empty($iframely['meta']['duration'])) {
        $information['duration'] = $iframely['meta']['duration'];
    }
    $information['code'] = $iframely['html'];
    return $information;
  }
  
  public function setPhoto($photo, $wishe_id)
  {
    if( $photo instanceof Zend_Form_Element_File ) {
      $file = $photo->getFileName();
      $fileName = $file;
    } else if( $photo instanceof Storage_Model_File ) {
      $file = $photo->temporary();
      $fileName = $photo->name;
    } else if( $photo instanceof Core_Model_Item_Abstract && !empty($photo->file_id) ) {
      $tmpRow = Engine_Api::_()->getItem('storage_file', $photo->file_id);
      $file = $tmpRow->temporary();
      $fileName = $tmpRow->name;
    } else if( is_array($photo) && !empty($photo['tmp_name']) ) {
      $file = $photo['tmp_name'];
      $fileName = $photo['name'];
    } else if( is_string($photo) && file_exists($photo) ) {
      $file = $photo;
      $fileName = $photo;
    } else {
      throw new Seswishe_Model_Exception('invalid argument passed to setPhoto');
    }

    if( !$fileName ) {
      $fileName = basename($file);
    }
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $extension = ltrim(strrchr(basename($fileName), '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    
    $params = array(
      'parent_type' => 'seswishe_wishe',
      'parent_id' => $wishe_id,
      'user_id' => $viewer_id,
      'name' => $fileName,
    );

    // Save
    $filesTable = Engine_Api::_()->getItemTable('storage_file');

    // Resize image (main)
    $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_m.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(720, 720)
      ->write($mainPath)
      ->destroy();

    // Resize image (main)
    $profilePath = $path . DIRECTORY_SEPARATOR . $base . '_p.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(720, 720)
      ->write($profilePath)
      ->destroy();

    // Store
    $iMain = $filesTable->createFile($mainPath, $params);
    $iIconprofile = $filesTable->createFile($profilePath, $params);
    
    $iMain->bridge($iIconprofile, 'thumb.profile');
    
    // Remove temp files
    @unlink($mainPath);
    @unlink($profilePath);

    // Update row
    $this->modified_date = date('Y-m-d H:i:s');
    $photo_id = $iMain->file_id;
    //$this->save();
    
    return $photo_id;
  }
}