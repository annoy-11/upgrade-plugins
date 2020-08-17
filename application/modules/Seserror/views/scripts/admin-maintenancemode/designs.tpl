<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: designs.tpl 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Seserror/views/scripts/dismiss_message.tpl';?>
<h3 style="margin-bottom:6px;"><?php echo $this->translate("Maintenance Mode Page Design Template Settings"); ?></h3>
<p><?php echo $this->translate("Here, you can configure the design template settings for the Maintenance Mode page on your website. <br /> Note: Below, the text for this error page can not be translated from the Language Manager. So, please enter the text in 1 language below only."); ?></p>
<br style="clear:both;" />

<div class='tabs'>
  <ul class="navigation">
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seserror', 'controller' => 'maintenancemode'), $this->translate('General Settings')) ?>
    </li>
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seserror', 'controller' => 'maintenancemode', 'action' => 'designs'), $this->translate('Designs')) ?>
    </li>
  </ul>
</div>
<div class='clear'>
  <div class='settings sesbasic_admin_form pages_design_list'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>