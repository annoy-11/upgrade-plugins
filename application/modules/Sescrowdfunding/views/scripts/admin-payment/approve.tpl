<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: approve.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(!$this->disable_gateway){ ?>
<div class='sesbasic_popup_form'>
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
