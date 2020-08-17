<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesariana/externals/styles/styles.css'); ?>
<?php if($this->memberlink == 1 && $this->sesmemberEnable && $this->showinfotooltip == 1){ ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); ?>
<?php } ?>

<div class="ariana_member_block sesbasic_clearfix sesbasic_bxs">
	<div class="ariana_member_block_members">
    <?php foreach( $this->paginator as $user ): ?>
      <?php if($this->memberlink == 1){ ?>
      <a href="<?php echo $user->getHref(); ?>" <?php if($this->sesmemberEnable && $this->showinfotooltip == 1){ ?> class="ses_tooltip" <?php } ?> data-src="<?php echo $user->getGuid(); ?>">
      <?php } ?>
      <?php echo $this->itemPhoto($user, 'thumb.profile') ?>
      <?php if($this->memberlink == 1){ ?>
      </a>
      <?php } ?>
    <?php endforeach; ?>
  </div>
  <div class="ariana_member_block_heading">
  	<h2><?php echo $this->translate($this->heading); ?></h2>
    <p><?php echo $this->translate($this->caption); ?></p>
  </div>
</div>
<style type="text/css">
.ariana_member_block{height:<?php echo $this->height * 2 ?>px}
.ariana_member_block_members > a,
.ariana_member_block_members > img{height:<?php echo $this->height ?>px;width:<?php echo $this->width ?>px;}
</style>
