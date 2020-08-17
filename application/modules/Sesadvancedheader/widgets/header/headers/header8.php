<?php  ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvancedheader/externals/styles/header8.css'); ?>
<div class="advance_header_main sesbasic_bxs sesbasic_clearfix">
  <div class="header_background_opacity"></div>
	<div class="header_top sesbasic_clearfix">
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
    <?php if(in_array('mainMenu',$this->header_options)) { ?>
      <div class="header_middle">
        <a href="javascript:void(0);" class="main_menu_toggle"><i class="fa fa-bars main_menu_toggle_btn"></i></a>
        <div class="header_main_menu">
          <?php include 'mainmenu.tpl'; ?>
        </div>
      </div>
    <?php } ?>
    <?php if(in_array('miniMenu',$this->header_options)) { ?>
      <div class="header_right">
        <div class="mini_menu_section">
         <?php include 'minimenu.tpl'; ?>
        </div>
      </div>
    <?php } ?>
  </div>
  <div class="header_fix sesbasic_clearfix">
  	<div class="header_fix_inner">
    <div class="header_left">
			<?php if(in_array('logo',$this->header_options)) { ?>
        <?php if($this->headerfixedlogo): ?>
          <div class="header_logo">
            <?php $headerlogo = $this->baseUrl() . '/' . $this->headerfixedlogo; ?>
            <a href="<?php echo $this->baseUrl(); ?>"><img style="height:<?php echo $settings->getSetting('sesadvancedheader.fixed.height', 27); ?>px;margin-top:<?php echo $settings->getSetting('sesadvancedheader.fixed.margintop', 0) ?>px;" alt="<?php echo $this->siteTitle; ?>" src="<?php echo $headerlogo ?>"></a>
          </div>
        <?php else: ?>
          <div class="header_logo">
            <a href="<?php echo $this->baseUrl(); ?>"><?php echo $this->siteTitle; ?></a>
          </div>
        <?php endif; ?>
      <?php } ?>
      <?php if(in_array('search',$this->header_options) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('advancedsearch')) { 
				 		echo $this->content()->renderWidget("advancedsearch.search");
					}else{
           include 'search.tpl'; 
        } ?>
    </div>
    <?php if(in_array('mainMenu',$this->header_options)) { ?>
      <div class="header_middle">
        <a href="javascript:void(0);" class="main_menu_toggle"><i class="fa fa-bars main_menu_toggle_btn"></i></a>
        <div class="header_main_menu">
          <?php include 'mainmenu.tpl'; ?>
        </div>
      </div>
    <?php } ?>
    </div>
  </div>
</div>
<script type="application/javascript">
  sesJqueryObject(document).on('click','.main_menu_toggle_btn',function(e){
    if(sesJqueryObject(this).hasClass('active')){
      //close menu
      sesJqueryObject(this).removeClass('active');
      sesJqueryObject(this).parent().parent().find('.header_main_menu').removeClass('header_sidebar_panel');
    }else{
      //open menu
      sesJqueryObject(this).addClass('active');
      sesJqueryObject(this).parent().parent().find('.header_main_menu').addClass('header_sidebar_panel');
    }
  });

  sesJqueryObject(document).on('click','.sidepabel_menu_btn',function(e){
    sesJqueryObject('.header_sidebar_panel').removeClass('header_sidebar_panel');
    sesJqueryObject('.main_menu_toggle_btn').removeClass('active');
  });
</script>
