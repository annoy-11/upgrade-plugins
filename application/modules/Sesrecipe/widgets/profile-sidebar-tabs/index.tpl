<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesrecipe/externals/styles/styles.css'); ?>
<?php
  $base_url = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($base_url . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); 
?>
<div class="sesrecipe_sidebar_tabs sesrecipe_profile_tabs sesbasic_bxs"></div>

<script type="application/javascript">
if (matchMedia('only screen and (min-width: 767px)').matches) {
	sesJqueryObject(document).ready(function(){
	var tabs = sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').get(0).outerHTML;
	sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').remove();
	sesJqueryObject('.sesrecipe_sidebar_tabs').html(tabs);
	//sesJqueryObject('.sesrecipe_sidebar_tabs').find('.tabs_alt', '.tabs_parent' ).removeClass();
});
sesJqueryObject(document).on('click','ul#main_tabs li > a',function(){
	if(sesJqueryObject(this).parent().hasClass('more_tab'))
	  return;
	var index = sesJqueryObject(this).parent().index() + 1;
	var divLength = sesJqueryObject('.layout_core_container_tabs > div');
	for(i=0;i<divLength.length;i++){
		sesJqueryObject(divLength[i]).hide();
	}
	sesJqueryObject('.layout_core_container_tabs').children().eq(index).show();
});
sesJqueryObject(document).on('click','.tab_pulldown_contents ul li',function(){
 var totalLi = sesJqueryObject('ul#main_tabs > li').length;
 var index = sesJqueryObject(this).index();
 var divLength = sesJqueryObject('.layout_core_container_tabs > div');
	for(i=0;i<divLength.length;i++){
		sesJqueryObject(divLength[i]).hide();
	}
 sesJqueryObject('.layout_core_container_tabs').children().eq(index+totalLi).show();
});
}
</script>