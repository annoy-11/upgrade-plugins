<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _showAttribution.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php $isPageSubject = empty($this->page) ? $this->viewer() : $this->page; 
      $type = $isPageSubject->getType();
?>
<?php  
  if($type == "sespage_page"){
    $isAdmin = Engine_Api::_()->getDbTable('pageroles','sespage')->isAdmin(array('page_id'=>$isPageSubject->getIdentity(),'user_id'=>$this->viewer()->getIdentity()));
    if(!$isAdmin){
      $isPageSubject = $this->viewer();
    }
  }
?>

<div class="sespage_switcher_cnt notclose sesact_owner_selector sesact_owner_selector_s">
  <a href="javascript:;" class="sespage_feed_change_option_a notclose _st" data-subject="<?php echo !empty($isPageSubject) ? $isPageSubject->getGuid() : $this->viewer()->getGuid(); ?>" data-rel="<?php echo !empty($isPageSubject) ? $isPageSubject->getGuid() : $this->viewer()->getGuid(); ?>" data-page="<?php echo $this->sespage->getIdentity(); ?>" data-src="<?php echo $isPageSubject->getPhotoUrl() ? $isPageSubject->getPhotoUrl() : 'application/modules/User/externals/images/nophoto_user_thumb_icon.png'; ?>">
     <?php echo $this->itemPhoto($isPageSubject, 'thumb.icon', $isPageSubject->getTitle(), array('class'=> 'sespage_elem_cnt')); ?>
    <i class="fa fa-caret-down sespage_elem_cnt notclose"></i>
  </a>
  <a href="javascript:;" class="sespage_feed_change_option notclose _lin"></a>
</div>
