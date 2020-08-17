<?php  ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvancedheader/externals/styles/header14.css'); ?>
<div class="advance_header_main sesbasic_bxs sesbasic_clearfix">
  <div class="header_background_opacity"></div>
	<div class="header_main header_normal sesbasic_clearfix">
    <div class="header_top sesbasic_clearfix">
     <div class="header_top_inner">
      <div class="advance_menu">
        <?php if(in_array('socialshare',$this->header_options)) { ?>
          <?php include 'extra_links.tpl'; ?>
        <?php } ?>
      </div>
      <?php if(in_array('search',$this->header_options)){ ?>
        <div class="header_search_main">
          <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('advancedsearch')) { 
				 		echo $this->content()->renderWidget("advancedsearch.search");
					}else{
           include 'search.tpl'; 
        } ?>
        </div>
      <?php } ?>
       <?php if(in_array('miniMenu',$this->header_options)){ ?>
        <div class="mini_menu_section">
          <?php include 'minimenu.tpl'; ?>
        </div>
      <?php } ?>
        </div>
      </div>
    </div>
    <div class="header_middel header_left">
      <?php if(in_array('logo',$this->header_options)) { ?>
        <?php include 'logo.tpl'; ?>
      <?php } ?>
       <?php if(in_array('mainMenu',$this->header_options)){ ?>
          <div class="header_main_menu">
            <?php include 'mainmenu.tpl'; ?>
          </div>
        <?php } ?>
        <div class="header_collapse">
           <a class="collapse_left"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>Collapse Menu</a>
           <a class="collapse_right" style="display:none;"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
        </div>
    </div>
  </div>
  <div class="header_fix">
  	<?php include 'header_fix.tpl'; ?>
  </div>
</div>
<script>
sesJqueryObject(document).ready(function(){
				sesJqueryObject(".collapse_left").click(function(){
       sesJqueryObject("body").addClass("collapsed_menu");
    });
		sesJqueryObject(".collapse_right").click(function(){
       sesJqueryObject("body").removeClass("collapsed_menu");
    });
});
</script>
