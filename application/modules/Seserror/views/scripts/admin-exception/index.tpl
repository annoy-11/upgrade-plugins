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
<?php include APPLICATION_PATH .  '/application/modules/Seserror/views/scripts/dismiss_message.tpl';?>
<h3 style="margin-bottom:6px;"><?php echo $this->translate("Exception Page Design Template Settings"); ?></h3>
<p><?php echo $this->translate("Here, you can configure the design template settings for the Exception page on your website."); ?></p>
<br style="clear:both;" />

<div class='tabs'>
  <ul class="navigation">
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seserror', 'controller' => 'exception'), $this->translate('General Settings')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seserror', 'controller' => 'exception', 'action' => 'designs'), $this->translate('Designs')) ?>
    </li>
  </ul>
</div>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready',function() {
    hideoption('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.exceptionenable', 1);?>');
  });


function hideoption(value) {

  if(value == 1) {
    $('seserror_exceptionpagetext1-wrapper').style.display = 'block';
    $('seserror_exceptionpagetext2-wrapper').style.display = 'block';
    $('seserror_exceptionpagetext3-wrapper').style.display = 'block';
  } else if(value == 0) {
    $('seserror_exceptionpagetext1-wrapper').style.display = 'none';
    $('seserror_exceptionpagetext2-wrapper').style.display = 'none';
    $('seserror_exceptionpagetext3-wrapper').style.display = 'none';
  }
}

</script>
