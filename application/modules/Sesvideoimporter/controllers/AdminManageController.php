<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesvideoimporter
 * @package    Sesvideoimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2016-04-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesvideoimporter_AdminManageController extends Core_Controller_Action_Admin
{
	protected function checkDir(){
		$path = APPLICATION_PATH . '/public/sesvideoimporter';
		if (!is_dir($path)){
			@mkdir($path,0777,true);
			return true;
		}
		return true;
	}
  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('videoimporter_admin_main', array(), 'videoimporter_admin_main_manage');

		if(isset($_FILES['pornhub'])){
			set_time_limit(0);
			$uploadPath = APPLICATION_PATH . '/public/sesvideoimporter';
			$id = $_POST['pornhub_id'];
			$return =	$this->checkDir();
			if($return){
				$filename = time().'_'.$_FILES['pornhub']['name'];
				move_uploaded_file($_FILES['pornhub']['tmp_name'],$uploadPath.'/'.$filename);
				$dbGetInsert = Engine_Db_Table::getDefaultAdapter();
				$dbGetInsert->query("UPDATE engine4_sesvideoimporter_imports SET file_path = '".$filename."' , modified_date = NOW() WHERE import_id = ".$id);
			}
		}
		if(isset($_FILES['xtube'])){
			set_time_limit(0);
			$uploadPath = APPLICATION_PATH . '/public/sesvideoimporter';
			$id = $_POST['xtube_id'];
			$return =	$this->checkDir();
			if($return){
				$filename = time().'_'.$_FILES['xtube']['name'];
				move_uploaded_file($_FILES['xtube']['tmp_name'],$uploadPath.'/'.$filename);
				$dbGetInsert = Engine_Db_Table::getDefaultAdapter();
				$dbGetInsert->query("UPDATE engine4_sesvideoimporter_imports SET file_path = '".$filename."' , modified_date = NOW() WHERE import_id = ".$id);
			}
		}
		//importer stats
		$table= Engine_Api::_()->getDbtable('imports', 'sesvideoimporter');
		$tableName = $table->info('name');
    $this->view->paginator = $table->select()
																->from($tableName)
															  ->query()
															  ->fetchAll();																
  }
	public function pornAction(){		
		$error_code = 0;
		set_time_limit(0);
		$page		=	1;
		$pages	=	2;
		$item_id = $this->_getParam('id',false);
		$sleepValue = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesvideoimporter.sleeptime',2);
		$dbGetInsert = Engine_Db_Table::getDefaultAdapter();
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Api::_()->getDbtable('videos', 'sesvideo')->getAdapter();
    $db->beginTransaction();
		$table = Engine_Api::_()->getDbtable('videos', 'sesvideo');
		while(true) {
			try{
				if($page > $pages)
					break;
				$videoResponse	=	$this->getPornVideos($page);
				// If you want to get videos from specific category you should pass second parameter to getRedtubeVideos function which is the name of the category.
				// getRedtubeVideos($page,'CATEGORY_NAME_HERE');
				$videos			=	$videoResponse->result;
				foreach($videos as $video_obj) {
					 $value['code'] = $video_obj->id;
					 $tableName =  $table->info('name');
					 $select = $table->select()->from($tableName,'video_id')->where('code =?',$value['code']);
					 $existsVideo = $select->where('type =?',100)->query()->fetchColumn();
					 //if video exists continue;
					 if($existsVideo)
					 	continue;
					 $video = $table->createRow();
					 $value['title']=$video_obj->title;
					 $value['duration'] = $video_obj->duration;
					 $value['type'] = 100;
					 $imageurl = $video_obj->thumb;
					 $value['status'] = 1;
					  $value['owner_id'] = $viewer->getIdentity();
					 $video->setFromArray($value);
        	 $video->save();
					 $photo_id = $this->setPhoto($imageurl,$video->video_id);
					 $video->photo_id = $photo_id;
					 $video->save();
					 // CREATE AUTH STUFF HERE
					$auth = Engine_Api::_()->authorization()->context;
					$roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
					$auth_view = "everyone";
					$viewMax = array_search($auth_view, $roles);
					foreach ($roles as $i => $role) {
						$auth->setAllowed($video, $role, 'view', ($i <= $viewMax));
					}
					$roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
					$auth_comment = "everyone";
					$commentMax = array_search($auth_comment, $roles);
					foreach ($roles as $i => $role) {
						$auth->setAllowed($video, $role, 'comment', ($i <= $commentMax));
					}
					//tag
					if(isset($video_obj->tags)){
					 $tags = (array) $video_obj->tags;
					 $tagT = '';
					 foreach($tags as $tag){
							$tagT =  $tagT.''.$tag.',';
					 }
					 $tags = preg_split('/[,]+/', $tagT);
      		 $video->tags()->setTagMaps($viewer, $tags);
					}
					 $db->commit();
				}
				$pages	=	$videoResponse->count % 20 == 0 ? $videoResponse->count / 20 : floor($videoResponse->count) / 20;
				$page++;
				$total = current(explode('.',$pages));
				$dbGetInsert->query("UPDATE engine4_sesvideoimporter_imports SET total = ".$total.", page_number = ".$page." , modified_date = NOW() WHERE import_id = ".$item_id);
				unset($videoResponse);
				unset($videos);
				sleep($sleepValue);	 
			} catch(Exception $e){
				// Something is wrong with the response. You should handle that exception.
				echo json_encode(array('error_code'=>1));die;
			}	
		}
		echo json_encode(array('error_code'=>0,'page'=>$page));die;
	
	}
	public function pornhubAction(){
		set_time_limit(0);
		$error_code = 0;
		$item_id = $this->_getParam('id',false);
		$table = Engine_Api::_()->getDbtable('imports', 'sesvideoimporter');
		$tableName =  $table->info('name');
		$pathFile = $table->select()->from($tableName,'file_path')->where('import_id = ?',$item_id)->query()->fetchColumn();
		if(!$pathFile){
			echo json_encode(array('error_code'=>1));die;
		}
		$path = $uploadPath = APPLICATION_PATH . '/public/sesvideoimporter/'.$pathFile;
		$file = fopen($path,"r");
		$counter = 0;
		$sleepValue = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesvideoimporter.sleeptime',2);
		$dbGetInsert = Engine_Db_Table::getDefaultAdapter();
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Api::_()->getDbtable('videos', 'sesvideo')->getAdapter();
    $db->beginTransaction();
		$table = Engine_Api::_()->getDbtable('videos', 'sesvideo');
		$cattable = Engine_Api::_()->getDbtable('categories', 'sesvideo');
		$counter= 0;
		while(! feof($file))
		{
			try{
				$videoData = fgetcsv($file,0,'|');
				$value['code'] = $videoData[0];
				$regex = '/(<iframe.*? src=(\"|\'))(.*?)((\"|\').*)/';
				preg_match($regex, $value['code'], $matches);
				if(count($matches) > 2)
				{
						$matches = $matches[3];
						$value['code'] =  @end(explode('embed/',$matches));
				}else
					continue;
				 $tableName =  $table->info('name');
				 $select = $table->select()->from($tableName,'video_id')->where('code =?',$value['code']);
				 $existsVideo = $select->where('type =?',12)->query()->fetchColumn();
				 //if video exists continue;
				 if($existsVideo)
					continue;
				 //category
				 $category = explode(';',$videoData[5]);
				 foreach($category as $cat){
						$cattableName =  $cattable->info('name');
						$selectCat = $cattable->select()->from($cattableName,'category_id');
						$existsCat = $selectCat->where('category_name =?',$cat)->query()->fetchColumn();
						if($existsCat){
							$value['category_id'] = $cat;
							break;
						}
				 }
				 
				 $video = $table->createRow();
				 $value['title'] = $videoData[3];
				 $imageurl = $videoData[1];
				 $value['duration'] = $videoData[7];
				 $value['type'] = 12;
					$value['status'] = 1;
					$value['owner_id'] = $viewer->getIdentity();
					 $video->setFromArray($value);
        	 $video->save();
					 $photo_id = $this->setPhoto($imageurl,$video->video_id);
					 $video->photo_id = $photo_id;
					 $video->save();
					 // CREATE AUTH STUFF HERE
					$auth = Engine_Api::_()->authorization()->context;
					$roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
					$auth_view = "everyone";
					$viewMax = array_search($auth_view, $roles);
					foreach ($roles as $i => $role) {
						$auth->setAllowed($video, $role, 'view', ($i <= $viewMax));
					}
					$roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
					$auth_comment = "everyone";
					$commentMax = array_search($auth_comment, $roles);
					foreach ($roles as $i => $role) {
						$auth->setAllowed($video, $role, 'comment', ($i <= $commentMax));
					}
					//tag
					$tags = $videoData[4];
					if($tags){
					 $tags = explode(';',$tags);
      		 $video->tags()->setTagMaps($viewer, $tags);
					}
					 $db->commit();
					 $dbGetInsert->query("UPDATE engine4_sesvideoimporter_imports SET total = ".$counter.", page_number = ".$counter." , modified_date = NOW() WHERE import_id = ".$item_id);
					 $counter++;
					 sleep($sleepValue);
			} catch(Exception $e){
				// Something is wrong with the response. You should handle that exception.
				echo json_encode(array('error_code'=>1));die;
			}	
		}
		fclose($file);
		echo json_encode(array('error_code'=>0,'item_import'=>$counter));die;
	}
	
  public function xtubeAction() {

    set_time_limit(0);
    $error_code = 0;
    $item_id = $this->_getParam('id',false);

    $table = Engine_Api::_()->getDbtable('imports', 'sesvideoimporter');
    $tableName =  $table->info('name');

    $pathFile = $table->select()
                    ->from($tableName,'file_path')
                    ->where('import_id = ?',$item_id)
                    ->query()
                    ->fetchColumn();

    if(!$pathFile) {
      echo json_encode(array('error_code'=>1));die;
    }

    $path = $uploadPath = APPLICATION_PATH . '/public/sesvideoimporter/'.$pathFile;
    $file = fopen($path,"r");
    $counter = 0;
    $sleepValue = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesvideoimporter.sleeptime',2);

    $dbGetInsert = Engine_Db_Table::getDefaultAdapter();

    $viewer = Engine_Api::_()->user()->getViewer();

    $db = Engine_Api::_()->getDbtable('videos', 'sesvideo')->getAdapter();
    $db->beginTransaction();

    $table = Engine_Api::_()->getDbtable('videos', 'sesvideo');
    $cattable = Engine_Api::_()->getDbtable('categories', 'sesvideo');

    $counter= 0;

    while(! feof($file)) {
      try {
        $videoData = fgetcsv($file,0,'|');
        $value['code'] = $videoData[1];

        $regex = '/(<iframe.*? src=(\"|\'))(.*?)((\"|\').*)/';
        preg_match($regex, $value['code'], $matches);

        if(count($matches) > 2) {
          $matches = $matches[3];
          $value['code'] =  @end(explode('embed/',$matches));
        } else
          continue;

        $tableName =  $table->info('name');
        $select = $table->select()->from($tableName,'video_id')->where('code =?',$value['code']);
        $existsVideo = $select->where('type =?',17)->query()->fetchColumn();
        //if video exists continue;
        if($existsVideo)
          continue;
        //category

        $category = explode(';',$videoData[5]);
        foreach($category as $cat){
          $cattableName =  $cattable->info('name');
          $selectCat = $cattable->select()->from($cattableName,'category_id');
          $existsCat = $selectCat->where('category_name =?',$cat)->query()->fetchColumn();
          if($existsCat){
            $value['category_id'] = $cat;
            break;
          }
        }

        $video = $table->createRow();
        $value['title'] = $videoData[8];
        $imageurl = $videoData[3];
        $value['duration'] = $videoData[11];
        $value['type'] = 17;
        $value['status'] = 1;
        $value['owner_id'] = $viewer->getIdentity();
        $video->setFromArray($value);
        $video->save();
        $photo_id = $this->setPhoto($imageurl,$video->video_id);
        $video->photo_id = $photo_id;
        $video->save();

        // CREATE AUTH STUFF HERE
        $auth = Engine_Api::_()->authorization()->context;
        $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
        $auth_view = "everyone";
        $viewMax = array_search($auth_view, $roles);
        foreach ($roles as $i => $role) {
          $auth->setAllowed($video, $role, 'view', ($i <= $viewMax));
        }
        $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
        $auth_comment = "everyone";
        $commentMax = array_search($auth_comment, $roles);
        foreach ($roles as $i => $role) {
          $auth->setAllowed($video, $role, 'comment', ($i <= $commentMax));
        }

        //tag
        $tags = $videoData[6];
        if($tags){
        $tags = explode(';',$tags);
        $video->tags()->setTagMaps($viewer, $tags);
        }

        $db->commit();
        $dbGetInsert->query("UPDATE engine4_sesvideoimporter_imports SET total = ".$counter.", page_number = ".$counter." , modified_date = NOW() WHERE import_id = ".$item_id);
        $counter++;
        sleep($sleepValue);
      } catch(Exception $e){
        // Something is wrong with the response. You should handle that exception.
        echo json_encode(array('error_code'=>1));die;
      }	
    }
    fclose($file);
    echo json_encode(array('error_code'=>0,'item_import'=>$counter));die;
  }
	
	
	
	public function redtubeAction(){
		$error_code = 0;
		set_time_limit(0);
		$page		=	1;
		$pages	=	2;
		$item_id = $this->_getParam('id',false);
		$sleepValue = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesvideoimporter.sleeptime',2);
		$dbGetInsert = Engine_Db_Table::getDefaultAdapter();
		$viewer = Engine_Api::_()->user()->getViewer();
		$db = Engine_Api::_()->getDbtable('videos', 'sesvideo')->getAdapter();
    $db->beginTransaction();
		$table = Engine_Api::_()->getDbtable('videos', 'sesvideo');
		while(true) {
			try{
				if($page > $pages)
					break;
				$videoResponse	=	$this->getRedtubeVideos($page);
				// If you want to get videos from specific category you should pass second parameter to getRedtubeVideos function which is the name of the category.
				// getRedtubeVideos($page,'CATEGORY_NAME_HERE');
				$videos			=	$videoResponse->videos;
				foreach($videos as $video) {
					 $video_obj	=	$video->video;
					 $value['code'] = $video_obj->video_id;
					 $tableName =  $table->info('name');
					 $select = $table->select()->from($tableName,'video_id')->where('code =?',$value['code']);
					 $existsVideo = $select->where('type =?',5)->query()->fetchColumn();
					 //if video exists continue;
					 if($existsVideo)
					 	continue;
					 $video = $table->createRow();
					 $value['title']=$video_obj->title;
					 $duration = $video_obj->duration;
					 $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $duration);					
					 sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
					 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
					 $value['duration'] = $time_seconds;
					 $value['type'] = 5;
					 $imageurl = $video_obj->thumb;
					 $value['status'] = 1;
					  $value['owner_id'] = $viewer->getIdentity();
					 $video->setFromArray($value);
        	 $video->save();
					 $photo_id = $this->setPhoto($imageurl,$video->video_id);
					 $video->photo_id = $photo_id;
					 $video->save();
					 // CREATE AUTH STUFF HERE
					$auth = Engine_Api::_()->authorization()->context;
					$roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
					$auth_view = "everyone";
					$viewMax = array_search($auth_view, $roles);
					foreach ($roles as $i => $role) {
						$auth->setAllowed($video, $role, 'view', ($i <= $viewMax));
					}
					$roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
					$auth_comment = "everyone";
					$commentMax = array_search($auth_comment, $roles);
					foreach ($roles as $i => $role) {
						$auth->setAllowed($video, $role, 'comment', ($i <= $commentMax));
					}
					//tag
					if(isset($video_obj->tags)){
					 $tags = (array) $video_obj->tags;
					 $tagT = '';
					 foreach($tags as $tag){
							$tagT =  $tagT.''.$tag->tag_name.',';
					 }
					 $tags = preg_split('/[,]+/', $tagT);
      		 $video->tags()->setTagMaps($viewer, $tags);
					}
					 $db->commit();
				}
				$pages	=	$videoResponse->count % 20 == 0 ? $videoResponse->count / 20 : floor($videoResponse->count) / 20;
				$page++;
				$total = current(explode('.',$pages));
				$dbGetInsert->query("UPDATE engine4_sesvideoimporter_imports SET total = ".$total.", page_number = ".$page." , modified_date = NOW() WHERE import_id = ".$item_id);
				unset($videoResponse);
				unset($videos);
				sleep($sleepValue);	 
			} catch(Exception $e){
				// Something is wrong with the response. You should handle that exception.
				echo json_encode(array('error_code'=>1));die;
			}	
		}
		echo json_encode(array('error_code'=>0,'page'=>$page));die;
	}
	
	
 
	function RedTubeApiCall($http_server, $params = array())
	{
		$query_string	=	'?';
 
		if(is_array($params) && count($params)){
			foreach($params as $k=>$v){
				$query_string .= $k.'='.$v.'&';
			}
			$query_string	=	rtrim($query_string,'&');
		}
		return	file_get_contents($http_server.$query_string);
	}
  function getPornVideos($page = 0, $category = false){
		$http		=	'http://api.porn.com/videos/find.json'; 
		$params		=	array(
			'page'		=>	$page
		);
		$response	=	$this->RedTubeApiCall($http , $params);
		if ($response) {
			$json	=	 json_decode($response);
			if(isset($json->code) && $json->code != 0 && isset($json->message)){
				throw new Exception($json->message, $json->code);
			}
			return $json;
		}
		return false;
		
	}
 
	function getRedtubeVideos($page = 0, $category = false)
	{
		$http		=	'http://api.redtube.com/';
		$call		=	'redtube.Videos.searchVideos';
 
 
		$params		=	array(
			'output'	=>	'json',
			'data'		=>	$call,
			'page'		=>	$page
		);
 
		if($category){
			$params['category']		=	$category;
		}
 
		$response	=	$this->RedTubeApiCall($http , $params);
 
		if ($response) {
			$json	=	 json_decode($response);
			if(isset($json->code) && isset($json->message)){
				throw new Exception($json->message, $json->code);
			}
			return $json;
		}
		return false;
	}
  protected function setPhoto($photo,$id = 0) {
    if (is_string($photo)) {
      $file = $photo;
      $fileName = $photo;
    } else {
      throw new User_Model_Exception('invalid argument passed to setPhoto');
    }
    if (!$fileName) {
      $fileName = $file;
    }
    $name = basename($file);
    $extension = ltrim(strrchr($fileName, '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => 'video',
        'parent_id' => $id,
        'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        'name' => $fileName,
    );
    // Save
    $filesTable = Engine_Api::_()->getDbtable('files', 'storage');
    $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_main.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
            ->resize(500, 500)
            ->write($mainPath)
            ->destroy();
    // Store
    try {
      $iMain = $filesTable->createFile($mainPath, $params);
    } catch (Exception $e) {
      // Remove temp files
      @unlink($mainPath);
      // Throw
      if ($e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE) {
        throw new Sesvideoimporter_Model_Exception($e->getMessage(), $e->getCode());
      } else {
        throw $e;
      }
    }
    // Remove temp files
    @unlink($mainPath);
    // Update row
    // Delete the old file?
    if (!empty($tmpRow)) {
      $tmpRow->delete();
    }
    return $iMain->file_id;
  }
	
}