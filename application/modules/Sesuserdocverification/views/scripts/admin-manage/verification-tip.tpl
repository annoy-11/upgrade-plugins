<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: verification-tip.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesuserdocverification/views/scripts/dismiss_message.tpl';?>

<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<?php $distip = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserdocverification.distip', 1); ?>

<script type="text/javascript">
 
  window.addEvent('domready',function() {
    showhide('<?php echo $distip;?>');
  });
  
  function showhide(value) {
    if(value == 1) {
			document.getElementById('sesuserdocverification_dotypetip-wrapper').style.display = 'block';
		} else {
			document.getElementById('sesuserdocverification_dotypetip-wrapper').style.display = 'none';
    }
  }
</script>
