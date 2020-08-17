<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-category.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Seswishe/views/scripts/dismiss_message.tpl';?>
<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seswishe', 'controller' => 'categories', 'action' => 'index'), $this->translate("Back to Manage Categories"), array('class'=>'sesbasic_icon_back buttonlink')) ?>
<br /><br />
<div class='settings sesbasic_admin_form'>
  <?php echo $this->form->render($this); ?>
</div>
