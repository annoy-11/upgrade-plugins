<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: approve.tpl  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php if(!$this->disable_gateway){ ?>
<div class='sesgroup_approve_payment_popup'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<?php }else{?>
	  <div class="tip">
    <span>
      <?php echo $this->translate("no payment gateway enable.") ?>
    </span>
  </div>
<?php } ?>
