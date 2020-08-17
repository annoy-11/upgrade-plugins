<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php 
  $isValid = false;
  $item = null;
  if($this->subject){
    $item = Engine_Api::_()->getItem('sesgrouppoll_poll',$this->subject->poll_id);
    if($item)
      $isValid = true;
  }
  if($item)
   $group = Engine_Api::_()->getItem('sesgroup_group',$this->subject->group_id);
  
  $dontShow = true;
  if($isValid && !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.other.modulegroups', 0))
    $dontShow = false;
   
?>
<div class="sesbasic_breadcrumb">
    <?php if($dontShow): ?>
    <a href="<?php echo $this->url(array('action' => 'home'), 'sesgroup_general'); ?>"><?php echo $this->translate("Groups Home"); ?></a>&nbsp;&raquo;
    <a href="<?php echo $this->url(array('action' => 'browse'), 'sesgroup_general'); ?>"><?php echo $this->translate("Browse Groups"); ?></a>&nbsp;&raquo;
    <?php endif; ?>
   <?php if($isValid):?>
    <?php if($group): ?>
        <a href="<?php echo $group->getHref(); ?>"><?php echo $group->getTitle(); ?></a>&nbsp;&raquo;
    <?php endif; ?>
   <?php endif; ?>
    <a href="<?php echo $item->getHref();?>"><?php echo !$item->getTitle() ? $this->translate('Untitled'): $item->getTitle(); ?></a>
</div>
