<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
  $allParams = $this->allParams;
  $baseUrl = $this->layout()->staticBaseUrl;
  $this->headLink()->appendStylesheet($baseUrl . 'application/modules/Eblog/externals/styles/styles.css'); 
  $this->headLink()->appendStylesheet($baseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); 
  $this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); 
  $this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); 
?>
<?php if(isset($allParams['eblog_categorycover_photo']) && !empty($allParams['eblog_categorycover_photo'])) { ?>
  <div class="eblog_category_cover sesbasic_bxs sesbm">
    <div class="eblog_category_cover_inner">
      <div class="eblog_category_cover_img"  style="background-image:url(<?php echo str_replace('//','/',$baseUrl.'/'.$allParams['eblog_categorycover_photo']); ?>);"></div>
      <div class="eblog_category_cover_content">
        <div class="eblog_category_cover_blocks">
          <div class="eblog_category_cover_block_img">
            <span style="background-image:url(<?php echo str_replace('//','/',$baseUrl.'/'.$allParams['eblog_categorycover_photo']); ?>);"></span>
          </div>
          <div class="eblog_category_cover_block_info">
            <?php if(isset($allParams['title']) && !empty($allParams['title'])): ?>
              <div class="eblog_category_cover_title"> 
                <?php echo $this->translate($allParams['title']); ?>
              </div>
            <?php endif; ?>
            <?php if(isset($allParams['description']) && !empty($allParams['description'])): ?>
              <div class="eblog_category_cover_des clear sesbasic_custom_scroll">
                <?php echo $this->translate($allParams['description']);?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } else { ?>
  <div class="eblog_browse_cat_top sesbm">
    <?php if(isset($allParams['title']) && !empty($allParams['title'])): ?>
      <div class="eblog_catview_title"> 
        <?php echo $this->translate($allParams['title']); ?>
      </div>
    <?php endif; ?>
    <?php if(isset($allParams['description']) && !empty($allParams['description'])): ?>
      <div class="eblog_catview_des">
        <?php echo $this->translate($allParams['description']);?>
      </div>
    <?php endif; ?>
  </div>
<?php } ?>
