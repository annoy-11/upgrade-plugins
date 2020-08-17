<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>

<?php 
  $isValid = false;
  $item = null;
  if($this->subject){
    $item = Engine_Api::_()->getItem('sesbusinesspoll_poll',$this->subject->poll_id);
    if($item)
      $isValid = true;
  }
  if($item)
   $business = Engine_Api::_()->getItem('businesses',$this->subject->business_id);
  
  $dontShow = true;
  if($isValid && !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.other.modulebusinesses', 0))
    $dontShow = false;
   
?>
<div class="sesbasic_breadcrumb">
    <?php if($dontShow): ?>
    <a href="<?php echo $this->url(array('action' => 'home'), 'sesbusiness_general'); ?>"><?php echo $this->translate("Businesses Home"); ?></a>&nbsp;&raquo;
    <a href="<?php echo $this->url(array('action' => 'browse'), 'sesbusiness_general'); ?>"><?php echo $this->translate("Browse Businesses"); ?></a>&nbsp;&raquo;
    <?php endif; ?>
   <?php if($isValid):?>
    <?php if($business): ?>
        <a href="<?php echo $business->getHref(); ?>"><?php echo $business->getTitle(); ?></a>&nbsp;&raquo;
    <?php endif; ?>
   <?php endif; ?>
    <a href="<?php echo $item->getHref();?>"><?php echo !$item->getTitle() ? $this->translate('Untitled'): $item->getTitle(); ?></a>
</div>
