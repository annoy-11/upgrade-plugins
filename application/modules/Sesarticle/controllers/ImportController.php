<?php
class Sesarticle_ImportController extends Core_Controller_Action_Standard {
  public function indexAction() {
    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('sesarticle', null, 'create')->isValid()) return;
    $this->view->form = $form = new Sesarticle_Form_Import();
     // If not post or form not valid, return
    if( !$this->getRequest()->isPost() ) {
        return;
    }
    $values = $form->getValues();
    if( !$form->isValid($this->getRequest()->getPost()) ) {
        return;
    }
    if (empty($values['file_data'])) {
        $form->addError($this->view->translate("Article XML File * Please complete this field - it is required."));
        return;
    }
    $file = $form->getElement ( 'file_data' );
    $path = $file->getDestination () . DIRECTORY_SEPARATOR . $file->getValue ();
    $xml = simplexml_load_file($path);
    if($_POST['import_type'] == 1) {
      if (empty($_FILES['file_data']['name'])) {
        $form->addError('Please select blogger xml file you want to import here.');
        return;
      }
      $posts = array();
      $xml =  $xml->entry;
      foreach( $xml as $row ) {
        $posts[] = array(
          "title"=>$row->title,
          "content"=>$row->content,
          "import_type" => 1,
        );
      }
      $this->importArticles($posts);
    }elseif($_POST['import_type'] == 2) {
      if (empty($_FILES['file_data']['name'])) {
        $form->addError('Please select wordpress xml file you want to import here.');
        return;
      }
      $posts = array();
      foreach($xml->channel->item as $item) {
        $content = $item->children('http://purl.org/rss/1.0/modules/content/');
        $posts[] = array(
        "title"=>$item->title,
        "content"=>$content->encoded,
        "import_type" => 2,
        );
      }
      $this->importArticles($posts);
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
      $this->importArticles($posts);
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'),'sesarticle_general',true);
  }
  public function importArticles($posts) {
    foreach($posts as $post) {
      $title = $post['title'];
      if(!$title)
        continue;
      // Process
      $table = Engine_Api::_()->getDbtable('sesarticles', 'sesarticle');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        // Create sesarticle
        $viewer = Engine_Api::_()->user()->getViewer();
        $values = array();
        $sesarticle = $table->createRow();
        $sesarticle->ip_address = $_SERVER['REMOTE_ADDR'];
        $sesarticle->title = htmlspecialchars_decode($title);
        $sesarticle->body = $post['content'];
        $sesarticle->owner_type = $viewer->getType();
        $sesarticle->owner_id = $viewer->getIdentity();
        $sesarticle->category_id = 0;
        $sesarticle->subcat_id = 0;
        $sesarticle->subsubcat_id = 0;
        $sesarticle->is_approved = 1;
        $sesarticle->seo_title = $title;
        if(isset($sesarticle->package_id) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesarticlepackage') ){
          $package_id = Engine_Api::_()->getDbTable('packages','sesarticlepackage')->getDefaultPackage();
          $sesarticle->package_id = $package_id;
        }
        $sesarticle->save();
        $article_id = $sesarticle->article_id;
        $sesarticle->custom_url = $article_id;
        $roleTable = Engine_Api::_()->getDbtable('roles', 'sesarticle');
        $row = $roleTable->createRow();
        $row->article_id = $article_id;
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
          $auth->setAllowed($sesarticle, $role, 'view', ($i <= $viewMax));
          $auth->setAllowed($sesarticle, $role, 'comment', ($i <= $commentMax));
          $auth->setAllowed($sesarticle, $role, 'video', ($i <= $videoMax));
          $auth->setAllowed($sesarticle, $role, 'music', ($i <= $musicMax));
        }
        $sesarticle->save();
        // Add activity only if sesarticle is published
  //       if( $values['draft'] == 0 && $values['is_approved'] == 1 && (!$sesarticle->publish_date || strtotime($sesarticle->publish_date) <= time())) {
  //         $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sesarticle, 'sesarticle_new');
  //         // make sure action exists before attaching the sesarticle to the activity
  //         if( $action ) {
  //           Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sesarticle);
  //         }
  //         //Send notifications for subscribers
  //       	Engine_Api::_()->getDbtable('subscriptions', 'sesarticle')->sendNotifications($sesarticle);
  //       	$sesarticle->is_publish = 1;
  //       	$sesarticle->save();
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
