<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<h2><?php echo $this->translate("Responsive Vertical Theme") ?></h2>
<div class="sesbasic_nav_btns">
  <a href="<?php echo $this->url(array('module' => 'sesariana', 'controller' => 'settings', 'action' => 'support'),'admin_default',true); ?>" target = "_blank" class="request-btn">Help</a>
</div>
<?php if( count($this->navigation) ): ?>
  <div class='sesbasic-admin-navgation'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>
