<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<h2><?php echo $this->translate("(OTP) One Time Password, SMS Mobile Verification & Safe Login") ?></h2>
<div class="sesbasic_nav_btns">,
  <a href="<?php echo $this->url(array('module' => 'otpsms', 'controller' => 'settings', 'action' => 'support'),'admin_default',true); ?>" class="help-btn">Help Center</a>
</div>
<?php if( count($this->navigation) ): ?>
  <div class='sesbasic-admin-navgation'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>
