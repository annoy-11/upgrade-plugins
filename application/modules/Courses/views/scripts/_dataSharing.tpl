<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _dataSharing.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $shareType = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.share', 1); ?>
<?php if(isset($this->socialSharingActive) && $shareType):?>
  <a href="<?php echo $this->url(array('module' => 'activity','controller' => 'index','action' => 'share','type' => $course->getType(),'id' => $course->getIdentity(),'format' => 'smoothbox'),'default',true);?>" class="smoothbox share_btn sesbasic_icon_btn"><i class="fa fa-share-alt"></i></a>
  <?php if($shareType == 2): ?>
    <?php if($this->socialshare_icon_limit): ?>
      <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $course, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
      <?php else: ?>
      <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $course, 'socialshare_enable_plusicon' => $this->socialshare_enable_listview1plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_listview1limit)); ?>
    <?php endif; ?>
  <?php endif; ?>
<?php endif;?>
