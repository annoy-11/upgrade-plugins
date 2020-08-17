<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<h2><?php echo $this->translate("Professional Share Plugin") ?></h2>
<?php
$sessocialshare_adminmenu = Zend_Registry::isRegistered('sessocialshare_adminmenu') ? Zend_Registry::get('sessocialshare_adminmenu') : null;
if(!empty($sessocialshare_adminmenu)) { ?>
<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>
<?php } ?>
