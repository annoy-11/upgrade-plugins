<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-category.tpl  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesdiscussion/views/scripts/dismiss_message.tpl';?>
<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdiscussion', 'controller' => 'categories', 'action' => 'index'), $this->translate("Back to Manage Categories"), array('class'=>'sesbasic_icon_back buttonlink')) ?>
<br /><br />
<div class='settings sesbasic_admin_form'>
  <?php echo $this->form->render($this); ?>
</div>
