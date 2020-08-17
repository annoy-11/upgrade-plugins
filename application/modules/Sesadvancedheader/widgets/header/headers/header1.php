<?php  ?>
<?php
	$fixedHeader = $settings->getSetting('sesadvancedheader.header.fixed', 0);
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvancedheader/externals/styles/header1.css'); ?>
<div class="advance_header_main sesbasic_bxs sesbasic_clearfix">
  <div class="header_background_opacity"></div>
	<div class="header_normal">
    <div class="header_top sesbasic_clearfix">
      <div class="header_left">
        <?php if(in_array('logo',$this->header_options)) { ?>
          <?php include 'logo.tpl'; ?>
        <?php } ?>
        <?php if(in_array('search',$this->header_options) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('advancedsearch')) { 
				 		echo $this->content()->renderWidget("advancedsearch.search");
					}else{
           include 'search.tpl'; 
        } ?>
      </div>
      <?php if(in_array('miniMenu',$this->header_options)) { ?>
        <div class="header_right">
          <?php include 'minimenu.tpl'; ?>
        </div>
      <?php } ?>
      <?php if(in_array('ads',$this->header_options)){ ?>
        <?php include 'ads.tpl'; ?>
      <?php } ?>
    </div>
    <?php if(in_array('mainMenu',$this->header_options)) { ?>
      <div class="header_bottom sesbasic_clearfix">
        <div class="header_bottom_inner sesbasic_clearfix">
           <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmenu')) { ?>
            <?php echo $this->content()->renderWidget("sesmenu.main-menu"); ?>
         <?php } else { ?>
          <div class="header_main_menu">
            <?php include 'mainmenu.tpl'; ?>
          </div>
           <?php } ?>
          <?php $settings = Engine_Api::_()->getApi('settings', 'core');
                $enableCTA = $settings->getSetting('sesadvancedheader_cta_enable', 0);
          ?>
          <?php if($enableCTA){ ?>
          <div class="header_cta_btn">
             <a href="<?php echo $settings->getSetting('sesadvancedheader_cta_url', ""); ?>"><?php echo $settings->getSetting('sesadvancedheader_cta_text', ''); ?></a>
          </div>
          <?php  } ?>
        </div>
      </div>
    <?php } ?>
  </div>
  <div class="header-fix">
  	<?php include 'header_fix.tpl'; ?>
  </div>
</div>
<script>
// sesJqueryObject(document).ready(function(){
//   sesJqueryObject("body").addClass("header_one");
// });
</script>
