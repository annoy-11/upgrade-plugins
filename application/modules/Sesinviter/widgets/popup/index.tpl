<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinviter
 * @package    Sesinviter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-12-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php 
$settings = Engine_Api::_()->getApi('settings', 'core');
$socialmediaoptions = unserialize($settings->getSetting('sesinviter.socialmediaoptions', ''));
?>
<?php if($socialmediaoptions && in_array('gmail', $socialmediaoptions)) { ?>
  <?php $this->headScript()->appendFile('https://apis.google.com/js/client.js'); ?>
<?php } ?>

<?php if($socialmediaoptions && in_array('facebook', $socialmediaoptions)) { ?>
  <script src="http://connect.facebook.net/en_US/all.js" type="text/javascript"></script>
<?php } ?>

<?php $id = $this->identity; ?>

<?php if($this->buttonposition == 1) { ?>
  <?php if($this->popuptype){ ?>
  	<a href="javascript:;" data-url="<?php echo $this->layout()->staticBaseUrl.'sesinviter/index/invite/'; ?>" class="sesinviter_side_button sesinviter_side_button_<?php echo $id; ?> sesinviter_right_side_button sessmoothbox sesbasic_animation sesbasic_bxs"><?php echo $this->translate($this->buttontext); ?></a>
  <?php } else { ?> 
  	<a href="<?php echo $this->redirectOpen; ?>" class="sesinviter_side_button sesinviter_side_button_<?php echo $id; ?> sesinviter_right_side_button sesbasic_animation sesbasic_bxs"><?php echo $this->translate($this->buttontext); ?></a>
  <?php } ?>
<?php }else if($this->buttonposition == 2) { ?>
  <?php if($this->popuptype){ ?>
 	 <a href="javascript:;" data-url="<?php echo $this->layout()->staticBaseUrl.'sesinviter/index/invite/'; ?>" class="sesinviter_side_button sesinviter_side_button_<?php echo $id; ?> sesinviter_left_side_button sessmoothbox sesbasic_animation sesbasic_bxs"><?php echo $this->translate($this->buttontext); ?></a>
  <?php }else{ ?> 
  	<a href="<?php echo $this->redirectOpen; ?>" class="sesinviter_side_button sesinviter_side_button_<?php echo $id; ?> sesinviter_left_side_button sesbasic_animation sesbasic_bxs"><?php echo $this->translate($this->buttontext); ?></a>
  <?php } ?>
<?php } else { ?>
 <?php if($this->popuptype){ ?>
		<a href="javascript:;" data-url="<?php echo $this->layout()->staticBaseUrl.'sesinviter/index/invite/'; ?>" class="sesinviter_button sesinviter_side_button_<?php echo $id; ?> sessmoothbox sesbasic_animation sesbasic_bxs"><?php echo $this->translate($this->buttontext); ?></a>
 <?php }else{ ?> 
  	<a href="<?php echo $this->redirectOpen; ?>" class="sesinviter_button sesinviter_side_button_<?php echo $id; ?> sesbasic_animation sesbasic_bxs"><?php echo $this->translate($this->buttontext); ?></a>
  <?php } ?>
<?php } ?>

<?php if($this->margintype == 'per'){$type = '%';}else{$type = 'px';} ?>
<style type="text/css">
html a.sesinviter_side_button_<?php echo $id; ?>{
  background-color: <?php echo '#'.$this->buttoncolor;?> !important;
  color:<?php echo '#'.$this->textcolor;?> !important;
	top:50%;
}
html a.sesinviter_side_button_<?php echo $id; ?>:hover{
  background-color: <?php echo '#'.$this->texthovercolor;?> !important;
  color:<?php echo '#'.$this->textcolor;?> !important;
  text-decoration:none !important;
}
</style>