<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<ul class="sesprofilelock_user_widget">
  <?php foreach( $this->paginator as $user ): ?>
  <?php $userItem = Engine_Api::_()->getItem('user', $user->user_id); ?>
  <li>
    <?php echo $this->htmlLink($userItem->getHref(), $this->itemPhoto($userItem, 'thumb.icon', $userItem->getTitle()), array('class' => 'sesprofilelock_user_thumb')) ?>
    <div class='sesprofilelock_user_info'>
      <div class='sesprofilelock_user_name'>
        <?php echo $this->htmlLink($userItem->getHref(), $userItem->getTitle()) ?>
      </div>
      <?php if(isset($this->statistics) && in_array('viewCount', $this->statistics)): ?>
      <div class='sesprofilelock_user_stats'>
        <?php echo $this->translate("Total Views: "); ?>
        <?php echo $this->translate(array('%s view', '%s views', $user->view_count),$this->locale()->toNumber($user->view_count)) ?>
      </div>
      <?php endif; ?>
      <?php if(isset($this->statistics) && in_array('lastSeen', $this->statistics)): ?>
      <div class='sesprofilelock_user_stats'>
        <?php echo $this->translate("Last Visited: %s", $this->timestamp($user->modified_date)); ?>
      </div>
      <?php endif; ?>
    </div>
  </li>
  <?php endforeach; ?>
</ul>
