<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/styles/styles.css'); ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesbusiness/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesbusiness/externals/scripts/owl.carousel.js'); 
?>
<div class="sesbusiness_hero_slideshow_container sesbasic_bxs <?php if($this->params['isfullwidth']){ ?> _isfullwidth<?php } ?>" style="height:<?php echo is_numeric($this->params['height']) ? $this->params['height'].'px' : $this->params['height']; ?>;">
  <section>
    <div class="sesbusiness_hero_slideshow_inner sesbasic_clearfix sesbusiness_hero_slideshow sesbusiness_hero_slideshow_inner_<?php echo $this->identity;?>">
      <?php foreach($this->businesses as $business):?>
        <?php $viewer = Engine_Api::_()->user()->getViewer();?>
        <div class="sesbusiness_hero_slideshow_item item">
          <div class="_img" style="height:<?php echo is_numeric($this->params['height']) ? $this->params['height'].'px' : $this->params['height']; ?>;"> <span style="background-image:url(<?php echo $business->getPhotoUrl(); ?>);"></span> </div>
          <div class="_overlay"></div>
          <div class="_cont">
            <div class="_continner">
              <article>
                <?php if(isset($this->titleActive)):?>
                  <?php if(strlen($business->getTitle()) > $this->params['title_truncation']):?>
                    <?php $title = mb_substr($business->getTitle(),0,$this->params['title_truncation']).'...';?>
                  <?php else: ?>
                    <?php $title = $business->getTitle();?>
                  <?php endif; ?>
                  <h2><a href="<?php echo $business->getHref();?>"><?php echo $title;?></a></h2>
                <?php endif;?>
                <?php if(isset($this->descriptionActive)):?>
                <p class="_des"><?php echo $this->string()->truncate($this->string()->stripTags($business->description), $this->params['description_truncation']) ?></p>
                <?php endif;?>
              </article>
            </div>
          </div>
        </div>
      <?php endforeach;?>
    </div>
  </section>
</div>
<script type="text/javascript">
  sesbusinessJqueryObject('.sesbusiness_hero_slideshow_inner_<?php echo $this->identity;?>').owlCarousel({
    nav : true,
    loop:true,
    items:1,
    autoplay:<?php echo $this->params['autoplay'] ?>,
    autoplayTimeout:<?php echo $this->params['speed'] ?>,
  })
  sesbusinessJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
  sesbusinessJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
  <?php if($this->params['isfullwidth']){ ?>
    sesJqueryObject(document).ready(function(){
      var htmlElement = document.getElementsByTagName("body")[0];
      htmlElement.addClass('sesbusiness_slideshow_full');
    });
  <?php } ?>
</script>
<style type="text/css">
  <?php if($this->params['navigation'] == 'nextprev'){?>
    .sesbusiness_hero_slideshow_inner_<?php echo $this->identity;?> .owl-dots{display:none;}
    .sesbusiness_hero_slideshow_inner_<?php echo $this->identity;?> .owl-nav > div{display:block !important;}
  <?php } else{ ?>
    .sesbusiness_hero_slideshow_inner_<?php echo $this->identity;?> .owl-nav{display:none;}
  <?php } ?>
</style>
