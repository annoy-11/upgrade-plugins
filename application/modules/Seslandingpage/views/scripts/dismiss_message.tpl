<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("Custom/Content/Members Widget Collection") ?></h2>

<?php $seslandingpage_adminmenu = Zend_Registry::isRegistered('seslandingpage_adminmenu') ? Zend_Registry::get('seslandingpage_adminmenu') : null; ?>
<?php if($seslandingpage_adminmenu) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='tabs'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
