<?php ?>
<?php $allParams = $this->all_params; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sestestimonial/externals/styles/style.css'); ?>
<?php if(count($this->paginator) > 0): ?>
    <div class="sestestimonial_sidebar_list sesbasic_clearfix sesbasic_bxs"> 
    <?php foreach($this->paginator as $item) { ?>
      <?php $user = Engine_Api::_()->getItem('user', $item->user_id); ?>
      <div class="sestestimonial_sidelist_item sesbasic_clearfix sesbasic_bxs">
        <div class="testimonial_sidelist_body sesbasic_bxs">
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.titleviewpage', 1)) { ?>
            <div class="sidelist_title">
              <a href="<?php echo $item->getHref(); ?>"><span class="_title"><?php echo $item->title; ?></span></a>
            </div>
          <?php } ?>        
          <div class="sidelist_content sesbasic_text_light">            
            <?php if(strlen(nl2br($item->description)) > $allParams['truncationlimit']):?>
              <?php $description = mb_substr(nl2br($item->description),0,$allParams['truncationlimit']).'...';?>
              <p class="_desc"><?php echo $description; ?></p>
            <?php else: ?>
              <p class="_desc"><?php echo nl2br($item->description); ?></p>
            <?php endif;?>
          </div>	          
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.rating', 1)) { ?>
            <div class="testimonial_sidelist_rating">
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
        <div class="testimonial_sidelist_footer sesbasic_bxs">
          <!-- <div class="sidelist_body_img">
            <div class="sidelist_body_img_inner">
              <a href="<?php echo $user->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.profile'); ?></a>
            </div>
          </div> -->
          <div class="sidelist_designation sesbasic_text_light">
            <span class="_name"><a href="<?php echo $user->getHref(); ?>">by&nbsp;<?php echo $user->getTitle(); ?></a></span>
            <?php if($item->designation && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.designation', 1)) { ?>
              <span class="_desg"><?php echo $item->designation; ?></span>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>
    </div>
<?php endif; ?>
<?php ?>
