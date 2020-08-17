<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesrecipe/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>

<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
  <?php if(isset($this->bannerImage) && !empty($this->bannerImage)){ ?>
    <div class="sesrecipe_category_cover sesbasic_bxs sesbm">
      <div class="sesrecipe_category_cover_inner" style="background-image:url(<?php echo str_replace('//','/',$baseUrl.'/'.$this->bannerImage); ?>);">
        <div class="sesrecipe_category_cover_content">
          <div class="sesrecipe_category_cover_blocks">
            <div class="sesrecipe_category_cover_block_img">
              <span style="background-image:url(<?php echo str_replace('//','/',$baseUrl.'/'.$this->bannerImage); ?>);"></span>
            </div>
            <div class="sesrecipe_category_cover_block_info">
              <?php if(isset($this->title) && !empty($this->title)): ?>
                <div class="sesrecipe_category_cover_title"> 
                  <?php echo $this->translate($this->title); ?>
                </div>
              <?php endif; ?>
              <?php if(isset($this->description) && !empty($this->description)): ?>
                <div class="sesrecipe_category_cover_des clear sesbasic_custom_scroll">
                  <?php echo $this->translate($this->description);?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php }else{ ?>
    <div class="sesrecipe_browse_cat_top sesbm">
      <?php if(isset($this->title) && !empty($this->title)): ?>
        <div class="sesrecipe_catview_title"> 
          <?php echo $this->translate($this->title); ?>
        </div>
      <?php endif; ?>
      <?php if(isset($this->description) && !empty($this->description)): ?>
        <div class="sesrecipe_catview_des">
          <?php echo $this->translate($this->description);?>
        </div>
      <?php endif; ?>
    </div>
  <?php } ?>