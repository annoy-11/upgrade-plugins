<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: send-newsletter.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sessportz/views/scripts/dismiss_message.tpl';?>
<?php if( count($this->subnavigation) ): ?>
  <div class='sesbasic-admin-sub-tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->subnavigation)->render();?>
  </div>
<?php endif; ?>
<?php if( $this->form ): ?>
  <div class="settings">
    <?php echo $this->form->render($this) ?>
  </div>
<?php else: ?>
  <div class="tip">
    Your message has been queued for sending.
  </div>
<?php endif; ?>
