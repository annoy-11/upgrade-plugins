<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _showAttribution.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php $isGroupSubject = empty($this->group) ? $this->viewer() : $this->group; 
      $type = $isGroupSubject->getType();
?>
<?php  
  if($type == "sesgroup_group"){
    $isAdmin = Engine_Api::_()->getDbTable('grouproles','sesgroup')->isAdmin(array('group_id'=>$isGroupSubject->getIdentity(),'user_id'=>$this->viewer()->getIdentity()));
    if(!$isAdmin){
      $isGroupSubject = $this->viewer();
    }
  }else{
    return;
  }
?>

<div class="sesgroup_switcher_cnt notclose sesact_owner_selector sesact_owner_selector_s">
  <a href="javascript:;" class="sesgroup_feed_change_option_a notclose _st" data-subject="<?php echo !empty($isGroupSubject) ? $isGroupSubject->getGuid() : $this->viewer()->getGuid(); ?>" data-rel="<?php echo !empty($isGroupSubject) ? $isGroupSubject->getGuid() : $this->viewer()->getGuid(); ?>" data-group="<?php echo $this->sesgroup->getIdentity(); ?>" data-src="<?php echo $isGroupSubject->getPhotoUrl() ? $isGroupSubject->getPhotoUrl() : 'application/modules/User/externals/images/nophoto_user_thumb_icon.png'; ?>">
     <?php echo $this->itemPhoto($isGroupSubject, 'thumb.icon', $isGroupSubject->getTitle(), array('class'=> 'sesgroup_elem_cnt')); ?>
    <i class="fa fa-caret-down sesgroup_elem_cnt notclose"></i>
  </a>
  <a href="javascript:;" class="sesgroup_feed_change_option notclose _lin"></a>
</div>
