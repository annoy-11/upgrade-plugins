<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div id="socialtube_custom_menu_tab_container" class="socialtube_browse_nav sesbasic_clearfix"><div id="socialtube_custom_menu" class="socialtube_browse_nav_inner"></div></div>
<?php
	$request = Zend_Controller_Front::getInstance()->getRequest();
	$moduleName = $request->getModuleName();
?>
<script type="application/javascript">
sesJqueryObject(document).ready(function(e){
	var socialtube_menu_height = sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu').height() + 10;
	if(sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu').length){
		sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu').hide();
		var sesCustomMenu = sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu');
		sesCustomMenu.remove();
		var sescustommenuParent = sesJqueryObject('.layout_top').find('.layout_middle');
		if(!sescustommenuParent.html().trim())
      sescustommenuParent.remove();
      
		sesJqueryObject('#socialtube_custom_menu').html(sesCustomMenu.html());
		sesJqueryObject('#socialtube_custom_menu_tab_container').height(socialtube_menu_height + 'px');
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