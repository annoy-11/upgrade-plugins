<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercoverphoto
 * @package    Sesusercoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: confirmation.tpl 2016-05-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesusercover_confirm_popup sesbasic_bxs">
	<p>Are you sure you want to remove your Cover?</p>
  <div class="sesusercover_confirm_popup_btns">
  	<button onclick="javascript:window.sessmoothboxclose();">Cancel</button>
   	<button onclick="javascript:window.removeCoverPhoto();window.sessmoothboxclose();">Confirm</button>
  </div>
</div>