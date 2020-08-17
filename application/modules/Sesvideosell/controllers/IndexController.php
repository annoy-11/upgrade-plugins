<?php

class Sesvideosell_IndexController extends Core_Controller_Action_Standard {

  public function ordersAction() {
  
    $this->view->user_id = $user_id = $this->_getParam('user_id', null);
    $this->view->user = $user = $user = Engine_Api::_()->getItem('user', $user_id);
    
    $userTableName = Engine_Api::_()->getItemTable('user')->info('name');
    
    $sesvideosellTable = Engine_Api::_()->getDbTable('orders', 'sesvideosell');
    $sesvideosellTableName = $sesvideosellTable->info('name');

    $select = $sesvideosellTable->select()
            ->setIntegrityCheck(false)
            ->from($sesvideosellTableName)
            ->joinLeft($userTableName, "$sesvideosellTableName.user_id = $userTableName.user_id", 'displayname')
            ->where($sesvideosellTableName . '.user_id = ?', $user_id)
            ->where($sesvideosellTableName . '.state = ?', 'complete')
            ->order('order_id DESC');

    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    
  }
  
  public function soldAction() {
  
    $this->view->user_id = $user_id = $this->_getParam('user_id', null);
    $this->view->user = $user = Engine_Api::_()->getItem('user', $user_id);
    
    $userTableName = Engine_Api::_()->getItemTable('user')->info('name');
    
    $sesvideosellTable = Engine_Api::_()->getDbTable('orders', 'sesvideosell');
    $sesvideosellTableName = $sesvideosellTable->info('name');
    $videoTable = Engine_Api::_()->getDbTable('videos', 'sesvideo');
    $videoTableName = $videoTable->info('name');
    
    $select = $sesvideosellTable->select()
            ->setIntegrityCheck(false)
            ->from($sesvideosellTableName)
            ->joinLeft($userTableName, "$sesvideosellTableName.user_id = $userTableName.user_id", 'displayname')
            ->join($videoTableName, "$videoTableName.video_id = $sesvideosellTableName.video_id", null)
            ->where($videoTableName . '.owner_id = ?', $user_id)
            ->where($sesvideosellTableName . '.state = ?', 'complete')
            ->order($sesvideosellTableName .'.order_id DESC');

    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    
  }

  //Download song action
  public function downloadAction() {

    $video = Engine_Api::_()->getItem('sesvideo_video', $this->_getParam('video_id'));

    $storage = Engine_Api::_()->getItem('storage_file', $video->file_id);

    if($storage->service_id == 2) {
      $servicesTable = Engine_Api::_()->getDbtable('services', 'storage');
      $result  = $servicesTable->select()
                  ->from($servicesTable->info('name'), 'config')
                  ->where('service_id = ?', $storage->service_id)
                  ->limit(1)
                  ->query()
                  ->fetchColumn();
      $serviceResults = Zend_Json_Decoder::decode($result);
      if($serviceResults['baseUrl']) {
        $path = 'http://' . $serviceResults['baseUrl'] . '/' . $storage->storage_path;
      } else {
        $path = 'http://' . $serviceResults['bucket'] . '.s3.amazonaws.com/' . $storage->storage_path;
      }
    } else {
      //Song file name and path
      $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . $storage->storage_path;
    }

    //KILL ZEND'S OB
    while (ob_get_level() > 0) {
      ob_end_clean();
    }

//     $video->download_count++;
//     $video->save();
    
    $baseName = $storage->name . '.' . $storage->extension;

    header("Content-Disposition: attachment; filename=" . urlencode(basename($baseName)), true);
    header("Content-Transfer-Encoding: Binary", true);
    header("Content-Type: application/force-download", true);
    header("Content-Type: application/octet-stream", true);
    header("Content-Type: application/download", true);
    header("Content-Description: File Transfer", true);
    header("Content-Length: " . filesize($path), true);
    readfile("$path");
    exit();
    return;
  }
}