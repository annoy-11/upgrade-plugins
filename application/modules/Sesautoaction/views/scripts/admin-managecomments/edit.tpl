<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesautoaction/views/scripts/dismiss_message.tpl';?>

<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesautoaction', 'controller' => 'managecomments', 'action' => 'index'), "Back to Manage Comments", array('class'=>'sesbasic_icon_back buttonlink')) ?>
<br /><br />
<div class='settings sesbasic_admin_form'>
  <?php echo $this->form->render($this); ?>
</div>
