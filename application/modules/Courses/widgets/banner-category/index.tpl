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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>

<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
  <?php if(isset($this->params['courses_categorycover_photo']) && !empty($this->params['courses_categorycover_photo'])){ ?>
  <?php $bannermainheight= $this->params['height']  + 60; ?>
    <div class="courses_category_cover sesbasic_bxs sesbm <?php if($this->params['isfullwidth']){ ?>courses_category_cover_full_container<?php } ?>"  style="<?php if($this->params['isfullwidth']):?>margin-top:-<?php echo is_numeric($this->params['margin_top']) ? $this->params['margin_top'].'px' : $this->params['margin_top']?>;<?php endif;?>height:<?php echo $bannermainheight ?>px;">
      <div class="courses_category_cover_inner">
			 <div class="courses_category_cover_img" style="background-image:url(<?php echo !empty($this->bannerImage) ? str_replace('//','/',$baseUrl.'/'.$this->bannerImage) : 'application\modules\Eclassroom\externals\images\category-banner-image.png'; ?>);"></div>
        <div class="courses_category_cover_content">
          <div class="courses_category_cover_blocks">
            <div class="courses_category_cover_block_img">
              <span style="background-image:url(<?php echo !empty($this->bannerImage) ? str_replace('//','/',$baseUrl.'/'.$this->bannerImage) : 'application\modules\Eclassroom\externals\images\category-banner-image.png'; ?>);"></span>
            </div>
            <div class="courses_category_cover_block_info">
              <?php if(isset($this->title) && !empty($this->title)): ?>
                <div class="courses_category_cover_title"> 
                  <?php echo $this->translate($this->title); ?>
                </div>
              <?php endif; ?>
              <?php if(isset($this->description) && !empty($this->description)): ?>
                <div class="courses_category_cover_des clear sesbasic_custom_scroll">
                  <?php echo $this->translate($this->description);?>
                </div>
              <?php endif; ?>
              <?php if(count($this->paginator)){ ?>
                <div class="courses_category_cover_pages">
                  <div class="courses_category_cover_pages_head"><?php echo $this->params['title_pop']; ?></div>
                  <?php foreach($this->paginator as $pagesCri){ ?>
                    <div class="courses_category_cover_item sesbasic_animation">
                      <a href="<?php echo $pagesCri->getHref(); ?>" data-src="<?php echo $pagesCri->getGuid(); ?>" class="_thumbimg">
                        <span class="bg_item_photo sesbasic_animation" style="background-image:url(<?php echo $pagesCri->getPhotoUrl('thumb.profile'); ?>);"></span>
                        <div class="_info sesbasic_animation">
                          <div class="_title"><?php echo $pagesCri->getTitle(); ?> </div>
                        </div>
                      </a>
                    </div>
                  <?php }  ?>
                </div>
              <?php	}  ?>
        		
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php }else{ ?>
    <div class="courses_browse_cat_top sesbm">
      <?php if(isset($this->title) && !empty($this->title)): ?>
        <div class="courses_catview_title"> 
          <?php echo $this->translate($this->title); ?>
        </div>
      <?php endif; ?>
      <?php if(isset($this->description) && !empty($this->description)): ?>
        <div class="courses_catview_des">
          <?php echo $this->translate($this->description);?>
        </div>
      <?php endif; ?>
    </div>  
  <?php } ?>
