<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<h2><?php echo $this->translate("Members Verification by Other Members Plugin") ?></h2>
<div class="sesbasic_nav_btns">
  <a href="<?php echo $this->url(array('module' => 'sesmemveroth', 'controller' => 'settings', 'action' => 'support'),'admin_default',true); ?>" target = "_blank" class="request-btn">Help</a>
</div>
<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>
