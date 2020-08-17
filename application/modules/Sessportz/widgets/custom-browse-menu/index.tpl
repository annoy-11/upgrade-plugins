<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div id="sessportz_custom_menu_tab_container" class="sessportz_browse_nav sesbasic_clearfix"><div id="sessportz_custom_menu" class="sessportz_browse_nav_inner"></div></div>
<?php
	$request = Zend_Controller_Front::getInstance()->getRequest();
	$moduleName = $request->getModuleName();
?>
<script type="application/javascript">
sesJqueryObject(document).ready(function(e){
	var elegant_menu_height = sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu').height();
	if(sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu').length){
		sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu').hide();
		sesJqueryObject('#sessportz_custom_menu').html(sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu').html());
		sesJqueryObject('#sessportz_custom_menu_tab_container').height(elegant_menu_height + 'px');
		var height = sesJqueryObject(".layout_page_header").height();
		if($("global_wrapper")) {
			$("global_wrapper").setStyle("margin-top", height+"px");
		}
	}
	
});
</script>
<style type="text/css">
.layout_<?php echo $moduleName; ?>_browse_menu{display:none;}
.sesevent_dashboard_main_nav > div,
.sesevent_dashboard_main_nav > div{background:none !important;border-width:0 !important;margin:0 !important;padding:0 !important;}
</style>

