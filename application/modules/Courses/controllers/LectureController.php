<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: LectureController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_LectureController extends Core_Controller_Action_Standard
{
    public function init() {
    }
    public function createAction() {
        if (!$this->_helper->requireAuth()->setAuthParams('courses', null, 'lec_create')->isValid())
          return;
        if (!$this->_helper->requireUser->isValid())
          return;
        $viewer = $this->view->viewer();
        $sessmoothbox = $this->view->typesmoothbox = false;
        if ($this->_getParam('typesmoothbox', false)) {
          // Render
          $sessmoothbox = true;
          $this->view->typesmoothbox = true;
        }  else { 
          $this->_helper->content->setEnabled();
        }
        $this->view->courseId = $courseId = $this->_getParam('course_id',false);
        $this->view->course = $course = Engine_Api::_()->getItem('courses', $courseId);
        $totalLecture = Engine_Api::_()->getDbTable('lectures', 'courses')->countLectures($viewer->getIdentity());
        $allowLectureCount = Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'lecture_count');
        $this->view->createLimit = 1;
        if ($totalLecture >= $allowLectureCount && $allowLectureCount != 0) {
          $this->view->createLimit = 0;
        } else {
            $this->view->form = $form = new Courses_Form_Lecture_Create();
        }
        // If not post or form not valid, return
        if( !$this->getRequest()->isPost() ) {
          return;
        }

        if( !$form->isValid($this->getRequest()->getPost()) ) {
          return;
        }
        $values = $form->getValues();
        $lectureTable = Engine_Api::_()->getDbTable('lectures', 'courses');
        $db = $lectureTable->getAdapter();
        $db->beginTransaction();
        try {
            $viewer = Engine_Api::_()->user()->getViewer();
            if (isset($_POST['title']) && !empty($_POST['title']))
                $values['title'] = $_POST['title'];
            if (isset($_POST['as_preview']) && !empty($_POST['as_preview']))
                $values['as_preview'] = $_POST['as_preview'];
            if (isset($_POST['description']) && !empty($_POST['description']))
                $values['description'] = $_POST['description'];
            if (isset($_POST['description']) && !empty($_POST['description']))
                $values['timer'] = $_POST['timer'];
            if (isset($_POST['type']) && !empty($_POST['type']))
                $values['type'] = $_POST['type'];
            if (isset($_FILES['Filedata']) && !empty($_FILES['Filedata']['name']))
               $_POST['id'] = $this->uploadVideoAction();
        if($values['type'] == 'external') {
            $information = $this->handleIframelyInformation($_POST['url']);
            if (empty($information)) {
                $form->addError('We could not find a video there - please check the URL and try again.');
                return;
            }
            $values['code'] = $information['code'];
            $values['thumbnail'] = $information['thumbnail'];
            $values['duration'] = $information['duration'];
        }  else if ($values['type'] == 'html') {
            $values['code'] = Engine_Text_BBCode::prepare($_POST['htmltext']);
        } else if($values['type'] == 'internal') {
            $lecture = Engine_Api::_()->getItem('courses_lecture', $this->_getParam('id'));
            if(empty($lecture)){
                $lecture = $lectureTable->createRow();
            }
        } 
        if(empty($lecture)) {
            $lecture = $lectureTable->createRow();
        }
        if ($values['type'] == 'internal' && isset($_FILES['photo_id']['name']) && $_FILES['photo_id']['name'] != '') {
            $values['photo_id'] = $this->setPhoto($form->photo_id, $lecture->lecture_id, true);
        }
        $values['course_id'] = $course->course_id;
        $values['owner_id'] = $viewer->getIdentity();
        $lecture->setFromArray($values);
        $lecture->save();

        $thumbnail = $values['thumbnail'];
        $ext = ltrim(strrchr($thumbnail, '.'), '.');
        $thumbnail_parsed = @parse_url($thumbnail);
        $tmp_file = APPLICATION_PATH . '/temporary/link_' . md5($thumbnail) . '.' . $ext;
        $content = $this->url_get_contents($thumbnail);
        
        if ($content) {
              $valid_thumb = true;
              file_put_contents($tmp_file, $content);
        } else {
              $valid_thumb = false;
        }
        if( isset($_FILES['photo_id']['name']) && $_FILES['photo_id']['name'] != ''){
            $lecture->photo_id = $this->setPhoto($form->photo_id,  $lecture->lecture_id, true);
            $lecture->save();
        } else if($valid_thumb && $thumbnail && $ext && $thumbnail_parsed && in_array($ext, array('jpg', 'jpeg', 'gif', 'png'))) {
          $thumb_file = APPLICATION_PATH . '/temporary/link_thumb_' . md5($thumbnail) . '.' . $ext;
            //resize video thumbnails
            $image = Engine_Image::factory();
            $image->open($tmp_file)
                    ->resize(500, 500)
                    ->write($thumb_file)
                    ->destroy();
            try {
            $thumbFileRow = Engine_Api::_()->storage()->create($thumb_file, array(
                'parent_type' => 'courses_lecture',
                'parent_id' => $lecture->lecture_id,
            ));
            // Remove temp file
            @unlink($thumb_file);
            @unlink($tmp_file);
            $lecture->photo_id = $thumbFileRow->file_id;
            $lecture->save();
            } catch (Exception $e){
            throw $e;
            @unlink($thumb_file);
            @unlink($tmp_file);
            }
        }
        $course->lecture_count++;
        $course->save();
        $db->commit();
        $users = Engine_Api::_()->getDbtable('ordercourses', 'courses')->getCoursePurchasedMember($course->course_id);
        $lectureTitle = '<a href="'.$lecture->getHref().'">'.$lecture->getTitle().'</a>';
        $courseTitle = '<a href="'.$course->getHref().'">'.$course->getTitle().'</a>';
        foreach($users as $user){
          $user = Engine_Api::_()->getItem('user', $user->user_id);
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($user, $viewer, $course, 'courses_lecture_create',array('lecture'=>$lectureTitle));
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_courses_lecture_create', array('lecture_title' => $lectureTitle, 'course_name' => $courseTitle,'sender_title' => $viewer->getTitle(), 'object_link' => $user->getHref(), 'host' => $_SERVER['HTTP_HOST']));
            //Activity Feed work
          $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($user, $course, "courses_lecture_create");
          if ($action) {
            Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $course);
          }
        }
          return $this->_helper->redirector->gotoRoute(array('course_id' => $course->custom_url,'action'=>'manage-lectures'), 'courses_dashboard', true);
        }catch(Exception $e){
          $db->rollBack();
          throw $e;
        }
    }
    public function editAction() {
        if (!$this->_helper->requireAuth()->setAuthParams('courses', null, 'lec_edit')->isValid())
            return;
        if (!$this->_helper->requireUser->isValid())
            return;
        $viewer = $this->view->viewer();
        $sessmoothbox = $this->view->typesmoothbox = false;
        if ($this->_getParam('typesmoothbox', false)) {
          // Render
          $sessmoothbox = true;
          $this->view->typesmoothbox = true;
        } 
        $this->view->lectureId = $lectureId = $this->_getParam('lecture_id',false);
        $format = $this->_getParam('format',false);
        $this->view->lecture = $lecture = Engine_Api::_()->getItem('courses_lecture', $lectureId);
        $this->view->form = $form = new Courses_Form_Lecture_Edit();
        $this->view->type = $lecture->type; 
        $form->populate($lecture->toArray());
        $form->populate(
            array('htmltext'=>$lecture->code)
        ); 
        if (!$this->getRequest()->isPost()) {
            return;
        }
        $values = $form->getValues(); 
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();  
        try {
            $viewer = Engine_Api::_()->user()->getViewer();
            $course = Engine_Api::_()->getItem('courses', $lecture->course_id);
            $values['type'] = $lecture->type;
            if (isset($_POST['title']) && !empty($_POST['title']))
                $values['title'] = $_POST['title'];
            if (isset($_POST['description']) && !empty($_POST['description']))
                $values['description'] = $_POST['description'];
            if (isset($_POST['description']) && !empty($_POST['description']))
                $values['timer'] = $_POST['timer'];
            $values['as_preview'] = $_POST['as_preview'];
        if($values['type'] == 'external') {
             if (!empty($_POST['url'])) {
                $information = $this->handleIframelyInformation($_POST['url']);
                $values['code'] = $information['code'];
                $values['thumbnail'] = $information['thumbnail'];
                $values['duration'] = $information['duration'];
            }
        }  else if ($values['type'] == 'html') {
            $values['code'] = Engine_Text_BBCode::prepare($_POST['htmltext']);
        } else if($values['type'] == 'internal') {
             
        } 
        if ($values['type'] == 'internal' && isset($_FILES['photo_id']['name']) && $_FILES['photo_id']['name'] != '') { die;
            $values['photo_id'] = $this->setPhoto($form->photo_id, $lecture->lecture_id, true);
        } 
        $values['owner_id'] = $viewer->getIdentity();
        if(empty($values['photo_id']))
          $values['photo_id'] = $lecture->photo_id;
        $lecture->setFromArray($values);
        $lecture->save();

        $thumbnail = $values['thumbnail'];
        $ext = ltrim(strrchr($thumbnail, '.'), '.');
        $thumbnail_parsed = @parse_url($thumbnail);

        if (@GetImageSize($thumbnail)) {
            $valid_thumb = true;
        } else {
            $valid_thumb = false;
        }

        if( isset($_FILES['photo_id']['name']) && $_FILES['photo_id']['name'] != ''){
            $lecture->photo_id = $this->setPhoto($form->photo_id,  $lecture->lecture_id, true);
            $lecture->save();
        } else if($valid_thumb && $thumbnail && $ext && $thumbnail_parsed && in_array($ext, array('jpg', 'jpeg', 'gif', 'png'))) { 
            $tmp_file = APPLICATION_PATH . '/temporary/link_' . md5($thumbnail) . '.' . $ext;
            $thumb_file = APPLICATION_PATH . '/temporary/link_thumb_' . md5($thumbnail) . '.' . $ext;
            $src_fh = fopen($thumbnail, 'r');
            $tmp_fh = fopen($tmp_file, 'w');
            stream_copy_to_stream($src_fh, $tmp_fh, 1024 * 1024 * 2);
            //resize video thumbnails
            $image = Engine_Image::factory();
            $image->open($tmp_file)
                    ->resize(500, 500)
                    ->write($thumb_file)
                    ->destroy();
            try {
              $thumbFileRow = Engine_Api::_()->storage()->create($thumb_file, array(
                  'parent_type' => 'courses_lecture',
                  'parent_id' => $lecture->lecture_id,
              ));
              // Remove temp file
              @unlink($thumb_file);
              @unlink($tmp_file);
              $lecture->file_id = $thumbFileRow->file_id;
              $lecture->save();
            } catch (Exception $e){
              throw $e;
              @unlink($thumb_file);
              @unlink($tmp_file);
            }
        }
        $db->commit();
          if($format && !$this->_getParam('course_id', false)){
            $this->view->message = Zend_Registry::get('Zend_Translate')->_('The selected lecture has been edited.');
            return $this->_forward('success', 'utility', 'core', array('smoothboxClose' => 10,'parentRefresh' => 10,'messages' => array($this->view->message)
                ));
          } else {
            return $this->_helper->redirector->gotoRoute(array('course_id' => $course->custom_url,'action'=>'manage-lectures'), 'courses_dashboard', true);
          }
        }catch(Exception $e){
            $db->rollBack();
            throw $e;
        }
    }
    public function validationAction() {
        $url = trim(strip_tags($this->_getParam('uri')));
        $ajax = $this->_getParam('ajax', false);
        $information = $this->handleIframelyInformation($url);
        $this->view->ajax = $ajax;
        $this->view->valid = !empty($information['code']);
        $this->view->iframely = $information;
    }
    public function handleIframelyInformation($uri) {
        $iframelyDisallowHost = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses_iframely_disallow');
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
        }//canonical
        if (!empty($iframely['meta']['title'])) {
            $information['title'] = $iframely['meta']['title'];
        }
        if (!empty($iframely['meta']['description'])) {
            $information['description'] = $iframely['meta']['description'];
        }
        if (!empty($iframely['meta']['duration'])) {
            $information['duration'] = $iframely['meta']['duration'];
        } else {
          $video_id = explode("?v=", $iframely['meta']['canonical']);
          $video_id = $video_id[1];
          $information['duration'] = $this->YoutubeVideoInfo($video_id);
        }
        if(!empty($information['duration']))
          $information['duration'] = Engine_Date::convertISO8601IntoSeconds($information['duration']);
        $information['status'] = 1;
        $information['code'] = $iframely['html'];
        return $information;
    }
    public function YoutubeVideoInfo($video_id) {
        $url = 'https://www.googleapis.com/youtube/v3/videos?id='.$video_id.'&key=AIzaSyDYwPzLevXauI-kTSVXTLroLyHEONuF9Rw&part=snippet,contentDetails';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        return  $response_a->items[0]->contentDetails->duration; //get video duaration
    }
    protected function setPhoto($photo, $id) {
        if ($photo instanceof Zend_Form_Element_File) {
            $file = $photo->getFileName();
            $fileName = $file;
        } else if ($photo instanceof Storage_Model_File) {
            $file = $photo->temporary();
            $fileName = $photo->name;
        } else if ($photo instanceof Core_Model_Item_Abstract && !empty($photo->photo_id)) {
            $tmpRow = Engine_Api::_()->getItem('storage_file', $photo->photo_id);
            $file = $tmpRow->temporary();
            $fileName = $tmpRow->name;
        } else if (is_array($photo) && !empty($photo['tmp_name'])) {
            $file = $photo['tmp_name'];
            $fileName = $photo['name'];
        } else if (is_string($photo) && file_exists($photo)) {
            $file = $photo;
            $fileName = $photo;
        } else {
            throw new Exception('invalid argument passed to setPhoto');
        }
        if (!$fileName) {
            $fileName = $file;
        }
        $name = basename($file);
        $extension = ltrim(strrchr($fileName, '.'), '.');
        $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
        $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
        $params = array(
            'parent_type' => 'courses_lecture',
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
        try {
        $iMain = $filesTable->createFile($mainPath, $params);
        } catch (Exception $e) {
        // Remove temp files
        @unlink($mainPath);
        // Throw
        if ($e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE) {
            throw new Exception($e->getMessage(), $e->getCode());
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
    public function deleteAction()
    {
        // In smoothbox
        $this->_helper->layout->setLayout('default-simple');
        $id = $this->_getParam('lecture_id');
        if($this->_getParam('is_Ajax_Delete',null) && $id) {
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try
            {
                  $lecture = Engine_Api::_()->getItem('courses_lecture', $id);
                  $course = Engine_Api::_()->getItem('courses', $lecture->course_id);
                  $course->lecture_count--;
                  $course->save();
              //  delete the lecture entry into the database
                  $lecture->delete();              
                  $db->commit();
                  echo json_encode(array('status'=>1));die;
            }
            catch( Exception $e )
            {
                $db->rollBack();
                throw $e;
            }
             echo json_encode(array('status'=>0));die;
        }
        $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
        $form->setTitle('Delete Lecture?');
        $form->setDescription('Are you sure that you want to delete this Lecture? It will not be recoverable after being deleted.');
        $form->submit->setLabel('Delete');
        $this->view->lecture_id = $id;
        // Check post
        if($this->getRequest()->isPost())
        {
          $db = Engine_Db_Table::getDefaultAdapter();
          $db->beginTransaction();
          try
          {
              $lecture = Engine_Api::_()->getItem('courses_lecture', $id);
              $course = Engine_Api::_()->getItem('courses', $lecture->course_id);
              $course->lecture_count--;
              $course->save();
              // delete the lecture entry into the database
              $lecture->delete();
              $db->commit();
          }
          catch( Exception $e )
          {
              $db->rollBack();
              throw $e;
          }
           return $this->_forward('success', 'utility', 'core', array(
                'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'browse'), 'courses_general', true),
                'messages' => array('Your Lecture has been  Deleted successfully')
          ));
        }
    }
    public function uploadVideoAction() { 
        if (!$this->_helper->requireUser()->checkRequire()) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Max file size limit exceeded (probably).');
            return;
        }
        if (!$this->getRequest()->isPost()) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
            return;
        }
        $values = $this->getRequest()->getPost();
        if (empty($_FILES['Filedata'])) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('No file');
            return;
        }
        $illegal_extensions = array('php', 'pl', 'cgi', 'html', 'htm', 'txt','zip');
        if (in_array(pathinfo($_FILES['Filedata']['name'], PATHINFO_EXTENSION), $illegal_extensions)) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid Upload');
            return;
        } 
        $uploadwall = $this->_getParam('uploadwall',0);
        $db = Engine_Api::_()->getDbtable('lectures', 'courses')->getAdapter();
        $db->beginTransaction();
    try {
      $viewer = Engine_Api::_()->user()->getViewer();
      $values['owner_id'] = $viewer->getIdentity();
      $params = array(
          'owner_type' => 'user',
          'owner_id' => $viewer->getIdentity()
      );
      $lecture = $this->createVideo($params, $_FILES['Filedata'], $values);
      $lecture->save();
      $db->commit();
      return $lecture->lecture_id;
    } catch (Exception $e) {
      $db->rollBack();
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('An error occurred.') . $e;
      // throw $e;
      return;
    }
  }
  public function createVideo($params, $file, $values,$lecture_date = false) { 
    if ($file instanceof Storage_Model_File) { 
      $params['file_id'] = $file->getIdentity();
    } else { 
      // create video item
    if(!$lecture_date){
      	$lecture = Engine_Api::_()->getDbtable('lectures', 'courses')->createRow();
      	$file_ext = pathinfo($file['name']);
				$file_ext = $file_ext['extension'];
			}else{
        $lecture = $lecture_date;
    }
    $lecture->owner_id = $params['owner_id'];
    $lecture->status = 2;
    $lecture->save();
      // Store video in temporary storage object for ffmpeg to handle
      $storage = Engine_Api::_()->getItemTable('storage_file');
			$params = array(
          'parent_id' => $lecture->lecture_id,
          'parent_type' => $lecture->getType(),
          'user_id' => $lecture->owner_id,
          'mime_major' => 'video',
          'mime_minor' => $file_ext,
      );
    if(!$lecture_date){ 
        $lecture->code = $file_ext;
      	$storageObject = $storage->createFile($file, $params); 
        $lecture->file_id = $file_id = $storageObject->file_id; 
    }
    // Remove temporary file
    @unlink($file['tmp_name']);
        $file = Engine_Api::_()->getItemTable('storage_file')->getFile($file_id, null); 
        $file = (_ENGINE_SSL ? 'https://' : 'http://')
            . $_SERVER['HTTP_HOST'].$file->map(); 
        $lecture->duration = $duration = $this->getVideoDuration($lecture,$file);
        if($duration){
            $thumb_splice = $duration / 2;
            $this->getVideoThumbnail($lecture,$thumb_splice,$file);
        }
    $lecture->status = 1;
    $lecture->save();
      // Add to jobs
      Engine_Api::_()->getDbtable('jobs', 'core')->addJob('lecture_encode', array('lecture_id' => $lecture->getIdentity(), ));
    }
    return $lecture;
  }
  public function getVideoThumbnail($lecture,$thumb_splice,$file = false){ 
		$tmpDir = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary' . DIRECTORY_SEPARATOR . 'video';
		$thumbImage = $tmpDir . DIRECTORY_SEPARATOR . $lecture -> getIdentity() . '_thumb_image.jpg';
		$ffmpeg_path = Engine_Api::_() -> getApi('settings', 'core') ->video_ffmpeg_path;
		if (!@file_exists($ffmpeg_path) || !@is_executable($ffmpeg_path))
		{
			$output = null;
			$return = null;
			exec($ffmpeg_path . ' -version', $output, $return);
			if ($return > 0)
			{
				return 0;
			}
		}
		if(!$file)
			$fileExe = $lecture->code;
		else
			$fileExe = $file;
		$output = PHP_EOL;
		$output .= $fileExe . PHP_EOL;
		$output .= $thumbImage . PHP_EOL;
		$thumbCommand = $ffmpeg_path . ' ' . '-i ' . escapeshellarg($fileExe) . ' ' . '-f image2' . ' ' . '-ss ' . $thumb_splice . ' ' . '-vframes ' . '1' . ' ' . '-v 2' . ' ' . '-y ' . escapeshellarg($thumbImage) . ' ' . '2>&1';
		// Process thumbnail
		$thumbOutput = $output . $thumbCommand . PHP_EOL . shell_exec($thumbCommand);
		// Check output message for success
		$thumbSuccess = true;
		if (preg_match('/video:0kB/i', $thumbOutput))
		{
			$thumbSuccess = false;
		}
		// Resize thumbnail
		if ($thumbSuccess && is_file($thumbImage))
		{
			try
			{
				$image = Engine_Image::factory();
				$image->open($thumbImage)->resize(500, 500)->write($thumbImage)->destroy();
				$thumbImageFile = Engine_Api::_()->storage()->create($thumbImage, array(
					'parent_id' => $lecture -> getIdentity(),
					'parent_type' => $lecture -> getType(),
					'user_id' => $lecture -> owner_id
					)
				);
				$lecture->photo_id = $thumbImageFile->file_id;
				$lecture->save();
				@unlink($thumbImage);
				return true;
			}
			catch (Exception $e)
			{
				throw $e;
				@unlink($thumbImage);
			}
		}
		 @unlink(@$thumbImage);
		 return false;
	}
	public function getVideoDuration($lecture,$file = false)
	{ 
		$duration = 0;
		if ($lecture)
		{
      $ffmpeg_path = Engine_Api::_() -> getApi('settings', 'core') -> video_ffmpeg_path;
      if (!@file_exists($ffmpeg_path) || !@is_executable($ffmpeg_path))
      {
          $output = null;
          $return = null;
          exec($ffmpeg_path . ' -version', $output, $return);
          if ($return > 0)
          {
              return 0;
          }
      }
      if(!$file)
          $fileExe = $lecture->code;
      else
          $fileExe = $file;
      // Prepare output header
      $fileCommand = $ffmpeg_path . ' ' . '-i ' . escapeshellarg($fileExe) . ' ' . '2>&1';
      // Process thumbnail
      $fileOutput = shell_exec($fileCommand);
      // Check output message for success
      $infoSuccess = true;
      if (preg_match('/video:0kB/i', $fileOutput))
      {
          $infoSuccess = false;
      }
      // Resize thumbnail
      if ($infoSuccess)
      {
        // Get duration of the video to caculate where to get the thumbnail
        if (preg_match('/Duration:\s+(.*?)[.]/i', $fileOutput, $matches))
        {
            list($hours, $minutes, $seconds) = preg_split('[:]', $matches[1]);
            $duration = ceil($seconds + ($minutes * 60) + ($hours * 3600));
        }
      }
		}
		return $duration;
	}
  public function viewAction() {
    $this->view->lecture_id = $lecture_id = $this->getRequest()->getParam('lecture_id', '0');
    $this->view->user_id = $user_id = $this->getRequest()->getParam('user_id', '0');
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->lecture = $lecture = Engine_Api::_()->getItem('courses_lecture',$lecture_id);
     Engine_Api::_()->core()->setSubject($lecture);
    if ($viewer->getIdentity() != 0 && isset($lecture->lecture_id)) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_courses_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $lecture->lecture_id . '", "courses_lecture","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
    }
    if ($this->_getParam('typesmoothbox', false)) {
      $this->view->lecture = $lecture = Engine_Api::_()->getItem('courses_lecture',$lecture_id);
      $this->view->user = $user = Engine_Api::_()->getItem('user', $user_id);
      $course = Engine_Api::_()->getItem('courses', $lecture->course_id);
      $privateImageURL = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbasic.private.photo', 1);
      if (!is_file($privateImageURL))
        $privateImageURL = 'application/modules/Courses/externals/images/private-video.jpg';
      if (!$course->authorization()->isAllowed($viewer, 'view')) {
        $this->view->imagePrivateURL = $privateImageURL;
      }
      $this->view->canComment = $course->authorization()->isAllowed($viewer, 'comment');
      /* Insert data for recently viewed widget */
      if ($viewer->getIdentity() != 0 && isset($course->lecture_id)) {
        $dbObject = Engine_Db_Table::getDefaultAdapter();
        $dbObject->query('INSERT INTO engine4_courses_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $lecture->lecture_id . '", "courses_lecture","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
      }
      $this->view->type = $type = $this->_getParam('type');
      // get next video URL
      $this->view->nextVideo = Engine_Api::_()->getDbTable('lectures', 'courses')->videoLightBox($lecture, '>','','',$type,$this->_getParam('item_id',''));
      // get previous video URL
      $this->view->previousVideo = Engine_Api::_()->getDbTable('lectures', 'courses')->videoLightBox($lecture, '<','','',$type,$this->_getParam('item_id',''));
      if (!$viewer || !$viewer->getIdentity() || !$lecture->isOwner($viewer)) {
        $lecture->view_count = new Zend_Db_Expr('view_count + 1');
        $lecture->save();
      }
      if ($lecture->type == "internal") {
        if (!empty($lecture->file_id)) {
          $storage_file = Engine_Api::_()->getItem('storage_file', $lecture->file_id);
          if ($storage_file) {
            $this->view->lecture_location = $storage_file->map();
            $this->view->lecture_extension = $storage_file->extension;
          }
        }
      }
      $viewer = Engine_Api::_()->user()->getViewer();
      $this->view->lectureEmbedded = $lecture->code;
      $this->view->canEdit = $canEdit = $course->authorization()->isAllowed($viewer, 'edit');
      $this->view->canDelete = $canDelete = $course->authorization()->isAllowed($viewer, 'delete');
      $this->renderScript('lecture/lecture-lightbox-viewer.tpl');
    } else {
      $this->_helper->content->setEnabled();
    }
		$this->view->customParamsArray = $customParamsArray;
  }
  public function imageviewerdetailAction() {
    $this->view->lecture = $lecture = Engine_Api::_()->getItem('courses_lecture',$lecture_id);
    $this->view->user = $user = Engine_Api::_()->getItem('user', $user_id);
    $course = Engine_Api::_()->getItem('courses', $lecture->course_id);
		$privateImageURL = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbasic.private.photo', 1);
		if (!is_file($privateImageURL))
			$privateImageURL = 'application/modules/Courses/externals/images/private-video.jpg';
    if (!$course->authorization()->isAllowed($viewer, 'view')) {
      $this->view->imagePrivateURL = $privateImageURL;
    }
    $this->view->canComment = $course->authorization()->isAllowed($viewer, 'comment');
    /* Insert data for recently viewed widget */
    if ($viewer->getIdentity() != 0 && isset($course->lecture_id)) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_courses_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $lecture->lecture_id . '", "courses_lecture","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
    }
		$this->view->type = $type = $this->_getParam('type');
		 // get next video URL
    $this->view->nextVideo = Engine_Api::_()->getDbTable('lectures', 'courses')->videoLightBox($lecture, '>','','',$type,$this->_getParam('item_id',''));
    // get previous video URL
    $this->view->previousVideo = Engine_Api::_()->getDbTable('lectures', 'courses')->videoLightBox($lecture, '<','','',$type,$this->_getParam('item_id',''));
    if (!$viewer || !$viewer->getIdentity() || !$lecture->isOwner($viewer)) {
      $lecture->view_count = new Zend_Db_Expr('view_count + 1');
      $lecture->save();
    }
    if ($lecture->type == "internal") {
      if (!empty($lecture->file_id)) {
        $storage_file = Engine_Api::_()->getItem('storage_file', $lecture->file_id);
        if ($storage_file) {
          $this->view->lecture_location = $storage_file->map();
          $this->view->lecture_extension = $storage_file->extension;
        }
      }
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->lectureEmbedded = $lecture->code;
    $this->view->canEdit = $canEdit = $course->authorization()->isAllowed($viewer, 'edit');
    $this->view->canDelete = $canDelete = $course->authorization()->isAllowed($viewer, 'delete');
    $this->renderScript('lecture/image-viewer-detail-basic.tpl');
  }
  function url_get_contents ($Url) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $Url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      $output = curl_exec($ch);
      curl_close($ch);
      return $output;
  }
}
