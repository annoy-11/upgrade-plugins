<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
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
  if($isValid && !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.other.modulejobs', 0))
    $dontShow = false;
   
?>
<div class="sesbasic_breadcrumb">
  <?php if($dontShow): ?>
    <a href="<?php echo $this->url(array('action' => 'home'), 'sesjob_general'); ?>"><?php echo $this->translate("Jobs Home");?></a>&nbsp;&raquo;
    <a href="<?php echo $this->url(array('action' => 'browse'), 'sesjob_general'); ?>"><?php echo $this->translate("Browse Jobs"); ?></a>&nbsp;&raquo;
  <?php endif; ?>
  <?php if($this->subject->getType() == 'sesjob_job' && $isValid):?>
    <?php if($item): ?>
      <a href="<?php echo $item->getHref(); ?>"><?php echo $item->getTitle(); ?></a>&nbsp;&raquo;
    <?php endif; ?>
  <?php endif; ?>
  <?php echo !$this->subject->getTitle() ? $this->translate("Untitled"): $this->subject->getTitle(); ?>
</div>
