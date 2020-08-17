<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<h2><?php echo $this->translate("Page Theme") ?></h2>
<?php 
$sespagethm_adminmenu = Zend_Registry::isRegistered('sespagethm_adminmenu') ? Zend_Registry::get('sespagethm_adminmenu') : null;
if(!empty($sespagethm_adminmenu)) { ?>
<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>
<?php } ?>
