<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-category.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesqa/views/scripts/dismiss_message.tpl';?>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/ses-scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/ses-scripts/jquery.min.js'); ?>
<div class='clear sesqa-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesqa-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render(); ?>
      </div>
    <?php endif; ?>
    <div class="sesqa-form-cont">
     <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesqa', 'controller' => 'categories', 'action' => 'index'), $this->translate("Back to Manage Categories"), array('class'=>'sesqa_icon_back buttonlink')) ?>
      <br /><br />
      <div class='settings sesqa_admin_form'>
        <?php echo $this->form->render($this); ?>
      </div>
    </div>
  </div>
</div>