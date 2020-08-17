<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-team-member.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sessportz/views/scripts/dismiss_message.tpl';?>

<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessportz', 'controller' => 'manageteam', 'action' => 'index'), $this->translate("Back to Manage Team"), array('class'=>'sesbasic_icon_back buttonlink')) ?>
<br class="clear" /><br />

<div class='settings sesbasic_admin_form'>
  <?php echo $this->form->render($this) ?>
</div>
