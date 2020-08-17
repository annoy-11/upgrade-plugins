<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _showAttribution.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php $isBusinessSubject = empty($this->business) ? $this->viewer() : $this->business; 
      $type = $isBusinessSubject->getType();
?>
<?php  
  if($type == "businesses"){
    $isAdmin = Engine_Api::_()->getDbTable('businessroles','sesbusiness')->isAdmin(array('business_id'=>$isBusinessSubject->getIdentity(),'user_id'=>$this->viewer()->getIdentity()));
    if(!$isAdmin){
      $isBusinessSubject = $this->viewer();
    }
  }
?>

<div class="sesbusiness_switcher_cnt notclose sesact_owner_selector sesact_owner_selector_s">
  <a href="javascript:;" class="sesbusiness_feed_change_option_a notclose _st" data-subject="<?php echo !empty($isBusinessSubject) ? $isBusinessSubject->getGuid() : $this->viewer()->getGuid(); ?>" data-rel="<?php echo !empty($isBusinessSubject) ? $isBusinessSubject->getGuid() : $this->viewer()->getGuid(); ?>" data-business="<?php echo $this->sesbusiness->getIdentity(); ?>" data-src="<?php echo $isBusinessSubject->getPhotoUrl() ? $isBusinessSubject->getPhotoUrl() : 'application/modules/User/externals/images/nophoto_user_thumb_icon.png'; ?>">
     <?php echo $this->itemPhoto($isBusinessSubject, 'thumb.icon', $isBusinessSubject->getTitle(), array('class'=> 'sesbusiness_elem_cnt')); ?>
    <i class="fa fa-caret-down sesbusiness_elem_cnt notclose"></i>
  </a>
  <a href="javascript:;" class="sesbusiness_feed_change_option notclose _lin"></a>
</div>
