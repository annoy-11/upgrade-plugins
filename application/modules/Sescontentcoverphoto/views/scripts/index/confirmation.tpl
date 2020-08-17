<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontentcoverphoto
 * @package    Sescontentcoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: confirmation.tpl 2016-06-020 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesusercover_confirm_popup sesbasic_bxs">
	<p><?php echo $this->translate("Are you sure you want to remove your Cover Photo?"); ?></p>
  <div class="sesusercover_confirm_popup_btns">
  	<button onclick="javascript:window.sessmoothboxclose();"><?php echo $this->translate("Cancel"); ?></button>
   	<button onclick="javascript:window.removeCoverPhoto();window.sessmoothboxclose();"><?php echo $this->translate("Confirm"); ?></button>
  </div>
</div>