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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sessocialtube/externals/styles/styles.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery-1.8.2.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sessocialtube/externals/scripts/owl.carousel.min.js'); ?>


<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<div class="socialtube_lp_members_block sesbasic_bxs">
	<div class="socialtube_lp_members_block_content">
    <?php if($this->heading): ?>
      <h2><?php echo $this->translate("%s members and counting ...", $this->member_count); ?></h2>
    <?php endif; ?>
    <?php if(!$this->showType): ?>
	    <ul class="clearfix socialtube_lp_members_block_list">
	      <?php foreach( $this->paginator as $user ): ?>
	        <li class="socialtube_lp_members_thumb" style="height:<?php echo $this->height ?>px; width:<?php echo $this->width ?>px;">
	          <a href="<?php echo $user->getHref() ?>" class ="item_thumb" title="<?php echo $user->displayname ?>">
	            <?php $url = $user->getPhotoUrl('thumb.profile'); ?>
	            <?php if ($url == ''){$url = $this->layout()->staticBaseUrl ."application/modules/User/externals/images/nophoto_user_thumb_profile.png";
	            } ?>
	            <span style="background-image:url(<?php echo $url; ?>);"></span>
	          </a>
	          <?php if($this->showTitle): ?>
		          <div class='member_info'>
		            <?php echo $user->displayname; ?>
		          </div>
	          <?php endif; ?>
	        </li>
	      <?php endforeach; ?>
	    </ul>
    <?php else: ?>
	    <div class="clearfix socialtube_lp_members_carousel" id="socialtube_lp_members_carousel">
	      <?php foreach( $this->paginator as $user ): ?>
	        <div class="socialtube_lp_members_thumb">
	          <a href="<?php echo $user->getHref() ?>" class ="item_thumb" title="<?php echo $user->displayname ?>">
	            <?php $url = $user->getPhotoUrl('thumb.profile'); ?>
	            <?php if ($url == ''){$url = $this->layout()->staticBaseUrl ."application/modules/User/externals/images/nophoto_user_thumb_profile.png";
	            } ?>
	            <span style="background-image:url(<?php echo $url; ?>);"></span>
	          </a>
	          <?php if($this->showTitle): ?>
		          <div class='member_info'>
		            <?php echo $user->displayname; ?>
		          </div>
	          <?php endif; ?>
	        </div>
	      <?php endforeach; ?>
	    </div>
    <?php endif; ?>
  </div>
</div>
<?php if($this->showType): ?>
<script>
  jquery1_8_2SesObject(document).ready(function() {
		jquery1_8_2SesObject("#socialtube_lp_members_carousel").owlCarousel({
		navigation: true,
		pagination: false,
		items : 10, //10 items above 1000px browser width
		itemsDesktop : [1000,9], //5 items between 1000px and 901px
		itemsDesktopSmall : [900,6], // betweem 900px and 601px
		itemsTablet: [600,4], //2 items between 600 and 0
		itemsMobile : [480,2], // itemsMobile disabled - inherit from itemsTablet option
      navigationText: [
      "<i class='fa fa-chevron-left'></i>",
			"<i class='fa fa-chevron-right'></i>"
      ],
		});
  });
</script>
<?php endif; ?>