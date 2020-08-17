<?php  ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvancedheader/externals/styles/header2.css'); ?>
<div class="advance_header_main sesbasic_bxs sesbasic_clearfix">
  <div class="header_background_opacity"></div>
	<div class="header_normal">
    <div class="header_top">
      <?php if(in_array('search',$this->header_options)) { ?>
        <div class="header_left">
           <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('advancedsearch')) { 
				 		echo $this->content()->renderWidget("advancedsearch.search");
					}else{
           include 'search.tpl'; 
        } ?>
        </div>
      <?php } ?>
      <?php if(in_array('miniMenu',$this->header_options)) { ?>
        <div class="header_right">
          <?php include 'minimenu.tpl'; ?>
        </div>
      <?php } ?>
      <?php if(in_array('logo',$this->header_options)) { ?>
        <div class="header_middle">
          <?php include 'logo.tpl'; ?>
        </div>
      <?php } ?>
    </div>
     <?php if(in_array('mainMenu',$this->header_options)) { ?>
    <div class="header_bottom">
      <div class="header_bottom_inner sesbasic_clearfix">
           <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmenu')) { ?>
            <?php echo $this->content()->renderWidget("sesmenu.main-menu"); ?>
         <?php } else { ?>
          <div class="header_main_menu">
            <?php include 'mainmenu.tpl'; ?>
          </div>
           <?php } ?>
        </div>
     </div>
   <?php } ?>
  </div>
</div>
