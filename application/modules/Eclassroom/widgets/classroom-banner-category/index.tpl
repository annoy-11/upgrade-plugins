<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
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
	<?php
  	 $bannermainheight= $this->params['height']  + 60;
  ?>
  <div class="eclassroom_category_cover sesbasic_bxs sesbm sesbasic_bxs <?php if($this->params['isfullwidth']){ ?>eclassroom_category_cover_full_container<?php } ?>"  style="<?php if($this->params['isfullwidth']):?>margin-top:-<?php echo is_numeric($this->params['margin_top']) ? $this->params['margin_top'].'px' : $this->params['margin_top']?>;<?php endif;?>height:<?php echo $bannermainheight ?>px;">
    <div class="eclassroom_category_cover_inner">
      <div class="eclassroom_category_cover_img" style="background-image:url(<?php echo str_replace('//','/',$baseUrl.'/'.$this->params['eclassroom_categorycover_photo']); ?>);"></div>
      <div class="eclassroom_category_cover_content">
        <div class="eclassroom_category_cover_blocks" style="height:<?php echo $this->params['height'] ?>px;">
          <div class="eclassroom_category_cover_block_img">
            <span style="background-image:url(<?php echo str_replace('//','/',$baseUrl.'/'.$this->params['eclassroom_categorycover_photo']); ?>);"></span>
          </div>
          <div class="eclassroom_category_cover_block_info">
            <?php if(isset($this->params['title']) && !empty($this->params['title'])): ?>
            <div class="eclassroom_category_cover_title"> 
              <?php echo $this->translate($this->params['title']); ?>
            </div>
            <?php endif; ?>
            <?php if(isset($this->params['description']) && !empty($this->params['description'])): ?>
              <div class="eclassroom_category_cover_des clear sesbasic_custom_scroll">
            		<p><?php echo nl2br($this->params['description']);?></p>
              </div>
            <?php endif; ?>
            <?php if(count($this->paginator)){   ?>
            	<div class="eclassroom_category_cover_classroom">
              	<div class="eclassroom_category_cover_classroom_head"><?php echo $this->params['title_pop']; ?></div>
           			<?php foreach($this->paginator as $classroomCri){  ?>
                  <div class="eclassroom_category_cover_item sesbasic_animation">
                    <a href="<?php echo $classroomCri->getHref(); ?>" data-src="<?php echo $classroomCri->getGuid(); ?>" class="_thumbimg">
                      <span class="bg_item_photo sesbasic_animation" style="background-image:url(<?php echo $classroomCri->getPhotoUrl('thumb.profile'); ?>);"></span>
                      <div class="_info sesbasic_animation">
                        <div class="_title"><?php echo $classroomCri->getTitle(); ?> </div>
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
				htmlElement.addClass('eclassroom_category_cover_full');
			});
		</script>
  <?php } ?>
