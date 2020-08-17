<?php ?>
<div class="header_fix_inner">
  <div class="header_logo_bottom">
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
  </div>
  <?php if(in_array('mainMenu',$this->header_options)){ ?>
      <?php $headerFix = true; ?>
      <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmenu')) { ?>
            <?php echo $this->content()->renderWidget("sesmenu.main-menu"); ?>
         <?php } else { ?>
          <div class="header_main_menu">
            <?php include 'mainmenu.tpl'; ?>
          </div>
           <?php } ?>
  <?php } ?>
  <?php if(in_array('search',$this->header_options)){ ?>
    <div class="header_scroll_serchbox">
      <a href="javascript:void(0);" class="fa fa-search search_open"></a>
      <?php if(in_array('search',$this->header_options)){ ?>
        <div class="header_bottom_searchbox">
          <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('advancedsearch')) { 
				 		echo $this->content()->renderWidget("advancedsearch.search");
					}else{
           include 'search.tpl'; 
        } ?>
        </div>
      <?php } ?>
    </div>
  <?php } ?>
</div>