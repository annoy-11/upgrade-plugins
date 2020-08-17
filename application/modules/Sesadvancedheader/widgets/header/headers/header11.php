<?php  ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvancedheader/externals/styles/header11.css'); ?>
<div class="advance_header_main sesbasic_bxs sesbasic_clearfix">
  <div class="header_background_opacity"></div>
  <div class="header_normal">
    <div class="header_bottom_main">
      <div class="header_bottom sesbasic_clearfix">
        <div class="header_left">
          <?php if(in_array('logo',$this->header_options)) { ?>
            <?php include 'logo.tpl'; ?>
          <?php } ?>
        </div>
        <?php if(in_array('search',$this->header_options)){ ?>
          <div id="header_searchbox">
            <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('advancedsearch')) { 
				 		echo $this->content()->renderWidget("advancedsearch.search");
					}else{
           include 'search.tpl'; 
        } ?>
          </div>
        <?php } ?>
        <?php if(in_array('mainMenu',$this->header_options)){ ?>
          <div class="header_main_menu">
            <a href="javascript:void();" class="header_main_menu_more"><?php echo $this->translate($this->moretext); ?></a>
            <?php include 'mainmenu.tpl'; ?>
          </div>
        <?php } ?>
        <?php if(in_array('ads',$this->header_options)) { ?>
          <?php include 'ads.tpl'; ?>
        <?php } ?>
        <?php if(in_array('miniMenu',$this->header_options)) { ?>
          <div class="mini_menu_section">
            <?php include 'minimenu.tpl'; ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="header_fix sesbasic_clearfix">
  	<?php include 'header_fix.tpl'; ?>
  </div>
</div>
