<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<h2><?php echo $this->translate("Membership Subscription Badge") ?></h2>

<?php $subscriptionbadge_adminmenu = Zend_Registry::isRegistered('subscriptionbadge_adminmenu') ? Zend_Registry::get('subscriptionbadge_adminmenu') : null; ?>

<?php if(!empty($subscriptionbadge_adminmenu)) { ?>
  <?php if( count($this->navigation) ):?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
