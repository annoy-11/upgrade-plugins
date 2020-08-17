<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php $responseiveLayoutCheck = Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_responsive_layout'); ?>
<?php 
$request = Zend_Controller_Front::getInstance()->getRequest();
$moduleName = $request->getModuleName();
$getMainMenuTitle = Engine_Api::_()->sespagethm()->getMainMenuTitle('core_main_'.$moduleName); 
?>
<div class="sespagethm_header_4">
  <div class="header_top clearfix">
    <?php if($this->show_logo):?>
    <div class="header_logo"> <?php echo $this->content()->renderWidget('sespagethm.menu-logo'); ?> </div>
    <?php endif; ?>
    <?php if($responseiveLayoutCheck == '1' && $this->show_menu): ?>
    <div class="sespagethm_mobile_menu">
      <?php include 'mobile-menu.tpl'; ?>
    </div>
    <?php endif; ?>
    <div class="fixed_toggle_nav">
      <div class="fixed_dropdown"><i class="fa fa-bars" id="fixed_dropdown_toggle"></i>
        <ul class="fixed_dropdown_option" id="fixed_dropdown_option">
          <?php echo $this->content()->renderWidget("sespagethm.toggle-menu-main"); ?>
        </ul>
      </div>
      <span class="selected_toggle_btn"><?php echo $this->translate($getMainMenuTitle); ?></span> </div>
    <?php if($this->show_mini):?>
    <div class="header_mini_menu">
      <?php echo $this->content()->renderWidget("sespagethm.menu-mini"); ?>
    </div>
    <?php endif; ?>
    <?php if($this->show_search):?>
    <div class="header_search">
      <?php
              if(defined('sesadvancedsearch')){
                echo $this->content()->renderWidget("advancedsearch.search");
      }else{
      echo $this->content()->renderWidget("sespagethm.search");
      }
      ?>
    </div>
    <?php endif; ?>
  </div>
  <?php if($this->show_menu):?>
  <div class="sespagethm_header_main_menu"> <?php echo $this->content()->renderWidget("sespagethm.menu-main"); ?> </div>
  <?php endif;?>
</div>
<style>
  <?php if(!$this->miniUserPhoto): ?>
    .sespagethm_minimenu_links .sespagethm_minimenu_profile a img{ border-radius:0;}
  <?php  endif;?>
</style>
<script>
  sesJqueryObject(window).scroll(function() {    
      var scroll = sesJqueryObject(window).scrollTop();
      if (scroll >= 100) {
          sesJqueryObject("#global_header").addClass("sticky");
      } else {
          sesJqueryObject("#global_header").removeClass("sticky");
      }
  });
</script> 
<script>

sesJqueryObject(document).click(function(){
	sesJqueryObject('#fixed_dropdown_option').removeClass('fixed_dropdown_open');
})
sesJqueryObject(document).on('click','#fixed_dropdown_toggle', function(e){
	e.preventDefault();
	if(sesJqueryObject('#fixed_dropdown_option').hasClass('fixed_dropdown_open'))
		sesJqueryObject('#fixed_dropdown_option').removeClass('fixed_dropdown_open');
	else
		sesJqueryObject('#fixed_dropdown_option').addClass('fixed_dropdown_open');
	return false;
});
</script>
