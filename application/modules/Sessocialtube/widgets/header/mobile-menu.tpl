<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: login-or-signup.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<a href="javascript:void;" class="socialtube_mobile_menu_toggle" id="socialtube_mobile_menu_toggle"><i class="fa fa-bars"></i></a>
<div class="socialtube_mobile_menu_container" id="socialtube_mobile_menu_container">
  <div class="socialtube_mobile_menu_search" style="display:none;"><?php //echo $this->content()->renderWidget("sessocialtube.search"); ?></div>
  <div class="socialtube_mobile_menu_links">
    <?php echo $this->content()->renderWidget("core.menu-main"); ?>
  </div>
</div>    
<script>
$('socialtube_mobile_menu_toggle').addEvent('click', function(event){
	event.stop();
	if($('socialtube_mobile_menu_container').hasClass('show-menu'))
		$('socialtube_mobile_menu_container').removeClass('show-menu');
	else
		$('socialtube_mobile_menu_container').addClass('show-menu');
	return false;
});
</script>