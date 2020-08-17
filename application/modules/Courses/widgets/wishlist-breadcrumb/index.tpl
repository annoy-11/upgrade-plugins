<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php 
  $isValid = false;
  if($this->subject) {
    if(isset($this->subject->resource_type) && $this->subject->resource_type){
      $item = Engine_Api::_()->getItem($this->subject->resource_type,$this->subject->resource_id);
      if($item)
        $isValid = true;
    }
    $dontShow = true;
    if($isValid)
      $dontShow = false;
  } 
?>
<div class="sesbasic_breadcrumb">
    <a href="<?php echo $this->url(array('action' => 'home'), 'courses_general'); ?>"><?php echo $this->translate("Courses Home");?></a>&nbsp;&raquo;
    <a href="<?php echo $this->url(array('action' => 'browse'), 'courses_wishlist'); ?>"><?php echo $this->translate("Browse Wishlist"); ?></a>
  <?php if($this->subject) { ?> &nbsp;&raquo;
    <?php if($this->subject->getType() == 'courses' && $isValid):?>
      <?php if($item): ?>
        <a href="<?php echo $item->getHref(); ?>"><?php echo $item->getTitle(); ?></a>&nbsp;&raquo;
      <?php endif; ?>
    <?php endif; ?>
    <?php echo !$this->subject->getTitle() ? $this->translate("Untitled"): $this->subject->getTitle(); ?>
  <?php } ?>
</div>
