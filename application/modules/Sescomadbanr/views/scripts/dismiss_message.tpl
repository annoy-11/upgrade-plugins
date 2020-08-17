<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescomadbanr
 * @package    Sescomadbanr
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2019-03-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("Community Advertisements Banner Extension") ?></h2>
<?php $sescomadbanr_admin = Zend_Registry::isRegistered('sescomadbanr_admin') ? Zend_Registry::get('sescomadbanr_admin') : null; ?>
<?php if($sescomadbanr_admin) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='tabs'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
