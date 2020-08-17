<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
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
  if($isValid && !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.other.modulearticles', 0))
    $dontShow = false;
   
?>
<div class="sesbasic_breadcrumb">
  <?php if($dontShow): ?>
    <a href="<?php echo $this->url(array('action' => 'home'), 'sesarticle_general'); ?>"><?php echo $this->translate("Articles Home");?></a>&nbsp;&raquo;
    <a href="<?php echo $this->url(array('action' => 'browse'), 'sesarticle_general'); ?>"><?php echo $this->translate("Browse Articles"); ?></a>&nbsp;&raquo;
  <?php endif; ?>
  <?php if($this->subject->getType() == 'sesarticle' && $isValid):?>
    <?php if($item): ?>
      <a href="<?php echo $item->getHref(); ?>"><?php echo $item->getTitle(); ?></a>&nbsp;&raquo;
    <?php endif; ?>
  <?php endif; ?>
  <?php echo !$this->subject->getTitle() ? $this->translate("Untitled"): $this->subject->getTitle(); ?>
</div>
