<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="header_top clearfix">
	<div class="header_top_container clearfix">
    <?php if($this->show_menu): ?>	
      <div class="sidebar_panel_menu_btn">
        <a href="javascript:void(0);" id="sidebar_panel_menu_btn"><i></i></a>
      </div>
    <?php endif; ?> 
    <?php if($this->show_logo):?>
      <div class="header_logo">
        <?php echo $this->content()->renderWidget('sesytube.menu-logo'); ?>
      </div>
      <div class="sesytube_header_currencydropdown"><ul class="sesytube_currencydropdown"></ul></div>
    <?php endif; ?>
    <?php if($this->show_search):?>
      <a href="javascript:void(0);" class="mobile_search_toggle_btn fa fa-search" id="mobile_search_toggle"></a>
    <?php endif; ?>
    <div class="minimenu_search_box" id="minimenu_search_box">
      <?php if($this->show_search):
        if(defined('sesadvancedsearch')){
            echo $this->content()->renderWidget("advancedsearch.search");
        }else{
            echo $this->content()->renderWidget("sesytube.search");
        }
        ?>
      <?php endif; ?>    
    </div>
    <?php if($this->show_mini):?>
      <div class="header_minimenu">
        <?php echo $this->content()->renderWidget("sesytube.menu-mini"); ?>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php if($this->show_menu):?>
	<div class="header_main_menu clearfix" id="sesytube_main_menu">
    <div class="header_main_menu_container">
      <?php echo $this->content()->renderWidget("sesytube.menu-main"); ?>
    </div>
	</div>
<?php endif; ?>
<script>
	jqueryObjectOfSes(document).ready(function(e){
	var height = jqueryObjectOfSes('.layout_page_header').height();
		if($('global_wrapper')) {
	    $('global_wrapper').setStyle('margin-top', height+"px");
	  }
	});
</script>
<script type="text/javascript">
  sesJqueryObject(document).on('click','#mobile_search_toggle',function(){
    if(sesJqueryObject (this).hasClass('active')){
     sesJqueryObject (this).removeClass('active');
     sesJqueryObject ('.minimenu_search_box').removeClass('open_search');
    }else{
     sesJqueryObject (this).addClass('active');
     sesJqueryObject ('.minimenu_search_box').addClass('open_search');
    }
 });
    	
<?php if($this->show_menu && (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesytube.header.design', 2) == 2)){ ?>
	sesJqueryObject ("body").addClass('sidebar-panel-enable');
<?php } ?>
</script>
