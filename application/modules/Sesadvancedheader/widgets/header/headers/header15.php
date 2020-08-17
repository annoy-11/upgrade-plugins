<?php  ?>

<?php
  $sesmainmenueffect = $settings->getSetting('sesadvancedheader.mainmenueffect', 'overlay');
  $overlayEffect = $settings->getSetting('sesadvancedheader.overlayeffect', 'menu_overlay');
  $pushereffect = $settings->getSetting('sesadvancedheader.pushereffect', 'menu_pusher');
  $slideeffect = $settings->getSetting('sesadvancedheader.slideeffect', 'menu_alwayhide');
	$slideeffect = $settings->getSetting('sesadvancedheader.slideeffect', 'menu_alwayshow');
	$fixedHeader = $settings->getSetting('sesadvancedheader.header.fixed', 0);
  if($sesmainmenueffect == 'overlay') {
    $mainmenueffect = $overlayEffect;
  } else if($sesmainmenueffect == 'pusher') {
    $mainmenueffect = $pushereffect;
  } else if($sesmainmenueffect == 'slide') {
    if($slideeffect == 'menu_slide_showhide') {
      $mainmenueffect = 'menu_alwayhide';
    } else if($slideeffect == 'menu_slide_alwayshow') {
      $mainmenueffect = 'menu_alwayshow';
    } else if($slideeffect == 'menu_slide_expand') {
      $mainmenueffect = 'menu_expand';
    } else if($slideeffect == 'menu_slide_collaps') {
      $mainmenueffect = 'menu_collaps';
    } else {
      $mainmenueffect = $slideeffect;
    }
  }
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvancedheader/externals/styles/header15.css'); ?>
<div class="advance_header_main sesbasic_bxs sesbasic_clearfix">
  <div class="header_background_opacity"></div>
  <?php if(empty($fixedHeader)) { ?>
	<div class="header_top sesbasic_clearfix">
  	<?php if(in_array('mainMenu',$this->header_options)) { ?>
      <div class="header_middle <?php echo $mainmenueffect; ?>">
        <a href="javascript:void(0);" class="main_menu_toggle"><i class="fa fa-bars main_menu_toggle_btn"></i></a>
        <div class="header_main_menu">
          <?php include 'mainmenu.tpl'; ?>
        </div>
      </div>
    <?php } ?>
    <div class="header_left">
      <?php if(in_array('logo',$this->header_options)) { ?>
        <?php include 'logo.tpl'; ?>
      <?php } ?>
        <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('advancedsearch')) { 
				 		echo $this->content()->renderWidget("advancedsearch.search");
					}else{
           include 'search.tpl'; 
        } ?>
    </div>
    <?php if(in_array('miniMenu',$this->header_options)){ ?>
      <div class="header_right">
        <div class="mini_menu_section">
         <?php include 'minimenu.tpl'; ?>
        </div>
      </div>
    <?php } ?>
  </div>
  </div>
  <?php } else { ?>
  <div class="header_fix sesbasic_clearfix">
  	<div class="header_fix_inner">
		<?php if(in_array('mainMenu',$this->header_options)) { ?>
      <div class="header_middle <?php echo $mainmenueffect; ?>">
        <a href="javascript:void(0);" class="main_menu_toggle"><i class="fa fa-bars main_menu_toggle_btn"></i></a>
        <div class="header_main_menu">
          <?php include 'mainmenu.tpl'; ?>
        </div>
      </div>
    <?php } ?>
    <div class="header_left">
      <?php if(in_array('logo',$this->header_options)) { ?>
        <div class="header_logo">
            <?php $headerlogo = $this->baseUrl() . '/' . $this->headerfixedlogo; ?>
            <a href="<?php echo $this->baseUrl(); ?>"><img style="height:<?php echo $settings->getSetting('sesadvancedheader.fixed.height', 27); ?>px;margin-top:<?php echo $settings->getSetting('sesadvancedheader.fixed.margintop', 15) ?>px;" alt="<?php echo $this->siteTitle; ?>" src="<?php echo $headerlogo ?>"></a>
          </div>
      <?php } ?>
        <?php if(in_array('search',$this->header_options) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('advancedsearch')) { 
				 		echo $this->content()->renderWidget("advancedsearch.search");
					}else{
           include 'search.tpl'; 
        } ?>
    </div>
    <?php if(in_array('miniMenu',$this->header_options)){ ?>
      <div class="header_right">
        <div class="mini_menu_section">
         <?php include 'minimenu.tpl'; ?>
        </div>
      </div>
    <?php } ?>
    </div>
  </div>
</div>
<?php } ?>
</div>
<script type="application/javascript">

  sesJqueryObject(document).on('click','.sidepabel_menu_btn',function(e){
    sesJqueryObject('.header_sidebar_panel').removeClass('header_sidebar_panel');
    sesJqueryObject('.main_menu_toggle_btn').removeClass('active');
  });
		var height = sesJqueryObject(".layout_sesadvancedheader_header").height();
	if($("menu_left_panel")) {
		$("menu_left_panel").setStyle("top", height+"px");
	}

	var heightPannel = sesJqueryObject("#menu_left_panel").height();
	sesJqueryObject('#global_content').css('min-height',heightPannel+'px');

  var htmlElement = document.getElementsByTagName("body")[0];

	<?php if($mainmenueffect == 'menu_alwayshow') { ?>
        htmlElement.addClass('<?php echo $slideeffect ?>');

    <?php } ?>


  sesJqueryObject(document).on('click','.main_menu_toggle',function(e) {
    <?php if($mainmenueffect == 'menu_pusher' || $mainmenueffect == 'menu_pusher_rotate') { ?>
      if(htmlElement.hasClass('globle_pusher_panle')) {
        htmlElement.removeClass('globle_pusher_panle');
      } else {
        htmlElement.addClass('globle_pusher_panle');
      }
    <?php } else if($mainmenueffect == 'menu_alwayhide') { ?>
      if(htmlElement.hasClass('<?php echo $slideeffect ?>')) {
        htmlElement.removeClass('<?php echo $slideeffect ?>');
      } else {
        htmlElement.addClass('<?php echo $slideeffect ?>');
      }
			<?php } else if($mainmenueffect == 'menu_alwayshow') { ?>
      if(htmlElement.hasClass('<?php echo $slideeffect ?>')) {
        htmlElement.removeClass('<?php echo $slideeffect ?>');
      } else {
        htmlElement.addClass('<?php echo $slideeffect ?>');
      }
    <?php } else if($mainmenueffect == 'menu_collaps') { ?>
      if(htmlElement.hasClass('<?php echo $slideeffect ?>')) {
        htmlElement.removeClass('<?php echo $slideeffect ?>');
      } else {
        htmlElement.addClass('<?php echo $slideeffect ?>');
      }
			<?php } else if($mainmenueffect == 'menu_expand') { ?>
      if(htmlElement.hasClass('<?php echo $slideeffect ?>')) {
        htmlElement.removeClass('<?php echo $slideeffect ?>');
      } else {
        htmlElement.addClass('<?php echo $slideeffect ?>');
      }
    <?php } ?>
  });
</script>
