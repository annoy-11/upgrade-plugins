<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontentcoverphoto
 * @package    Sescontentcoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl 2016-06-020 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<h2><?php echo $this->translate("Content Profiles Cover Photo Plugin") ?></h2>
<?php $sescontentcoverphoto_adminmenu = Zend_Registry::isRegistered('sescontentcoverphoto_adminmenu') ? Zend_Registry::get('sescontentcoverphoto_adminmenu') : null; ?>
<?php if($sescontentcoverphoto_adminmenu) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='tabs'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
