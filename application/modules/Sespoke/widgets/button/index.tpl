<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespoke/externals/styles/styles.css'); ?>

<?php if($this->showIconText == 1): ?>
	<div class="sespoke_buttons_block sespoke_buttons_onlyicons sespoke_clearfix">
<?php elseif($this->showIconText == 2): ?>
	<div class="sespoke_buttons_block sespoke_buttons_onlytext sespoke_clearfix">
<?php elseif($this->showIconText == 3): ?>
	<div class="sespoke_buttons_block sespoke_buttons_both sespoke_clearfix">
<?php endif; ?>
  <?php foreach($this->results as $item):
    if($item['member_levels']) {
    $member_levels = json_decode($item['member_levels']);
    }
    $name  = ucfirst($item['name']);
    $icon = $item['icon'];
  ?>
  <?php if($item['action'] == 'action'): ?>
   <?php $title = $this->translate($name). ' ' .$this->item->getTitle(); ?>
  <?php else: ?>
    <?php $title = $this->translate("Send %s", $name); ?>
  <?php endif; ?>
  <?php $icon = Engine_Api::_()->storage()->get($icon, '')->getPhotoUrl(); ?>
    <?php if(in_array($this->viewer_level_id, $member_levels)): ?>
      <?php if($this->showIconText == 1): ?>
        <?php	echo $this->htmlLink(array('route' => 'default', 'module' => 'sespoke', 'controller' => 'index', 'action' => 'poke', 'id' => $this->id, 'manageaction_id' => $item['manageaction_id']), "<i style='background-image:url($icon);'></i>", array('title' => $title, 'class' => 'smoothbox sespoke_button sespoke_bxs sespoke_button')) ;	?>
      <?php elseif($this->showIconText == 2): ?>
        <?php	echo $this->htmlLink(array('route' => 'default', 'module' => 'sespoke', 'controller' => 'index', 'action' => 'poke', 'id' => $this->id, 'manageaction_id' => $item['manageaction_id']), $this->translate($name) . ' ' . $this->item->getTitle(), array('title' => $title, 'class' => 'smoothbox sespoke_button sespoke_bxs sespoke_button')) ;	?>
      <?php elseif($this->showIconText == 3): ?>
        <?php	echo $this->htmlLink(array('route' => 'default', 'module' => 'sespoke', 'controller' => 'index', 'action' => 'poke', 'id' => $this->id, 'manageaction_id' => $item['manageaction_id']), $this->translate("<i style='background-image:url($icon);'></i> %s %s", $name, $this->item->getTitle()), array('title' => $title, 'class' => 'smoothbox sespoke_button sespoke_bxs sespoke_button')) ;	?>
      <?php endif; ?>
    <?php endif; ?>
  <?php endforeach; ?>
</div>
