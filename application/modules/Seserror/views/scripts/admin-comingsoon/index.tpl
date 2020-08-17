<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<?php include APPLICATION_PATH .  '/application/modules/Seserror/views/scripts/dismiss_message.tpl';?>

<h3 style="margin-bottom:6px;"><?php echo $this->translate("Coming Soon Page Design Template Settings"); ?></h3>
<p><?php echo $this->translate("Here, you can configure the design template settings for the Coming Soon page on your website."); ?></p>
<br style="clear:both;" />

<div class='tabs'>
  <ul class="navigation">
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seserror', 'controller' => 'comingsoon'), $this->translate('General Settings')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seserror', 'controller' => 'comingsoon', 'action' => 'designs'), $this->translate('Designs')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seserror', 'controller' => 'visitors', 'action' => 'index'), $this->translate('Manage Visitors')) ?>
    </li>
  </ul>
</div>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="text/javascript">
  if(!sesJqueryObject('#seserror_comingsoondate-hour').val()) {
    sesJqueryObject('#seserror_comingsoondate-hour').children().eq(0).remove();
    sesJqueryObject('#seserror_comingsoondate-hour').prepend('<option value="0"></option>');
    sesJqueryObject('#seserror_comingsoondate-hour').val(1);
  }
  if(!sesJqueryObject('#seserror_comingsoondate-minute').val()) {
    sesJqueryObject('#seserror_comingsoondate-minute').children().eq(0).remove();
    sesJqueryObject('#seserror_comingsoondate-minute').prepend('<option value="0"></option>');
    sesJqueryObject('#seserror_comingsoondate-minute').val(10);
  }
  $('seserror_comingsoondate-hour').hide();
  $('seserror_comingsoondate-minute').hide();
  $('seserror_comingsoondate-ampm').hide();
</script>