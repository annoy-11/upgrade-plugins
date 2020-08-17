<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $responseiveLayoutCheck = Engine_Api::_()->sesspectromedia()->getContantValueXML('sm_responsive_layout'); ?>
<?php if($this->header_template == '1'): ?>
	<div class="sm_header_1">
  	<div class="header_top">
     <?php if($this->show_logo):?>
      <div class="header_logo">
        <?php echo $this->content()->renderWidget('sesspectromedia.menu-logo'); ?>
      </div>
     <?php endif; ?>
      <?php if($responseiveLayoutCheck == '1' && $this->show_menu): ?>
	      <div class="sm_mobile_menu">
	        <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmenu')) { ?>
        <?php echo $this->content()->renderWidget("sesmenu.main-menu"); ?>
      <?php } else { ?>
        <?php include 'mobile-menu.tpl'; ?>
      <?php } ?>
	      </div>
      <?php endif; ?>
       <?php if($this->show_mini):?>
      <div class="header_mini_menu">
        <?php echo $this->content()->renderWidget("sesspectromedia.menu-mini"); ?>
      </div>
      <?php endif; ?>
       <?php if($this->show_search):?>
      <div class="header_search">
          <?php
              if(defined('sesadvancedsearch')){
                echo $this->content()->renderWidget("advancedsearch.search");
          }else{
          echo $this->content()->renderWidget("sesspectromedia.search");
          }
          ?>
      </div>
     <?php endif; ?>
    </div>
    <?php if($this->show_menu):?>
    <div class="sm_header_main_menu">
       <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmenu')) { ?>
        <?php echo $this->content()->renderWidget("sesmenu.main-menu"); ?>
      <?php } else { ?>
        <?php echo $this->content()->renderWidget("sesspectromedia.menu-main"); ?>
      <?php } ?>
    </div>
    <?php endif;?>
  </div>
<?php elseif($this->header_template == '2'):?>
  <div class="sm_header_2">
    <div class="header_top">
     <?php if($this->show_logo):?>
      <div class="header_logo">
        <?php echo $this->content()->renderWidget('sesspectromedia.menu-logo'); ?>
      </div>
     <?php endif; ?>
      <?php if($responseiveLayoutCheck == '1' && $this->show_menu): ?>
	      <div class="sm_mobile_menu">
	        <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmenu')) { ?>
        <?php echo $this->content()->renderWidget("sesmenu.main-menu"); ?>
      <?php } else { ?>
        <?php include 'mobile-menu.tpl'; ?>
      <?php } ?>
	      </div>
      <?php endif; ?>
       <?php if($this->show_mini):?>
      <div class="header_mini_menu">
        <?php echo $this->content()->renderWidget("sesspectromedia.menu-mini"); ?>
      </div>
      <?php endif; ?>
       <?php if($this->show_search):?>
      <div class="header_search">
          <?php
              if(defined('sesadvancedsearch')){
                echo $this->content()->renderWidget("advancedsearch.search");
          }else{
          echo $this->content()->renderWidget("sesspectromedia.search");
          }
          ?>
      </div>
      <?php endif; ?>
    </div>
    <?php if($this->show_menu):?>
    <div class="sm_header_main_menu">
     <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmenu')) { ?>
        <?php echo $this->content()->renderWidget("sesmenu.main-menu"); ?>
      <?php } else { ?>
        <?php echo $this->content()->renderWidget("sesspectromedia.menu-main"); ?>
      <?php } ?>
    </div>
    <?php endif;?>
  </div>  
<?php elseif($this->header_template == '3'):?>
  <div class="sm_header_3">
  	<div class="header_top">
     <?php if($this->show_logo):?>
      <div class="header_logo">
        <?php echo $this->content()->renderWidget('sesspectromedia.menu-logo'); ?>
      </div>
      <?php endif; ?>
      <?php if($responseiveLayoutCheck == '1' && $this->show_menu): ?>
	      <div class="sm_mobile_menu">
	        <?php include 'mobile-menu.tpl'; ?>
	      </div>
      <?php endif; ?>
      <?php if($this->show_mini):?>
      <div class="header_mini_menu">
        <?php echo $this->content()->renderWidget("sesspectromedia.menu-mini"); ?>
      </div>
      <?php endif; ?>
       <?php if($this->show_search):?>
      <div class="header_search">
          <?php
              if(defined('sesadvancedsearch')){
                echo $this->content()->renderWidget("advancedsearch.search");
          }else{
          echo $this->content()->renderWidget("sesspectromedia.search");
          }
          ?>
      </div>
      <?php  endif; ?>
    </div>
    <?php if($this->show_menu):?>
      <div class="sm_header_main_menu">
      <?php echo $this->content()->renderWidget("sesspectromedia.menu-main"); ?>
    </div>
    <?php endif;?>
  </div>
<?php elseif($this->header_template == '4'):?>
  <div class="sm_header_4">
  	<div class="header_top clearfix">
     <?php if($this->show_logo):?>
      <div class="header_logo">
        <?php echo $this->content()->renderWidget('sesspectromedia.menu-logo'); ?>
      </div>
      <?php endif; ?>
      <?php if($responseiveLayoutCheck == '1' && $this->show_menu): ?>
	     <div class="sm_mobile_menu">
	        <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmenu')) { ?>
        <?php echo $this->content()->renderWidget("sesmenu.main-menu"); ?>
      <?php } else { ?>
        <?php include 'mobile-menu.tpl'; ?>
      <?php } ?>
	      </div>
      <?php endif; ?>
       <?php if($this->show_mini):?>
      <div class="header_mini_menu">
        <?php echo $this->content()->renderWidget("sesspectromedia.menu-mini"); ?>
      </div>
      <?php endif; ?>
       <?php if($this->show_search):?>
      <div class="header_search">
          <?php
              if(defined('sesadvancedsearch')){
                echo $this->content()->renderWidget("advancedsearch.search");
          }else{
          echo $this->content()->renderWidget("sesspectromedia.search");
          }
          ?>
      </div>
      <?php endif; ?>
    </div>
    <?php if($this->show_menu):?>
  	<div class="sm_header_main_menu">
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmenu')) { ?>
        <?php echo $this->content()->renderWidget("sesmenu.main-menu"); ?>
      <?php } else { ?>
        <?php echo $this->content()->renderWidget("sesspectromedia.menu-main"); ?>
      <?php } ?>
  </div>
  <?php endif;?>
  </div>
<?php elseif($this->header_template == '5'):?>
<div class="sm_header_5" style="height:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sm.header.height', '130px');?>">
  	<div class="header_top clearfix">
     <?php if($this->show_logo):?>
      <div class="header_logo">
        <?php echo $this->content()->renderWidget('sesspectromedia.menu-logo'); ?>
      </div>
      <?php endif; ?>
      <?php if($responseiveLayoutCheck == '1' && $this->show_menu): ?>
	      <div class="sm_mobile_menu">
	        <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmenu')) { ?>
        <?php echo $this->content()->renderWidget("sesmenu.main-menu"); ?>
      <?php } else { ?>
        <?php include 'mobile-menu.tpl'; ?>
      <?php } ?>
	      </div>
      <?php endif; ?>
       <?php if($this->show_mini):?>
      <div class="header_mini_menu">
        <?php echo $this->content()->renderWidget("sesspectromedia.menu-mini"); ?>
      </div>
      <?php endif; ?>
       <?php if($this->show_search):?>
      <div class="header_search">
      <?php
          if(defined('sesadvancedsearch')){
            echo $this->content()->renderWidget("advancedsearch.search");
          }else{
            echo $this->content()->renderWidget("sesspectromedia.search");
          }
      ?>
      </div>
      <?php endif; ?>
    </div>
    <?php if($this->show_menu):?>
  	<div class="sm_header_main_menu <?php if(!$this->nav_position): ?>from_right <?php endif;?>">
     <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmenu')) { ?>
        <?php echo $this->content()->renderWidget("sesmenu.main-menu"); ?>
      <?php } else { ?>
        <?php echo $this->content()->renderWidget("sesspectromedia.menu-main"); ?>
      <?php } ?>
  </div>
  <?php endif;?>
</div>
<?php $header_fixed = Engine_Api::_()->sesspectromedia()->getContantValueXML('sm_header_fixed_layout'); 

if($header_fixed == '1'):

?>
<script>
	jqueryObjectOfSes(document).ready(function(e){
	var height = jqueryObjectOfSes('.layout_page_header').height();
		if($('global_wrapper')) {
	    $('global_wrapper').setStyle('margin-top', height+"px");
	  }
	});
	</script>
<?php endif; ?>
<style type="text/css">
 <?php if(count($this->header_images)):?>
.layout_page_header{background-image:url(<?php echo Engine_Api::_()->storage()->get($this->header_images['0']['file_id'], '')->getPhotoUrl(); ?>);}
<?php endif;?>
</style>
<?php endif; ?>
<style>
<?php if(!$this->miniUserPhoto): ?>
.sm_minimenu_links .sm_minimenu_profile a img{ border-radius:0;}
<?php  endif;?>
</style>
