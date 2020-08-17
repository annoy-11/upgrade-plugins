<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontentcoverphoto
 * @package    Sescontentcoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: icon_button.tpl 2016-06-020 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if($this->showicontype == 2): ?>

  <?php if($this->resource_type == 'album'): ?>
    <?php if(in_array('editinfo',$this->option) && $typeArray['canEdit']): ?>
      <div><a href='<?php echo $this->url(array('action' => 'edit', 'album_specific' => $subject->getIdentity()), 'album_specific', true); ?>' class='sesbasic_button'><i class='fa fa-pencil'></i><span><?php  echo $this->translate("Edit Settings"); ?></span></a></div>
    <?php endif; ?>
  <?php endif; ?>
  
  <?php if($this->resource_type == 'blog'): ?>
    <?php if(in_array('editinfo',$this->option) && $typeArray['canEdit']): ?>
      <?php $href = 'blogs/edit/'.$subject->getIdentity(); ?>
      <div><a href='<?php echo $href; ?>' class='sesbasic_button'><i class='fa fa-pencil'></i><span><?php  echo $this->translate("Edit This Entry"); ?></span></a></div>
    <?php endif; ?>
  <?php endif; ?>
  
  <?php if($this->resource_type == 'classified'): ?>
    <?php if(in_array('editinfo',$this->option) && $typeArray['canEdit']): ?>
      <div><a href='<?php echo $this->url(array('action' => 'edit', 'classified_id' => $subject->getIdentity()), 'classified_specific', true); ?>' class='sesbasic_button'><i class='fa fa-pencil'></i><span><?php  echo $this->translate("Edit"); ?></span></a></div>
    <?php endif; ?>
  <?php endif; ?>
  
  <?php if($this->resource_type == 'event'): ?>
    <?php if(in_array('editinfo',$this->option) && $typeArray['canEdit']): ?>
      <div><a href='<?php echo $this->url(array('controller' => 'event', 'action' => 'edit', 'event_id' => $subject->getIdentity(), 'ref' => 'profile'), 'event_specific', true); ?>' class='sesbasic_button'><i class='fa fa-pencil'></i><span><?php  echo $this->translate("Edit Event Details"); ?></span></a></div>
    <?php endif; ?>
  <?php endif; ?>
  
  <?php if($this->resource_type == 'group'): ?>
    <?php if(in_array('editinfo',$this->option) && $typeArray['canEdit']): ?>
      <div><a href='<?php echo $this->url(array('controller' => 'group', 'action' => 'edit', 'group_id' => $subject->getIdentity(), 'ref' => 'profile'), 'group_specific', true); ?>' class='sesbasic_button'><i class='fa fa-pencil'></i><span><?php  echo $this->translate("Edit Group Details"); ?></span></a></div>
    <?php endif; ?>
  <?php endif; ?>
  
  <?php if($this->resource_type == 'music_playlist'): ?>
    <?php $slug = $subject->getSlug(); ?>
    <?php if(in_array('editinfo',$this->option) && $typeArray['canEdit']): ?>
      <div><a href='<?php echo $this->url(array('action' => 'edit', 'playlist_id' => $subject->playlist_id, 'slug' => $slug,), 'music_playlist_specific', true); ?>' class='sesbasic_button'><i class='fa fa-pencil'></i><span><?php  echo $this->translate("Edit Playlist"); ?></span></a></div>
    <?php endif; ?>
  <?php endif; ?>

  <?php if($this->resource_type == 'video'): ?>
    <?php if(in_array('editinfo',$this->option) && $typeArray['canEdit']): ?>
      <div><a href='<?php echo $this->url(array('module' => 'video', 'controller' => 'index', 'action' => 'edit',
        'video_id' => $subject->getIdentity()), 'default', true); ?>' class='sesbasic_button'><i class='fa fa-pencil'></i><span><?php  echo $this->translate("Edit"); ?></span></a></div>
    <?php endif; ?>
  <?php endif; ?>

  <?php //Comon Share and Report Button ?>
  <?php if(in_array('share',$this->option) && $this->viewer_id): ?>
    <div><a href='<?php echo $this->url(array('module' => 'activity', 'controller' => 'index', 'action' => 'share',     'type' => $this->resource_type,  'id' => $subject->getIdentity(), 'format' => 'smoothbox'), 'default', true); ?>' class='smoothbox sesbasic_button'><i class='fa fa-share'></i><span><?php  echo $this->translate("Share"); ?></span></a></div>
  <?php endif; ?>
  
  <?php if(in_array('report',$this->option) && $this->viewer_id): ?>
    <div><a href='<?php echo $this->url(array('module' => 'core', 'controller' => 'report', 'action' => 'create',       'subject' => $subject->getGuid(), 'format' => 'smoothbox'), 'default', true); ?>' class='smoothbox sesbasic_button'><i class='fa fa-flag'></i><span><?php  echo $this->translate("Report"); ?></span></a></div>
  <?php endif; ?>
    
  <?php $checkedArray = array('group', 'event'); ?>
  <?php if(in_array($this->resource_type, $checkedArray)): ?>
    <?php //Options Work ?>
    <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 && in_array('options',$this->option)){ ?>
      <div><a href="javascript:void(0);" class="sesbasic_button sesusercover_option_btn fa fa-cog" id="parent_container_option"></a></div>
    <?php } ?>
  <?php endif; ?>

<?php else: ?>

  <?php if($this->resource_type == 'album') { ?>
    <?php if(in_array('editinfo',$this->option) && $typeArray['canEdit']): ?>
      <div><a href='<?php echo $this->url(array('action' => 'edit', 'album_id' => $subject->getIdentity()), 'album_specific', true); ?>' class='sesbasic_btn'><i class='fa fa-pencil'></i><span><i class='fa fa-caret-down'></i><?php  echo $this->translate("Edit Settings"); ?></span></a></div>
    <?php endif; ?>
  <?php } ?>
  
  <?php if($this->resource_type == 'blog') { ?>
    <?php if(in_array('editinfo',$this->option) && $typeArray['canEdit']): ?>
      <?php $href = 'blogs/edit/'.$subject->getIdentity(); ?>
      <div><a href='<?php echo $href; ?>' class='sesbasic_btn'><i class='fa fa-pencil'></i><span><i class='fa fa-caret-down'></i><?php  echo $this->translate("Edit This Entry"); ?></span></a></div>
    <?php endif; ?>
  <?php } ?>
  
  <?php if($this->resource_type == 'classified') { ?>
    <?php if(in_array('editinfo',$this->option) && $typeArray['canEdit']): ?>
      <div><a href='<?php echo $this->url(array('action' => 'edit', 'classified_id' => $subject->getIdentity()), 'classified_specific', true); ?>' class='sesbasic_btn'><i class='fa fa-pencil'></i><span><i class='fa fa-caret-down'></i><?php  echo $this->translate("Edit"); ?></span></a></div>
    <?php endif; ?>
  <?php } ?>

  <?php if($this->resource_type == 'event') { ?>
    <?php if(in_array('editinfo',$this->option) && $typeArray['canEdit']): ?>
      <div><a href='<?php echo $this->url(array('controller' => 'event', 'action' => 'edit', 'event_id' => $subject->getIdentity(), 'ref' => 'profile'), 'event_specific', true); ?>' class='sesbasic_btn'><i class='fa fa-pencil'></i><span><i class='fa fa-caret-down'></i><?php  echo $this->translate("Edit Event Details"); ?></span></a></div>
    <?php endif; ?>
  <?php } ?>
  
  <?php if($this->resource_type == 'group') { ?>
    <?php if(in_array('editinfo',$this->option) && $typeArray['canEdit']): ?>
      <div><a href='<?php echo $this->url(array('controller' => 'group', 'action' => 'edit', 'group_id' => $subject->getIdentity(), 'ref' => 'profile'), 'group_specific', true); ?>' class='sesbasic_btn'><i class='fa fa-pencil'></i><span><i class='fa fa-caret-down'></i><?php  echo $this->translate("Edit Group Details"); ?></span></a></div>
    <?php endif; ?>
  <?php } ?>
  
  <?php if($this->resource_type == 'video') { ?>
    <?php if(in_array('editinfo',$this->option) && $typeArray['canEdit']): ?>
      <div><a href='<?php echo $this->url(array('module' => 'video', 'controller' => 'index', 'action' => 'edit',
        'video_id' => $subject->getIdentity()), 'default', true); ?>' class='sesbasic_btn'><i class='fa fa-pencil'></i><span><i class='fa fa-caret-down'></i><?php  echo $this->translate("Edit"); ?></span></a></div>
    <?php endif; ?>
  <?php } ?>
  
  <?php if($this->resource_type == 'music_playlist') { ?>
    <?php $slug = $subject->getSlug(); ?>
    <?php if(in_array('editinfo',$this->option) && $typeArray['canEdit']): ?>
      <div><a href='<?php echo $this->url(array('action' => 'edit', 'playlist_id' => $subject->playlist_id, 'slug' => $slug), 'music_playlist_specific', true); ?>' class='sesbasic_btn'><i class='fa fa-pencil'></i><span><i class='fa fa-caret-down'></i><?php  echo $this->translate("Edit Playlist"); ?></span></a></div>
    <?php endif; ?>
  <?php } ?>
  
  <?php //Common Share and Report Icon ?>
  <?php if(in_array('share',$this->option) && $this->viewer_id): ?>
    <div><a href='<?php echo $this->url(array('module' => 'activity', 'controller' => 'index', 'action' => 'share',     'type' => $this->resource_type,  'id' => $subject->getIdentity(), 'format' => 'smoothbox'), 'default', true); ?>' class='smoothbox sesbasic_btn'><i class='fa fa-share'></i><span><i class='fa fa-caret-down'></i><?php  echo $this->translate("Share"); ?></span></a></div>
  <?php endif; ?>
  <?php if(in_array('report',$this->option) && $this->viewer_id): ?>
    <div><a href='<?php echo $this->url(array('module' => 'core', 'controller' => 'report', 'action' => 'create',       'subject' => $subject->getGuid(), 'format' => 'smoothbox'), 'default', true); ?>' class='smoothbox sesbasic_btn'><i class='fa fa-flag'></i><span><i class='fa fa-caret-down'></i><?php  echo $this->translate("Report"); ?></span></a></div>
  <?php endif; ?>
  <?php $checkedArray = array('group', 'event'); ?>
  <?php if(in_array($this->resource_type, $checkedArray)): ?>
    <?php //Options Work ?>
    <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 && in_array('options',$this->option)){ ?>
      <div><a href="javascript:void(0);" class="sesbasic_btn sesusercover_option_btn fa fa-ellipsis-h" id="parent_container_option"></a></div>
    <?php } ?>
  <?php endif; ?>
  
<?php endif; ?>