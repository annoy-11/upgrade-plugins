<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ImportController.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmediaimporter_ImportController extends Core_Controller_Action_Standard
{
  public function indexAction(){
      // get select media data
  }
  public function mediaDataAction(){
    $view = Zend_Registry::get('Zend_View');
    parse_str($_POST['formData'], $_POST['mediaData']);
    $type = $_POST['typeData'];
    $mediatype = $_POST['mediatypeData'];
    $mediaData = $_POST['mediaData'];
    $data['mediatype'] = $mediatype;
    $data['album_data'] = $mediaData;
    $data['type'] = $type;
    if($type == 'facebook')
      $data['photos'] = Engine_Api::_()->getApi('facebook','sesmediaimporter')->getData($mediaData,$mediatype);
    else if($type == 'instagram')
      $data['photos'] = Engine_Api::_()->getApi('instagram','sesmediaimporter')->getData($mediaData,$mediatype);
    else if($type == '500px')
      $data['photos'] = Engine_Api::_()->getApi('px500','sesmediaimporter')->getData($mediaData,$mediatype);
    else if($type == 'flickr'){
        if($mediatype != 'album')
          $data['photos'] = $mediaData;
        else
          $data['photos'] = Engine_Api::_()->getApi('flickr','sesmediaimporter')->getData($mediaData,$mediatype);
    }else if($type == 'google'){
        if($mediatype != 'album')
          $data['photos'] = $mediaData;
        else
          $data['photos'] = Engine_Api::_()->getApi('google','sesmediaimporter')->getData($mediaData,$mediatype);
    }
    if($mediatype == 'album'){
      $count_photo = 0;
      foreach($data['photos'] as $countPhoto)
        $count_photo = $count_photo + count($countPhoto);
    }else if($mediatype == "zip"){
      $storage = Engine_Api::_()->getItemTable('storage_file');
      $params = array(
          'parent_id' => '1',
          'parent_type' => 'sesmediaimporter_file',
          'user_id' => $this->view->viewer()->getIdentity(),
      );
      $storageObject = $storage->createFile($_FILES['upload_zip'], $params);
      $_SESSION['upload_zip'] = $storageObject->file_id;  
    }else{
        unset($data['album_data']);
        $count_photo = count($data['photos']['photos']) ;
    }
    $count_album = count($data['album_data']['album_id']);
    if($mediatype == "zip"){
      $message = $view -> translate('Import <strong>%s</strong>', $_FILES['upload_zip']['name']);
    }else if ($count_album && $count_photo)
      $message = $view -> translate('Import <strong>%s</strong> photo(s) in <strong>%s</strong> album(s).', $count_photo, $count_album);
    else if ($count_photo)
      $message = $view -> translate('Import <strong>%s</strong> photo(s).', $count_photo);
    
    echo json_encode(array('data'=>$data,'message'=>$message,'type'=>$mediatype));die;
  }
  public function importAlbumsAction(){
     $mediaData = $_POST['mediadata'];
  }
}
