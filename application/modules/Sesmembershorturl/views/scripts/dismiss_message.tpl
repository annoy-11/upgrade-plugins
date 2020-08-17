<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershorturl
 * @package    Sesmembershorturl
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<h2><?php echo $this->translate("Custom & Short Member Profile URLs Plugin") ?></h2>
<div class="sesbasic_nav_btns">
  <a href="<?php echo $this->url(array('module' => 'sesmembershorturl', 'controller' => 'settings', 'action' => 'support'),'admin_default',true); ?>" target = "_blank" class="request-btn">Help</a>
</div>
<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>
