<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php  $baseURL = Zend_Registry::get('StaticBaseUrl');?>
<?php 
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js');
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/scripts/slick/slick.js');
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/styles/styles.css');
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusinessoffer/externals/styles/style.css');
?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>

<div class="sesbusinessoffer_welcome_block_container">
  <div class="sesbusinessoffer_business_carousel_wrapper sesbusinessoffer_carousel_wrapper sesbasic_clearfix sesbasic_bxs <?php if($this->params['viewType'] == 'horizontal'): ?>sesbusinessoffer_carousel_h_wrapper<?php else: ?>sesbusinessoffer_carousel_v_wrapper <?php endif; ?>" style="min-height:<?php echo $this->params['imageheight'] ?>px;">
    <div id="businesseslide_<?php echo $this->identity; ?>" class="sesbasic_clearfix sesbusinessoffer_carousel_<?php echo $this->identity; ?> slider sesbusinessoffer_slick_slider">
      <?php foreach( $this->paginator as $item): ?>
      <div class="sesbusinessoffer_carousel_grid_item sesbasic_clearfix <?php if(isset($this->contactButtonActive) || isset($this->socialSharingActive)):?> _isbtns<?php endif;?>" style="width:<?php echo is_numeric($this->params['width']) ? $this->params['width'].'px':$this->params['width'];?>;">
        <article>
          <div class="_thumb sesbusinessoffer_thumb sesbusinessoffer_profile_inner" style="height:<?php echo $this->params['imageheight'] ?>px;"> <a href="<?php echo $item->getHref(); ?>" class="sesbusinessoffer_profile_img"> <span class="sesbasic_animation" style="background-image:url(<?php echo $item->getPhotoUrl(); ?>);"></span> </a> <a href="<?php echo $item->getHref();?>" class="_thumblink"></a> 
            <!-- Share Buttons -->
            <?php include APPLICATION_PATH .  '/application/modules/Sesbusinessoffer/views/scripts/_dataSharing.tpl';?>
            <!-- Labels -->
            <?php include APPLICATION_PATH .  '/application/modules/Sesbusinessoffer/views/scripts/_dataLabel.tpl';?>
            <?php if($this->offertypevalueActive && !empty($item->offertypevalue)) { ?>
            <span class="sesbusinessoffer_type">
            <?php if($item->offertype == 1) { ?>
            <?php echo $item->offertypevalue . '%'; ?> 
            <?php } elseif($item->offertype == 2) { ?>
            <?php echo $this->translate("Fixed %s", $item->offertypevalue); ?>
            <?php } ?>
            </span>
            <?php } ?>
          </div>
          <div class="sesbusinessoffer_profile_body"> <span class="_name"><?php echo $this->htmlLink($item, Engine_Api::_()->sesbasic()->textTruncation($item->getTitle(), $this->params['grid_title_truncation']), array('title' => $item->getTitle())) ?></span> <span class="_owner sesbasic_text_light">
            <?php if(isset($this->byActive)) { ?>
            <span> <?php echo $this->translate('<i class="fa fa-user"></i>');
											$itemOwner  = Engine_Api::_()->getItem('user',$item->owner_id); ?> <?php echo $this->htmlLink($itemOwner->getHref(), $itemOwner->getTitle(), array('class' => 'thumbs_author')) ?> </span>
            <?php }?>
            <?php if($this->posteddateActive) { ?>
            <span> <i class="fa fa-clock-o"></i> <?php echo $this->timestamp($item->creation_date) ?> </span>
            <?php } ?>
            <?php if($this->businessnameActive) { ?>
            <?php $business = Engine_Api::_()->getItem('businesses', $item->parent_id); ?>
            <span class="sesbusinessoffer_businessname"> <i class="fa fa-file-text"></i> <a href="<?php echo $business->getHref(); ?>"><?php echo $business->getTitle(); ?></a> </span>
            <?php } ?>
            </span>
            <?php if($this->claimedcountActive || $this->remainingcountActive || $this->getofferlinkActive) { ?>
              <div class="sesbusinessoffer_claim">
                <?php if($this->claimedcountActive) { ?>
                  <span class="sesbasic_text_light"><?php echo $this->translate("Claimed: "); ?><span class="_num"><?php echo $item->claimed_count; ?></span></span>
                <?php } ?>
                <?php if($this->remainingcountActive) { ?>
                  <span class="sesbasic_text_light"><?php echo $this->translate("Remaining: "); ?><span class="_num"><?php echo $item->totalquantity - $item->claimed_count; ?> </span></span>
                <?php } ?>
                <?php if($this->getofferlinkActive && $item->claimed_count < $item->totalquantity) { ?>
                  <span class="sesbusinessoffer_get_offer"><a class="smoothbox" href="<?php echo $this->url(array('controller' => 'index', 'action' => 'getoffer','parent_id' => $item->parent_id, 'businessoffer_id' => $item->getIdentity(), 'format' => 'smoothbox'), 'sesbusinessoffer_general', true); ?>"><?php echo $this->translate(" Get Offer"); ?></a></span>
                <?php } ?>
              </div>
            <?php } ?>
            <?php if($this->griddescriptionActive) { ?>
            <span class="_desc sesbasic_text_light">
            <?php $ro = preg_replace('/\s+/', ' ',$item->body);?>
            <?php $tmpBody = preg_replace('/ +/', ' ',html_entity_decode(strip_tags( $ro)));?>
            <?php  echo nl2br( Engine_String::strlen($tmpBody) > $this->params['grid_description_truncation'] ? Engine_String::substr($tmpBody, 0, $this->params['grid_description_truncation']) . '...' : $tmpBody );?>
            </span>
            <?php } ?>
            <div class="sesbusinessoffer_main"> <span class="sesbusinessoffer_coupon"> mob_18 </span>
              <?php if($this->offerlinkActive) { ?>
              <span class="sesbusinessoffer_link"> <a href="<?php echo $item->offerlink; ?>"><?php echo $this->translate("Click Here"); ?><i class="fa fa-long-arrow-right"></i></a> </span>
              <?php } ?>
            </div>
          </div>
          <!-- Stats -->
          <?php include APPLICATION_PATH .  '/application/modules/Sesbusinessoffer/views/scripts/_dataStatics.tpl';?>
        </article>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="sesbasic_loading_cont_overlay" style="display:block;"></div>
  </div>
</div>
<style type="text/css">
.sesbusinessoffer_carousel_<?php echo $this->identity; ?>{display:none;}
.sesbusinessoffer_carousel_<?php echo $this->identity; ?>.slick-initialized{display:block;}
.sesbusinessoffer_carousel_<?php echo $this->identity; ?>.slick-initialized + .sesbasic_loading_cont_overlay{display:none !important;}
</style>
<script type="text/javascript">
	<?php if($this->params['viewType'] == 'horizontal'): ?>
	sesBasicAutoScroll(document).on('ready', function() {
		sesBasicAutoScroll(".sesbusinessoffer_carousel_<?php echo $this->identity; ?>").slick({
			infinite: true,
			dots: false,
			slidesToShow: 1,
			variableWidth: true,
			slidesToScroll: 1,
			dots:false,
			centerMode: true,
	})});
<?php else: ?>
	sesBasicAutoScroll(document).on('ready', function() {
		sesBasicAutoScroll(".sesbusinessoffer_carousel_<?php echo $this->identity; ?>").slick({
			infinite: true,
			dots: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			dots:false,
	})});
<?php endif; ?>
</script> 
