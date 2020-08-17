<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemoji
 * @package    Sesemoji
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2017-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<h2><?php echo $this->translate("SESEMOJI_PLUGIN") ?></h2>
<?php $sesemoji_adminmenu = Zend_Registry::isRegistered('sesemoji_adminmenu') ? Zend_Registry::get('sesemoji_adminmenu') : null; ?>
<?php if($sesemoji_adminmenu) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='tabs'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
