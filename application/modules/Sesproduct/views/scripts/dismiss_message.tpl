
<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $estore_estoreadminmenu = Zend_Registry::isRegistered('estore_estoreadminmenu') ? Zend_Registry::get('estore_estoreadminmenu') : null; ?>

<h2><?php echo $this->translate("Stores Marketplace Plugin") ?></h2>
<?php include APPLICATION_PATH .  '/application/modules/Sesbasic/views/scripts/_mapKeyTip.tpl';?>
<div class="sesbasic_nav_btns">
  <a href="#" target = "_blank" class="request-btn"><?php echo $this->translate("Description"); ?></a>
  <a href="<?php echo $this->url(array('module' => 'Sesproduct', 'controller' => 'settings', 'action' => 'support'),'admin_default',true); ?>" target = "_blank" class="request-btn"><?php echo $this->translate("Help"); ?></a>
</div>

<?php if(!empty($estore_estoreadminmenu)) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
<?php if(!empty($this->subNavigation) && count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
<?php endif; ?>

