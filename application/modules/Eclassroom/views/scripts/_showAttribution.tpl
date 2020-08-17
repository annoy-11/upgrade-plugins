<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _showAttribution.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<?php $isStoreSubject = empty($this->classroom) ? $this->viewer() : $this->classroom; 
      $type = $isStoreSubject->getType();
?>
<?php  
  if($type == "classrooms"){
    $isAdmin = Engine_Api::_()->getDbTable('classroomroles','eclassroom')->isAdmin(array('classroom_id'=>$isStoreSubject->getIdentity(),'user_id'=>$this->viewer()->getIdentity()));
    if(!$isAdmin){
      $isStoreSubject = $this->viewer();
    }
  }
?>

<div class="eclassroom_switcher_cnt notclose sesact_owner_selector sesact_owner_selector_s">
  <a href="javascript:;" class="eclassroom_feed_change_option_a notclose _st" data-subject="<?php echo !empty($isStoreSubject) ? $isStoreSubject->getGuid() : $this->viewer()->getGuid(); ?>" data-rel="<?php echo !empty($isStoreSubject) ? $isStoreSubject->getGuid() : $this->viewer()->getGuid(); ?>" data-classroom="<?php echo $this->eclassroom->getIdentity(); ?>" data-src="<?php echo $isStoreSubject->getPhotoUrl() ? $isStoreSubject->getPhotoUrl() : 'application/modules/User/externals/images/nophoto_user_thumb_icon.png'; ?>">
     <?php echo $this->itemPhoto($isStoreSubject, 'thumb.icon', $isStoreSubject->getTitle(), array('class'=> 'eclassroom_elem_cnt')); ?>
    <i class="fa fa-caret-down eclassroom_elem_cnt notclose"></i>
  </a>
  <a href="javascript:;" class="eclassroom_feed_change_option notclose _lin"></a>
</div>
