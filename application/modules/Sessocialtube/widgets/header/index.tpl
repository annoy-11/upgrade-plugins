<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $responseiveLayoutCheck = Engine_Api::_()->sessocialtube()->getContantValueXML('socialtube_responsive_layout'); ?>
<?php if($this->header_template == '1'): ?>
	<div class="socialtube_header_1">
  	<div class="header_top">
     <?php if($this->show_logo):?>
      <div class="header_logo">
        <?php echo $this->content()->renderWidget('sessocialtube.menu-logo'); ?>
      </div>
     <?php endif; ?>
      <?php if($responseiveLayoutCheck == '1' && $this->show_menu): ?>
	      <div class="socialtube_mobile_menu">
	        <?php include 'mobile-menu.tpl'; ?>
	      </div>
      <?php endif; ?>
       <?php if($this->show_mini):?>
      <div class="header_mini_menu">
        <?php echo $this->content()->renderWidget("sessocialtube.menu-mini"); ?>
      </div>
      <?php endif; ?>
       <?php if($this->show_search):?>
      <div class="header_search">
          <?php
              if(defined('sesadvancedsearch')){
                echo $this->content()->renderWidget("advancedsearch.search");
              }else{
              echo $this->content()->renderWidget("sessocialtube.search")<?php
              if(defined('sesadvancedsearch')){
                echo $this->content()->renderWidget("advancedsearch.search");
          }else{
          echo $this->content()->renderWidget("sessocialtube.search");
          }
          ?><?php
              if(defined('sesadvancedsearch')){
                echo $this->content()->renderWidget("advancedsearch.search");
          }else{
          echo $this->content()->renderWidget("sessocialtube.search");
          }
          ?><?php
              if(defined('sesadvancedsearch')){
                echo $this->content()->renderWidget("advancedsearch.search");
          }else{
          echo $this->content()->renderWidget("sessocialtube.search");
          }
          ?>;
              }
          ?>
      </div>
     <?php endif; ?>
    </div>
    <?php if($this->show_menu):?>
    <div class="socialtube_header_main_menu">
      <?php echo $this->content()->renderWidget("sessocialtube.menu-main"); ?>
    </div>
    <?php endif;?>
  </div>

<?php elseif($this->header_template == '2'):?>
  <div class="socialtube_header_2">
    <div class="header_top">
     <?php if($this->show_logo):?>
      <div class="header_logo">
        <?php echo $this->content()->renderWidget('sessocialtube.menu-logo'); ?>
      </div>
     <?php endif; ?>
      <?php if($responseiveLayoutCheck == '1' && $this->show_menu): ?>
	      <div class="socialtube_mobile_menu">
	        <?php include 'mobile-menu.tpl'; ?>
	      </div>
      <?php endif; ?>
       <?php if($this->show_mini):?>
      <div class="header_mini_menu">
        <?php echo $this->content()->renderWidget("sessocialtube.menu-mini"); ?>
      </div>
      <?php endif; ?>
       <?php if($this->show_search):?>
      <div class="header_search">
          <?php
          if(defined('sesadvancedsearch')){
            echo $this->content()->renderWidget("advancedsearch.search");
          }else{
          echo $this->content()->renderWidget("sessocialtube.search");
          }
          ?>
      </div>
      <?php endif; ?>
    </div>
    <?php if($this->show_menu):?>
    <div class="socialtube_header_main_menu">
      <?php echo $this->content()->renderWidget("sessocialtube.menu-main"); ?>
    </div>
    <?php endif;?>
  </div>  
<?php elseif($this->header_template == '3'):?>
  <div class="socialtube_header_3">
  	<div class="header_top">
     <?php if($this->show_logo):?>
      <div class="header_logo">
        <?php echo $this->content()->renderWidget('sessocialtube.menu-logo'); ?>
      </div>
      <?php endif; ?>
      <?php if($responseiveLayoutCheck == '1' && $this->show_menu): ?>
	      <div class="socialtube_mobile_menu">
	        <?php include 'mobile-menu.tpl'; ?>
	      </div>
      <?php endif; ?>
      <?php if($this->show_mini):?>
      <div class="header_mini_menu">
        <?php echo $this->content()->renderWidget("sessocialtube.menu-mini"); ?>
      </div>
      <?php endif; ?>
       <?php if($this->show_search):?>
      <div class="header_search">
          <?php
          if(defined('sesadvancedsearch')){
            echo $this->content()->renderWidget("advancedsearch.search");
          }else{
          echo $this->content()->renderWidget("sessocialtube.search");
          }
          ?>
      </div>
      <?php  endif; ?>
    </div>
    <?php if($this->show_menu):?>
      <div class="socialtube_header_main_menu">
      <?php echo $this->content()->renderWidget("sessocialtube.menu-main"); ?>
    </div>
    <?php endif;?>
  </div>
<?php elseif($this->header_template == '4'):?>
  <div class="socialtube_header_4">
  	<div class="header_top clearfix">
     <?php if($this->show_logo):?>
      <div class="header_logo">
        <?php echo $this->content()->renderWidget('sessocialtube.menu-logo'); ?>
      </div>
      <?php endif; ?>
      <?php if($responseiveLayoutCheck == '1' && $this->show_menu): ?>
	      <div class="socialtube_mobile_menu">
	        <?php include 'mobile-menu.tpl'; ?>
	      </div>
      <?php endif; ?>
       <?php if($this->show_mini):?>
      <div class="header_mini_menu">
        <?php echo $this->content()->renderWidget("sessocialtube.menu-mini"); ?>
      </div>
      <?php endif; ?>
       <?php if($this->show_search):?>
      <div class="header_search">
          <?php
          if(defined('sesadvancedsearch')){
            echo $this->content()->renderWidget("advancedsearch.search");
          }else{
          echo $this->content()->renderWidget("sessocialtube.search");
          }
          ?>
      </div>
      <?php endif; ?>
    </div>
    <?php if($this->show_menu):?>
  	<div class="socialtube_header_main_menu">
    <?php echo $this->content()->renderWidget("sessocialtube.menu-main"); ?>
  </div>
  <?php endif;?>
  </div>

<?php elseif($this->header_template == '5'):?>
	<div class="socialtube_header_5" style="height:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('socialtube.header.height', '130px');?>">
  	<div class="header_top clearfix">
     <?php if($this->show_logo):?>
        <div class="header_logo">
          <?php echo $this->content()->renderWidget('sessocialtube.menu-logo'); ?>
        </div>
      <?php endif; ?>
      <?php if($responseiveLayoutCheck == '1' && $this->show_menu): ?>
	      <div class="socialtube_mobile_menu">
	        <?php include 'mobile-menu.tpl'; ?>
	      </div>
      <?php endif; ?>
      <?php if($this->show_mini):?>
        <div class="header_mini_menu">
          <?php echo $this->content()->renderWidget("sessocialtube.menu-mini"); ?>
        </div>
      <?php endif; ?>
      <?php if($this->show_search):?>
        <div class="header_search">
            <?php
              if(defined('sesadvancedsearch')){
                echo $this->content()->renderWidget("advancedsearch.search");
            }else{
            echo $this->content()->renderWidget("sessocialtube.search");
            }
            ?>
        </div>
      <?php endif; ?>
    </div>
    <?php if($this->show_menu):?>
      <div class="socialtube_header_main_menu <?php if(!$this->nav_position): ?>from_right <?php endif;?>">
        <?php echo $this->content()->renderWidget("sessocialtube.menu-main"); ?>
      </div>
    <?php endif; ?>
  </div>
<?php elseif($this->header_template == '6'): ?>
	<div class="socialtube_header_6 sesbasic_clearfix">
  	<?php if($this->show_logo):?>
      <div class="header_logo">
        <?php echo $this->content()->renderWidget('sessocialtube.menu-logo'); ?>
      </div>
   	<?php endif; ?>
     <?php if($responseiveLayoutCheck == '1' && $this->show_menu): ?>
        <div class="socialtube_mobile_menu">
          <?php include 'mobile-menu.tpl'; ?>
        </div>
     <?php endif; ?>
    <?php if($this->show_menu):?>
      <div class="socialtube_header_main_menu">
      	<?php echo $this->content()->renderWidget("sessocialtube.menu-main"); ?>
      </div>
    <?php endif;?>
     <?php if($this->show_mini):?>
      <div class="header_mini_menu">
        <?php echo $this->content()->renderWidget("sessocialtube.menu-mini"); ?>
      </div>
    <?php endif; ?>
     <?php if($this->show_search):?>
      <div class="header_search">
          <?php
              if(defined('sesadvancedsearch')){
                echo $this->content()->renderWidget("advancedsearch.search");
          }else{
          echo $this->content()->renderWidget("sessocialtube.search");
          }
          ?>
      </div>
     <?php endif; ?>

  </div>
<?php endif;?>
<?php if($this->header_template == '5'):?>
  <?php if(count($this->header_images)):?>  
    <style type="text/css">
    .layout_page_header{background-image:url(<?php echo Engine_Api::_()->storage()->get($this->header_images['0']['file_id'], '')->getPhotoUrl(); ?>);}
    </style>
  <?php endif;?>
<?php endif;?> 
<?php if(!$this->miniUserPhoto): ?>
  <style>
  .socialtube_minimenu_links .socialtube_minimenu_profile a img{ border-radius:0;}
  </style>
<?php  endif;?>
