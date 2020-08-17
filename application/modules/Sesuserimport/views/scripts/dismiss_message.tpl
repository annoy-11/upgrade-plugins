<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesuserimport
 * @package    Sesuserimport
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("Administration Tool: Bulk Importing, Creating New / Dummy Users Plugin") ?></h2>
<?php
$sesuserimport_adminmenu = Zend_Registry::isRegistered('sesuserimport_adminmenu') ? Zend_Registry::get('sesuserimport_adminmenu') : null;
if(!empty($sesuserimport_adminmenu)) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='tabs'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
