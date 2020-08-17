<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvanceheader/externals/styles/styles.css'); ?>
<?php $widgetParams = $this->widgetParams; ?>
<div class="sesadvheader_banner_main sesbasic_bxs" style="height:<?php echo $widgetParams['height']; ?>px;">
	<div class="sesadvheader_banner_inner" style="height:<?php echo $widgetParams['height']; ?>px;background-image:url(<?php echo $widgetParams['backgroundimage']; ?>);">
  	<div class="sesadvheader_custom_navigation_banner_opacity"></div>
  	<div id="sesadvheader_custom_navigation_banner" class="<?php echo $widgetParams['textalignment']; ?>"></div>
  </div>  
 </div>
<?php
	$request = Zend_Controller_Front::getInstance()->getRequest();
	$moduleName = $request->getModuleName();
	
?>
<script type="application/javascript">
 var htmlElement = document.getElementsByTagName("body")[0];
 htmlElement.removeClass('sesadvheader_banner_add');
sesJqueryObject(document).ready(function(e) {
    var bowsermenulength = sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu').find('.tabs').find('ul').length;
      if(bowsermenulength == 0){
        sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu').hide();
    }
    if(sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu').length) {
    
      sesJqueryObject ("body").addClass('sesadvheader_menubanner');

      var navigationMenu = sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu').find('.headline');
      var finalNavigationTitle = "<h2>"+navigationMenu.find('h2').html()+"</h2>";
      sesJqueryObject('#sesadvheader_custom_navigation_banner').html(finalNavigationTitle);
      navigationMenu.find('h2').remove();
     
    } else {
      sesJqueryObject('.layout_sesadvheader_custom_navigation_menu').hide();
    }
		
		
		//var bowserbreadcum = sesJqueryObject('div[class^="layout_<?php echo $moduleName; ?>_breadcrumb"]');
		var bowserbreadcum = sesJqueryObject('.layout_sesalbum_breadcrumb_album_view');
		if(bowserbreadcum.length != 0){
			sesJqueryObject('#sesadvheader_custom_navigation_banner').html('<div class="view_page_banner_title">'+bowserbreadcum.html()+"</div>");
			bowserbreadcum.hide();
		}
});
</script>