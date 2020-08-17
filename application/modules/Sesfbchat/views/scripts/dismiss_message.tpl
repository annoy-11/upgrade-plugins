<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbchat
 * @package    Sesfbchat
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2019-01-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo "FB Messenger Customer Live Chat Plugin" ?></h2>
<?php $sesfbchat_adminmenu = Zend_Registry::isRegistered('sesfbchat_adminmenu') ? Zend_Registry::get('sesfbchat_adminmenu') : null; ?>
<?php if($sesfbchat_adminmenu) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='tabs'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
