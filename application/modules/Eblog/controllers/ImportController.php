  <?php
class Eblog_ImportController extends Core_Controller_Action_Standard {
  public function indexAction() {
    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('eblog_blog', null, 'create')->isValid()) return;
    $this->view->form = $form = new Eblog_Form_Import();
     // If not post or form not valid, return
    if( !$this->getRequest()->isPost() )
    return;
    if( !$form->isValid($this->getRequest()->getPost()) )
    return;
    if (empty($values['file_data'])) {
        $form->addError($this->view->translate("Blog XML File * Please complete this field - it is required."));
        return;
    }
    $file = $form->getElement ( 'file_data' );
    $path = $file->getDestination () . DIRECTORY_SEPARATOR . $file->getValue ();
    $xml = simplexml_load_file($path);
    if($_POST['import_type'] == 1) {
      $posts = array();
      if (empty($_FILES['file_data']['name'])) {
        $form->addError('Please select blogger xml file you want to import here.');
        return;
      }
      $xml =  $xml->entry;
      foreach( $xml as $row ) {
        $posts[] = array(
          "title"=>$row->title,
          "content"=>$row->content,
          "import_type" => 1,
        );
      }
      $this->importBlogs($posts);
    }elseif($_POST['import_type'] == 2) {
      $posts = array();
      if (empty($_FILES['file_data']['name'])) {
        $form->addError('Please select wordpress xml file you want to import here.');
        return;
      }
      foreach($xml->channel->item as $item) {
        $content = $item->children('http://purl.org/rss/1.0/modules/content/');
        $posts[] = array(
        "title"=>$item->title,
        "content"=>$content->encoded,
        "import_type" => 2,
        );
      }
      $this->importBlogs($posts);
    }elseif($_POST['import_type'] == 3) {
      if(empty($_POST['user_name'])) {
        $form->addError ('Username can not be empty.');
        return;
      }
      $i = 0;
      $posts = array();
      $finish = true;
      $counter = 1;
      $arrayCounter = 0;
      do {
        $fileUrl = "http://".$_POST['user_name'].".tumblr.com/api/read/json?start=".$i."&num=50";
        $content = @file_get_contents ( $fileUrl );
        $subContent  = preg_replace('#var tumblr_api_read = (.*);#','$1',$content);;
        $data = json_decode($subContent, true);
        foreach($data['posts'] as $item) {
          $posts[$arrayCounter] = array(
            "title"=>$item['regular-title'],
            "content"=>$item['regular-body'],
            "import_type" => 3,
          );
          $arrayCounter++;
        }
        $total = $data['posts-total'];
        $i = ($arrayCounter);
        if(ceil($total/50) <= $counter) {
          $finish = false;
        }
        ++$counter;
      }
      while($finish);
      $this->importBlogs($posts);
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'),'eblog_general',true);
  }
  public function importBlogs($posts) {
    foreach($posts as $post) {
      $title = $post['title'];
      if(!$title)
        continue;
      // Process
      $table = Engine_Api::_()->getDbtable('blogs', 'eblog');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        // Create eblog
        $viewer = Engine_Api::_()->user()->getViewer();
        $values = array();
        $eblog = $table->createRow();
        $eblog->ip_address = $_SERVER['REMOTE_ADDR'];
        $eblog->title = htmlspecialchars_decode($title);
        $eblog->body = $post['content'];
        $eblog->owner_type = $viewer->getType();
        $eblog->owner_id = $viewer->getIdentity();
        $eblog->category_id = 0;
        $eblog->subcat_id = 0;
        $eblog->subsubcat_id = 0;
        $eblog->is_approved = 1;
        $eblog->seo_title = $title;
        if(isset($eblog->package_id) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('eblogpackage') ){
          $package_id = Engine_Api::_()->getDbTable('packages','eblogpackage')->getDefaultPackage();
          $eblog->package_id = $package_id;
        }
        $eblog->save();
        $blog_id = $eblog->blog_id;
        $eblog->custom_url = $blog_id;
        $roleTable = Engine_Api::_()->getDbtable('roles', 'eblog');
        $row = $roleTable->createRow();
        $row->blog_id = $blog_id;
        $row->user_id = $viewer->getIdentity();
        $row->save();
        // Auth
        $auth = Engine_Api::_()->authorization()->context;
        $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
        $values['auth_view'] = 'everyone';
        $values['auth_comment'] = 'everyone';
        $viewMax = array_search($values['auth_view'], $roles);
        $commentMax = array_search($values['auth_comment'], $roles);
        $videoMax = array_search(isset($values['auth_video']) ? $values['auth_video']: '', $roles);
        $musicMax = array_search(isset($values['auth_music']) ? $values['auth_music']: '', $roles);
        foreach( $roles as $i => $role ) {
          $auth->setAllowed($eblog, $role, 'view', ($i <= $viewMax));
          $auth->setAllowed($eblog, $role, 'comment', ($i <= $commentMax));
          $auth->setAllowed($eblog, $role, 'video', ($i <= $videoMax));
          $auth->setAllowed($eblog, $role, 'music', ($i <= $musicMax));
        }
        $eblog->save();
        // Add activity only if eblog is published
  //       if( $values['draft'] == 0 && $values['is_approved'] == 1 && (!$eblog->publish_date || strtotime($eblog->publish_date) <= time())) {
  //         $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $eblog, 'eblog_new');
  //         // make sure action exists before attaching the eblog to the activity
  //         if( $action ) {
  //           Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $eblog);
  //         }
  //         //Send notifications for subscribers
  //       	Engine_Api::_()->getDbtable('subscriptions', 'eblog')->sendNotifications($eblog);
  //       	$eblog->is_publish = 1;
  //       	$eblog->save();
  // 			}
        // Commit
        $db->commit();
      }
      catch( Exception $e ) {
        //silence and continue;
       //$db->rollBack();
      //throw $e;
      }
    }
  }
}
