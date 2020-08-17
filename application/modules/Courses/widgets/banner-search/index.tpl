<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Courses/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Courses/externals/scripts/owl.carousel.js'); 
?>
<div class="courses_banner_search_wrapper sesbasic_clearfix sesbasic_bxs _iscategorybox <?php if($this->params['show_full_width'] == 'yes'):?>isfullwidth<?php endif;?>">
  <section class="_mainsection" style="height:<?php echo is_numeric($this->params['height_image']) ? $this->params['height_image'].'px' : $this->params['height_image'];?>">
    <div class="_mainsectionimg" style="height:<?php echo is_numeric($this->params['height_image']) ? $this->params['height_image'].'px' : $this->params['height_image']?>;background-image:url(application/modules/Courses/externals/images/search-banner-bg.jpg);">
        <div class="_banneroverlay"></div>
        <div class="_mainsectioncover">
        <div>
          <div class="_maincontent">
            <h2><?php echo $this->params['banner_title'];?></h2>
            <p><?php echo $this->params['description'];?></p>
            <div class="_searchform">
            	<div>
              	<?php echo $this->form->render($this) ?>
            	</div>
            </div>
          </div>
        </div>
      </div>	
    </div>	
  </section>
  <?php if($this->params['show_carousel']):?>
    <section class="_catsection">
      <div class="_cont">
        <?php if($this->params['category_carousel_title']):?><div class="_cateheading"><?php echo $this->params['category_carousel_title'];?></div><?php endif;?>
        <div class="_categorycontainer">
          <div class="courses_banner_categories courses_banner_cat_<?php echo $this->identity;?>">
            <?php foreach($this->categories as $category):?>
              <div class="_catitem _isthumb">
                <a href="<?php echo $category->getHref();?>">
                  <?php if($category->thumbnail):?>
                    <span class="sesbasic_animation" style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($category->thumbnail)->getPhotoUrl('thumb.thumb'); ?>);"></span>
                  <?php else:?>
                    <span class="sesbasic_animation" style="background-image:url(application/modules/Courses/externals/images/category-thumb.png);"></span>
                  <?php endif;?>
                  <div class="_catitem_holder">
                    <?php if($category->colored_icon):?>
                      <i class="_caticon"><img src="<?php echo  Engine_Api::_()->storage()->get($category->colored_icon)->getPhotoUrl(); ?>" /></i>
                    <?php else:?>
                      <i class="_caticon"><img src="application/modules/Courses/externals/images/category-icon.png" /></i>
                    <?php endif;?>
                    <div class="_catname" title="<?php echo $category->getTitle();?>"><?php echo $category->getTitle();?></div>
                  </div>
                </a>
              </div>
            <?php endforeach;?>
          </div>
        </div>
      </div>
    </section>
  <?php endif;?>
</div>
<script type="application/javascript">
  coursesJqueryObject('.courses_banner_cat_<?php echo $this->identity;?>').owlCarousel({
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
  coursesJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
  coursesJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
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
      initializeSesPageMapList();
    }
  });
</script>
