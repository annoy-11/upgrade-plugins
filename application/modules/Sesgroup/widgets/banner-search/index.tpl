<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroup/externals/styles/styles.css'); ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesgroup/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesgroup/externals/scripts/owl.carousel.js'); 
?>
<script type="text/javascript">
  window.addEvent('domready',function() {
    /* settings */
    var showDuration = 2000;
    var container = $('sesgroup_banner_search_imgs');
    var images = container.getElements('img');
    var currentIndex = 0;
    var interval;
    /* opacity and fade */
    images.each(function(img,i){ 
      if(i > 0) {
        img.set('opacity',0);
      }
    });
    /* worker */
    var show = function() {   
      images[currentIndex].fade('out');
      images[currentIndex = currentIndex < images.length - 1 ? currentIndex+1 : 0].fade('in');
    };
    /* start once the page is finished loading */
    window.addEvent('load',function(){
      interval = show.periodical(showDuration);
    });
  });
</script>
<div class="sesgroup_banner_search_wrapper sesbasic_clearfix sesbasic_bxs _iscategorybox <?php if($this->params['show_full_width'] == 'yes'):?>isfullwidth<?php endif;?>">
  <section class="_mainsection" style="height:<?php echo is_numeric($this->params['height_image']) ? $this->params['height_image'].'px' : $this->params['height_image'];?>">
    <div class="_mainsectionimg" style="height:<?php echo is_numeric($this->params['height_image']) ? $this->params['height_image'].'px' : $this->params['height_image']?>;background-image:url(application/modules/Sesgroup/externals/images/search-banner-bg.jpg);">
        <div id="sesgroup_banner_search_imgs"  class="sesgroup_banner_search_imgs">
          <img src="./application/modules/Sesgroup/externals/images/banner-1.jpg"/>
          <img src="./application/modules/Sesgroup/externals/images/banner-2.jpg"/>
          <img src="./application/modules/Sesgroup/externals/images/banner-3.jpg"/>
        </div>
        <div class="_banneroverlay"></div>
        <div class="_mainsectioncover">
        <div>
          <div class="_maincontent">
            <h2><?php echo $this->translate($this->params['banner_title']);?></h2>
            <p><?php echo $this->params['description'];?></p>
            <div class="_searchform">
            	<div>
              	<?php echo $this->form->render($this) ?>
            	</div>
            </div>
              <?php if($this->params['show_carousel']):?>
              <div class="_catsection">
                <div class="_cont">
                  <?php if($this->params['category_carousel_title']):?><!-- <div class="_cateheading"><?php echo $this->params['category_carousel_title'];?></div> --><?php endif;?>
                  <div class="_categorycontainer">
                    <div class="sesgroup_banner_categories sesgroup_banner_cat">
                      <?php foreach($this->categories as $category):?>
                        <div class="_catitem _isthumb">
                          <a href="<?php echo $category->getHref();?>">
                            <?php if($category->thumbnail):?>
                              <span class="sesbasic_animation"></span>
                            <?php else:?>
                              <span class="sesbasic_animation" style="background-image:url(application/modules/Sesgroup/externals/images/category-thumb.png);"></span>
                            <?php endif;?>
                            <div class="_catitem_holder">
                              <?php if($category->colored_icon):?>
                                <i class="_caticon"><img src="<?php echo  Engine_Api::_()->storage()->get($category->colored_icon)->getPhotoUrl(); ?>" /></i>
                              <?php else:?>
                                <i class="_caticon"><img src="application/modules/Sesgroup/externals/images/category-icon.png" /></i>
                              <?php endif;?>
                              <div class="_catname" title="<?php echo $category->getTitle();?>"><?php echo $category->getTitle();?></div>
                            </div>
                          </a>
                        </div>
                      <?php endforeach;?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif;?>
          </div>
        </div>
      </div>	
    </div>	
  </section>

</div>
<script type="application/javascript">
  sesgroupJqueryObject('.sesgroup_banner_cat').owlCarousel({
    nav :true,
    loop:false,
    items:5,
    autoplay:false,
    responsive : {
      0 : {
        items:1,
      },
      480 : {
        items:1,
      },
      768 : {
        items:3,
      },
      1024 : {
        items:5,
      }
    }
  })
  sesgroupJqueryObject(".owl-prev").html('<i class="fa fa-long-arrow-left"></i>');
  sesgroupJqueryObject(".owl-next").html('<i class="fa fa-long-arrow-right"></i>');
  <?php if($this->params['show_full_width'] == 'yes'){ ?>
  sesJqueryObject(document).ready(function(){
    sesJqueryObject('#global_content').css('padding-top',0);
    sesJqueryObject('#global_wrapper').css('padding-top',0);	
  });
  <?php  } ?>
</script>

<script>
  sesJqueryObject(document).ready(function(){
    mapLoad = false;
    if(sesJqueryObject('#lat-wrapper').length > 0){
      sesJqueryObject('#lat-wrapper').css('display' , 'none');
      sesJqueryObject('#lng-wrapper').css('display' , 'none');
      initializeSesGroupMapList();
    }
    <?php if(isset($this->params['header_transparent']) && $this->params['header_transparent']):?>
      var htmlElement = document.getElementsByTagName("body")[0];
      htmlElement.addClass('header_transparency');
    <?php endif;?>
  });
</script>
