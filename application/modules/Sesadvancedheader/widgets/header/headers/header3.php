<?php  ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvancedheader/externals/styles/header3.css'); ?>
<div class="advance_header_main sesbasic_bxs sesbasic_clearfix">
<div class="header_background_opacity"></div>
	<div class="header_normal">
  	<div class="header_top">
      <?php if(in_array('miniMenu',$this->header_options)) { ?>
        <div class="header_left">
          <div class="mini_menu_section">
           <?php include 'minimenu.tpl'; ?>
          </div>
        </div>
      <?php } ?>
      <?php if(in_array('mainMenu',$this->header_options)) { ?>
        <div class="header_right">
          <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmenu')) { ?>
            <?php echo $this->content()->renderWidget("sesmenu.main-menu"); ?>
         <?php } else { ?>
          <div class="header_main_menu">
            <?php include 'mainmenu.tpl'; ?>
          </div>
           <?php } ?>
        </div>
      <?php } ?>
    </div>
  	<div class="header_bottom">
      <div class="header_bottom_inner">
        <?php if(in_array('logo',$this->header_options)){ ?>
          <?php include 'logo.tpl'; ?>
        <?php } ?>
         <?php if(in_array('search',$this->header_options) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('advancedsearch')) { 
				 		echo $this->content()->renderWidget("advancedsearch.search");
					}else{
           include 'search.tpl'; 
        } ?>
        <?php if(in_array('ads',$this->header_options)) { ?>
          <?php include 'ads.tpl'; ?>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="header_fix">
  	<?php include 'header_fix.tpl'; ?>
  </div>
</div>
