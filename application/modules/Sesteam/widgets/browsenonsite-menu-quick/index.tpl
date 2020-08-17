<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div class="quicklinks">
	<ul class="navigation">
		<li>
      <?php if($this->sesteamType == 'nonmember'): ?>
        <?php if($this->linkText): ?>
         <?php $text = $this->linkText; ?>
        <?php else: ?>
          <?php $text = 'Browse Non Site Team'; ?>
        <?php endif; ?>
        <?php echo $this->htmlLink(array('route' => 'sesteam_teampage', 'action' => 'nonsiteteam'), $this->translate($text), array('class' => 'buttonlink sesteam_icon_team')); ?>
      <?php else: ?>
        <?php if($this->linkText): ?>
         <?php $text = $this->linkText; ?>
        <?php else: ?>
          <?php $text = 'Browse Site Team'; ?>
        <?php endif; ?>
        <?php echo $this->htmlLink(array('route' => 'sesteam_teampage', 'action' => 'team'), $this->translate($text), array('class' => 'buttonlink sesteam_icon_team')); ?>
      <?php endif; ?>
    </li>
  </ul>  
</div>