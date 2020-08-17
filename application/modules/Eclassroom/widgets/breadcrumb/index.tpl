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
<?php 
  $isValid = false;
  if(isset($this->subject->resource_type) && $this->subject->resource_type){
    $item = Engine_Api::_()->getItem($this->subject->resource_type,$this->subject->resource_id);
    if($item)
      $isValid = true;
  }
  $dontShow = true;
  if($isValid)
    $dontShow = false;
   
?>
<div class="sesbasic_breadcrumb">
  <?php if($dontShow): ?>
    <a href="<?php echo $this->url(array('action' => 'home'), 'eclassroom_general'); ?>"><?php echo $this->translate("Classroom Home");?></a>&nbsp;&raquo;
    <a href="<?php echo $this->url(array('action' => 'browse'), 'eclassroom_general'); ?>"><?php echo $this->translate("Browse Classroom"); ?></a>&nbsp;&raquo;
  <?php endif; ?>
  <?php if($this->subject->getType() == 'classroom' && $isValid):?>
    <?php if($item): ?>
      <a href="<?php echo $item->getHref(); ?>"><?php echo $item->getTitle(); ?></a>&nbsp;&raquo;
    <?php endif; ?>
  <?php endif; ?>
  <?php echo !$this->subject->getTitle() ? $this->translate("Untitled"): $this->subject->getTitle(); ?>
</div>
