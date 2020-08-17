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

<h2><?php echo $this->translate("Professional Search Plugin") ?></h2>
<div class="sesbasic_nav_btns">,
  <a href="<?php echo $this->url(array('module' => 'advancedsearch', 'controller' => 'settings', 'action' => 'help'),'admin_default',true); ?>" class="help-btn">Help Center</a>
</div>

<?php $advancedsearch_adminmenu = Zend_Registry::isRegistered('advancedsearch_adminmenu') ? Zend_Registry::get('advancedsearch_adminmenu') : null; ?>

<?php if(!empty($advancedsearch_adminmenu)) { ?>
  <?php if( count($this->navigation) ):?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
