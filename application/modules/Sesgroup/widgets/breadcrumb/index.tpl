<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>

<?php 
  $isValid = false;
  if(isset($this->subject->resource_type) && $this->subject->resource_type){
    $item = Engine_Api::_()->getItem($this->subject->resource_type,$this->subject->resource_id);
    if($item)
      $isValid = true;
  }
  $dontShow = true;
  if($isValid && !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.other.modulepages', 0))
    $dontShow = false;
   
?>
<div class="sesbasic_breadcrumb">
    <?php if($dontShow): ?>
    <a href="<?php echo $this->url(array('action' => 'home'), 'sesgroup_general'); ?>"><?php echo $this->translate("Groups Home"); ?></a>&nbsp;&raquo;
    <a href="<?php echo $this->url(array(), 'sesgroup_general'); ?>"><?php echo $this->translate("Browse Groups"); ?></a>&nbsp;&raquo;
    <?php endif; ?>
   <?php if($isValid):?>
    <?php if($item): ?>
        <a href="<?php echo $item->getHref(); ?>"><?php echo $item->getTitle(); ?></a>&nbsp;&raquo;
    <?php endif; ?>
   <?php endif; ?>
  <?php echo !$this->subject->getTitle() ? $this->translate("Untitled"): $this->subject->getTitle(); ?>
</div>
