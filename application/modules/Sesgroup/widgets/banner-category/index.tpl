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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>

<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php if(isset($this->params['sesgroup_categorycover_photo']) && !empty($this->params['sesgroup_categorycover_photo'])){ ?>
	<?php
  	 $bannermainheight= $this->params['height']  + 60;
  ?>
  <div class="sesgroup_category_cover sesbasic_bxs sesbm sesbasic_bxs <?php if($this->params['isfullwidth']){ ?>sesgroup_category_cover_full_container<?php } ?>"  style="<?php if($this->params['isfullwidth']):?>margin-top:-<?php echo is_numeric($this->params['margin_top']) ? $this->params['margin_top'].'px' : $this->params['margin_top']?>;<?php endif;?>height:<?php echo $bannermainheight ?>px;">
    <div class="sesgroup_category_cover_inner">
      <div class="sesgroup_category_cover_img" style="background-image:url(<?php echo str_replace('//','/',$baseUrl.'/'.$this->params['sesgroup_categorycover_photo']); ?>);"></div>
      <div class="sesgroup_category_cover_content">
        <div class="sesgroup_category_cover_blocks" style="height:<?php echo $this->params['height'] ?>px;">
          <div class="sesgroup_category_cover_block_img">
            <span style="background-image:url(<?php echo str_replace('//','/',$baseUrl.'/'.$this->params['sesgroup_categorycover_photo']); ?>);"></span>
          </div>
          <div class="sesgroup_category_cover_block_info">
            <?php if(isset($this->params['title']) && !empty($this->params['title'])): ?>
            <div class="sesgroup_category_cover_title"> 
              <?php echo $this->translate($this->params['title']); ?>
            </div>
            <?php endif; ?>
            <?php if(isset($this->params['description']) && !empty($this->params['description'])): ?>
              <div class="sesgroup_category_cover_des clear sesbasic_custom_scroll">
            		<p><?php echo nl2br($this->params['description']);?></p>
              </div>
            <?php endif; ?>
            <?php if(count($this->paginator)){ ?>
            	<div class="sesgroup_category_cover_groups">
              	<div class="sesgroup_category_cover_groups_head"><?php echo $this->params['title_pop']; ?></div>
           			<?php foreach($this->paginator as $groupsCri){ ?>
                  <div class="sesgroup_category_cover_item sesbasic_animation">
                    <a href="<?php echo $groupsCri->getHref(); ?>" data-src="<?php echo $groupsCri->getGuid(); ?>" class="_thumbimg">
                      <span class="bg_item_photo sesbasic_animation" style="background-image:url(<?php echo $groupsCri->getPhotoUrl('thumb.profile'); ?>);"></span>
                      <div class="_info sesbasic_animation">
                        <div class="_title"><?php echo $groupsCri->getTitle(); ?> </div>
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
    <?php if($this->params['isfullwidth']){ ?>
    <script type="text/javascript">	
			sesJqueryObject(document).ready(function(){
				var htmlElement = document.getElementsByTagName("body")[0];
				htmlElement.addClass('sesgroup_category_cover_full');
			});
		</script>
  <?php } ?>
<?php }else{ ?>
  <div class="sesgroup_browse_cat_top sesbm">
    <?php if(isset($this->params['title']) && !empty($this->params['title'])): ?>
    <div class="sesgroup_catview_title"> 
      <?php echo $this->params['title']; ?>
    </div>
    <?php endif; ?>
    <?php if(isset($this->params['description']) && !empty($this->params['description'])): ?>
    <div class="sesgroup_catview_des">
      <?php echo $this->params['description'];?>
    </div>
    <?php endif; ?>
  </div>
  <?php if(count($this->paginator)){ ?>
    <?php $width = $this->params['width'];?>
    <?php $height = $this->params['height_advgrid'];?>
    <div class="clearfix sesgroup_category_top_groups sesbasic_bxs">
      <div class="sesgroup_catview_list_title clear sesbasic_clearfix">
      	<span class="_title"><?php echo $this->params['title_pop']; ?></span>
      </div>
      <ul class="clear sesbasic_clearfix">
        <?php foreach($this->paginator as $group){ ?>
          <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/group/_advgridView.tpl';?>
        <?php }  ?>
      </ul>
    </div>
  <?php	}  ?>
<?php } ?>