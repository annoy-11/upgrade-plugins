<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $allParams = $this->all_params; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sestestimonial/externals/styles/style.css'); ?>
<?php if(count($this->paginator) > 0): ?>
  <?php if($allParams['viewtype'] == 'listview'): ?>  
    <div class="sestestimonial_listing sesbasic_clearfix sesbasic_bxs"> 
    <?php foreach($this->paginator as $item) { ?>
      <?php $user = Engine_Api::_()->getItem('user', $item->user_id); ?>
      <div class="sestestimonial_list_item sesbasic_clearfix sesbasic_bxs">
        <div class="testimonial_list_body sesbasic_bxs">
          <div class="list_body_img">
            <div class="list_body_img_inner">
              <a href="<?php echo $user->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.profile'); ?></a>
            </div>
          </div>
          <div class="list_content sesbasic_text_light">
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.titleviewpage', 1)) { ?>
              <div class="list_title">
                <a href="<?php echo $item->getHref(); ?>"><span class="_title"><?php echo $item->title; ?></span></a>
              </div>
            <?php } ?>
            <p class="_desc"><?php echo mb_substr(nl2br($item->description),0,$this->truncationlimit).'...'; ?></p>
          </div>	
        </div>
        <div class="testimonial_list_footer sesbasic_bxs">
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.rating', 1)) { ?>
            <div class="testimonial_list_rating">
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
          <div class="list_designation sesbasic_text_light">
            <span class="_name"><a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a></span>
            <?php if($item->designation && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.designation', 1)) { ?>
              <span class="_desg"><?php echo $item->designation; ?></span>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>
    </div>
  <?php elseif($allParams['viewtype'] == 'advlistview'): ?>
    <div class="sestestimonial_advlisting sesbasic_clearfix sesbasic_bxs"> 
        <?php foreach($this->paginator as $item): ?>
          <?php $user = Engine_Api::_()->getItem('user', $item->user_id); ?>
          <div class="sestestimonial_advlist_item">
            <div class="testimonial_quote_right">
              <i class="fa fa-quote-right"></i>
            </div>
            <div class="testimonial_advlist_body sesbasic_clearfix sesbasic_bxs">
              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.titleviewpage', 1)) { ?>
                <div class="testimonial_advlist_title">
                  <a href="<?php echo $item->getHref(); ?>"><span class="_title"><?php echo $item->title; ?></span></a>
                </div>
              <?php } ?>
              <div class="list_body_desc">
                <p><?php echo mb_substr(nl2br($item->description),0,$this->truncationlimit).'...'; ?></p>
                <div class="list_body_img">
                  <a href="<?php echo $user->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.icon'); ?></a>
                </div>
                <span class="_name"><a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a></span>
                <?php if($item->designation && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.designation', 1)) { ?>
                  <span class="_designation sesbasic_text-light">&#40;<?php echo $item->designation; ?>&#41;</span>
                <?php } ?>
                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.rating', 1)) { ?>
                  <div class="testimonial_advlist_rating">
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
            </div>
          </div>
      <?php endforeach; ?>    
    </div>
  <?php elseif($allParams['viewtype'] == 'gridview'): ?>  
    <div class="sestestimonial_grid_basic sesbasic_clearfix sesbasic_bxs">
  <?php foreach($this->paginator as $item): ?>
    <?php $user = Engine_Api::_()->getItem('user', $item->user_id); ?>
    <div class="sestestimonial_grid_item">
      <div class="sestestimonial_grid_inner">
        <div class="testimonial_grid_header">
          <img src="application/modules/Sestestimonial/externals/images/comma-3.png">
        </div>
        <div class="testimonial_grid_body">
          <div class="grid_body_img">
            <a href="<?php echo $user->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.profile'); ?></a>
          </div>
          <div class="grid_body_desc sesbasic_text_light">
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.titleviewpage', 1)) { ?>
            <div class="testimonial_gridbasic_title">
              <a href="<?php echo $item->getHref(); ?>"><span class="_title"><?php echo $item->title; ?></span></a>
            </div>
            <?php } ?>
            <p><?php echo mb_substr(nl2br($item->description),0,$this->truncationlimit).'...'; ?></p>
          </div>
        </div>	
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.rating', 1)) { ?>
          <div class="testimonial_grid_rating">
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
        <div class="testimonial_grid_footer">
          <a href="<?php echo $user->getHref(); ?>"><span class="_name"><?php echo $user->getTitle(); ?></span></a>
          <?php if($item->designation && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.designation', 1)) { ?>
            <span class="_desg">&#40; <?php echo $item->designation; ?> &#41;</span>
          <?php } ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
    </div>
  <?php elseif($allParams['viewtype'] == 'advgridview'): ?>  
    <div class="sestestimonial_advgrid sesbasic_clearfix sesbasic_bxs">
  <?php foreach($this->paginator as $item): ?>
    <?php $user = Engine_Api::_()->getItem('user', $item->user_id); ?>
    <div class="sestestimonial_advgrid_item">
      <div class="sestestimonial_advgrid_inner">
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.rating', 1)) { ?>
          <div class="testimonial_advgrid_header">
            <div class="ribbon">
              <span><?php echo $item->rating; ?> <i class="fa fa-star"></i></span>
            </div>
          </div>
        <?php } ?>
        <div class="testimonial_advgrid_body">
          <div class="advgrid_body_img">
            <a href="<?php echo $user->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.profile'); ?></a>
          </div>
          <div class="testimonial_advgrid_des">
            <a href="<?php echo $user->getHref(); ?>"><span class="_name"><?php echo $user->getTitle(); ?></span></a>
            <?php if($item->designation && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.designation', 1)) { ?>
              <span class="_desg">&#40; <?php echo $item->designation; ?> &#41;</span>
            <?php } ?>
          </div>
          <div class="advgrid_body_desc sesbasic_text_light">
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.titleviewpage', 1)) { ?>
              <div class="testimonial_advgrid_title">
                <a href="<?php echo $item->getHref(); ?>"><span class="_title"><?php echo $item->title; ?></span></a>
              </div>
            <?php } ?>
            <p><?php echo mb_substr(nl2br($item->description),0,$this->truncationlimit).'...'; ?></p>
          </div>	
        </div>
      </div>
    </div>
  <?php endforeach; ?>
    </div>
  <?php elseif($allParams['viewtype'] == 'pinview'): ?>
    <ul class="sestestimonial_pinboard sesbasic_clearfix sesbasic_bxs">
      <?php foreach($this->paginator as $item): ?>
        <?php $user = Engine_Api::_()->getItem('user', $item->user_id); ?>
        <li class="sestestimonial_pinboard_item new_image_pinboard_<?php echo $randonNumber; ?>" >
          <div class="sestestimonial_pinboard_inner">
            <div class="testimonial_pin_body">
              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.titleviewpage', 1) && $item->title) { ?>
                <div class="testimonial_pin_title">
                  <a href="<?php echo $item->getHref(); ?>"><span class="_title"><?php echo $item->title; ?></span></a>
                </div>
              <?php } ?>
              <div class="pin_body_desc sesbasic_text_light">
                <p><?php echo mb_substr(nl2br($item->description),0,$this->truncationlimit).'...'; ?></p>
              </div>
            </div>
            <div class="testimonial_pin_footer">
              <div class="pin_body_img">
                <a href="<?php echo $user->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.icon'); ?></a>
              </div>
              <a href="<?php echo $user->getHref(); ?>"><span class="_name"><?php echo $user->getTitle(); ?></span></a>
              <?php if($item->designation && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.designation', 1)) { ?>
                <span class="_desg">&#40; <?php echo $item->designation; ?> &#41;</span>
              <?php } ?>
              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.rating', 1)) { ?>
                <div class="testimonial_pin_rating">
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
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
<?php endif; ?>
