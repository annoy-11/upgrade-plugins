<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdocument/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>

<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php if(isset($this->bannerImage) && !empty($this->bannerImage)){ ?>
<div class="sesdocument_category_cover sesbasic_bxs sesbm">
  <div class="sesdocument_category_cover_inner" style="background-image:url(<?php echo str_replace('//','/',$baseUrl.'/'.$this->bannerImage); ?>);">
    <div class="sesdocument_category_cover_content">
      <div class="sesdocument_category_cover_blocks">
        <div class="sesdocument_category_cover_block_img">
          <span style="background-image:url(<?php echo str_replace('//','/',$baseUrl.'/'.$this->bannerImage); ?>);"></span>
        </div>
        <div class="sesdocument_category_cover_block_info">
          <?php if(isset($this->title) && !empty($this->title)): ?>
          <div class="sesdocument_category_cover_title"> 
            <?php echo $this->translate($this->title); ?>
          </div>
          <?php endif; ?>
          
          <?php if(isset($this->description) && !empty($this->description)): ?>
            <div class="sesdocument_category_cover_des clear sesbasic_custom_scroll">
          <p><?php echo nl2br($this->description);?></p>
            </div>
          <?php endif; ?>
            
          <?php if(count($this->paginator)){ ?>
           <div class="sesdocument_category_cover_documents">
             <div class="sesdocument_category_cover_documents_head"><?php echo $this->translate($this->title_pop); ?></div>
         <?php foreach($this->paginator as $documentsCri){ ?>
              <div class="sesdocument_thumb sesbasic_animation">
                <a href="<?php echo $documentsCri->getHref(); ?>" data-src="<?php echo $documentsCri->getGuid(); ?>" class="sesdocument_thumb_img ses_tooltip">
                  <span class="sesdocument_animation" style="background-image:url(<?php echo $documentsCri->getPhotoUrl('thumb.normal'); ?>);"></span>
                  <div class="sesdocument_category_cover_documents_item_info sesdocument_animation">
                    <div class="sesdocument_list_title"><?php echo $documentsCri->getTitle(); ?> </div>
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
<div class="sesdocument_browse_cat_top sesbm">
  <?php if(isset($this->title) && !empty($this->title)): ?>
  <div class="sesdocument_catview_title"> 
    <?php echo $this->title; ?>
  </div>
  <?php endif; ?>
  <?php if(isset($this->description) && !empty($this->description)): ?>
  <div class="sesdocument_catview_des">
    <?php echo $this->description;?>
  </div>
  <?php endif; ?>
</div>
  <?php if(count($this->paginator)){ ?>
    <div class="sesdocument_category_cover_documents clearfix sesdocument_category_top_documents sesbasic_bxs">
     <div class="sesdocument_categories_documents_listing_title clear sesbasic_clearfix">
       <span class="sesdocument_category_title"><?php echo $this->title_pop; ?></span>
     </div>
  <?php foreach($this->paginator as $documentsCri){ ?>
      <div class="sesdocument_thumb sesbasic_animation">
        <a href="<?php echo $documentsCri->getHref(); ?>" data-src="<?php echo $documentsCri->getGuid(); ?>" class="sesdocument_thumb_img ses_tooltip">
          <span class="sesdocument_animation" style="background-image:url(<?php echo $documentsCri->getPhotoUrl('thumb.profile'); ?>);"></span>
          <div class="sesdocument_category_cover_documents_item_info sesdocument_animation">
            <div class="sesdocument_list_title"><?php echo $documentsCri->getTitle(); ?> </div>
          </div>
        </a>
      </div>
  <?php }  ?>
  </div>
  <?php	}  ?>
<?php } ?>
