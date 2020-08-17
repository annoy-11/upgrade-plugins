<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Jobs.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmediaimporter_Plugin_Task_Jobs extends Core_Plugin_Task_Abstract {
  public function execute() {
    ini_set('memory_limit', '-1');
    $db = Engine_Db_Table::getDefaultAdapter();
    $results = $db->query("SELECT * FROM `engine4_sesmediaimporter_import` WHERE completed = 0")->fetchAll();
    $photoTable = Engine_Api::_()->getItemtable('album_photo');
    $sesalbum_installed = Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesalbum'));
    foreach($results as $result) {
      $data = json_decode($result['params'],true);
      if($data['mediatype'] == "zip"){
        $this->importZip($data,$result,$photoTable,$db,$sesalbum_installed);
      }else if($data['mediatype'] == 'album')
        $this->importAlbums($data,$result,$photoTable,$db,$sesalbum_installed);
      else
        $this->importPhotos($data,$result,$photoTable,$db,$sesalbum_installed);
      $db->query("UPDATE `engine4_sesmediaimporter_import` SET completed = 1 WHERE import_id = ".$result['import_id']);
    }  
  }
  private function rrmdir($src) {
    $dir = opendir($src);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            $full = $src . '/' . $file;
            if ( is_dir($full) ) {
                $this->rrmdir($full);
            }
            else {
                unlink($full);
            }
        }
    }
    closedir($dir);
    rmdir($src);
}
   public function importZip($data,$result,$photoTable,$db,$sesalbum_installed = true){
        $storageId = $data['zip_upload'];
        $storage = Engine_Api::_()->getItem('storage_file',$storageId);
        $targetzip = APPLICATION_PATH . DIRECTORY_SEPARATOR.$storage->storage_path;
        //check folder exists
        if(file_exists(str_replace('.zip','',$targetzip))){
            $this->uploadZipFiles(str_replace('.zip','',$targetzip),$data,$result,$photoTable,$db,$sesalbum_installed);
        }else{
          /* Extracting Zip File */
          $zip = new ZipArchive();
          $name = str_replace('.zip','',basename($targetzip));
          $x = $zip->open($targetzip); //open the zip file to extract
          if ($x === true) {
              $targetzip = substr($targetzip, 0, strrpos( $targetzip, '/')).DIRECTORY_SEPARATOR.$name;
              $extract = $zip->extractTo($targetzip); //place in the directory with same name 
              $zip->close();
              @unlink($targetzip.'.zip'); //Deleting the Zipped file
              // Get subdirectories
              chmod($targetzip, 0777) ;
              $this->uploadZipFiles($targetzip,$data,$result,$photoTable,$db,$sesalbum_installed);
          }     
        }
  }
  public function uploadZipFiles($targetdir,$data,$result,$photoTable,$db,$sesalbum_installed = false){
      $directories = glob($targetdir.'*', GLOB_ONLYDIR);
      if ($directories !== FALSE) {
      // If we're here, we're done
      $album_id = $data['album_data']['sesalbum_album_id'];
      $album = Engine_Api::_()->getItem('album',$album_id);
      if(!$album){
        $db->query("UPDATE `engine4_sesmediaimporter_import` SET completed = 1 WHERE import_id = ".$result['import_id']); 
        return; 
      }
      $viewer = Engine_Api::_()->getItem('user',$album->owner_id);
        try {     
          $counter = 0;
          foreach($directories as $directory) {
            $path = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
            
              foreach ($path as $file) {
                if (!$file->isFile())
                  continue;
                $base_name = basename($file->getFilename());
                if (!($pos = strrpos($base_name, '.')))
                  continue;
                if(substr_count($base_name, '.') > 1)
                  continue;
                $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
                if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png','JPEG','JPG','PNG','GIF')))
                  continue;
               try{
                 
                $pathName = $file->getPathname(); 
                $photo = $photoTable->createRow();
                
                $photo->setFromArray(array(
                    'owner_type' => 'user',
                    'owner_id' => $viewer->getIdentity()
                ));       
                $photo->save(); 
                $photo->order = $photo->photo_id;
                $photo->save();
                $photoData = $pathName;
                if($sesalbum_installed){
                  $setPhoto = $photo->setPhoto($photoData,true,false,$viewer);
                }else{
                  $setPhoto = $this->setPhoto($photoData,true,false,$viewer,$photo);  
                }
                $photo->album_id = $album_id;
                $photo->save();  
                if(!$album->photo_id){
                  $album->photo_id = $photo->photo_id;
                  $album->save();  
                }
                
                unset($pathName);
                $counter++;
               }catch(Exception $e){
                  continue;
                  //throw $e;
               }
            }
          }
          $db->commit();
          $this->rrmdir($targetdir);
          $isDraft = 1;
          if($sesalbum_installed){
            $isDraft = $album->draft;
            $album->draft = 0;
          }
          $album->save();
          $api = Engine_Api::_()->getDbtable('actions', 'activity');
          $action = $api->addActivity($viewer, $album, 'album_photo_new', null, array('count' => $album->count()));
          $photos = $db->query("SELECT * FROM `engine4_album_photos` WHERE album_id = ".$album_id." LIMIT 9")->fetchAll();
          foreach($photos as $photoAlbum){
            if( $action instanceof Activity_Model_Action && $count < 9)
            {
              $photoAlbum = Engine_Api::_()->getItem('album_photo',$photoAlbum['photo_id']);
              $api->attachActivity($action, $photoAlbum, Activity_Model_Action::ATTACH_MULTI);
            }
          }
          if($isDraft == 0){
            //Tag Work
            if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
              $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
              foreach($album->tags()->getTagMaps() as $tag) {
                $tag = $tagMap->getTag();
                if (!isset($tag->text))
                  continue;
                $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$action->getIdentity().'", "'.$tag->text.'")');
              }
            }  
          }
          $db->query("UPDATE `engine4_sesmediaimporter_import` SET params = '".json_encode($data)."' WHERE import_id = ".$result['import_id']);
         }catch(Exception $e){
            if( $e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE ) {
	            if($sesalbum_installed){
                $album->draft = 0;
                $album->save();
              }
              $db->query("UPDATE `engine4_sesmediaimporter_import` SET completed = 1 WHERE import_id = ".$result['import_id']);
              $sesmediaLink = '<a href="' . $album->getHref() . '">' . "Please check" . '</a>';
              Engine_Api::_()->getDbtable('notifications', 'activity')
                  ->addNotification($viewer, $viewer, $album, 'sesmediaimporter_import_error',array('sesmediaLink'=>$sesmediaLink));
              throw new Sesalbum_Model_Exception($e->getMessage(), $e->getCode());
            }
            $db->rollBack();
            throw $e;
         }
      }  
  }
  public function importPhotos($data,$result,$photoTable,$db,$sesalbum_installed = true){
    $album_id = $data['album_data']['sesalbum_album_id'];
    $album = Engine_Api::_()->getItem('album',$album_id);
    if(!$album){
        $db->query("UPDATE `engine4_sesmediaimporter_import` SET completed = 1 WHERE import_id = ".$result['import_id']); 
        return; 
      }
    $viewer = Engine_Api::_()->getItem('user',$album->owner_id);
    $count = 0;
    foreach($data['photos']['photos'] as $key => $id){
       try{      
        $photo = $photoTable->createRow();
        $photo->setFromArray(array(
            'owner_type' => 'user',
            'owner_id' => $viewer->getIdentity()
        ));       
        $photo->save(); 
        $photo->order = $photo->photo_id;
        $photo->save();
        $photoData = $data['photos']['photos_url'][$key];
        if($sesalbum_installed){
        $setPhoto = $photo->setPhoto($photoData,true,false,$viewer);
        }else{
          $setPhoto = $this->setPhoto($photoData,true,false,$viewer,$photo);   
        }
        $photo->album_id = $album_id;
        $photo->save();  
        if(!$album->photo_id){
          $album->photo_id = $photo->photo_id;
          $album->save();  
        }
        $db->query("INSERT INTO engine4_sesmediaimporter_photos (`owner_id`, `item_id`,`service`,`type`) VALUES ('".$viewer->getIdentity()."','".$key."','".$data['type']."','".$data['mediatype']."')");
        unset($data['photos']['photos'][$key]);
        if(!count($data['photos']['photos'])){
          $isDraft = 1;
          if($sesalbum_installed){
            $isDraft = $album->draft;
            $album->draft = 0;
          }
          $album->save();
          $api = Engine_Api::_()->getDbtable('actions', 'activity');
          $action = $api->addActivity($viewer, $album, 'album_photo_new', null, array('count' => $album->count()));
          $photos = $db->query("SELECT * FROM `engine4_album_photos` WHERE album_id = ".$album_id." LIMIT 9")->fetchAll();
          foreach($photos as $photoAlbum){
            if( $action instanceof Activity_Model_Action && $count < 9)
            {
              $photoAlbum = Engine_Api::_()->getItem('album_photo',$photoAlbum['photo_id']);
              $api->attachActivity($action, $photoAlbum, Activity_Model_Action::ATTACH_MULTI);
            }
          }
          
          if($isDraft == 0){
            //Tag Work
            if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
              $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
              foreach($album->tags()->getTagMaps() as $tag) {
                $tag = $tagMap->getTag();
                if (!isset($tag->text))
                  continue;
                $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$action->getIdentity().'", "'.$tag->text.'")');
              }
            }  
          }
          
        }
        $db->query("UPDATE `engine4_sesmediaimporter_import` SET params = '".json_encode($data)."' WHERE import_id = ".$result['import_id']);
       }catch(Exception $e){
         if( $e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE ) { $isDraft = 1;
           if($sesalbum_installed){
                $album->draft = 0;
                $album->save();
            }
            $db->query("UPDATE `engine4_sesmediaimporter_import` SET completed = 1 WHERE import_id = ".$result['import_id']);
            $sesmediaLink = '<a href="' . $album->getHref() . '">' . "Please check" . '</a>';
              Engine_Api::_()->getDbtable('notifications', 'activity')
                  ->addNotification($viewer, $viewer, $album, 'sesmediaimporter_import_error',array('sesmediaLink'=>$sesmediaLink));
            throw new Sesalbum_Model_Exception($e->getMessage(), $e->getCode());
          }
          throw $e;
       }
       $count++;
     }        
    return true;        
  }
  public function importAlbums($data, $result,$photoTable,$db,$sesalbum_installed = true){
    foreach($data['album_data']['album_id'] as $importAlbumData){
        $dataAlbum = $data['album_data'];
        $album_id =   $dataAlbum['sesalbum_album_id'][$importAlbumData];
        $album = Engine_Api::_()->getItem('album',$album_id);
        if(!$album){
          $db->query("UPDATE `engine4_sesmediaimporter_import` SET completed = 1 WHERE import_id = ".$result['import_id']); 
          return; 
        }
        $album->title = $dataAlbum['album_name'][$importAlbumData];
        $album->save();
        $viewer = Engine_Api::_()->getItem('user',$album->owner_id);
        $count = 0;
        foreach($data['photos'][$importAlbumData] as $key => $photoData){
           try{      
            $photo = $photoTable->createRow();
            $photo->setFromArray(array(
                'owner_type' => 'user',
                'owner_id' => $viewer->getIdentity()
            ));       
            $photo->save(); 
            $photo->order = $photo->photo_id;
            $photo->save();
            if($sesalbum_installed){
              $setPhoto = $photo->setPhoto($photoData,true,false,$viewer);
            }else{
              $setPhoto = $this->setPhoto($photoData,true,false,$viewer,$photo);  
            }
            $photo->album_id = $album_id;
            $photo->save();  
            if(!$album->photo_id){
              $album->photo_id = $photo->photo_id;
              $album->save();  
            }
            $db->query("INSERT INTO engine4_sesmediaimporter_photos (`owner_id`, `item_id`,`service`,`type`) VALUES ('".$viewer->getIdentity()."','".$key."','".$data['type']."','".$data['mediatype']."')");
            unset($data['photos'][$importAlbumData][$key]);
            if(!count($data['photos'][$importAlbumData])){
              $db->query("INSERT INTO engine4_sesmediaimporter_albums (`owner_id`, `item_id`) VALUES ('".$viewer->getIdentity()."','".$importAlbumData."')");
              if(isset($album->draft)){
                $album->draft = 0;
              }
               $album->save();
              $api = Engine_Api::_()->getDbtable('actions', 'activity');
              $action = $api->addActivity($viewer, $album, 'album_photo_new', null, array('count' => $album->count()));
              $photos = $db->query("SELECT * FROM `engine4_album_photos` WHERE album_id = ".$album_id." LIMIT 9")->fetchAll();
              foreach($photos as $photoAlbum){
                if( $action instanceof Activity_Model_Action && $count < 9)
                {
                  $photoAlbum = Engine_Api::_()->getItem('album_photo',$photoAlbum['photo_id']);
                  $api->attachActivity($action, $photoAlbum, Activity_Model_Action::ATTACH_MULTI);
                }
              }
                            
              // notify the owner
               Engine_Api::_()->getDbtable('notifications', 'activity')
                  ->addNotification($viewer, $viewer, $album, 'sesmediaimporter_importer');
              
            }
            $db->query("UPDATE `engine4_sesmediaimporter_import` SET params = '".json_encode($data)."' WHERE import_id = ".$result['import_id']);
           }catch(Exception $e){
             if( $e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE ) {
		           if($sesalbum_installed){
                  $album->draft = 0;
                  $album->save();
                }
                $db->query("UPDATE `engine4_sesmediaimporter_import` SET completed = 1 WHERE import_id = ".$result['import_id']);
                $sesmediaLink = '<a href="' . $album->getHref() . '">' . "Please check" . '</a>';
              Engine_Api::_()->getDbtable('notifications', 'activity')
                  ->addNotification($viewer, $viewer, $album, 'sesmediaimporter_import_error',array('sesmediaLink'=>$sesmediaLink));
                throw new Exception($e->getMessage(), $e->getCode());
              }
              throw $e;
           }
           $count++;
         }        
      }  
      return true;
  }
  public function curlUpload($source,$target){
    
    $ch = curl_init($source);
    $fp = fopen($target, "wb");
    
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    return $target;
  }
   public function setPhoto($photo,$isURL = false,$isUploadDirect = false,$viewer = false,$obj)
  {
    $fileName = time().'_album';
    $imageName = $photo;
    $photo = current(explode('?',$photo));
    $PhotoExtension='.'.pathinfo($photo, PATHINFO_EXTENSION);
    if($PhotoExtension == ".")
      $PhotoExtension = ".jpg";
    $filenameInsert=$fileName.$PhotoExtension;
    $fileName = $filenameInsert;
    //$copySuccess=@copy($imageName, APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary/'.$filenameInsert);
    $copySuccess = $this->curlUpload($imageName,APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary/'.$filenameInsert);
    if($copySuccess)
      $file = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary'.DIRECTORY_SEPARATOR.$filenameInsert;
    else	
      return false;
    $name = basename($photo);
    $extension = ltrim(strrchr($name, '.'), '.');
    $base = rtrim(substr(basename($name), 0, strrpos(basename($name), '.')), '.');
    if(!$extension)
      $extension = "jpg";

    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
      'parent_type' => $obj->getType(),
      'parent_id' => $obj->getIdentity(),
      'user_id' => $obj->owner_id,
      'name' => $fileName,
    );

    // Save
    $filesTable = Engine_Api::_()->getDbtable('files', 'storage');

    // Resize image (main)
    $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_m.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
      ->autoRotate()
      ->resize(720, 720)
      ->write($mainPath)
      ->destroy();
    
    // Resize image (normal)
    $normalPath = $path . DIRECTORY_SEPARATOR . $base . '_in.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
      ->autoRotate()
      ->resize(320, 240)
      ->write($normalPath)
      ->destroy();
    
    // Store
    try {
      $iMain = $filesTable->createFile($mainPath, $params);
      $iIconNormal = $filesTable->createFile($normalPath, $params);
      
      $iMain->bridge($iIconNormal, 'thumb.normal');
    } catch( Exception $e ) {
      // Remove temp files
      @unlink($mainPath);
      @unlink($normalPath);
      // Throw
      if( $e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE ) {
        throw new Album_Model_Exception($e->getMessage(), $e->getCode());
      } else {
        throw $e;
      }
    }
    
    // Remove temp files
    @unlink($mainPath);
    @unlink($normalPath);

    // Update row
    $obj->modified_date = date('Y-m-d H:i:s');
    $obj->file_id = $iMain->file_id;
    $obj->save();

    // Delete the old file?
    if( !empty($tmpRow) ) {
      $tmpRow->delete();
    }

    return $obj;
  }
}
