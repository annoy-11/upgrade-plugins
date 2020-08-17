<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<?php if($this->progressbar->type == 'bar'){ ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/styles/pro-bars.min.css'); ?>
<!-- HTML5 SHIV -->
<!--[if lt IE 9]>
  <script src="http://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="http://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
<?php foreach($this->progressbarcontent as $cont){ ?>
	<?php $unserialize = unserialize($cont['settings']); ?>
	<div class="one-whole pro-bar-container-wrapper clear sesbasic_clearfix sespagebuilder-prc-<?php echo isset($unserialize['title_allign']) && $unserialize['title_allign'] != '' ? $unserialize['title_allign'] : 'm'; ?>" style="width:<?php echo isset($unserialize['width']) && $unserialize['width'] ? str_replace(array('px','%'),'',$unserialize['width']) : '' ; ?>px;">
  	<div class="pro-bar-container" style="background:#<?php echo $unserialize['empty_bg_color'] ? $unserialize['empty_bg_color'] :'16a085' ?>;height:<?php echo isset($unserialize['height']) && $unserialize['height'] ? str_replace(array('px','%'),'',$unserialize['height']).'px' : '20px' ; ?>;border-radius:<?php echo isset($unserialize['show_radius']) && $unserialize['show_radius'] ? '20px' : '' ;  ?>">
      <?php if($cont['title']){ ?>
        <div class="pro-bar-candy-title sesbasic_bxs" style="color:#<?php echo isset($unserialize['title_color']) && $unserialize['title_color'] != '' ? $unserialize['title_color'] : ''; ?>;line-height:<?php echo isset($unserialize['height']) && $unserialize['height'] ? str_replace(array('px','%'),'',$unserialize['height']).'px' : '20px' ; ?>"><?php echo $cont['title']; ?></div>
      <?php } ?>
      <div class="pro-bar bar-100" data-pro-bar-percent="<?php echo $unserialize['value']; ?>" style="background:#<?php echo $unserialize['filled_bg_color'] ? $unserialize['filled_bg_color'] :'16a085' ?>;;border-radius:<?php echo isset($unserialize['show_radius']) && $unserialize['show_radius'] ? '20px' : '' ;  ?>">
       <div class="pro-bar-candy candy-ltr <?php echo isset($unserialize['gradient_setting']) && $unserialize['gradient_setting'] == 'moving' ? 'animation' : '' ; ?> <?php echo isset($unserialize['gradient_setting']) && $unserialize['gradient_setting'] != 'single' ? 'background-image' : '' ; ?>" style="height:<?php echo isset($unserialize['height']) && $unserialize['height'] ? str_replace(array('px','%'),'',$unserialize['height']).'px' : '20px' ; ?>;background-size:<?php echo isset($unserialize['height']) && $unserialize['height'] ?  $unserialize['height'].'px '. $unserialize['height'].'px' : '30px 30px' ; ?>"></div>
      </div>
    </div>
	</div>
 <?php } ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/scripts/jquery-2.1.1.min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/scripts/jquery.ui.min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/scripts/smoothscroll.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/scripts/visible.min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/scripts/pro-bars.js'); ?>
<?php }else{ ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/styles/progress.css'); ?>
 <div class="pie_progress_container">
 		<?php foreach($this->progressbarcontent as $cont){ ?>
    	<?php $unserialize = unserialize($cont['settings']); ?>
      <div class="sespagebuilder_pptp_<?php echo isset($unserialize['title_allign']) && $unserialize['title_allign'] != '' ? $unserialize['title_allign'] : 'm'; ?> pie_progress_<?php echo $this->identity.'_'.$cont["progressbarcontent_id"]; ?>" role="progressbar" data-goal="<?php echo $unserialize['value']; ?>" data-barcolor="#<?php echo  $unserialize['filled_bg_color'] ? $unserialize['filled_bg_color'] : 10; ?>" data-barsize="<?php echo  $unserialize['circle_width'] ? $unserialize['circle_width'] : 10; ?>" aria-valuemin="0" aria-valuemax="100">
      <?php if(isset($unserialize['show_count']) && $unserialize['show_count']){ ?>
          <span class="pie_progress__number"></span>
      <?php } ?>
          <?php if($cont['title']){ ?>
            <span class="pie_progress_title pie_progress__label" style="color:#<?php echo isset($unserialize['title_color']) && $unserialize['title_color'] != '' ? $unserialize['title_color'] : ''; ?>"><?php echo $cont['title']; ?></span>
          <?php } ?>
      </div>
      <style type="text/css">
				.pie_progress_<?php echo $this->identity.'_'.$cont["progressbarcontent_id"]; ?> {
						width: <?php echo isset($unserialize['width']) && $unserialize['width'] ? str_replace(array('px','%'),'',$unserialize['width']) : '160' ; ?>px;
				}
			</style>
      <script type="text/javascript">
				fixedPagesSES(document).ready(function($){
					fixedPagesSES('.pie_progress_<?php echo $this->identity.'_'.$cont["progressbarcontent_id"]; ?>').asPieProgress({
								namespace: 'pie_progress',
								trackcolor:'#<?php echo $unserialize["empty_bg_color"] ? $unserialize["empty_bg_color"] : "f2f2f2"; ?>',
						});
					fixedPagesSES('.pie_progress_<?php echo $this->identity.'_'.$cont["progressbarcontent_id"]; ?>').asPieProgress('start');
				});
    </script>
     <?php } ?>
 </div>      
 <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/scripts/jquery-2.1.3.min.js'); ?>
 <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/scripts/jquery-asPieProgress.js'); ?>   
<?php } ?>