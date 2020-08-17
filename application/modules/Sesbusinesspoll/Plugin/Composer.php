<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Composer.php  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinesspoll_Plugin_Composer extends Core_Plugin_Abstract {
  public function onAttachSesbusinesspoll($data) {
    $subject = $_POST['subject'];
    $values['business_id'] = $businessId =  substr($subject, 11);
    $values['title'] = $title = $_POST['title'];
    $values['description'] = $description = $_POST['description'];
    $options = $_POST['optionsArray'];
    $options = array_filter(array_map('trim', $options));
    foreach( $options as $index => $option ) {
      if( strlen($option) > 300 ) {
        $options[$index] = Engine_String::substr($option, 0, 300);
      }
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    // Process
	
    $pollTable = Engine_Api::_()->getItemTable('sesbusinesspoll_poll');
    $pollOptionsTable = Engine_Api::_()->getDbtable('options', 'sesbusinesspoll');
    $db = $pollTable->getAdapter();
    $db->beginTransaction();
    try {
      $values['user_id'] = $viewer->getIdentity();
      $values['auth_view'] = 'everyone';
      $values['auth_comment'] = 'everyone';
      $values['view_privacy'] = $values['auth_view'];
      // Create poll
      $poll = $pollTable->createRow();
      $poll->setFromArray($values);
      $poll->save();
      // Create options
      $censor = new Engine_Filter_Censor();
      $html = new Engine_Filter_Html(array('AllowedTags'=> array('a')));
      $counter = 0;
      $storage = Engine_Api::_()->getItemTable('storage_file');
      foreach( $options as $option ) {
        $option = $censor->filter($html->filter($option));
        $file_id = 0;
        $image_type= 0;
        if(!empty($_FILES['optionsImage']['name'][$counter])){
          $file['tmp_name'] = $_FILES['optionsImage']['tmp_name'][$counter];
		  $file['name'] = $_FILES['optionsImage']['name'][$counter];
		  $file['size'] = $_FILES['optionsImage']['size'][$counter];
		  $file['error'] = $_FILES['optionsImage']['error'][$counter];
		  $file['type'] = $_FILES['optionsImage']['type'][$counter];
          $image_type = 1;
        }elseif(!empty($_POST['optionsGif'][$counter])){
          $file_id  = $_POST['optionsGif'][$counter];
          $image_type = 2;
        }
        if(!empty($file) && $image_type == 1){
          $thumbname = $storage->createFile($file, array(
            'parent_id' => $poll->getIdentity(),
            'parent_type' => 'sesbusinesspoll_poll',
            'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
          ));
          $file_id = $thumbname->file_id;
        }
        $pollOptionsTable->insert(array(
          'poll_id' => $poll->getIdentity(),
          'poll_option' => $option,
          'file_id'=>$file_id,
          'image_type'=>$image_type
        ));
		 $image_type = 0;
        $counter ++;
      }
      // Privacy
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
      foreach( $roles as $i => $role ) {
        $auth->setAllowed($poll, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($poll, $role, 'comment', ($i <= $commentMax));
      }
      $auth->setAllowed($poll, 'registered', 'vote', true);
      $db->commit();
    } catch( Exception $e ) {
      $db->rollback();
      throw $e;
    }
    
    return $poll;

  }
}
