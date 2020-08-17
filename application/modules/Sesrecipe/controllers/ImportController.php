<?php
class Sesrecipe_ImportController extends Core_Controller_Action_Standard {
  public function indexAction() {
    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('sesrecipe_recipe', null, 'create')->isValid()) return;
    $this->view->form = $form = new Sesrecipe_Form_Import();
     // If not post or form not valid, return
    if( !$this->getRequest()->isPost() )
    return;
    if( !$form->isValid($this->getRequest()->getPost()) )
    return;
    if (empty($values['file_data'])) {
        $form->addError($this->view->translate("Recipe XML File * Please complete this field - it is required."));
        return;
    }
    $file = $form->getElement ( 'file_data' );
    $path = $file->getDestination () . DIRECTORY_SEPARATOR . $file->getValue ();
    $xml = simplexml_load_file($path);
    if($_POST['import_type'] == 1) {
      $posts = array();
      $xml =  $xml->entry;
      foreach( $xml as $row ) {
        $posts[] = array(
          "title"=>$row->title,
          "content"=>$row->content,
          "import_type" => 1,
        );
      }
      $this->importRecipes($posts);
    }elseif($_POST['import_type'] == 2) {
      $posts = array();
      foreach($xml->channel->item as $item) {
        $content = $item->children('http://purl.org/rss/1.0/modules/content/');
        $posts[] = array(
        "title"=>$item->title,
        "content"=>$content->encoded,
        "import_type" => 2,
        );
      }
      $this->importRecipes($posts);
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
      $this->importRecipes($posts);
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'),'sesrecipe_general',true);
  }
  public function importRecipes($posts) {
    foreach($posts as $post) {
      $title = $post['title'];
      if(!$title)
        continue;
      // Process
      $table = Engine_Api::_()->getDbtable('recipes', 'sesrecipe');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        // Create sesrecipe
        $viewer = Engine_Api::_()->user()->getViewer();
        $values = array();
        $sesrecipe = $table->createRow();
        $sesrecipe->ip_address = $_SERVER['REMOTE_ADDR'];
        $sesrecipe->title = htmlspecialchars_decode($title);
        $sesrecipe->body = $post['content'];
        $sesrecipe->owner_type = $viewer->getType();
        $sesrecipe->owner_id = $viewer->getIdentity();
        $sesrecipe->category_id = 0;
        $sesrecipe->subcat_id = 0;
        $sesrecipe->subsubcat_id = 0;
        $sesrecipe->is_approved = 1;
        $sesrecipe->seo_title = $title;
        if(isset($sesrecipe->package_id) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesrecipepackage') ){
          $package_id = Engine_Api::_()->getDbTable('packages','sesrecipepackage')->getDefaultPackage();
          $sesrecipe->package_id = $package_id;
        }
        $sesrecipe->save();
        $recipe_id = $sesrecipe->recipe_id;
        $sesrecipe->custom_url = $recipe_id;
        $roleTable = Engine_Api::_()->getDbtable('roles', 'sesrecipe');
        $row = $roleTable->createRow();
        $row->recipe_id = $recipe_id;
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
          $auth->setAllowed($sesrecipe, $role, 'view', ($i <= $viewMax));
          $auth->setAllowed($sesrecipe, $role, 'comment', ($i <= $commentMax));
          $auth->setAllowed($sesrecipe, $role, 'video', ($i <= $videoMax));
          $auth->setAllowed($sesrecipe, $role, 'music', ($i <= $musicMax));
        }
        $sesrecipe->save();
        // Add activity only if sesrecipe is published
  //       if( $values['draft'] == 0 && $values['is_approved'] == 1 && (!$sesrecipe->publish_date || strtotime($sesrecipe->publish_date) <= time())) {
  //         $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sesrecipe, 'sesrecipe_new');
  //         // make sure action exists before attaching the sesrecipe to the activity
  //         if( $action ) {
  //           Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sesrecipe);
  //         }
  //         //Send notifications for subscribers
  //       	Engine_Api::_()->getDbtable('subscriptions', 'sesrecipe')->sendNotifications($sesrecipe);
  //       	$sesrecipe->is_publish = 1;
  //       	$sesrecipe->save();
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
