<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $allParams = $this->all_params; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sestestimonial/externals/styles/style.css'); ?>
<?php 
$baseURL = $this->layout()->staticBaseUrl;
$this->headScript()->appendFile($baseURL . 'application/modules/Sestestimonial/externals/scripts/core.js'); 
$this->headScript()->appendFile($baseURL . 'application/modules/Sestestimonial/externals/scripts/jquery.js'); 
$this->headScript()->appendFile($baseURL . 'application/modules/Sestestimonial/externals/scripts/owl.carousel.js'); 
?>
<div class="sestestimonial_list_slideshow sesbasic_clearfix sesbasic_bxs">
  <div class="testimonial_quote_right">
      <i class="fa fa-quote-right"></i>
  </div>
  <div class="list_testimonial_slideshow">
      <?php foreach($this->paginator as $item) { ?>
      <?php $user = Engine_Api::_()->getItem('user', $item->user_id); ?>
      <div class="item sesbasic_bg">
        <div class="sestestimonial_slide_listing sesbasic_clearfix sesbasic_bxs">
          <div class="sestestimonial_slidelist_item">
            <div class="testimonial_slidelist_body sesbasic_clearfix">
              <div class="testimonial_slidelist_title">
                  <a href="<?php echo $item->getHref(); ?>"><span class="_title"><?php echo $item->title; ?></span></a>
              </div>
              <div class="list_body_desc">
                  <p><?php echo mb_substr(nl2br($item->description),0,$allParams['truncationlimit']).'...'; ?></p>
              </div>
            </div>
              <div class="testimonial_slider_footer sesbasic_clearfix">
                <div class="list_body_img">
                  <a href="<?php echo $user->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.profile'); ?></a>
                </div>
                <div class="testimonial_footer_desc">
                  <h4><a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a></h4>
                  <?php if($item->designation && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.designation', 1)) { ?>
                    <span class="_designation sesbasic_text-light">&#40;<?php echo $item->designation; ?>&#41;</span>
                  <?php } ?>
                </div>
                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.rating', 1)) { ?>
                  <div class="testimonial_slider_rating">
                    <?php for( $x=1; $x<=$item->rating; $x++ ): ?>
                      <span class="rating_star_generic rating_star"></span>
                    <?php endfor; ?>
                    <?php if( (round($item->rating) - $item->rating) > 0): ?>
                      <span class="rating_star_generic rating_star_half"></span>
                    <?php endif; ?>
                    <?php for( $x=5; $x>round($item->rating); $x-- ): ?>
                      <span class="rating_star_generic rating_star_empty"></span>
                    <?php endfor; ?>
                  </div>
                <?php } ?>
              </div>
          </div>
        </div>
      </div>
      <?php } ?>
  </div>
</div>
<script type="text/javascript">
  sesgroupJqueryObject('.list_testimonial_slideshow').owlCarousel({
    nav: true,
    loop: false,
    items: 1,
    autoplay: true,
    responsive: {
      0: {
          items: 1,
      },
      480: {
          items: 1,
      },
      768: {
          items: 1,
      },
      1024: {
          items: 1,
      }
    }
  });
  sesgroupJqueryObject(".owl-prev").html('<i class="fa fa-long-arrow-left"></i>');
  sesgroupJqueryObject(".owl-next").html('<i class="fa fa-long-arrow-right"></i>');
</script>
