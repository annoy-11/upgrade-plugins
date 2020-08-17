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
<?php $allparams = $this->allparams; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/styles.css'); ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Sespage/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Sespage/externals/scripts/owl.carousel.js'); 
?>
<div class="sespagenote_list_slideshow_container sesbasic_bxs">
  <div class="sespagenote_slideshow sespagenote_list_slideshow sespagenote_list_slideshow_<?php echo $this->identity;?>">
    <?php foreach($this->paginator as $item):?>
      <?php if(strlen($item->getTitle()) > $allparams['title_truncation']):?>
        <?php $title = mb_substr($item->getTitle(),0,$allparams['title_truncation']).'...';?>
      <?php else: ?>
        <?php $title = $item->getTitle();?>
      <?php endif; ?>
      <?php $owner = $item->getOwner();?>
      <div class="sespage_list_item item">
        <article class="sesbasic_clearfix">
          <div class="_thumb sespage_thumb" style="height:<?php echo $allparams['height'] ?>px;width:<?php echo $allparams['width'] ?>px;">
            <a href="<?php echo $item->getHref();?>" class="sespagenote_thumb_img sespagenote_profile_img sespagenote_browse_location_<?php echo $item->getIdentity(); ?>">
              <span style="background-image:url(<?php echo $item->getPhotoUrl(); ?>);"></span>
            </a>
           <!-- Labels -->
            <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/_dataLabel.tpl';?>
            <!-- Share Buttons -->
            <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/_dataSharing.tpl';?>
          </div>
          <div class="_cont">
            <?php if(in_array('title', $allparams['show_criteria'])):?>
              <div class="_title">
                <a href="<?php echo $item->getHref();?>" class='sespage_browse_location_<?php echo $item->getIdentity(); ?>'><?php echo $title;?></a>
              </div>
            <?php endif;?>
            <div class="_continner">
              <div class="_continnerleft sespagenote_profile_body">
                <div class="_owner sesbasic_text_light">
                  <?php if(in_array('by', $allparams['show_criteria'])):?>
                    <span class="_owner_name"><?php echo $this->translate('<i class="fa fa-user"></i>');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
                  <?php endif;?>
                   <?php if($this->posteddateActive) { ?>
                  <span>
                    <i class="fa fa-clock-o"></i> <?php echo $this->timestamp($item->creation_date) ?>
                  </span>
                <?php } ?>
                </div>
                
                <?php if(in_array('description', $allparams['show_criteria'])):?>
                  <div class="_des">
                    <?php echo $this->string()->truncate($this->string()->stripTags($item->body), $allparams['grid_description_truncation']) ?>
                  </div>
                <?php endif;?>
              </div> 
            </div>  
            <div class="_footer">
            <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/_dataStatics.tpl';?>
            </div>
          </div>
        </article>
      </div>
    <?php endforeach;?>
  </div>
</div>
<script type="text/javascript">
  sespageJqueryObject('.sespagenote_list_slideshow_<?php echo $this->identity;?>').owlCarousel({
    nav : true,
    loop:true,
    items:1,
    //autoplay:<?php echo $allparams['autoplay'] ?>,
    //autoplayTimeout:<?php echo $allparams['speed'] ?>,
  })
  sespageJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
  sespageJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
</script>
