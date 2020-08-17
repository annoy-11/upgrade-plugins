<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php  $baseURL = Zend_Registry::get('StaticBaseUrl');?>
<?php 
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js');
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/scripts/slick/slick.js');
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/styles.css');
?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<div class="sespagenote_welcome_block_container">
<div class="sespagenote_page_carousel_wrapper sespagenote_carousel_wrapper sesbasic_clearfix sesbasic_bxs <?php if($this->params['viewType'] == 'horizontal'): ?>sespagenote_carousel_h_wrapper<?php else: ?>sespagenote_carousel_v_wrapper <?php endif; ?>" style="min-height:<?php echo $this->params['imageheight'] ?>px;">
  <div id="pageslide_<?php echo $this->identity; ?>" class="sesbasic_clearfix sespagenote_carousel_<?php echo $this->identity; ?> slider sespagenote_slick_slider">
    <?php foreach( $this->paginator as $item): ?>
    	<div class="sespagenote_carousel_grid_item sesbasic_clearfix <?php if(isset($this->contactButtonActive) || isset($this->socialSharingActive)):?> _isbtns<?php endif;?>" style="width:<?php echo is_numeric($this->params['width']) ? $this->params['width'].'px':$this->params['width'];?>;">
        <article>
          <div class="_thumb sespagenote_thumb" style="height:<?php echo $this->params['imageheight'] ?>px;">
            <a href="<?php echo $item->getHref(); ?>" class="sespagenote_profile_img">
              <span class="sesbasic_animation" style="background-image:url(<?php echo $item->getPhotoUrl(); ?>);"></span>
            </a>
            <a href="<?php echo $item->getHref();?>" class="_thumblink"></a>
            <!-- Share Buttons -->
            <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/_dataSharing.tpl';?>
            <!-- Labels -->
            <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/_dataLabel.tpl';?>
            
            <?php if($this->pagenameActive) { ?>
            <?php $page = Engine_Api::_()->getItem('sespage_page', $item->parent_id); ?>
            <span class="sespagenote_pagename"> 
                <i class="fa fa-file-text"></i> <a href="<?php echo $page->getHref(); ?>"><?php echo $page->getTitle(); ?></a>
            </span>
          <?php } ?>
          </div>
          <div class="sespagenote_profile_body">
					  <span class="_name"><?php echo $this->htmlLink($item, Engine_Api::_()->sesbasic()->textTruncation($item->getTitle(), $this->params['grid_title_truncation']), array('title' => $item->getTitle())) ?></span>
              <span class="_owner sesbasic_text_light">
								<?php if(isset($this->byActive)) { ?>
									<span>
										<?php echo $this->translate('<i class="fa fa-user"></i>');
											$itemOwner  = Engine_Api::_()->getItem('user',$item->owner_id); ?>
										<?php echo $this->htmlLink($itemOwner->getHref(), $itemOwner->getTitle(), array('class' => 'thumbs_author')) ?>
									</span>
								<?php }?>
                <?php if($this->posteddateActive) { ?>
                  <span>
                    <i class="fa fa-clock-o"></i> <?php echo $this->timestamp($item->creation_date) ?>
                  </span>
                <?php } ?>
							</span>
							<?php if($this->descriptionActive) { ?>
                <span class="_desc sesbasic_text_light">
                  <?php $ro = preg_replace('/\s+/', ' ',$item->body);?>
                  <?php $tmpBody = preg_replace('/ +/', ' ',html_entity_decode(strip_tags( $ro)));?>
                  <?php  echo nl2br( Engine_String::strlen($tmpBody) > $this->params['grid_description_truncation'] ? Engine_String::substr($tmpBody, 0, $this->params['grid_description_truncation']) . '...' : $tmpBody );?>
                </span>
              <?php } ?>
          </div>
           <!-- Stats -->
           <?php include APPLICATION_PATH .  '/application/modules/sespagenote/views/scripts/_dataStatics.tpl';?>
        </article>
      </div>
    <?php endforeach; ?>
  </div>
	<div class="sesbasic_loading_cont_overlay" style="display:block;"></div>
</div>
</div>
<style type="text/css">
.sespagenote_carousel_<?php echo $this->identity; ?>{display:none;}
.sespagenote_carousel_<?php echo $this->identity; ?>.slick-initialized{display:block;}
.sespagenote_carousel_<?php echo $this->identity; ?>.slick-initialized + .sesbasic_loading_cont_overlay{display:none !important;}
</style>
<script type="text/javascript">
	<?php if($this->params['viewType'] == 'horizontal'): ?>
	sesBasicAutoScroll(document).on('ready', function() {
		sesBasicAutoScroll(".sespagenote_carousel_<?php echo $this->identity; ?>").slick({
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
		sesBasicAutoScroll(".sespagenote_carousel_<?php echo $this->identity; ?>").slick({
			infinite: true,
			dots: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			dots:false,
	})});
<?php endif; ?>
</script>
