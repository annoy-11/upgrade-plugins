<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php 
  $isValid = false;
  $item = null;
  if($this->subject){
    $item = Engine_Api::_()->getItem('sespagepoll_poll',$this->subject->poll_id);
    if($item)
      $isValid = true;
  }
  if($item)
   $page = Engine_Api::_()->getItem('sespage_page',$this->subject->page_id);
  
  $dontShow = true;
  if($isValid && !Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.other.modulepages', 0))
    $dontShow = false;
   
?>
<div class="sesbasic_breadcrumb">
    <?php if($dontShow): ?>
    <a href="<?php echo $this->url(array('action' => 'home'), 'sespage_general'); ?>"><?php echo $this->translate("Pages Home"); ?></a>&nbsp;&raquo;
    <a href="<?php echo $this->url(array('action' => 'browse'), 'sespage_general'); ?>"><?php echo $this->translate("Browse Pages"); ?></a>&nbsp;&raquo;
    <?php endif; ?>
   <?php if($isValid):?>
    <?php if($page): ?>
        <a href="<?php echo $page->getHref(); ?>"><?php echo $page->getTitle(); ?></a>&nbsp;&raquo;
    <?php endif; ?>
   <?php endif; ?>
    <a href="<?php echo $item->getHref();?>"><?php echo !$item->getTitle() ? $this->translate('Untitled'): $item->getTitle(); ?></a>
</div>
