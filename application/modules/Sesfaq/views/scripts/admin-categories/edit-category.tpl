<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-category.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sesfaq/views/scripts/dismiss_message.tpl';?>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/ses-scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/ses-scripts/jquery.min.js'); ?>
<div class='clear sesfaq-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesfaq-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render(); ?>
      </div>
    <?php endif; ?>
    <div class="sesfaq-form-cont">
     <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesfaq', 'controller' => 'categories', 'action' => 'index'), $this->translate("Back to Manage Categories"), array('class'=>'sesfaq_icon_back buttonlink')) ?>
      <br /><br />
      <div class='settings sesfaq_admin_form'>
        <?php echo $this->form->render($this); ?>
      </div>
    </div>
  </div>
</div>