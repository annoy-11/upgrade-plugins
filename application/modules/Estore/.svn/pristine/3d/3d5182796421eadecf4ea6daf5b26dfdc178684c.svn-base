<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _showAttribution.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php $isStoreSubject = empty($this->store) ? $this->viewer() : $this->store; 
      $type = $isStoreSubject->getType();
?>
<?php  
  if($type == "stores"){
    $isAdmin = Engine_Api::_()->getDbTable('storeroles','estore')->isAdmin(array('store_id'=>$isStoreSubject->getIdentity(),'user_id'=>$this->viewer()->getIdentity()));
    if(!$isAdmin){
      $isStoreSubject = $this->viewer();
    }
  }
?>

<div class="estore_switcher_cnt notclose sesact_owner_selector sesact_owner_selector_s">
  <a href="javascript:;" class="estore_feed_change_option_a notclose _st" data-subject="<?php echo !empty($isStoreSubject) ? $isStoreSubject->getGuid() : $this->viewer()->getGuid(); ?>" data-rel="<?php echo !empty($isStoreSubject) ? $isStoreSubject->getGuid() : $this->viewer()->getGuid(); ?>" data-store="<?php echo $this->estore->getIdentity(); ?>" data-src="<?php echo $isStoreSubject->getPhotoUrl() ? $isStoreSubject->getPhotoUrl() : 'application/modules/User/externals/images/nophoto_user_thumb_icon.png'; ?>">
     <?php echo $this->itemPhoto($isStoreSubject, 'thumb.icon', $isStoreSubject->getTitle(), array('class'=> 'estore_elem_cnt')); ?>
    <i class="fa fa-caret-down estore_elem_cnt notclose"></i>
  </a>
  <a href="javascript:;" class="estore_feed_change_option notclose _lin"></a>
</div>
