 <?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("Responsive Body Theme") ?></h2>
<?php $sesbody_adminmenu = Zend_Registry::isRegistered('sesbody_adminmenu') ? Zend_Registry::get('sesbody_adminmenu') : null; ?>
<?php if($sesbody_adminmenu) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='tabs'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
