<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if (!empty($this->viewer_id)): ?>
  <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'eclassroom')->isFollow(array('resource_id' => $this->subject->classroom_id,'resource_type' => $this->subject->getType())); ?>
  <?php $followClass = (!$followStatus) ? 'fa-check' : 'fa-times' ;?>
  <?php $followText = ($followStatus) ?  $this->translate('Unfollow') : $this->translate('Follow');?>
  <div class="eclassroom_sidebar_button">
    <a href='javascript:;' data-type='follow_classroom_button_view' data-url='<?php echo $this->subject->getIdentity(); ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_animation eclassroom_link_btn eclassroom_likefavfollow eclassroom_follow_view_<?php echo $this->subject->getIdentity(); ?> eclassroom_follow_classroom_view"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a>     
  </div>
<?php endif; ?>
  

