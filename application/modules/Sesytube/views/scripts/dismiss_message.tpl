<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("UTube Clone Theme") ?></h2>
<div class="sesbasic_nav_btns">
  <a href="<?php echo 'admin/sesytube/settings/support' ?>"  class="help-btn">Help Center</a>
</div>
<?php $sesytube_adminmenu = Zend_Registry::isRegistered('sesytube_adminmenu') ? Zend_Registry::get('sesytube_adminmenu') : null; ?>
<?php if(!empty($sesytube_adminmenu)) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
