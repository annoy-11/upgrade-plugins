<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesarticle/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>

<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
  <?php if(isset($this->bannerImage) && !empty($this->bannerImage)){ ?>
    <div class="sesarticle_category_cover sesbasic_bxs sesbm">
      <div class="sesarticle_category_cover_inner" style="background-image:url(<?php echo str_replace('//','/',$baseUrl.'/'.$this->bannerImage); ?>);">
        <div class="sesarticle_category_cover_content">
          <div class="sesarticle_category_cover_blocks">
            <div class="sesarticle_category_cover_block_img">
              <span style="background-image:url(<?php echo str_replace('//','/',$baseUrl.'/'.$this->bannerImage); ?>);"></span>
            </div>
            <div class="sesarticle_category_cover_block_info">
              <?php if(isset($this->title) && !empty($this->title)): ?>
                <div class="sesarticle_category_cover_title"> 
                  <?php echo $this->translate($this->title); ?>
                </div>
              <?php endif; ?>
              <?php if(isset($this->description) && !empty($this->description)): ?>
                <div class="sesarticle_category_cover_des clear sesbasic_custom_scroll">
                  <?php echo $this->translate($this->description);?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php }else{ ?>
    <div class="sesarticle_browse_cat_top sesbm">
      <?php if(isset($this->title) && !empty($this->title)): ?>
        <div class="sesarticle_catview_title"> 
          <?php echo $this->translate($this->title); ?>
        </div>
      <?php endif; ?>
      <?php if(isset($this->description) && !empty($this->description)): ?>
        <div class="sesarticle_catview_des">
          <?php echo $this->translate($this->description);?>
        </div>
      <?php endif; ?>
    </div>
  <?php } ?>